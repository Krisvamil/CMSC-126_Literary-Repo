<?php $title = 'Login'; $pageStyles = ['auth.css']; $pageScripts = ['auth.js']; ?>
<?php ob_start(); ?>

<section class="auth-container">
    <h1>Login</h1>
    <form action="<?= BASE_URL ?>/auth/login" method="POST">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" required>

        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>

        <button type="submit">Login</button>
    </form>
</section>

<?php $content = ob_get_clean(); require __DIR__ . '/layout.php'; ?>
