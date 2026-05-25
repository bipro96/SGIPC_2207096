<?php
require_once 'includes/functions.php';
$pageTitle = 'Events';
$activePage = 'events';

$filter = isset($_GET['filter']) ? sanitize($_GET['filter']) : 'all';
$events = getAllEvents($filter !== 'all' ? $filter : null);

include 'includes/header.php';
?>

    <header class="page-header">
        <div class="page-header-bg"></div>
        <div class="container">
            <p class="section-label">Calendar</p>
            <h1 class="section-title">Events</h1>
            <p class="section-subtitle">Contests, workshops, and community gatherings</p>
        </div>
    </header>

    <main>
   
        <section class="section compact-section">
            <div class="container">
                <div class="text-center animate-on-scroll">
                    <div class="filter-bar">
                        <a href="events.php" class="btn btn-sm <?php echo $filter === 'all' ? 'btn-primary' : 'btn-secondary'; ?>">All Events</a>
                        <a href="events.php?filter=upcoming" class="btn btn-sm <?php echo $filter === 'upcoming' ? 'btn-primary' : 'btn-secondary'; ?>">Upcoming</a>
                        <a href="events.php?filter=past" class="btn btn-sm <?php echo $filter === 'past' ? 'btn-primary' : 'btn-secondary'; ?>">Past</a>
                    </div>
                </div>
            </div>
        </section>

       
        <section class="section flush-top">
            <div class="container">
                <div class="grid-3">
                    <?php if (empty($events)): ?>
                        <div class="text-center" style="grid-column: 1 / -1; padding: var(--space-3xl) 0;">
                            <p class="text-muted">No events found in this category.</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($events as $event): ?>
                        <article class="card event-card animate-on-scroll">
                            <div class="event-card-top">
                                <div class="card-date"><?php echo formatDate($event['event_date']); ?></div>
                                <div class="event-status <?php echo $event['status']; ?>">
                                    <span><?php echo $event['status'] === 'upcoming' ? '&#9679;' : '&#9675;'; ?></span>
                                    <span><?php echo ucfirst($event['status']); ?></span>
                                </div>
                            </div>
                            <h3 class="card-title"><?php echo sanitize($event['title']); ?></h3>
                            <div class="event-meta"><?php echo sanitize($event['location']); ?> &middot; <?php echo sanitize($event['event_type']); ?></div>
                            <p class="card-text"><?php echo sanitize($event['description']); ?></p>
                        </article>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </section>


        <section class="section section-tinted">
            <div class="container">
                <div class="section-header animate-on-scroll">
                    <p class="section-label">Experience</p>
                    <h2 class="section-title">What to Expect</h2>
                </div>
                <div class="grid-3">
                    <div class="card animate-on-scroll">
                        <h3 class="card-title">Weekly Contests</h3>
                        <p class="card-text">Internal club contests every weekend with problems tailored to our members' skill levels. Great for consistent practice and rating improvement.</p>
                    </div>
                    <div class="card animate-on-scroll">
                        <h3 class="card-title">Training Camps</h3>
                        <p class="card-text">Intensive multi-day programs before major contests like ICPC. Covers advanced topics, mock contests, and team building exercises.</p>
                    </div>
                    <div class="card animate-on-scroll">
                        <h3 class="card-title">Workshops</h3>
                        <p class="card-text">Focused sessions on specific topics &mdash; dynamic programming, graph algorithms, number theory, and contest strategy from experienced members.</p>
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
