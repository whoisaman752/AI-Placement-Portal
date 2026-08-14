<footer class="cc-footer">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-5">
                <div class="footer-brand">CollegeConnect</div>
                <p class="mb-0" style="max-width: 28rem; font-size: 0.95rem;">
                    Real placement stories from seniors — rounds, packages, and preparation tips for your campus career journey.
                </p>
            </div>
            <div class="col-6 col-md-3">
                <p class="text-white fw-semibold mb-2" style="font-size: 0.85rem; letter-spacing: 0.06em; text-transform: uppercase;">Explore</p>
                <div class="d-flex flex-column gap-2">
                    <a href="experiences.php">Experiences</a>
                    <a href="companies.php">Companies</a>
                    <a href="add_experience.php">Share your journey</a>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <p class="text-white fw-semibold mb-2" style="font-size: 0.85rem; letter-spacing: 0.06em; text-transform: uppercase;">Account</p>
                <div class="d-flex flex-column gap-2">
                    <?php if (isset($_SESSION['user_id'])) { ?>
                        <a href="backend/logout.php">Logout</a>
                    <?php } else { ?>
                        <a href="login.php">Login</a>
                        <a href="signup.php">Create account</a>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="footer-bottom text-center text-md-start">
            &copy; <?php echo date('Y'); ?> CollegeConnect. Built for students, by students.
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/script.js"></script>
</body>
</html>
