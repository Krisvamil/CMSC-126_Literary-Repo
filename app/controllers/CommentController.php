<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Comment;

class CommentController extends BaseController
{
    public function store(): void
    {
        try {
            $workId = (int)($_POST['work_id'] ?? 0);
            $body   = trim($_POST['body']     ?? '');
            $userId = $_SESSION['user']['id'];

            $commentModel = new Comment($this->db);
            $commentModel->create($workId, $userId, $body);

            $this->logger->info("Added comment to work {$workId} by user {$userId}");
            $this->flash('success', 'Comment added.');
            $this->redirect("/works?id={$workId}");
        } catch (\Exception $e) {
            $this->logger->error('Add comment failed: ' . $e->getMessage());
            $this->flash('error', 'Failed to add comment.');
            $this->redirect("/works?id={$workId}");
        }
    }

    public function destroy(): void
    {
        try {
            $id     = (int)($_POST['id']      ?? 0);
            $workId = (int)($_POST['work_id'] ?? 0);

            $commentModel = new Comment($this->db);
            $commentModel->delete($id);

            $this->logger->info("Deleted comment {$id} from work {$workId}");
            $this->flash('success', 'Comment deleted.');
            $this->redirect("/works?id={$workId}");
        } catch (\Exception $e) {
            $this->logger->error('Delete comment failed: ' . $e->getMessage());
            $this->flash('error', 'Failed to delete comment.');
            $this->redirect("/works?id={$workId}");
        }
    }
}
