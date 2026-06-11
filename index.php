<?php

require_once 'includes/functions.php';
$pageTitle = 'Home';
$activePage = 'home';


$featuredEvents = getFeaturedEvents(3);
$members = getAllMembers();
$settings = [];
$stmt = $pdo->query("SELECT * FROM settings");
while ($row = $stmt->fetch()) { $settings[$row['setting_key']] = $row['setting_value']; }

include 'includes/header.php';
?>


    <header class="hero">
        <div class="hero-bg"></div>
        <div class="container">
            <div class="hero-layout">
                <div class="hero-content">
                    <div class="hero-affiliation">
                        <img src="assets/images/kuet-logo.png" alt="KUET logo" class="hero-affiliation-logo">
                        <span>Khulna University of Engineering & Technology</span>
                    </div>
                    <h1 class="hero-title">SGIPC</h1>
                    <p class="hero-tagline"><?php echo sanitize($settings['tagline'] ?? 'A creative programming club where KUET coders practice, compete, and build contest confidence together.'); ?></p>
                    <div class="hero-buttons">
                        <a href="events.php" class="btn btn-primary">Explore Events</a>
                        <a href="contact.php" class="btn btn-secondary">Join Community</a>
                    </div>
                    <div class="hero-proof" aria-label="SGIPC focus areas">
                        <span>Weekly contests</span>
                        <span>Mentor-led training</span>
                        <span>ICPC preparation</span>
                    </div>
                </div>
                <div class="hero-visual">
                    <div class="hero-slider" aria-label="SGIPC activity photos">
                        <div class="hero-slider-track">
                            <div class="hero-slide">
                                <img src="assets/images/sgipc-collage.jpg" alt="SGIPC members and contest moments">
                            </div>
                            <div class="hero-slide">
                                <img src="assets/images/gallery1.jpg" alt="SGIPC programming session">
                            </div>
                            <div class="hero-slide">
                                <img src="assets/images/gallery2.jpg" alt="SGIPC event participants">
                            </div>
                            <div class="hero-slide">
                                <img src="assets/images/gallery3.jpg" alt="SGIPC prize giving moment">
                            </div>
                            <div class="hero-slide">
                                <img src="assets/images/icpc-world-finals.jpg" alt="ICPC World Finals memory">
                            </div>
                        </div>
                        <button class="hero-slider-btn hero-slider-prev" type="button" aria-label="Previous photo">&lsaquo;</button>
                        <button class="hero-slider-btn hero-slider-next" type="button" aria-label="Next photo">&rsaquo;</button>
                        <div class="hero-slider-dots" aria-label="Choose photo"></div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main>
        <section class="section stats-section">
            <div class="container">
                <div class="section-header animate-on-scroll">
                    <p class="section-label">Numbers</p>
                    <h2 class="section-title">Growing Together</h2>
                </div>
                <div class="stats-grid">
                    <div class="stat-item animate-on-scroll">
                        <div class="stat-number" data-target="<?php echo (int)($settings['member_count'] ?? 120); ?>">0</div>
                        <div class="stat-label">Active Members</div>
                    </div>
                    <div class="stat-item animate-on-scroll">
                        <div class="stat-number" data-target="<?php echo (int)($settings['contests_hosted'] ?? 45); ?>">0</div>
                        <div class="stat-label">Contests Hosted</div>
                    </div>
                    <div class="stat-item animate-on-scroll">
                        <div class="stat-number" data-target="<?php echo (int)($settings['total_participants'] ?? 340); ?>">0</div>
                        <div class="stat-label">Participants</div>
                    </div>
                </div>
            </div>
        </section>


        <section class="section section-tinted">
            <div class="container">
                <div class="section-header animate-on-scroll">
                    <p class="section-label">Highlights</p>
                    <h2 class="section-title">Featured Events</h2>
                    <p class="section-subtitle">Recent and upcoming activities that define our community</p>
                </div>
                <div class="grid-3">
                    <?php foreach ($featuredEvents as $event): ?>
                    <article class="card event-card animate-on-scroll">
                        <div class="event-card-top">
                            <div class="card-date"><?php echo formatDate($event['event_date']); ?></div>
                            <div class="event-status <?php echo $event['status']; ?>">
                                <span><?php echo $event['status'] === 'upcoming' ? '&#9679;' : '&#9675;'; ?></span>
                                <span><?php echo ucfirst($event['status']); ?></span>
                            </div>
                        </div>
                        <h3 class="card-title"><?php echo sanitize($event['title']); ?></h3>
                        <div class="event-meta"><?php echo sanitize($event['location']); ?></div>
                        <p class="card-text"><?php echo sanitize($event['description']); ?></p>
                    </article>
                    <?php endforeach; ?>
                </div>
                <div class="text-center mt-4">
                    <a href="events.php" class="btn btn-secondary">View All Events</a>
                </div>
            </div>
        </section>

      
        <section class="section">
            <div class="container">
                <div class="section-header animate-on-scroll">
                    <p class="section-label">Achievements</p>
                    <h2 class="section-title">Recent Milestones</h2>
                </div>
                <div class="grid-3">
                    <div class="card animate-on-scroll">
                        <div class="achievement-badge">
                            <span>&#9733;</span>
                            <span>ICPC 2024</span>
                        </div>
                        <h3 class="card-title">Asia Regional Finalist</h3>
                        <p class="card-text">Two SGIPC teams qualified for the ICPC Asia Dhaka Regional 2024, marking our best performance to date.</p>
                    </div>
                    <div class="card animate-on-scroll">
                        <div class="achievement-badge">
                            <span>&#9733;</span>
                            <span>KUET IUPC</span>
                        </div>
                        <h3 class="card-title">50+ Universities</h3>
                        <p class="card-text">Our Inter University Programming Contest brought together over 150 teams from across Bangladesh.</p>
                    </div>
                    <div class="card animate-on-scroll">
                        <div class="achievement-badge">
                            <span>&#9733;</span>
                            <span>Training</span>
                        </div>
                        <h3 class="card-title">500+ Problems Solved</h3>
                        <p class="card-text">Club members collectively solved over 500 problems during our winter training camp series.</p>
                    </div>
                </div>
            </div>
        </section>

 
        <section class="section section-cta">
            <div class="container">
                <div class="text-center animate-on-scroll">
                    <h2 class="section-title">Ready to Level Up?</h2>
                    <p class="section-subtitle mb-4">Join SGIPC and become part of KUET's most passionate competitive programming community.</p>
                    <div class="hero-buttons" style="justify-content: center;">
                        <a href="resources.php" class="btn btn-primary">Start Learning</a>
                        <a href="about.php" class="btn btn-secondary">Learn More</a>
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
