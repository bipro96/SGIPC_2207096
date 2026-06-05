<?php
require_once '../includes/functions.php';
requireAdmin();

$pageTitle = 'Admin Dashboard';


$totalMembers = getMemberCount();
$totalEvents = getEventCount();
$totalResources = getResourceCount();
$totalContacts = getContactCount();
$unreadContacts = getUnreadContactCount();
$upcomingEvents = getUpcomingEventCount();


$recentContacts = getAllContacts();
$recentContacts = array_slice($recentContacts, 0, 5);
$recentEvents = getAllEvents();
$recentEvents = array_slice($recentEvents, 0, 5);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard — SGIPC</title>
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
            <li><a href="index.php" class="active">Dashboard</a></li>
            <li><a href="events.php">Events</a></li>
            <li><a href="members.php">Members</a></li>
            <li><a href="resources.php">Resources</a></li>
            <li><a href="contacts.php">Messages <?php if ($unreadContacts > 0): ?><span class="badge badge-cyan" style="margin-left:auto;font-size:0.65rem;"><?php echo $unreadContacts; ?></span><?php endif; ?></a></li>
            <li class="nav-separator"><a href="../index.php">&larr; Back to Site</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </aside>


    <div class="admin-main">
        <header class="admin-header">
            <h1>Dashboard</h1>
            <div style="display:flex;align-items:center;gap:var(--space-md);">
                <span style="color:var(--text-muted);font-size:0.875rem;"><?php echo sanitize($_SESSION['user_name'] ?? 'Admin'); ?></span>
                <div style="width:36px;height:36px;border-radius:50%;background:var(--gradient-cyan);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:0.875rem;">
                    <?php echo strtoupper(substr($_SESSION['user_name'] ?? 'A', 0, 1)); ?>
                </div>
            </div>
        </header>

        <div class="admin-content">
      
            <div class="admin-stats-grid">
                <div class="admin-stat-card">
                    <div class="admin-stat-value"><?php echo $totalMembers; ?></div>
                    <div class="admin-stat-label">Total Members</div>
                </div>
                <div class="admin-stat-card">
                    <div class="admin-stat-value"><?php echo $totalEvents; ?></div>
                    <div class="admin-stat-label">Total Events</div>
                </div>
                <div class="admin-stat-card">
                    <div class="admin-stat-value"><?php echo $upcomingEvents; ?></div>
                    <div class="admin-stat-label">Upcoming Events</div>
                </div>
                <div class="admin-stat-card">
                    <div class="admin-stat-value"><?php echo $totalContacts; ?></div>
                    <div class="admin-stat-label">Contact Messages</div>
                </div>
            </div>

            <div class="grid-2" style="gap:var(--space-xl);">
     
                <div>
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:var(--space-lg);">
                        <h2 style="font-family:var(--font-mono);font-size:1rem;">Recent Events</h2>
                        <a href="events.php" class="btn btn-sm btn-secondary">View All</a>
                    </div>
                    <div class="admin-table-wrap">
                        <table class="admin-table">
                            <thead>
                                <tr><th>Event</th><th>Date</th><th>Status</th></tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recentEvents as $event): ?>
                                <tr>
                                    <td><?php echo sanitize($event['title']); ?></td>
                                    <td><?php echo formatDate($event['event_date']); ?></td>
                                    <td><span class="badge badge-<?php echo $event['status'] === 'upcoming' ? 'green' : ($event['status'] === 'ongoing' ? 'orange' : 'cyan'); ?>"><?php echo ucfirst($event['status']); ?></span></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

               
                <div>
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:var(--space-lg);">
                        <h2 style="font-family:var(--font-mono);font-size:1rem;">Recent Messages</h2>
                        <a href="contacts.php" class="btn btn-sm btn-secondary">View All</a>
                    </div>
                    <div class="admin-table-wrap">
                        <table class="admin-table">
                            <thead>
                                <tr><th>Name</th><th>Subject</th><th>Status</th></tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recentContacts as $contact): ?>
                                <tr>
                                    <td><?php echo sanitize($contact['name']); ?></td>
                                    <td><?php echo ucfirst($contact['subject']); ?></td>
                                    <td><span class="badge badge-<?php echo $contact['is_read'] ? 'cyan' : 'green'; ?>"><?php echo $contact['is_read'] ? 'Read' : 'New'; ?></span></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
