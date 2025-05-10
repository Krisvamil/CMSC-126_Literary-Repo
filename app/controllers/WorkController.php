<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Work;

class WorkController extends BaseController
{
    public function index(): void
    {
        try {
            $workModel = new Work($this->db);
            $works     = $workModel->getAll();

            $this->render('dashboard', [
                'title'       => 'All Works',
                'pageStyles'  => ['dashboard.css'],
                'pageScripts' => ['dashboard.js'],
                'works'       => $works,
            ]);
        } catch (\Exception $e) {
            $this->logger->error('Error fetching works: ' . $e->getMessage());
            http_response_code(500);
            $this->render('errors/500', [
                'title'       => 'Error',
                'pageStyles'  => ['error.css'],
                'pageScripts' => ['error.js'],
            ]);
        }
    }

    public function create(): void
    {
        $this->render('works/create', [
            'title'       => 'Create Work',
            'pageStyles'  => ['authors.css'],
            'pageScripts' => ['authors.js'],
        ]);
    }

    public function store(): void
    {
        try {
            $title    = trim($_POST['title'] ?? '');
            $body     = trim($_POST['body']  ?? '');
            $authorId = $_SESSION['user']['id'];

            $workModel = new Work($this->db);
            $id        = $workModel->create($authorId, $title, $body);

            $this->logger->info("Created work ID {$id} by user {$authorId}");
            $this->flash('success', 'Work created successfully.');
            $this->redirect("/works?id={$id}");
        } catch (\Exception $e) {
            $this->logger->error('Create work failed: ' . $e->getMessage());
            $this->flash('error', 'Failed to create work.');
            $this->redirect('/works/create');
        }
    }

    public function edit(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        try {
            $workModel = new Work($this->db);
            $work      = $workModel->find($id);

            if (!$work) {
                http_response_code(404);
                $this->render('errors/404', [
                    'title'       => 'Not Found',
                    'pageStyles'  => ['error.css'],
                    'pageScripts' => ['error.js'],
                ]);
                return;
            }

            $this->render('works/edit', [
                'title'       => 'Edit Work',
                'pageStyles'  => ['authors.css'],
                'pageScripts' => ['authors.js'],
                'work'        => $work,
            ]);
        } catch (\Exception $e) {
            $this->logger->error('Edit work failed: ' . $e->getMessage());
            http_response_code(500);
            $this->render('errors/500', [
                'title'       => 'Error',
                'pageStyles'  => ['error.css'],
                'pageScripts' => ['error.js'],
            ]);
        }
    }

    public function update(): void
    {
        try {
            $id    = (int)($_POST['id']    ?? 0);
            $title = trim($_POST['title'] ?? '');
            $body  = trim($_POST['body']  ?? '');

            $workModel = new Work($this->db);
            $workModel->update($id, $title, $body);

            $this->logger->info("Updated work ID {$id}");
            $this->flash('success', 'Work updated.');
            $this->redirect("/works?id={$id}");
        } catch (\Exception $e) {
            $this->logger->error('Update work failed: ' . $e->getMessage());
            $this->flash('error', 'Failed to update work.');
            $this->redirect("/works/edit?id={$id}");
        }
    }

    public function destroy(): void
    {
        try {
            $id       = (int)($_POST['id'] ?? 0);
            $authorId = $_SESSION['user']['id'];

            $workModel = new Work($this->db);
            $workModel->delete($id);

            $this->logger->info("Deleted work ID {$id} by user {$authorId}");
            $this->flash('success', 'Work deleted.');
            $this->redirect('/authors');
        } catch (\Exception $e) {
            $this->logger->error("Delete work ID {$id} failed: {$e->getMessage()}");
            $this->flash('error', 'Failed to delete work.');
            $this->redirect('/authors');
        }
    }
}
