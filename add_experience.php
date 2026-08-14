<?php
$pageTitle = 'Share Experience — CollegeConnect';
$activePage = 'share';
include "includes/header.php";
?>

<div class="container page-hero">
    <span class="section-eyebrow">Contribute</span>
    <h1>Share your placement journey</h1>
    <p class="text-muted mb-0">Help juniors prepare with honest, round-by-round insights.</p>
</div>

<div class="container pb-5">
    <div class="form-panel">
        <form action="backend/add_experience.php" method="POST">
            <label class="form-label" for="placement_year">Placement year</label>
            <input type="number"
                id="placement_year"
                name="placement_year"
                class="form-control"
                placeholder="e.g. 2026"
                min="2020"
                max="2035"
                required>

            <label class="form-label" for="company">Company name</label>
            <input type="text" id="company" name="company" class="form-control" placeholder="Company name" required>

            <label class="form-label" for="role">Job role</label>
            <input type="text" id="role" name="role" class="form-control" placeholder="Job role" required>

            <label class="form-label" for="academic_year">Academic year</label>
            <input type="text" id="academic_year" name="academic_year"
                placeholder="e.g. 2025-26"
                class="form-control" required>

            <label class="form-label" for="package">Package (LPA)</label>
            <input type="number" step="0.01" id="package" name="package" placeholder="e.g. 12.5" class="form-control" required>

            <label class="form-label" for="rounds">Interview rounds</label>
            <textarea id="rounds" name="rounds" class="form-control" placeholder="Aptitude, Technical, HR (comma-separated)" required></textarea>

            <label class="form-label" for="experience">Full experience</label>
            <textarea id="experience" name="experience" class="form-control" style="min-height: 160px;" placeholder="Describe your preparation and each round…" required></textarea>

            <button type="submit" class="btn btn-success w-100 mt-2">Submit experience</button>
        </form>
    </div>
</div>

<?php include "includes/footer.php"; ?>
