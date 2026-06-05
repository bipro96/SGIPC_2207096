<?php
require_once '../includes/functions.php';
requireAdmin();

$pageTitle = 'Manage Resources';
$unreadContacts = getUnreadContactCount();

$action = $_GET['action'] ?? 'list';
$errors = [];


if (isset($_GET['delete'])) {
    deleteResource((int)$_GET['delete']);
    setFlash('success', 'Resource deleted successfully.');
    header('Location: resources.php');
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'title' => trim($_POST['title'] ?? ''),
        'description' => trim($_POST['description'] ?? ''),
        'url' => trim($_POST['url'] ?? ''),
        'category' => $_POST['category'] ?? 'beginner',
        'icon_code' => trim($_POST['icon_code'] ?? 'LN'),
        'sort_order' => (int)($_POST['sort_order'] ?? 0),
        'is_active' => isset($_POST['is_active']) ? 1 : 0
    ];

    if (empty($data['title'])) $errors[] = 'Title is required.';
    if (empty($data['url'])) $errors[] = 'URL is required.';

    if (empty($errors)) {
        if (isset($_POST['resource_id']) && !empty($_POST['resource_id'])) {
            updateResource((int)$_POST['resource_id'], $data);
            setFlash('success', 'Resource updated successfully.');
        } else {
            createResource($data);
            setFlash('success', 'Resource created successfully.');
        }
        header('Location: resources.php');
        exit;
    }
}


$editResource = null;
if ($action === 'edit' && isset($_GET['id'])) {
    $editResource = getResourceById((int)$_GET['id']);
}

$resources = getAllResources();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Resources — SGIPC Admin</title>
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
            <li><a href="resources.php" class="active">Resources</a></li>
            <li><a href="contacts.php">Messages <?php if ($unreadContacts > 0): ?><span class="badge badge-cyan" style="margin-left:auto;font-size:0.65rem;"><?php echo $unreadContacts; ?></span><?php endif; ?></a></li>
            <li class="nav-separator"><a href="../index.php">&larr; Back to Site</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </aside>

    <div class="admin-main">
        <header class="admin-header">
            <h1><?php echo $action === 'add' || $action === 'edit' ? ($editResource ? 'Edit Resource' : 'Add Resource') : 'Resources'; ?></h1>
            <?php if ($action === 'list'): ?>
            <a href="resources.php?action=add" class="btn btn-sm btn-primary">+ Add Resource</a>
            <?php endif; ?>
        </header>

        <div class="admin-content">
            <?php if ($action === 'add' || $action === 'edit'): ?>
                <?php if (!empty($errors)): ?>
                <div class="form-error" style="margin-bottom:var(--space-lg);max-width:700px;">
                    <?php foreach ($errors as $error): ?><div><?php echo sanitize($error); ?></div><?php endforeach; ?>
                </div>
                <?php endif; ?>

                <div class="admin-form">
                    <form method="POST" action="">
                        <?php if ($editResource): ?>
                        <input type="hidden" name="resource_id" value="<?php echo $editResource['id']; ?>">
                        <?php endif; ?>
                        <div class="form-group">
                            <label class="form-label">Title *</label>
                            <input type="text" name="title" class="form-input" value="<?php echo $editResource ? sanitize($editResource['title']) : ''; ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Description *</label>
                            <textarea name="description" class="form-textarea" required><?php echo $editResource ? sanitize($editResource['description']) : ''; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label">URL *</label>
                            <input type="url" name="url" class="form-input" value="<?php echo $editResource ? sanitize($editResource['url']) : ''; ?>" required>
                        </div>
                        <div class="grid-2" style="gap:var(--space-md);">
                            <div class="form-group">
                                <label class="form-label">Category</label>
                                <select name="category" class="form-select">
                                    <option value="beginner" <?php echo ($editResource && $editResource['category'] === 'beginner') ? 'selected' : ''; ?>>Beginner</option>
                                    <option value="intermediate" <?php echo ($editResource && $editResource['category'] === 'intermediate') ? 'selected' : ''; ?>>Intermediate</option>
                                    <option value="advanced" <?php echo ($editResource && $editResource['category'] === 'advanced') ? 'selected' : ''; ?>>Advanced</option>
                                    <option value="platform" <?php echo ($editResource && $editResource['category'] === 'platform') ? 'selected' : ''; ?>>Platform</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Icon Code</label>
                                <input type="text" name="icon_code" class="form-input" value="<?php echo $editResource ? sanitize($editResource['icon_code']) : 'LN'; ?>" maxlength="10">
                            </div>
                        </div>
                        <div class="grid-2" style="gap:var(--space-md);">
                            <div class="form-group">
                                <label class="form-label">Sort Order</label>
                                <input type="number" name="sort_order" class="form-input" value="<?php echo $editResource ? $editResource['sort_order'] : '0'; ?>">
                            </div>
                            <div class="form-group" style="display:flex;align-items:flex-end;padding-bottom:var(--space-sm);">
                                <label style="display:flex;align-items:center;gap:var(--space-sm);cursor:pointer;">
                                    <input type="checkbox" name="is_active" <?php echo (!$editResource || $editResource['is_active']) ? 'checked' : ''; ?> style="accent-color:var(--accent-cyan);">
                                    Active
                                </label>
                            </div>
                        </div>
                        <div style="display:flex;gap:var(--space-md);">
                            <button type="submit" class="btn btn-primary"><?php echo $editResource ? 'Update Resource' : 'Create Resource'; ?></button>
                            <a href="resources.php" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            <?php else: ?>
                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Icon</th>
                                <th>Status</th>
                                <th style="text-align:right;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($resources as $res): ?>
                            <tr>
                                <td><a href="<?php echo sanitize($res['url']); ?>" target="_blank" style="color:var(--accent-cyan);"><?php echo sanitize($res['title']); ?></a></td>
                                <td><span class="badge badge-<?php echo $res['category'] === 'beginner' ? 'green' : ($res['category'] === 'intermediate' ? 'orange' : ($res['category'] === 'advanced' ? 'red' : 'cyan')); ?>"><?php echo ucfirst($res['category']); ?></span></td>
                                <td style="font-family:var(--font-mono);font-weight:700;"><?php echo sanitize($res['icon_code']); ?></td>
                                <td><span class="badge badge-<?php echo $res['is_active'] ? 'green' : 'red'; ?>"><?php echo $res['is_active'] ? 'Active' : 'Inactive'; ?></span></td>
                                <td style="text-align:right;">
                                    <a href="resources.php?action=edit&id=<?php echo $res['id']; ?>" class="btn btn-sm btn-secondary">Edit</a>
                                    <a href="resources.php?delete=<?php echo $res['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this resource?')">Delete</a>
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
