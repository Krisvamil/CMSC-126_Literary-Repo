<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Reader;

class ReaderController extends BaseController
{
    public function dashboard(): void
    {
        try {
            $readerId   = $_SESSION['user']['id'];
            $readerModel= new Reader($this->db);

            $favorites = $readerModel->getFavorites($readerId);
            $follows   = $readerModel->getFollows($readerId);

            $this->render('readers/dashboard', [
                'title'       => 'My Dashboard',
                'pageStyles'  => ['readers.css'],
                'pageScripts' => ['readers.js'],
                'favorites'   => $favorites,
                'follows'     => $follows,
            ]);
        } catch (\Exception $e) {
            $this->logger->error('Reader dashboard error: ' . $e->getMessage());
            http_response_code(500);
            $this->render('errors/500', [
                'title'       => 'Error',
                'pageStyles'  => ['error.css'],
                'pageScripts' => ['error.js'],
            ]);
        }
    }

    public function favorite(): void
    {
        header('Content-Type: application/json');
        try {
            $data     = json_decode(file_get_contents('php://input'), true);
            $workId   = (int)($data['workId'] ?? 0);
            $readerId = $_SESSION['user']['id'];

            $readerModel= new Reader($this->db);
            $favorited  = $readerModel->toggleFavorite($readerId, $workId);

            $this->logger->info("Reader {$readerId} toggled favorite on work {$workId}");
            echo json_encode(['success' => true, 'favorited' => $favorited]);
        } catch (\Exception $e) {
            $this->logger->error('Toggle favorite failed: ' . $e->getMessage());
            http_response_code(500);
            echo json_encode(['success' => false]);
        }
    }

    public function follow(): void
    {
        header('Content-Type: application/json');
        try {
            $data      = json_decode(file_get_contents('php://input'), true);
            $authorId  = (int)($data['authorId'] ?? 0);
            $readerId  = $_SESSION['user']['id'];

            $readerModel= new Reader($this->db);
            $following  = $readerModel->toggleFollow($readerId, $authorId);

            $this->logger->info("Reader {$readerId} toggled follow on author {$authorId}");
            echo json_encode(['success' => true, 'following' => $following]);
        } catch (\Exception $e) {
            $this->logger->error('Toggle follow failed: ' . $e->getMessage());
            http_response_code(500);
            echo json_encode(['success' => false]);
        }
    }
}
