<?php


require_once __DIR__ . '/db.php';


// SESSION & AUTHENTICATION

session_start();

function isLoggedIn() {
    return isset($_SESSION['user_id']) && isset($_SESSION['user_type']);
}

function isAdmin() {
    return isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin';
}

function isMember() {
    return isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'member';
}

function getCurrentUser() {
    global $pdo;
    if (!isLoggedIn()) return null;
    
    if (isAdmin()) {
        $stmt = $pdo->prepare("SELECT id, username, email, full_name, 'admin' as user_type FROM admins WHERE id = ?");
    } else {
        $stmt = $pdo->prepare("SELECT id, handle as username, email, full_name, 'member' as user_type, rating, handle FROM members WHERE id = ?");
    }
    $stmt->execute([$_SESSION['user_id']]);
    return $stmt->fetch();
}

function requireAdmin() {
    if (!isAdmin()) {
        header('Location: ../login.php');
        exit;
    }
}

function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit;
    }
}


// SECURITY & SANITIZATION

function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
}

function generateSlug($string) {
    $slug = strtolower(trim($string));
    $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
    $slug = preg_replace('/-+/', '-', $slug);
    return rtrim($slug, '-');
}


// FLASH MESSAGES

function setFlash($type, $message) {
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function getFlash() {
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}

function hasFlash() {
    return isset($_SESSION['flash']);
}


// DATE & TIME HELPERS

function formatDate($date) {
    return date('F j, Y', strtotime($date));
}

function formatDateTime($date, $time = null) {
    if ($time) {
        return date('F j, Y \a\t g:i A', strtotime($date . ' ' . $time));
    }
    return date('F j, Y', strtotime($date));
}

function timeAgo($datetime) {
    $time = strtotime($datetime);
    $now = time();
    $diff = $now - $time;
    
    if ($diff < 60) return 'just now';
    if ($diff < 3600) return floor($diff / 60) . ' min ago';
    if ($diff < 86400) return floor($diff / 3600) . ' hours ago';
    if ($diff < 604800) return floor($diff / 86400) . ' days ago';
    return formatDate($datetime);
}


// DATABASE QUERIES - EVENTS

function getAllEvents($status = null) {
    global $pdo;
    if ($status) {
        $stmt = $pdo->prepare("SELECT * FROM events WHERE status = ? ORDER BY event_date ASC");
        $stmt->execute([$status]);
    } else {
        $stmt = $pdo->query("SELECT * FROM events ORDER BY FIELD(status, 'ongoing', 'upcoming', 'past'), event_date ASC");
    }
    return $stmt->fetchAll();
}

function getFeaturedEvents($limit = 3) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM events WHERE featured = 1 ORDER BY event_date ASC LIMIT ?");
    $stmt->execute([$limit]);
    return $stmt->fetchAll();
}

function getEventBySlug($slug) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM events WHERE slug = ? LIMIT 1");
    $stmt->execute([$slug]);
    return $stmt->fetch();
}

function getEventById($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM events WHERE id = ? LIMIT 1");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function createEvent($data) {
    global $pdo;
    $slug = generateSlug($data['title']);
    $stmt = $pdo->prepare("INSERT INTO events (title, slug, description, event_type, event_date, event_time, location, status, featured) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$data['title'], $slug, $data['description'], $data['event_type'], $data['event_date'], $data['event_time'], $data['location'], $data['status'], $data['featured']]);
    return $pdo->lastInsertId();
}

function updateEvent($id, $data) {
    global $pdo;
    $slug = generateSlug($data['title']);
    $stmt = $pdo->prepare("UPDATE events SET title = ?, slug = ?, description = ?, event_type = ?, event_date = ?, event_time = ?, location = ?, status = ?, featured = ? WHERE id = ?");
    $stmt->execute([$data['title'], $slug, $data['description'], $data['event_type'], $data['event_date'], $data['event_time'], $data['location'], $data['status'], $data['featured'], $id]);
}

function deleteEvent($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM events WHERE id = ?");
    $stmt->execute([$id]);
}

// ============================================
// DATABASE QUERIES - MEMBERS
// ============================================
function getAllMembers($activeOnly = true) {
    global $pdo;
    if ($activeOnly) {
        $stmt = $pdo->query("SELECT * FROM members WHERE is_active = 1 ORDER BY rating DESC");
    } else {
        $stmt = $pdo->query("SELECT * FROM members ORDER BY rating DESC");
    }
    return $stmt->fetchAll();
}

function getMemberById($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM members WHERE id = ? LIMIT 1");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function getMemberByHandle($handle) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM members WHERE handle = ? LIMIT 1");
    $stmt->execute([$handle]);
    return $stmt->fetch();
}

