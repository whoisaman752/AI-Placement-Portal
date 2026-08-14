<?php
include "backend/config.php";

$company = $_GET['name'] ?? '';
$companySafe = $conn->real_escape_string($company);

$sql = "SELECT e.*, u.name AS student_name
        FROM experiences e
        JOIN users u ON e.user_id = u.id
        WHERE e.company = '$companySafe'
        ORDER BY e.id DESC";

$result = $conn->query($sql);

$pageTitle = $company . ' Experiences — CollegeConnect';
$activePage = 'companies';
include "includes/header.php";
?>

<div class="container page-hero">
    <div class="breadcrumb-nav">
        <a href="companies.php">Companies</a> / <?php echo htmlspecialchars($company); ?>
    </div>
    <h1><?php echo htmlspecialchars($company); ?></h1>
    <p class="text-muted mb-0">Placement experiences shared by seniors.</p>
</div>

<div class="container pb-5">
    <?php
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
    ?>
        <article class="card feed-card">
            <h5 class="mb-1"><?php echo htmlspecialchars($row['role']); ?></h5>
            <p class="text-muted mb-3">
                <?php echo htmlspecialchars($row['student_name']); ?>
                · <?php echo htmlspecialchars($row['placement_year']); ?>
            </p>
            <p class="mb-3">
                <?php echo htmlspecialchars(substr($row['experience'], 0, 150)); ?>…
            </p>
            <a href="view_experience.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">
                View details
            </a>
        </article>
    <?php
        }
    } else {
        echo '<div class="empty-state"><p class="mb-0">No experiences found for this company.</p></div>';
    }
    ?>
</div>

<?php include "includes/footer.php"; ?>
