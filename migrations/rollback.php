<?php
declare(strict_types=1);
use mysqli;
use Exception;

require __DIR__ . '/../config/db.php';
// Determine latest batch
$res   = $mysqli->query("SELECT MAX(batch) AS b FROM migrations");
$batch = (int)$res->fetch_assoc()['b'];
if ($batch === 0) {
    echo "No migrations to rollback.\n";
    exit;
}

// Fetch migrations in this batch in reverse order
$stmt   = $mysqli->prepare(
    "SELECT migration FROM migrations WHERE batch = ? ORDER BY migration DESC"
);
$stmt->bind_param('i', $batch);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $name = $row['migration'];
    $downFile = __DIR__ . "/{$name}.down.sql";
    if (!file_exists($downFile)) {
        echo "No rollback script for {$name}, skipping.\n";
        continue;
    }

    echo "Rolling back {$name}...\n";
    $sql = file_get_contents($downFile);
    try {
        $mysqli->begin_transaction();
        $mysqli->multi_query($sql);
        while ($mysqli->more_results() && $mysqli->next_result()) {;}
        // Remove record
        $del = $mysqli->prepare("DELETE FROM migrations WHERE migration = ?");
        $del->bind_param('s', $name);
        $del->execute();
        $mysqli->commit();
        echo "✔ Rolled back {$name}.\n\n";
    } catch (Exception $e) {
        $mysqli->rollback();
        echo "✖ Error rolling back {$name}: " . $e->getMessage() . "\n";
        exit(1);
    }
}

echo "Rollback of batch {$batch} complete.\n";
