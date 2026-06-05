<?php
require_once '../includes/functions.php';
requireAdmin();

$pageTitle = 'Manage Events';
$unreadContacts = getUnreadContactCount();


$action = $_GET['action'] ?? 'list';
$errors = [];


if (isset($_GET['delete'])) {
    deleteEvent((int)$_GET['delete']);
    setFlash('success', 'Event deleted successfully.');
    header('Location: events.php');
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'title' => trim($_POST['title'] ?? ''),
        'description' => trim($_POST['description'] ?? ''),
        'event_type' => $_POST['event_type'] ?? 'contest',
        'event_date' => $_POST['event_date'] ?? '',
        'event_time' => $_POST['event_time'] ?? null,
        'location' => trim($_POST['location'] ?? ''),
        'status' => $_POST['status'] ?? 'upcoming',
        'featured' => isset($_POST['featured']) ? 1 : 0
    ];

    if (empty($data['title'])) $errors[] = 'Title is required.';
    if (empty($data['description'])) $errors[] = 'Description is required.';
    if (empty($data['event_date'])) $errors[] = 'Date is required.';

    if (empty($errors)) {
        if (isset($_POST['event_id']) && !empty($_POST['event_id'])) {
            updateEvent((int)$_POST['event_id'], $data);
            setFlash('success', 'Event updated successfully.');
        } else {
            createEvent($data);
            setFlash('success', 'Event created successfully.');
        }
        header('Location: events.php');
        exit;
    }
}


$editEvent = null;
if ($action === 'edit' && isset($_GET['id'])) {
    $editEvent = getEventById((int)$_GET['id']);
}


$events = getAllEvents();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Events — SGIPC Admin</title>
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
            <li><a href="events.php" class="active">Events</a></li>
            <li><a href="members.php">Members</a></li>
            <li><a href="resources.php">Resources</a></li>
            <li><a href="contacts.php">Messages <?php if ($unreadContacts > 0): ?><span class="badge badge-cyan" style="margin-left:auto;font-size:0.65rem;"><?php echo $unreadContacts; ?></span><?php endif; ?></a></li>
            <li class="nav-separator"><a href="../index.php">&larr; Back to Site</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </aside>

    <div class="admin-main">
        <header class="admin-header">
            <h1><?php echo $action === 'add' || $action === 'edit' ? ($editEvent ? 'Edit Event' : 'Add Event') : 'Events'; ?></h1>
            <?php if ($action === 'list'): ?>
            <a href="events.php?action=add" class="btn btn-sm btn-primary">+ Add Event</a>
            <?php endif; ?>
        </header>

        <div class="admin-content">
            <?php if ($action === 'add' || $action === 'edit'): ?>
                <!-- Form -->
                <?php if (!empty($errors)): ?>
                <div class="form-error" style="margin-bottom:var(--space-lg);max-width:700px;">
                    <?php foreach ($errors as $error): ?><div><?php echo sanitize($error); ?></div><?php endforeach; ?>
                </div>
                <?php endif; ?>

                <div class="admin-form">
                    <form method="POST" action="">
                        <?php if ($editEvent): ?>
                        <input type="hidden" name="event_id" value="<?php echo $editEvent['id']; ?>">
                        <?php endif; ?>
                        <div class="form-group">
                            <label class="form-label">Title *</label>
                            <input type="text" name="title" class="form-input" value="<?php echo $editEvent ? sanitize($editEvent['title']) : ''; ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Description *</label>
                            <textarea name="description" class="form-textarea" required><?php echo $editEvent ? sanitize($editEvent['description']) : ''; ?></textarea>
                        </div>
                        <div class="grid-2" style="gap:var(--space-md);">
                            <div class="form-group">
                                <label class="form-label">Event Type</label>
                                <select name="event_type" class="form-select">
                                    <option value="contest" <?php echo ($editEvent && $editEvent['event_type'] === 'contest') ? 'selected' : ''; ?>>Contest</option>
                                    <option value="workshop" <?php echo ($editEvent && $editEvent['event_type'] === 'workshop') ? 'selected' : ''; ?>>Workshop</option>
                                    <option value="bootcamp" <?php echo ($editEvent && $editEvent['event_type'] === 'bootcamp') ? 'selected' : ''; ?>>Bootcamp</option>
                                    <option value="seminar" <?php echo ($editEvent && $editEvent['event_type'] === 'seminar') ? 'selected' : ''; ?>>Seminar</option>
                                    <option value="practice" <?php echo ($editEvent && $editEvent['event_type'] === 'practice') ? 'selected' : ''; ?>>Practice</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="upcoming" <?php echo ($editEvent && $editEvent['status'] === 'upcoming') ? 'selected' : ''; ?>>Upcoming</option>
                                    <option value="ongoing" <?php echo ($editEvent && $editEvent['status'] === 'ongoing') ? 'selected' : ''; ?>>Ongoing</option>
                                    <option value="past" <?php echo ($editEvent && $editEvent['status'] === 'past') ? 'selected' : ''; ?>>Past</option>
                                </select>
                            </div>
                        </div>
                        <div class="grid-2" style="gap:var(--space-md);">
                            <div class="form-group">
                                <label class="form-label">Date *</label>
                                <input type="date" name="event_date" class="form-input" value="<?php echo $editEvent ? $editEvent['event_date'] : ''; ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Time</label>
                                <input type="time" name="event_time" class="form-input" value="<?php echo $editEvent ? $editEvent['event_time'] : ''; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Location</label>
                            <input type="text" name="location" class="form-input" value="<?php echo $editEvent ? sanitize($editEvent['location']) : ''; ?>" placeholder="CSE Lab 304">
                        </div>
                        <div class="form-group">
                            <label style="display:flex;align-items:center;gap:var(--space-sm);cursor:pointer;">
                                <input type="checkbox" name="featured" <?php echo ($editEvent && $editEvent['featured']) ? 'checked' : ''; ?> style="accent-color:var(--accent-cyan);">
                                Featured on homepage
                            </label>
                        </div>
                        <div style="display:flex;gap:var(--space-md);">
                            <button type="submit" class="btn btn-primary"><?php echo $editEvent ? 'Update Event' : 'Create Event'; ?></button>
                            <a href="events.php" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            <?php else: ?>
             
                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Featured</th>
                                <th style="text-align:right;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($events as $event): ?>
                            <tr>
                                <td><?php echo sanitize($event['title']); ?></td>
                                <td><?php echo formatDate($event['event_date']); ?></td>
                                <td><?php echo ucfirst($event['event_type']); ?></td>
                                <td><span class="badge badge-<?php echo $event['status'] === 'upcoming' ? 'green' : ($event['status'] === 'ongoing' ? 'orange' : 'cyan'); ?>"><?php echo ucfirst($event['status']); ?></span></td>
                                <td><?php echo $event['featured'] ? '<span class="badge badge-green">Yes</span>' : '<span class="text-muted">No</span>'; ?></td>
                                <td style="text-align:right;">
                                    <a href="events.php?action=edit&id=<?php echo $event['id']; ?>" class="btn btn-sm btn-secondary">Edit</a>
                                    <a href="events.php?delete=<?php echo $event['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this event?')">Delete</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

</body>
</html>
