<?php
$pageTitle = 'Sign up — CollegeConnect';
$activePage = 'signup';
$bodyClass = 'auth-page';
include "includes/header.php";
?>

<main class="auth-main">
    <div class="auth-card">
        <h1 class="auth-title">Create account</h1>
        <p class="auth-sub">Join CollegeConnect to share and learn from placement journeys.</p>

        <form action="backend/signup.php" method="POST">
            <div class="mb-3">
                <label class="form-label" for="name">Name</label>
                <input type="text" id="name" name="name" class="form-control" required autocomplete="name">
            </div>

            <div class="mb-3">
                <label class="form-label" for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" required autocomplete="email">
            </div>

            <div class="mb-3">
                <label class="form-label" for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" required autocomplete="new-password">
            </div>

            <div class="mb-3">
                <label class="form-label" for="role">Role</label>
                <select id="role" name="role" class="form-select" required>
                    <option value="student">Student</option>
                    <option value="senior">Senior (placed)</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">Sign up</button>
        </form>

        <p class="auth-footer-link">
            Already have an account? <a href="login.php">Login</a>
        </p>
    </div>
</main>

<?php include "includes/footer.php"; ?>
