<?php
session_start();
include "../backendwithphp/db_conection.php";

if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'company' && $_SESSION['role'] !== 'employer')) {
    header("Location: ../login.html");
    exit();
}

$user_id = $_SESSION['user_id'];

// Get company_id
$stmt = $conect->prepare("SELECT company_id, company_name FROM company WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$res = $stmt->get_result();
$company = $res->fetch_assoc();
$company_id = $company['company_id'];
$company_name = $company['company_name'];
$stmt->close();

// Fetch jobs
$job_stmt = $conect->prepare("SELECT * FROM jobs WHERE company_id = ? ORDER BY created_at DESC");
$job_stmt->bind_param("i", $company_id);
$job_stmt->execute();
$jobs_result = $job_stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>JobLaunch | My Job Postings</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <link rel="stylesheet" href="../style.css">
</head>
<body class="page-wrap">
    <header class="navbar">
        <div class="brand">JobLaunch</div>
        <button class="nav-toggle" aria-label="Toggle navigation" aria-expanded="false"><span></span></button>
        <div class="nav-drawer">
            <div class="auth-links">
                <a href="../backendwithphp/logout.php">Sign Out</a>
            </div>
            <div class="nav-links">
                <a class="active" href="../index.php">Home</a>
                <a href="../catagories.html">Categories</a>
                <a href="../about.html">AboutUs</a>
                <a href="../contact.html">ContactUs</a>
            </div>
        </div>
    </header>
  <section class="dashboard-section container">
    <div class="dashboard-shell">
      <aside class="sidebar">
        <div class="avatar" style="background:#dcdcdc;"></div>
        <h3><?php echo htmlspecialchars($company_name); ?></h3>
        <nav>
          <a href="employer_dashboard.html">Post New Job</a>
          <a class="active" href="my_posting.php">Total Job Posted</a>
          <a href="view_applications.html">Total Applicants</a>
          <a href="settings.html">Setting</a>
          <a href="more.html">More</a>
        </nav>
      </aside>

      <div class="dashboard-main">
        <div class="dashboard-header-actions">
          <a href="../backendwithphp/logout.php">Sign Out</a>
          <a href="../catagories.html">Job Listings</a>
        </div>
        
        <h1 class="section-title" style="text-align: left; margin-top: 20px;">Active Job Postings</h1>

        <div class="job-list-container">
            <?php if ($jobs_result->num_rows > 0): ?>
                <?php while($job = $jobs_result->fetch_assoc()): ?>
                    <div class="job-card" style="margin-bottom: 20px; background: #1f1f1f; padding: 20px; border-radius: 8px;">
                        <h3 style="margin-top:0;"><?php echo htmlspecialchars($job['title']); ?></h3>
                        <p style="color: #ccc; font-size: 0.9rem;">
                            <i class="fa-solid fa-location-dot"></i> <?php echo htmlspecialchars($job['location']); ?> | 
                            <i class="fa-solid fa-briefcase"></i> <?php echo htmlspecialchars($job['type']); ?>
                        </p>
                        <p style="margin: 10px 0;"><?php echo nl2br(htmlspecialchars(substr($job['description'], 0, 150))) . '...'; ?></p>
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span style="color: #00d12d; font-weight: bold;"><?php echo htmlspecialchars($job['salary']); ?></span>
                            <a href="#" class="btn btn-sm" style="background: #7c1fd2;">Edit</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>You haven't posted any jobs yet.</p>
            <?php endif; ?>
        </div>

      </div>
    </div>
  </section>
</body>
</html>
