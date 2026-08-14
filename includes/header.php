<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$pageTitle = $pageTitle ?? 'CollegeConnect';
$activePage = $activePage ?? '';
$bodyClass = $bodyClass ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,650;9..144,700&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css?v=4">
</head>
<body class="<?php echo htmlspecialchars($bodyClass); ?>">

<nav class="navbar navbar-expand-lg cc-navbar sticky-top">
    <div class="container">
        <a class="cc-brand navbar-brand" href="index.php">
            🎓CollegeConnect
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
                <li class="nav-item">
                    <a class="nav-link<?php echo $activePage === 'home' ? ' active' : ''; ?>" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link<?php echo $activePage === 'experiences' ? ' active' : ''; ?>" href="experiences.php">Experiences</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link<?php echo $activePage === 'companies' ? ' active' : ''; ?>" href="companies.php">Companies</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link<?php echo $activePage === 'share' ? ' active' : ''; ?>" href="add_experience.php">Share</a>
                </li>

                <?php if (isset($_SESSION['user_id'])) { ?>
                    <li class="nav-item d-none d-lg-block">
                        <span class="nav-link text-muted" style="cursor: default;">
                            <?php echo htmlspecialchars($_SESSION['name'] ?? 'Student'); ?>
                        </span>
                    </li>
                    <li class="nav-item">
                        <a href="backend/logout.php" class="nav-link btn-nav-outline">Logout</a>
                    </li>
                <?php } else { ?>
                    <li class="nav-item">
                        <a class="nav-link<?php echo $activePage === 'login' ? ' active' : ''; ?>" href="login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a href="signup.php" class="nav-link btn-nav-cta">Sign up</a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>
