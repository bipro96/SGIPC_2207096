<?php
require_once '../includes/functions.php';
requireAdmin();

$pageTitle = 'Contact Messages';
$unreadContacts = getUnreadContactCount();


if (isset($_GET['read'])) {
    markContactRead((int)$_GET['read']);
    header('Location: contacts.php');
    exit;
}


if (isset($_GET['delete'])) {
    deleteContact((int)$_GET['delete']);
    setFlash('success', 'Message deleted.');
    header('Location: contacts.php');
    exit;
}

$filter = $_GET['filter'] ?? 'all';
$contacts = $filter === 'unread' ? getAllContacts(true) : getAllContacts();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Messages — SGIPC Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;700&family=Manrope:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="admin-body">

<div class="admin-layout">
    <aside class="admin-sidebar">
        <div class="admin-sidebar-header">
            <a href="../index.php" class="logo">SGIPC</a>
            <p>Admin Panel</p>
        </div>
        <ul class="admin-nav">
            <li><a href="index.php">Dashboard</a></li>
            <li><a href="events.php">Events</a></li>
            <li><a href="members.php">Members</a></li>
            <li><a href="resources.php">Resources</a></li>
            <li><a href="contacts.php" class="active">Messages <?php if ($unreadContacts > 0): ?><span class="badge badge-cyan" style="margin-left:auto;font-size:0.65rem;"><?php echo $unreadContacts; ?></span><?php endif; ?></a></li>
            <li class="nav-separator"><a href="../index.php">&larr; Back to Site</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </aside>

    <div class="admin-main">
        <header class="admin-header">
            <h1>Contact Messages</h1>
            <div style="display:flex;gap:var(--space-sm);">
                <a href="contacts.php" class="btn btn-sm <?php echo $filter === 'all' ? 'btn-primary' : 'btn-secondary'; ?>">All</a>
                <a href="contacts.php?filter=unread" class="btn btn-sm <?php echo $filter === 'unread' ? 'btn-primary' : 'btn-secondary'; ?>">Unread (<?php echo $unreadContacts; ?>)</a>
            </div>
        </header>

        <div class="admin-content">
            <?php if (empty($contacts)): ?>
                <div class="card" style="text-align:center;padding:var(--space-3xl);">
                    <p class="text-muted">No messages found.</p>
                </div>
            <?php else: ?>
                <?php foreach ($contacts as $contact): ?>
                <div class="contact-card <?php echo !$contact['is_read'] ? 'unread' : ''; ?>">
                    <div class="contact-card-header">
                        <div>
                            <h3 style="font-size:1.05rem;margin-bottom:4px;">
                                <?php echo sanitize($contact['name']); ?>
                                <?php if (!$contact['is_read']): ?><span style="display:inline-block;width:8px;height:8px;background:var(--accent-cyan);border-radius:50%;margin-left:8px;"></span><?php endif; ?>
                            </h3>
                            <p style="font-size:0.82rem;color:var(--text-muted);">
                                <?php echo sanitize($contact['email']); ?> &middot; <?php echo ucfirst($contact['subject']); ?> &middot; <?php echo timeAgo($contact['created_at']); ?>
                            </p>
                        </div>
                        <div style="display:flex;gap:var(--space-sm);">
                            <?php if (!$contact['is_read']): ?>
                            <a href="contacts.php?read=<?php echo $contact['id']; ?>" class="btn btn-sm btn-success">Mark Read</a>
                            <?php endif; ?>
                            <a href="mailto:<?php echo sanitize($contact['email']); ?>" class="btn btn-sm btn-secondary">Reply</a>
                            <a href="contacts.php?delete=<?php echo $contact['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this message?')">Delete</a>
                        </div>
                    </div>
                    <div class="contact-card-body">
                        <?php echo nl2br(sanitize($contact['message'])); ?>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

</body>
</html>
