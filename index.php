<?php
session_start();
include "backend/config.php";

// Fetch experiences with student names AND total like counts in ONE single query
$sql = "SELECT e.*, 
               u.name AS student_name,
               COUNT(DISTINCT l.id) AS like_count
        FROM experiences e
        JOIN users u ON e.user_id = u.id
        LEFT JOIN likes l ON e.id = l.experience_id
        GROUP BY e.id
        ORDER BY e.id DESC";

$result = $conn->query($sql);

$pageTitle = 'CollegeConnect — Placement Experiences';
$activePage = 'home';
include "includes/header.php";
?>

<?php if (isset($_GET['added']) && $_GET['added'] === '1') { ?>
    <div class="container mt-3">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            Your experience was shared successfully. Thank you for helping juniors!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
<?php } ?>

<section class="hero">
    <div class="hero-bg">
        <img src="images/hero2.jpg" alt="hero image">
    </div>
    <div class="hero-overlay"></div>
    <div class="container">
        <div class="col-lg-8 col-xl-7">
            <p class="hero-brand">CollegeConnect</p>
            <p class="hero-tagline">
                Learn placements from your seniors — real hiring rounds, packages, and preparation tips from students who got placed.
            </p>
            <div class="hero-actions">
                <a href="experiences.php" class="btn btn-success btn-lg">Explore experiences</a>
                <a href="add_experience.php" class="btn btn-ghost btn-lg">Share your journey</a>
            </div>
        </div>
    </div>
</section>

<section class="stats-bar">
    <div class="container">
        <div class="row g-3">
            <div class="col-6 col-md-3">
                <div class="stat-item">
                    <div class="stat-value">20+</div>
                    <p class="stat-label">Companies covered</p>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-item">
                    <div class="stat-value">50+</div>
                    <p class="stat-label">Students placed</p>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-item">
                    <div class="stat-value">30+</div>
                    <p class="stat-label">Senior contributors</p>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-item">
                    <div class="stat-value">10+</div>
                    <p class="stat-label">Experiences shared</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section" id="featured-companies">
    <div class="container">
        <div class="section-header text-center">
            <span class="section-eyebrow">Hiring partners</span>
            <h2 class="section-title">Featured companies</h2>
            <p class="section-sub mx-auto">Insights drawn from campus drives at leading recruiters.</p>
        </div>
        <div class="logo-strip">
            <div class="logo-item"><img src="images/amazon.jpg" alt="Amazon"></div>
            <div class="logo-item"><img src="images/tcs.webp" alt="TCS"></div>
            <div class="logo-item"><img src="images/infosys.png" alt="Infosys"></div>
            <div class="logo-item"><img src="images/accenture.webp" alt="Accenture"></div>
        </div>
    </div>
</section>

<section class="section section-alt" id="placement-feed">
    <div class="container">
        <div class="section-header d-flex flex-column flex-md-row align-items-md-end justify-content-md-between gap-3">
            <div>
                <span class="section-eyebrow">Community</span>
                <h2 class="section-title">Placement feed</h2>
                <p class="section-sub">Recent stories from placed seniors on campus.</p>
            </div>
            <a href="experiences.php" class="btn btn-outline-primary">View all</a>
        </div>

        <?php if ($result && $result->num_rows > 0) { ?>
            <?php 
            // Prepared statement for comments to safely fetch comments per card
            $stmt_comments = $conn->prepare("
                SELECT c.comment, u.name 
                FROM comments c 
                JOIN users u ON c.user_id = u.id 
                WHERE c.experience_id = ? 
                ORDER BY c.id DESC LIMIT 5
            ");
            
            while ($row = $result->fetch_assoc()) { 
                $rounds = explode(",", $row['rounds']);
                $exp_id = (int)$row['id'];
                $like_count = (int)$row['like_count'];

                // Fetch up to 5 recent comments using prepared statement
                $stmt_comments->bind_param("i", $exp_id);
                $stmt_comments->execute();
                $comments_result = $stmt_comments->get_result();
            ?>

                <article class="card feed-card mb-4">
                    <div class="d-flex align-items-center mb-3">
                        <img src="images/user2.png" class="avatar me-3" alt="User avatar">
                        <div>
                            <h6 class="mb-0 fw-semibold" style="font-family: var(--font-body); color: var(--cc-navy);">
                                <?php echo htmlspecialchars($row['student_name']); ?>
                            </h6>
                            <small class="text-muted">
                                Placed in <?php echo htmlspecialchars($row['placement_year']); ?>
                            </small>
                        </div>
                    </div>

                    <h5 class="mb-2" style="font-size: 1.2rem;">
                        <a href="company.php?name=<?php echo urlencode($row['company']); ?>">
                            <?php echo htmlspecialchars($row['company']); ?>
                        </a>
                        <span class="text-muted fw-normal"> — <?php echo htmlspecialchars($row['role']); ?></span>
                    </h5>

                    <ul class="rounds-list">
                        <?php foreach ($rounds as $round) {
                            $r = trim($round);
                            if ($r === '') continue;
                        ?>
                            <li><?php echo htmlspecialchars($r); ?></li>
                        <?php } ?>
                    </ul>

                    <p class="text-muted mb-3">
                        <?php echo htmlspecialchars(mb_strimwidth($row['experience'], 0, 160, '…')); ?>
                    </p>

                    <p class="like-count mb-3"><?php echo $like_count; ?> like<?php echo $like_count === 1 ? '' : 's'; ?></p>

                    <div class="d-flex gap-2 flex-wrap">
                        <a href="view_experience.php?id=<?php echo $exp_id; ?>" class="btn btn-outline-primary btn-sm">
                            Read full experience
                        </a>

                        <?php if (isset($_SESSION['user_id'])) { ?>
                            <a href="backend/like.php?id=<?php echo $exp_id; ?>" class="btn btn-outline-success btn-sm">
                                Like
                            </a>
                        <?php } else { ?>
                            <a href="login.php" class="btn btn-outline-success btn-sm">
                                Login to like
                            </a>
                        <?php } ?>
                    </div>

                    <?php if (isset($_SESSION['user_id'])) { ?>
                        <form action="backend/add_comment.php" method="POST" class="mt-3 d-flex gap-2">
                            <input type="hidden" name="exp_id" value="<?php echo $exp_id; ?>">
                            <input type="text" name="comment" class="form-control" placeholder="Write a comment…" required>
                            <button type="submit" class="btn btn-primary">Post</button>
                        </form>
                    <?php } else { ?>
                        <div class="mt-3">
                            <a href="login.php" class="btn btn-outline-primary btn-sm">Login to comment</a>
                        </div>
                    <?php } ?>

                    <?php if ($comments_result && $comments_result->num_rows > 0) { ?>
                        <div class="mt-3">
                            <h6 class="text-muted mb-2" style="font-family: var(--font-body); font-size: 0.8rem; letter-spacing: 0.06em; text-transform: uppercase;">Comments</h6>
                            <?php while ($c = $comments_result->fetch_assoc()) { ?>
                                <div class="comment-box p-2 mb-1 bg-light rounded">
                                    <strong><?php echo htmlspecialchars($c['name']); ?>:</strong>
                                    <?php echo htmlspecialchars($c['comment']); ?>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </article>
            <?php 
            }
            $stmt_comments->close();
        } else { 
        ?>
            <div class="empty-state">
                <p class="mb-3">No experiences yet. Be the first to share your placement story.</p>
                <a href="add_experience.php" class="btn btn-success">Share an experience</a>
            </div>
        <?php } ?>
    </div>
</section>

<?php include "includes/footer.php"; ?>