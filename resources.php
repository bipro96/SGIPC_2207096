<?php
require_once 'includes/functions.php';
$pageTitle = 'Resources';
$activePage = 'resources';

$beginnerResources = getAllResources('beginner');
$intermediateResources = getAllResources('intermediate');
$advancedResources = getAllResources('advanced');

include 'includes/header.php';
?>

    <header class="page-header">
        <div class="page-header-bg"></div>
        <div class="container">
            <p class="section-label">Library</p>
            <h1 class="section-title">Resources</h1>
            <p class="section-subtitle">Everything you need to start and grow your competitive programming journey</p>
        </div>
    </header>

    <main>
        <!-- Beginner -->
        <section class="section">
            <div class="container">
                <div class="resource-category">
                    <h2 class="category-title">
                        Beginner
                        <span class="tag">Start Here</span>
                    </h2>
                    <p class="text-secondary mb-3">New to competitive programming? These resources will build your foundation in problem solving, basic algorithms, and coding fundamentals.</p>
                    <div class="grid-2">
                        <?php foreach ($beginnerResources as $res): ?>
                        <a href="<?php echo sanitize($res['url']); ?>" target="_blank" rel="noopener" class="link-card animate-on-scroll">
                            <div class="link-card-icon"><?php echo sanitize($res['icon_code']); ?></div>
                            <div class="link-card-content">
                                <h4><?php echo sanitize($res['title']); ?></h4>
                                <p><?php echo sanitize($res['description']); ?></p>
                            </div>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </section>

        <!-- Intermediate -->
        <section class="section section-tinted">
            <div class="container">
                <div class="resource-category">
                    <h2 class="category-title">
                        Intermediate
                        <span class="tag" style="background: var(--accent-green-dim); color: var(--accent-green);">Level Up</span>
                    </h2>
                    <p class="text-secondary mb-3">Ready to push your skills further? These resources cover advanced data structures, common patterns, and intermediate contest strategies.</p>
                    <div class="grid-2">
                        <?php foreach ($intermediateResources as $res): ?>
                        <a href="<?php echo sanitize($res['url']); ?>" target="_blank" rel="noopener" class="link-card animate-on-scroll">
                            <div class="link-card-icon"><?php echo sanitize($res['icon_code']); ?></div>
                            <div class="link-card-content">
                                <h4><?php echo sanitize($res['title']); ?></h4>
                                <p><?php echo sanitize($res['description']); ?></p>
                            </div>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </section>

        <!-- Advanced -->
        <section class="section">
            <div class="container">
                <div class="resource-category">
                    <h2 class="category-title">
                        Advanced
                        <span class="tag">Expert</span>
                    </h2>
                    <p class="text-secondary mb-3">For serious competitors aiming for ICPC Regionals, World Finals, and top ratings. Advanced topics, hard problems, and elite contest preparation.</p>
                    <div class="grid-2">
                        <?php foreach ($advancedResources as $res): ?>
                        <a href="<?php echo sanitize($res['url']); ?>" target="_blank" rel="noopener" class="link-card animate-on-scroll">
                            <div class="link-card-icon"><?php echo sanitize($res['icon_code']); ?></div>
                            <div class="link-card-content">
                                <h4><?php echo sanitize($res['title']); ?></h4>
                                <p><?php echo sanitize($res['description']); ?></p>
                            </div>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </section>

        <!-- Platforms -->
        <section class="section section-tinted">
            <div class="container">
                <div class="section-header animate-on-scroll">
                    <p class="section-label">Platforms</p>
                    <h2 class="section-title">Where We Compete</h2>
                </div>
                <div class="grid-3">
                    <div class="card animate-on-scroll text-center">
                        <div style="font-family: var(--font-mono); font-size: 2.5rem; color: var(--accent-cyan); margin-bottom: var(--space-md);">CF</div>
                        <h3 class="card-title">Codeforces</h3>
                        <p class="card-text">The primary platform for our weekly practice and rating progress. Div 2 and Div 3 contests are recommended for all members.</p>
                    </div>
                    <div class="card animate-on-scroll text-center">
                        <div style="font-family: var(--font-mono); font-size: 2.5rem; color: var(--accent-green); margin-bottom: var(--space-md);">AC</div>
                        <h3 class="card-title">AtCoder</h3>
                        <p class="card-text">Beginner-friendly contests with clean problem statements. The ABC series is perfect for building speed and accuracy.</p>
                    </div>
                    <div class="card animate-on-scroll text-center">
                        <div style="font-family: var(--font-mono); font-size: 2.5rem; color: var(--accent-cyan); margin-bottom: var(--space-md);">LC</div>
                        <h3 class="card-title">LeetCode</h3>
                        <p class="card-text">Excellent for interview preparation alongside competitive programming. The weekly contests test practical algorithmic thinking.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <a href="index.php" class="logo">SGIPC</a>
                    <p>Special Group Interested in Programming Contest at Khulna University of Engineering & Technology. Building the next generation of competitive programmers since 2015.</p>
                </div>
                <div class="footer-nav">
                    <h4 class="footer-title">Quick Links</h4>
                    <ul class="footer-links">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="about.php">About</a></li>
                        <li><a href="events.php">Events</a></li>
                        <li><a href="members.php">Members</a></li>
                    </ul>
                </div>
                <div class="footer-nav">
                    <h4 class="footer-title">Resources</h4>
                    <ul class="footer-links">
                        <li><a href="resources.php">Beginner</a></li>
                        <li><a href="resources.php">Intermediate</a></li>
                        <li><a href="resources.php">Advanced</a></li>
                        <li><a href="contact.php">Contact</a></li>
                    </ul>
                </div>
                <div class="footer-nav">
                    <h4 class="footer-title">Connect</h4>
                    <ul class="footer-links">
                        <li><a href="#">Facebook</a></li>
                        <li><a href="#">Discord</a></li>
                        <li><a href="#">GitHub</a></li>
                        <li><a href="#">YouTube</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p class="footer-copyright">&copy; <?php echo date('Y'); ?> SGIPC &mdash; KUET. All rights reserved.</p>
                <div class="footer-social">
                    <a href="#" aria-label="Facebook">f</a>
                    <a href="#" aria-label="Discord">d</a>
                    <a href="#" aria-label="GitHub">g</a>
                    <a href="#" aria-label="YouTube">y</a>
                </div>
            </div>
        </div>
    </footer>

<?php include 'includes/footer.php'; ?>
