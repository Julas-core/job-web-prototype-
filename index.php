<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JobLaunch | Home</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body class="page-wrap">
    <header class="navbar">
        <div class="brand">JobLaunch</div>
        <button class="nav-toggle" aria-label="Toggle navigation" aria-expanded="false"><span></span></button>
        <div class="nav-drawer">
            <div class="auth-links">
                <a href="login.html">Login</a>
                <span class="divider">|</span>
                <a href="register.html">Register</a>
            </div>
            <div class="nav-links">
                <a class="active" href="index.php">Home</a>
                <a href="catagories.html">Categories</a>
                <a href="about.html">AboutUs</a>
                <a href="contact.html">ContactUs</a>
            </div>
        </div>
    </header>

    <main class="container">
        <section class="hero">
            <h1>Apply <span class="accent-purple">Here</span>,<br>Find Your Future Job!</h1>
            <p class="hero-copy">Search thousands of roles, connect with top companies, and take the next step in your career.</p>
            <div class="search-row">
                <div class="search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                                <input class="search-input" type="text" placeholder="Job Title" aria-label="Search jobs by title">
                </div>
                <button class="btn hero-btn">Find Job</button>
            </div>
        </section>

        <section class="latest-jobs">
            <h2>Latest Jobs</h2>
            <div class="jobs-grid">
                <?php
                include "backendwithphp/db_conection.php";
                $sql = "SELECT j.id, j.title, j.location, j.type, j.salary, j.created_at, c.company_name 
                        FROM jobs j 
                        LEFT JOIN company c ON j.company_id = c.id 
                        ORDER BY j.created_at DESC LIMIT 6";
                $result = $conect->query($sql);
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="job-card">';
                        echo '<h3>' . htmlspecialchars($row['title']) . '</h3>';
                        echo '<p class="company">' . htmlspecialchars($row['company_name'] ?? 'Unknown') . '</p>';
                        echo '<p class="location"><i class="fa-solid fa-location-dot"></i> ' . htmlspecialchars($row['location']) . '</p>';
                        echo '<p class="type">' . htmlspecialchars($row['type']) . '</p>';
                        echo '<p class="salary">$' . htmlspecialchars($row['salary']) . '</p>';
                        echo '<a href="Users/job_detail.html?job_id=' . $row['id'] . '" class="btn">View Details</a>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>No jobs available at the moment.</p>';
                }
                ?>
            </div>
        </section>
    </main>
</body>
</html>