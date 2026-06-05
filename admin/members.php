<?php
require_once '../includes/functions.php';
requireAdmin();

$pageTitle = 'Manage Members';
$unreadContacts = getUnreadContactCount();


if (isset($_GET['delete'])) {
    deleteMember((int)$_GET['delete']);
    setFlash('success', 'Member deleted successfully.');
    header('Location: members.php');
    exit;
}

$members = getAllMembers(false);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Members — SGIPC Admin</title>
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
            <li><a href="members.php" class="active">Members</a></li>
            <li><a href="resources.php">Resources</a></li>
            <li><a href="contacts.php">Messages <?php if ($unreadContacts > 0): ?><span class="badge badge-cyan" style="margin-left:auto;font-size:0.65rem;"><?php echo $unreadContacts; ?></span><?php endif; ?></a></li>
            <li class="nav-separator"><a href="../index.php">&larr; Back to Site</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </aside>

    <div class="admin-main">
        <header class="admin-header">
            <h1>Members</h1>
        </header>

        <div class="admin-content">
            <div class="admin-table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Handle</th>
                            <th>Email</th>
                            <th>Rating</th>
                            <th>Department</th>
                            <th>Status</th>
                            <th style="text-align:right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($members as $member): ?>
                        <tr>
                            <td><?php echo sanitize($member['full_name']); ?></td>
                            <td style="font-family:var(--font-mono);font-size:0.875rem;"><?php echo sanitize($member['handle']); ?></td>
                            <td><?php echo sanitize($member['email']); ?></td>
                            <td style="font-family:var(--font-mono);font-weight:700;color:var(--accent-<?php echo $member['color']; ?>)"><?php echo (int)$member['rating']; ?></td>
                            <td><?php echo sanitize($member['department'] ?: '-'); ?></td>
                            <td><span class="badge badge-<?php echo $member['is_active'] ? 'green' : 'red'; ?>"><?php echo $member['is_active'] ? 'Active' : 'Inactive'; ?></span></td>
                            <td style="text-align:right;">
                                <a href="members.php?delete=<?php echo $member['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this member?')">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</body>
</html>
