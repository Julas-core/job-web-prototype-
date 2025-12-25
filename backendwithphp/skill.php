<?php
session_start();
include "db_conection.php";

$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
if (!isset($_SESSION['user_id']) || ($role !== 'job_seeker' && $role !== 'seeker')) {
    header("Location: ../login.html");
    exit;
}

$id = (int) $_SESSION['user_id'];

$stmt = $conect->prepare("SELECT primary_interest AS skill_name, skill_level FROM job_seeker WHERE user_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$skills = [];
if ($result && $row = $result->fetch_assoc()) {
    // Support single or comma-separated lists in the DB
    $names = [];
    $levels = [];
    if (!empty($row['skill_name'])) {
        $names = array_map('trim', explode(',', $row['skill_name']));
    }
    if (!empty($row['skill_level'])) {
        $levels = array_map('trim', explode(',', $row['skill_level']));
    }

    $count = max(count($names), count($levels));
    for ($i = 0; $i < $count; $i++) {
        $skills[] = [
            'name' => $names[$i] ?? '',
            'level' => $levels[$i] ?? ''
        ];
    }
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Skills</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="../style.css">
    <style>
        .skill-table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
        .skill-table th, .skill-table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .skill-table th { background:#f4f4f4; }
        .empty-msg { margin-top: 1rem; color: #666; }
    </style>
</head>
<body class="page-wrap">
    <header class="navbar">
    <div class="brand">JobLaunch</div>
    <div class="nav-links">
      <a href="../index.html">Home</a>
      <a href="../catagories.html">Categories</a>
      <a href="../about.html">AboutUs</a>
      <a href="../contact.html">ContactUs</a>
    </div>
    <div class="auth-links">
      <a href="logout.php">Logout</a>    
    </div>
  </header>

  <section class="dashboard-section container">
    <div class="dashboard-shell">
      <aside class="sidebar">
        <div class="avatar"></div>
        <h3>User</h3>
        <nav>
            <a href="../Users/seeker_dashboard.html">Personal Info</a>
            <a href="../Users/my_applications.html">Applied Jobs List</a>
            <!-- <a href="user-progress.html">Progress</a> -->
            <a class="active" href="../backendwithphp/skill.php">Skills</a>
            <!-- <a href="user-settings.html">Setting</a> -->
            <!-- <a href="user-more.html">More</a> -->
        </nav>
      </aside>

    <div class="container">
        <h2>Your Skills</h2>
        <div class="skills-container">
            <?php if (count($skills) > 0): ?>
                <table class="skill-table" style="border: 1px solid #000000ff;">
                    <thead>
                        <tr>
                            <th style ="color: black;">Skill name</th>
                            <th style ="color: black;">Skill level</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($skills as $s): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($s['name']); ?></td>
                                <td><?php echo htmlspecialchars($s['level']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="empty-msg">No skills found. Add your skills from the profile settings.</div>
            <?php endif; ?>
        </div>
    </div>
    </div>
  </section>
</body>
</html>