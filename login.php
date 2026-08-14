<?php
$pageTitle = 'Login — CollegeConnect';
$activePage = 'login';
$bodyClass = 'auth-page';
include "includes/header.php";
?>

<main class="auth-main">
    <div class="auth-card">
        <h1 class="auth-title">Welcome back</h1>
        <p class="auth-sub">Sign in to like, comment, and share experiences.</p>

        <form action="backend/login.php" method="POST">
            <div class="mb-3">
                <label class="form-label" for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" required autocomplete="email">
            </div>

            <div class="mb-3">
                <label class="form-label" for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" required autocomplete="current-password">
            </div>

            <button type="submit" class="btn btn-primary">Login</button>
        </form>

        <p class="auth-footer-link">
            Don&rsquo;t have an account? <a href="signup.php">Sign up</a>
        </p>
    </div>
</main>

<?php include "includes/footer.php"; ?>