function createMember($data) {
    global $pdo;
    $hash = password_hash($data['password'], PASSWORD_BCRYPT);
    $stmt = $pdo->prepare("INSERT INTO members (full_name, handle, email, password_hash, rating, achievement, color, department, student_id, bio) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$data['full_name'], $data['handle'], $data['email'], $hash, $data['rating'] ?? 0, $data['achievement'] ?? '', $data['color'] ?? 'cyan', $data['department'] ?? '', $data['student_id'] ?? '', $data['bio'] ?? '']);
    return $pdo->lastInsertId();
}

function updateMember($id, $data) {
    global $pdo;
    $fields = [];
    $values = [];
    
    foreach ($data as $key => $value) {
        if ($key === 'password' && !empty($value)) {
            $fields[] = 'password_hash = ?';
            $values[] = password_hash($value, PASSWORD_BCRYPT);
        } elseif ($key !== 'password') {
            $fields[] = "$key = ?";
            $values[] = $value;
        }
    }
    
    $values[] = $id;
    $sql = "UPDATE members SET " . implode(', ', $fields) . " WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($values);
}

function deleteMember($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM members WHERE id = ?");
    $stmt->execute([$id]);
}

function getMemberCount() {
    global $pdo;
    return $pdo->query("SELECT COUNT(*) FROM members WHERE is_active = 1")->fetchColumn();
}

function getExpertCount() {
    global $pdo;
    return $pdo->query("SELECT COUNT(*) FROM members WHERE rating >= 1600 AND is_active = 1")->fetchColumn();
}

function getTeamCount() {
    global $pdo;
    return $pdo->query("SELECT COUNT(*) FROM members WHERE rating >= 1800 AND is_active = 1")->fetchColumn();
}

function getNewRecruitCount() {
    global $pdo;
    return $pdo->query("SELECT COUNT(*) FROM members WHERE created_at >= DATE_SUB(NOW(), INTERVAL 1 YEAR) AND is_active = 1")->fetchColumn();
}

// DATABASE QUERIES - RESOURCES

function getAllResources($category = null) {
    global $pdo;
    if ($category) {
        $stmt = $pdo->prepare("SELECT * FROM resources WHERE category = ? AND is_active = 1 ORDER BY sort_order ASC");
        $stmt->execute([$category]);
    } else {
        $stmt = $pdo->query("SELECT * FROM resources WHERE is_active = 1 ORDER BY category, sort_order ASC");
    }
    return $stmt->fetchAll();
}

function getResourceById($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM resources WHERE id = ? LIMIT 1");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function createResource($data) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO resources (title, description, url, category, icon_code, sort_order, is_active) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$data['title'], $data['description'], $data['url'], $data['category'], $data['icon_code'], $data['sort_order'], $data['is_active']]);
    return $pdo->lastInsertId();
}

function updateResource($id, $data) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE resources SET title = ?, description = ?, url = ?, category = ?, icon_code = ?, sort_order = ?, is_active = ? WHERE id = ?");
    $stmt->execute([$data['title'], $data['description'], $data['url'], $data['category'], $data['icon_code'], $data['sort_order'], $data['is_active'], $id]);
}

function deleteResource($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM resources WHERE id = ?");
    $stmt->execute([$id]);
}


// DATABASE QUERIES - CONTACTS

function getAllContacts($unreadOnly = false) {
    global $pdo;
    if ($unreadOnly) {
        $stmt = $pdo->query("SELECT * FROM contacts WHERE is_read = 0 ORDER BY created_at DESC");
    } else {
        $stmt = $pdo->query("SELECT * FROM contacts ORDER BY created_at DESC");
    }
    return $stmt->fetchAll();
}

function getContactById($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM contacts WHERE id = ? LIMIT 1");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function createContact($data) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO contacts (name, email, subject, message) VALUES (?, ?, ?, ?)");
    $stmt->execute([$data['name'], $data['email'], $data['subject'], $data['message']]);
    return $pdo->lastInsertId();
}

function markContactRead($id) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE contacts SET is_read = 1 WHERE id = ?");
    $stmt->execute([$id]);
}

function deleteContact($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM contacts WHERE id = ?");
    $stmt->execute([$id]);
}

function getUnreadContactCount() {
    global $pdo;
    return $pdo->query("SELECT COUNT(*) FROM contacts WHERE is_read = 0")->fetchColumn();
}

// DATABASE QUERIES - SETTINGS

function getSetting($key, $default = '') {
    global $pdo;
    $stmt = $pdo->prepare("SELECT setting_value FROM settings WHERE setting_key = ?");
    $stmt->execute([$key]);
    $result = $stmt->fetch();
    return $result ? $result['setting_value'] : $default;
}

function updateSetting($key, $value) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE settings SET setting_value = ? WHERE setting_key = ?");
    $stmt->execute([$value, $key]);
}


// STATS HELPERS

function getEventCount() {
    global $pdo;
    return $pdo->query("SELECT COUNT(*) FROM events")->fetchColumn();
}

function getResourceCount() {
    global $pdo;
    return $pdo->query("SELECT COUNT(*) FROM resources")->fetchColumn();
}

function getContactCount() {
    global $pdo;
    return $pdo->query("SELECT COUNT(*) FROM contacts")->fetchColumn();
}

function getUpcomingEventCount() {
    global $pdo;
    return $pdo->query("SELECT COUNT(*) FROM events WHERE status = 'upcoming'")->fetchColumn();
}
