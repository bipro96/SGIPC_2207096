<?php
require_once 'includes/functions.php';
$pageTitle = 'Members';
$activePage = 'members';

$members = getAllMembers();
$expertCount = getExpertCount();
$teamCount = getTeamCount();
$newRecruitCount = getNewRecruitCount();

include 'includes/header.php';
?>

    <header class="page-header">
        <div class="page-header-bg"></div>
        <div class="container">
            <p class="section-label">Community</p>
            <h1 class="section-title">Members</h1>
            <p class="section-subtitle">The competitive programmers who make SGIPC exceptional</p>
        </div>
    </header>

    <main>
        <section class="section" style="padding-bottom: var(--space-lg);">
            <div class="container">
                <div class="text-center animate-on-scroll">
                    <p class="text-secondary" style="max-width: 600px; margin: 0 auto;">
                        These are some of our active competitive programmers with their Codeforces-style ratings and notable achievements. Ratings are updated periodically.
                    </p>
                </div>
            </div>
        </section>

        <section class="section" style="padding-top: 0;">
            <div class="container">
                <div class="grid-4">
                    <?php foreach ($members as $member): ?>
                    <article class="card member-card animate-on-scroll">
                        <div class="member-rating" style="color: var(--accent-<?php echo $member['color']; ?>)">
                            <?php echo (int)$member['rating']; ?> Rating
                        </div>
                        <h3 class="card-title"><?php echo sanitize($member['full_name']); ?></h3>
                        <div class="member-handle"><?php echo sanitize($member['handle']); ?></div>
                        <div class="achievement-badge">
                            <span>&#9733;</span>
                            <span><?php echo sanitize($member['achievement']); ?></span>
                        </div>
                    </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>


        <section class="section section-tinted">
            <div class="container">
                <div class="section-header animate-on-scroll">
                    <p class="section-label">Diversity</p>
                    <h2 class="section-title">Our Community by Numbers</h2>
                </div>
                <div class="grid-4">
                    <div class="card animate-on-scroll text-center">
                        <div class="stat-number" data-target="<?php echo $expertCount; ?>" style="font-size: 2.5rem;">0</div>
                        <p class="card-text">Expert+ Rated Members<br><span style="color: var(--text-muted); font-size: 0.8125rem;">Codeforces 1600+</span></p>
                    </div>
                    <div class="card animate-on-scroll text-center">
                        <div class="stat-number" data-target="15" style="font-size: 2.5rem;">0</div>
                        <p class="card-text">International Contest Experience<br><span style="color: var(--text-muted); font-size: 0.8125rem;">ICPC, Meta, Google</span></p>
                    </div>
                    <div class="card animate-on-scroll text-center">
                        <div class="stat-number" data-target="<?php echo $teamCount; ?>" style="font-size: 2.5rem;">0</div>
                        <p class="card-text">Active Teams<br><span style="color: var(--text-muted); font-size: 0.8125rem;">Preparing for ICPC 2025</span></p>
                    </div>
                    <div class="card animate-on-scroll text-center">
                        <div class="stat-number" data-target="<?php echo $newRecruitCount; ?>" style="font-size: 2.5rem;">0</div>
                        <p class="card-text">New Recruits (2024)<br><span style="color: var(--text-muted); font-size: 0.8125rem;">First-year students</span></p>
                    </div>
                </div>
            </div>
        </section>


        <section class="section">
            <div class="container">
                <div class="text-center animate-on-scroll">
                    <h2 class="section-title">Want to See Your Name Here?</h2>
                    <p class="section-subtitle mb-4">Every expert was once a beginner. Start your journey with SGIPC today.</p>
                    <a href="contact.php" class="btn btn-primary">Join the Club</a>
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
