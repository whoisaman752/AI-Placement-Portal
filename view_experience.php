<?php
include "backend/config.php";

if (!isset($_GET['id'])) {
    $pageTitle = 'Experience not found — CollegeConnect';
    $activePage = 'experiences';
    include "includes/header.php";
    echo '<div class="container py-5"><div class="empty-state"><p class="mb-0">No experience selected.</p></div></div>';
    include "includes/footer.php";
    exit();
}

$id = (int)$_GET['id'];

$sql = "SELECT e.*, u.name AS student_name
        FROM experiences e
        JOIN users u ON e.user_id = u.id
        WHERE e.id = $id";

$result = $conn->query($sql);

if (!$result || $result->num_rows == 0) {
    $pageTitle = 'Experience not found — CollegeConnect';
    $activePage = 'experiences';
    include "includes/header.php";
    echo '<div class="container py-5"><div class="empty-state"><p class="mb-0">Experience not found.</p></div></div>';
    include "includes/footer.php";
    exit();
}

$row = $result->fetch_assoc();
$yearLabel = !empty($row['placement_year']) ? htmlspecialchars($row['placement_year']) : 'Year not added';

$pageTitle = $row['company'] . ' Experience — CollegeConnect';
$activePage = 'experiences';
include "includes/header.php";
?>

<div class="container page-hero">
    <div class="breadcrumb-nav">
        <a href="experiences.php">Experiences</a>
        / <a href="company.php?name=<?php echo urlencode($row['company']); ?>"><?php echo htmlspecialchars($row['company']); ?></a>
    </div>
    <h1><?php echo htmlspecialchars($row['company']); ?> — <?php echo htmlspecialchars($row['role']); ?></h1>
    <p class="text-muted mb-0">
        <?php echo htmlspecialchars($row['student_name']); ?> · Placed in <?php echo $yearLabel; ?>
        <?php if (!empty($row['package'])) { ?>
            · <?php echo htmlspecialchars($row['package']); ?> LPA
        <?php } ?>
    </p>
</div>

<div class="container pb-5">
    <div class="detail-panel">
        <h3 class="h5 mb-3">Interview rounds</h3>
        <ul class="rounds-list">
            <?php
            $rounds = explode(",", $row['rounds']);
            foreach ($rounds as $round) {
                $r = trim($round);
                if ($r === '') continue;
                echo '<li>' . htmlspecialchars($r) . '</li>';
            }
            ?>
        </ul>

        <h3 class="h5 mb-3">Full experience</h3>
        <div class="experience-body"><?php echo nl2br(htmlspecialchars($row['experience'])); ?></div>

        <div class="mt-4 d-flex gap-2 flex-wrap">
            <a href="experiences.php" class="btn btn-outline-primary">All experiences</a>
            <a href="index.php" class="btn btn-secondary">Back home</a>
        </div>
    </div>
</div>

<?php include "includes/footer.php"; ?>
