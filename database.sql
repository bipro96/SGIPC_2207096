-- SGIPC Database Schema
-- Khulna University of Engineering & Technology
-- Programming Club Management System

CREATE DATABASE IF NOT EXISTS sgipc CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE sgipc;

-- ============================================
-- 1. ADMINS TABLE
-- ============================================
CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================
-- 2. EVENTS TABLE
-- ============================================
CREATE TABLE IF NOT EXISTS events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    slug VARCHAR(200) NOT NULL UNIQUE,
    description TEXT NOT NULL,
    event_type ENUM('contest', 'workshop', 'bootcamp', 'seminar', 'practice') DEFAULT 'contest',
    event_date DATE NOT NULL,
    event_time TIME,
    location VARCHAR(200),
    status ENUM('upcoming', 'past', 'ongoing') DEFAULT 'upcoming',
    featured TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================
-- 3. MEMBERS TABLE
-- ============================================
CREATE TABLE IF NOT EXISTS members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    handle VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    rating INT DEFAULT 0,
    achievement VARCHAR(200),
    color ENUM('cyan', 'green', 'orange') DEFAULT 'cyan',
    department VARCHAR(50),
    student_id VARCHAR(20),
    bio TEXT,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================
-- 4. RESOURCES TABLE
-- ============================================
CREATE TABLE IF NOT EXISTS resources (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    description TEXT NOT NULL,
    url VARCHAR(500) NOT NULL,
    category ENUM('beginner', 'intermediate', 'advanced', 'platform') NOT NULL,
    icon_code VARCHAR(10) DEFAULT 'LN',
    sort_order INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================
-- 5. CONTACTS TABLE
-- ============================================
CREATE TABLE IF NOT EXISTS contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    subject VARCHAR(50) DEFAULT 'general',
    message TEXT NOT NULL,
    is_read TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================
-- 6. SITE SETTINGS TABLE
-- ============================================
CREATE TABLE IF NOT EXISTS settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(50) NOT NULL UNIQUE,
    setting_value TEXT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================
-- INSERT DEFAULT DATA
-- ============================================

-- Default admin (password: admin123)
INSERT INTO admins (username, email, password_hash, full_name) VALUES
('admin', 'admin@sgipc.kuet.ac.bd', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'SGIPC Administrator');

-- Sample Events
INSERT INTO events (title, slug, description, event_type, event_date, event_time, location, status, featured) VALUES
('KUET Inter University Programming Contest', 'kuet-iupc-2026', 'A full-day onsite contest bringing university teams together for problem solving, rankings, and post-contest analysis.', 'contest', '2026-03-22', '09:00:00', 'CSE Building Auditorium', 'past', 1),
('Graph Theory Practice Sprint', 'graph-theory-sprint', 'Focused internal contest and editorial session on shortest paths, trees, DSU, and graph modeling patterns.', 'practice', '2026-04-18', '14:00:00', 'CSE Lab 304', 'past', 1),
('SGIPC Summer Training Camp', 'summer-training-camp-2026', 'Advanced algorithms, mock contests, team coordination, and daily upsolving for members preparing for regional contests.', 'bootcamp', '2026-06-28', '10:00:00', 'CSE Building', 'upcoming', 1),
('Beginner Bootcamp', 'beginner-bootcamp-2026', 'A structured introduction to competitive programming with hands-on sessions on implementation, math, and basic data structures.', 'workshop', '2026-07-19', '14:00:00', 'CSE Lab 304', 'upcoming', 1),
('ICPC Warmup Contest', 'icpc-warmup-2026', 'A three-person team contest designed to simulate ICPC conditions, communication pressure, and scoreboard strategy.', 'contest', '2026-08-16', '09:00:00', 'CSE Building Auditorium', 'upcoming', 0),
('Algorithmic Thinking Workshop', 'algo-thinking-workshop', 'A practical workshop on recognizing patterns, proving ideas, and turning rough observations into accepted solutions.', 'workshop', '2026-09-06', '14:00:00', 'CSE Lab 304', 'upcoming', 0);

-- Sample Members
INSERT INTO members (full_name, handle, email, password_hash, rating, achievement, color, department, student_id, bio) VALUES
('Rafid Hasan', 'rafid_01', 'rafid@student.kuet.ac.bd', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 2048, 'ICPC Asia Regional Finalist', 'cyan', 'CSE', '2007001', 'Passionate competitive programmer specializing in graph algorithms and dynamic programming.'),
('Nusrat Jahan', 'nusrat_j', 'nusrat@student.kuet.ac.bd', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1892, 'Codeforces Expert', 'green', 'CSE', '2007015', 'Expert in number theory and combinatorics. Loves mentoring junior members.'),
('Tanvir Ahmed', 'tanvir_cse', 'tanvir@student.kuet.ac.bd', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 2156, '2x ICPC Regionalist', 'cyan', 'CSE', '2007023', 'Team leader and strategist. Focused on ICPC World Finals preparation.'),
('Sadia Islam', 'sadia_i', 'sadia@student.kuet.ac.bd', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1754, 'KUET IUPC Champion', 'green', 'CSE', '2007031', 'Full-stack developer and competitive programmer. Expert in data structures.'),
('Imran Hossain', 'imran_h', 'imran@student.kuet.ac.bd', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1987, 'Meta Hacker Cup Round 3', 'cyan', 'CSE', '2007042', 'Algorithm enthusiast with a passion for geometry and string problems.'),
('Farhana Akter', 'farhana_a', 'farhana@student.kuet.ac.bd', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1823, 'Google Code Jam Qualifier', 'green', 'CSE', '2007051', 'Rising star in competitive programming. Specialist in greedy algorithms.'),
('Mehedi Hasan', 'mehedi_cp', 'mehedi@student.kuet.ac.bd', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 2234, 'ICPC World Finals aspirant', 'cyan', 'CSE', '2007063', 'One of the highest rated competitive programmers at KUET. Expert in all topics.'),
('Priya Saha', 'priya_s', 'priya@student.kuet.ac.bd', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1678, 'SGIPC Top Coder 2024', 'green', 'CSE', '2007071', 'Dedicated problem solver with steady rating growth. Loves constructive algorithms.');

-- Sample Resources - Beginner
INSERT INTO resources (title, description, url, category, icon_code, sort_order) VALUES
('Codeforces Edu - ITMO', 'Step-by-step course on basic algorithms and data structures with practice problems.', 'https://codeforces.com/edu/course/2', 'beginner', 'CF', 1),
('CSES Problem Set', 'Comprehensive collection of competitive programming problems organized by topic.', 'https://cses.fi/problemset/', 'beginner', 'CS', 2),
('USACO Guide', 'Structured learning path from Bronze to Platinum with modules and curated problems.', 'https://usaco.guide/', 'beginner', 'US', 3),
('HackerRank - Algorithms', 'Beginner-friendly environment with tutorials and easy-to-medium difficulty problems.', 'https://www.hackerrank.com/domains/algorithms', 'beginner', 'HR', 4);

-- Sample Resources - Intermediate
INSERT INTO resources (title, description, url, category, icon_code, sort_order) VALUES
('Codeforces', 'The largest competitive programming platform. Regular contests, Div 2/3 participation, and vast problem archive.', 'https://codeforces.com/', 'intermediate', 'CF', 1),
('AtCoder', 'Japanese platform known for high-quality problems. ABC and ARC contests are excellent for skill building.', 'https://atcoder.jp/', 'intermediate', 'AC', 2),
('CP-Algorithms', 'Comprehensive reference for competitive programming algorithms with clear explanations and code.', 'https://cp-algorithms.com/', 'intermediate', 'CP', 3),
('LeetCode', 'Excellent for interview prep and practicing standard patterns. Weekly contests and company-tagged problems.', 'https://leetcode.com/', 'intermediate', 'LC', 4);

-- Sample Resources - Advanced
INSERT INTO resources (title, description, url, category, icon_code, sort_order) VALUES
('Typical DP Contest', '90 essential competitive programming problems covering a wide range of classic techniques and patterns.', 'https://atcoder.jp/contests/typical90', 'advanced', '90', 1),
('OJ.uz', 'Archive of problems from prestigious contests like IOI, CEOI, and Balkan OI. High difficulty, high reward.', 'https://oj.uz/', 'advanced', 'OJ', 2),
('Library Checker', 'Test your implementations of advanced algorithms against strict test cases. Great for verifying your code library.', 'https://library-checker.herokuapp.com/', 'advanced', 'LB', 3),
('E869120 Blog', 'Curated problem lists and study plans from one of Japan top competitive programmers.', 'https://codeforces.com/blog/entry/91363', 'advanced', 'EG', 4);

-- Site Settings
INSERT INTO settings (setting_key, setting_value) VALUES
('club_name', 'SGIPC'),
('club_full_name', 'Special Group Interested in Programming Contest'),
('university', 'Khulna University of Engineering & Technology'),
('tagline', 'A creative programming club where KUET coders practice, compete, and build contest confidence together.'),
('founded_year', '2015'),
('member_count', '120'),
('contests_hosted', '45'),
('total_participants', '340'),
('contact_email', 'sgipc@kuet.ac.bd'),
('contact_email_alt', 'contact.sgipc@gmail.com'),
('location', 'KUET Campus, Khulna-9203, Bangladesh'),
('practice_hours', 'Friday - Saturday: 2:00 PM to 6:00 PM'),
('practice_location', 'CSE Lab 304');
