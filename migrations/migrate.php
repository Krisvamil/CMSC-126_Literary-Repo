<?php
declare(strict_types=1);
use mysqli;
use Exception;

require __DIR__ . '/../config/db.php';
$batch = 1;

// Fetch current max batch
$result = $mysqli->query("SELECT MAX(batch) AS max_batch FROM migrations");
$batch = ($result->fetch_assoc()['max_batch'] ?? 0) + 1;

// Collect all .up.sql files sorted
$files = array_filter(scandir(__DIR__), fn($f) => preg_match('/^\d+.*\.up\.sql$/', $f));
sort($files, SORT_STRING);

foreach ($files as $file) {
    $name = basename($file, '.up.sql');

    // Skip if already applied
    $stmt = $mysqli->prepare("SELECT 1 FROM migrations WHERE migration = ?");
    $stmt->bind_param('s', $name);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        echo "Skipping {$file} (already applied)\n";
        continue;
    }

    echo "Applying {$file}...\n";
    $sql = file_get_contents(__DIR__ . "/{$file}");
    try {
        $mysqli->begin_transaction();
        $mysqli->multi_query($sql);
        // flush multi_query results
        while ($mysqli->more_results() && $mysqli->next_result()) {;}
        // Record migration
        $ins = $mysqli->prepare("INSERT INTO migrations (migration, batch) VALUES (?, ?)");
        $ins->bind_param('si', $name, $batch);
        $ins->execute();
        $mysqli->commit();
        echo "✔ {$file} applied.\n\n";
    } catch (Exception $e) {
        $mysqli->rollback();
        echo "✖ Error in {$file}: " . $e->getMessage() . "\n";
        exit(1);
    }
}

echo "All pending migrations applied in batch {$batch}.\n";
