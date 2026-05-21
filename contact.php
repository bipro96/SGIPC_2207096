<?php
require_once 'includes/functions.php';
$pageTitle = 'Contact Us';
$activePage = 'contact';

$settings = [];
$stmt = $pdo->query("SELECT * FROM settings");
while ($row = $stmt->fetch()) { $settings[$row['setting_key']] = $row['setting_value']; }

$success = false;
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? 'general');
    $message = trim($_POST['message'] ?? '');

    if (empty($name) || strlen($name) < 2) {
        $errors[] = 'Name is required (at least 2 characters).';
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please provide a valid email address.';
    }
    if (empty($message) || strlen($message) < 10) {
        $errors[] = 'Message must be at least 10 characters long.';
    }

    if (empty($errors)) {
        createContact([
            'name' => $name,
            'email' => $email,
            'subject' => $subject,
            'message' => $message
        ]);
        $success = true;
    }
}

include 'includes/header.php';
?>

    <header class="page-header">
        <div class="page-header-bg"></div>
        <div class="container">
            <p class="section-label">Connect</p>
            <h1 class="section-title">Contact Us</h1>
            <p class="section-subtitle">Have questions? Want to join? Reach out to the SGIPC team.</p>
        </div>
    </header>

    <main>
        <section class="section">
            <div class="container">
                <div class="grid-2">
                    <!-- Contact Info -->
                    <div class="animate-on-scroll">
                        <p class="section-label">Get in Touch</p>
                        <h2 class="section-title" style="text-align: left;">Let's Talk</h2>
                        <p class="text-secondary" style="font-size: 1rem; line-height: 1.8; margin-bottom: var(--space-xl);">
                            Whether you are a KUET student interested in competitive programming, a potential sponsor, or an alumni looking to mentor &mdash; we would love to hear from you.
                        </p>

                        <div style="display: flex; flex-direction: column; gap: var(--space-lg);">
                            <div class="about-feature">
                                <div class="about-feature-icon">LOC</div>
                                <div class="about-feature-content">
                                    <h3>Location</h3>
                                    <p><?php echo nl2br(sanitize($settings['location'] ?? "KUET Campus, Khulna-9203, Bangladesh\nComputer Science & Engineering Department")); ?></p>
                                </div>
                            </div>
                            <div class="about-feature">
                                <div class="about-feature-icon">@</div>
                                <div class="about-feature-content">
                                    <h3>Email</h3>
                                    <p><?php echo sanitize($settings['contact_email'] ?? 'sgipc@kuet.ac.bd'); ?><br><?php echo sanitize($settings['contact_email_alt'] ?? 'contact.sgipc@gmail.com'); ?></p>
                                </div>
                            </div>
                            <div class="about-feature">
                                <div class="about-feature-icon">TM</div>
                                <div class="about-feature-content">
                                    <h3>Practice Hours</h3>
                                    <p><?php echo nl2br(sanitize(($settings['practice_hours'] ?? 'Friday - Saturday: 2:00 PM to 6:00 PM') . "\n" . ($settings['practice_location'] ?? 'CSE Lab 304'))); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

           
                    <div class="animate-on-scroll">
                        <div class="card" style="background: var(--bg-surface); border: 1px solid var(--border);">
                            <p class="section-label">Form</p>
                            <h3 class="card-title" style="margin-bottom: var(--space-lg);">Send a Message</h3>

                            <?php if (!empty($errors)): ?>
                                <div class="form-error">
                                    <?php foreach ($errors as $error): ?>
                                        <div><?php echo sanitize($error); ?></div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                            <?php if ($success): ?>
                                <div class="form-success visible">
                                    Thank you. Your message has been received. We will get back to you soon.
                                </div>
                            <?php else: ?>
                            <form method="POST" action="">
                                <div class="form-group">
                                    <label for="form-name" class="form-label">Name</label>
                                    <input type="text" id="form-name" name="name" class="form-input" placeholder="Your full name" required>
                                </div>
                                <div class="form-group">
                                    <label for="form-email" class="form-label">Email</label>
                                    <input type="email" id="form-email" name="email" class="form-input" placeholder="your.email@example.com" required>
                                </div>
                                <div class="form-group">
                                    <label for="form-subject" class="form-label">Subject</label>
                                    <select id="form-subject" name="subject" class="form-select">
                                        <option value="general">General Inquiry</option>
                                        <option value="join">Join the Club</option>
                                        <option value="sponsor">Sponsorship</option>
                                        <option value="collab">Collaboration</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="form-message" class="form-label">Message</label>
                                    <textarea id="form-message" name="message" class="form-textarea" placeholder="Tell us how we can help..." required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary" style="width: 100%;">Send Message</button>
                            </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <section class="section section-tinted">
            <div class="container">
                <div class="section-header animate-on-scroll">
                    <p class="section-label">FAQ</p>
                    <h2 class="section-title">Common Questions</h2>
                </div>
                <div class="grid-2">
                    <div class="card animate-on-scroll">
                        <h3 class="card-title">Who can join SGIPC?</h3>
                        <p class="card-text">Any KUET student with interest in programming is welcome. No prior competitive programming experience is required &mdash; we have dedicated tracks for absolute beginners.</p>
                    </div>
                    <div class="card animate-on-scroll">
                        <h3 class="card-title">Is there a membership fee?</h3>
                        <p class="card-text">No. SGIPC is completely free for all KUET students. We are funded by the CSE department and occasional event sponsors.</p>
                    </div>
                    <div class="card animate-on-scroll">
                        <h3 class="card-title">How often are contests held?</h3>
                        <p class="card-text">We organize internal contests every weekend. Additionally, we participate in online contests from Codeforces, AtCoder, and other platforms as a group.</p>
                    </div>
                    <div class="card animate-on-scroll">
                        <h3 class="card-title">Can non-CSE students join?</h3>
                        <p class="card-text">Absolutely! While most members are from CSE, we welcome students from EEE, ME, Civil, and other departments who are passionate about programming.</p>
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
