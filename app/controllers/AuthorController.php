<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Work;

class AuthorController extends BaseController
{
    public function dashboard(): void
    {
        try {
            $authorId  = $_SESSION['user']['id'];
            $workModel = new Work($this->db);
            $allWorks  = $workModel->getAll();

            // Filter to this author’s works
            $ownWorks = array_filter(
                $allWorks,
                fn($w) => (int)$w['author_id'] === $authorId
            );

            $this->render('authors/dashboard', [
                'title'       => 'My Works',
                'pageStyles'  => ['authors.css'],
                'pageScripts' => ['authors.js'],
                'works'       => $ownWorks,
            ]);
        } catch (\Exception $e) {
            $this->logger->error('Author dashboard error: ' . $e->getMessage());
            http_response_code(500);
            $this->render('errors/500', [
                'title'       => 'Error',
                'pageStyles'  => ['error.css'],
                'pageScripts' => ['error.js'],
            ]);
        }
    }
}
