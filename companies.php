<?php
include "backend/config.php";

$year = trim($_GET['year'] ?? '');
$company = trim($_GET['company'] ?? '');

// Base SQL Query using Prepared Statements
$sql = "SELECT company, academic_year, 
               COUNT(*) AS total_students,
               MIN(package) AS min_package,
               MAX(package) AS max_package
        FROM experiences
        WHERE 1=1";

$params = [];
$types = "";

if (!empty($year)) {
    $sql .= " AND academic_year = ?";
    $params[] = $year;
    $types .= "s";
}

if (!empty($company)) {
    // Escape LIKE special wildcards
    $companyParam = '%' . str_replace(['%', '_'], ['\%', '\_'], $company) . '%';
    $sql .= " AND company LIKE ?";
    $params[] = $companyParam;
    $types .= "s";
}

$sql .= " GROUP BY company, academic_year ORDER BY academic_year DESC";

$stmt = $conn->prepare($sql);

if ($params) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

$pageTitle = 'Company Insights — CollegeConnect';
$activePage = 'companies';
include "includes/header.php";
?>

<div class="container page-hero">
    <span class="section-eyebrow">Insights</span>
    <h1>Company insights</h1>
    <p class="text-muted mb-0">Compare placement counts and package ranges by company and year.</p>
</div>

<div class="container pb-5">

    <form method="GET" class="filter-bar">
        <div class="row g-2 align-items-end">
            <div class="col-md-5">
                <label class="form-label">Company</label>
                <input type="text" name="company" class="form-control"
                    value="<?php echo htmlspecialchars($company); ?>"
                    placeholder="Search company">
            </div>
            <div class="col-md-3">
                <label class="form-label">Academic year</label>
                <input type="text" name="year" class="form-control"
                    value="<?php echo htmlspecialchars($year); ?>"
                    placeholder="e.g. 2025-26">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Search</button>
            </div>
            <div class="col-md-2">
                <a href="companies.php" class="btn btn-secondary w-100">Clear</a>
            </div>
        </div>
    </form>

    <div class="row g-4">
    <?php
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $companyName = $row['company'];
            $academicYear = $row['academic_year'];
            $totalStudents = (int)$row['total_students'];
            $minPkg = $row['min_package'];
            $maxPkg = $row['max_package'];
    ?>
        <div class="col-md-6 col-lg-4">
            <div class="card company-card">
                <h5 class="mb-3">
                    <a href="company.php?name=<?php echo urlencode($companyName); ?>">
                        <?php echo htmlspecialchars($companyName); ?>
                    </a>
                </h5>

                <div class="meta-row">
                    <span>Year: <?php echo htmlspecialchars($academicYear); ?></span>
                </div>
                <div class="meta-row">
                    <span>Students placed: <strong style="color: var(--cc-navy);"><?php echo $totalStudents; ?></strong></span>
                </div>
                <div class="meta-row mb-3">
                    <span>
                        Package:
                        <strong style="color: var(--cc-navy);">
                        <?php
                        if (!is_null($minPkg) && $minPkg !== '') {
                            if ($minPkg == $maxPkg) {
                                echo htmlspecialchars($minPkg) . ' LPA';
                            } else {
                                echo htmlspecialchars($minPkg) . ' – ' . htmlspecialchars($maxPkg) . ' LPA';
                            }
                        } else {
                            echo 'Not available';
                        }
                        ?>
                        </strong>
                    </span>
                </div>

                <a href="company.php?name=<?php echo urlencode($companyName); ?>" class="btn btn-outline-primary btn-sm align-self-start">
                    View experiences
                </a>
            </div>
        </div>
    <?php
        }
    } else {
        echo '<div class="col-12"><div class="empty-state"><p class="mb-0">No data found for these filters.</p></div></div>';
    }
    
    // Close prepared statement
    $stmt->close();
    ?>
    </div>
</div>

<?php include "includes/footer.php"; ?>