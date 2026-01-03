<?php 
    // Basic Configuration
    $site_name = "Researchia";
    $hero_title = "Research Paper Management";
    $hero_sub = "Simplifying Research from Submission to Publication.";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $site_name; ?> - Welcome</title>
    
    <link rel="stylesheet" href="../css/dashboardStyle.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <header>
        <div class="container navbar">
            <div class="logo">
                <i class="fas fa-microscope"></i> <?php echo $site_name; ?>
            </div>
            <div class="auth-nav">
                <a href="#">Login</a>
                <a href="#" class="btn-reg">Register</a>
            </div>
        </div>
    </header>
<hr>
    <main>
        <section class="hero">
            <div class="container">
                <div class="hero-grid">
                    <div class="hero-text">
                        <h1><?php echo $hero_title; ?></h1>
                        <p class="hero-sub-text"><?php echo $hero_sub; ?></p>
                        <p class="description">
                            Access the university's premier portal for secure paper submission 
                            and unbiased peer review management.
                        </p>
                    </div>
                    
                    <div class="hero-visual">
                        </div>
                </div>

                <div class="features">
                    <div class="feature-card">
                        <i class="fas fa-upload"></i>
                        <h3>Online Paper Submission</h3>
                    </div>
                    <div class="feature-card">
                        <i class="fas fa-user-friends"></i>
                        <h3>Blind Peer Review</h3>
                    </div>
                    <div class="feature-card">
                        <i class="fas fa-chart-bar"></i>
                        <h3>Scoring & Feedback</h3>
                    </div>
                </div>
            </div>
        </section>
    </main>

</body>
</html>