<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\User;

class AuthController extends BaseController
{
    public function showLoginForm(): void
    {
        $this->render('login', [
            'title'       => 'Login',
            'pageStyles'  => ['auth.css'],
            'pageScripts' => ['auth.js'],
        ]);
    }

    public function login(): void
    {
        try {
            $email    = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            $userModel = new User($this->db);
            $user      = $userModel->findByEmail($email);

            if ($user && password_verify($password, $user['password_hash'])) {
                $_SESSION['user'] = [
                    'id'       => $user['id'],
                    'username' => $user['username'],
                    'role'     => $user['role'],
                ];
                $this->logger->info("Login successful for {$email}");
                $this->flash('success', "Welcome back, {$user['username']}!");
                $this->redirect('/dashboard');
            } else {
                $this->logger->error("Failed login attempt for {$email}");
                $this->flash('error', 'Invalid email or password.');
                $this->showLoginForm();
            }
        } catch (\Exception $e) {
            $this->logger->error('Login error: ' . $e->getMessage());
            http_response_code(500);
            $this->render('errors/500', [
                'title'       => 'Server Error',
                'pageStyles'  => ['error.css'],
                'pageScripts' => ['error.js'],
            ]);
        }
    }

    public function logout(): void
    {
        $username = $_SESSION['user']['username'] ?? 'Unknown';
        session_unset();
        session_destroy();
        session_start();
        $this->logger->info("Logout for {$username}");
        $this->flash('success', 'You have been logged out.');
        $this->redirect('/auth/login');
    }
}
