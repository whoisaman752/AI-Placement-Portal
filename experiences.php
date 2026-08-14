<?php
include "backend/config.php";

$pageTitle = 'All Experiences — CollegeConnect';
$activePage = 'experiences';
include "includes/header.php";
?>

<div class="container page-hero">
    <span class="section-eyebrow">Browse</span>
    <h1>All placement experiences</h1>
    <p class="text-muted mb-0">Round-by-round stories from seniors across companies and roles.</p>
</div>

<div class="container pb-5">
    <div class="row g-4">
        <?php
        $sql = "SELECT e.*, u.name AS student_name
                FROM experiences e
                JOIN users u ON e.user_id = u.id
                ORDER BY e.id DESC";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $rounds = explode(",", $row['rounds']);
        ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card exp-card">
                        <h5 class="mb-1" style="font-size: 1.15rem;">
                            <?php echo htmlspecialchars($row['company']); ?>
                        </h5>
                        <p class="mb-2 fw-medium" style="color: var(--cc-teal); font-size: 0.95rem;">
                            <?php echo htmlspecialchars($row['role']); ?>
                        </p>
                        <p class="card-meta">
                            <?php echo htmlspecialchars($row['student_name']); ?>
                            · Placed <?php echo htmlspecialchars($row['placement_year']); ?>
                        </p>

                        <ul class="rounds-list mb-3">
                            <?php foreach ($rounds as $round) {
                                $r = trim($round);
                                if ($r === '') continue;
                            ?>
                                <li><?php echo htmlspecialchars($r); ?></li>
                            <?php } ?>
                        </ul>

                        <a href="view_experience.php?id=<?php echo $row['id']; ?>" class="btn btn-primary mt-auto align-self-start">
                            View details
                        </a>
                    </div>
                </div>
        <?php
            }
        } else {
            echo '<div class="col-12"><div class="empty-state"><p class="mb-0">No experiences found.</p></div></div>';
        }
        ?>
    </div>
</div>

<?php include "includes/footer.php"; ?>
