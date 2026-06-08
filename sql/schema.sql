-- Football prediction contest schema and seed data.
-- Import this file into MySQL, then edit config.php with your database credentials.

CREATE TABLE IF NOT EXISTS users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(80) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') NOT NULL DEFAULT 'user',
    display_name VARCHAR(120) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS matches (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    tournament_stage VARCHAR(120) NOT NULL,
    group_name VARCHAR(80) NULL,
    team_home VARCHAR(120) NOT NULL,
    team_away VARCHAR(120) NOT NULL,
    match_datetime DATETIME NOT NULL,
    home_score TINYINT UNSIGNED NULL,
    away_score TINYINT UNSIGNED NULL,
    status ENUM('scheduled', 'live', 'finished') NOT NULL DEFAULT 'scheduled',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_matches_datetime (match_datetime),
    INDEX idx_matches_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS predictions (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    match_id INT UNSIGNED NOT NULL,
    predicted_home_score TINYINT UNSIGNED NOT NULL,
    predicted_away_score TINYINT UNSIGNED NOT NULL,
    points TINYINT UNSIGNED NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uniq_user_match (user_id, match_id),
    INDEX idx_predictions_match (match_id),
    CONSTRAINT fk_predictions_user FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE,
    CONSTRAINT fk_predictions_match FOREIGN KEY (match_id) REFERENCES matches (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO users (login, password_hash, role, display_name) VALUES
('admin', '$2y$12$WGtvwyAw7tACkweCEBzDZerB2c5bwr5zaW./SRu.8Ux9br9MHSEQy', 'admin', 'Администратор'),
('oleg', '$2y$12$x.1lDbEa/JI71shiDvLg6ukov4VPDX2KLRSr41E.aQ9x7bTYWtJnG', 'user', 'Олег'),
('user1', '$2y$12$55iHRX8O48FaTaLgUTZ2yuYtV.GqBh7/8CVUtoPU.S/G6y1VKzVIi', 'user', 'Иван'),
('user2', '$2y$12$55iHRX8O48FaTaLgUTZ2yuYtV.GqBh7/8CVUtoPU.S/G6y1VKzVIi', 'user', 'Мария')
ON DUPLICATE KEY UPDATE display_name = VALUES(display_name), role = VALUES(role);

INSERT INTO matches (tournament_stage, group_name, team_home, team_away, match_datetime, home_score, away_score, status) VALUES
('Group Stage', 'Group A', 'Германия', 'Франция', '2026-06-12 21:00:00', NULL, NULL, 'scheduled'),
('Group Stage', 'Group B', 'Аргентина', 'Испания', '2026-06-13 18:00:00', NULL, NULL, 'scheduled'),
('Group Stage', 'Group C', 'Бразилия', 'Португалия', '2026-06-14 22:00:00', NULL, NULL, 'scheduled'),
('1/8 Final', NULL, 'Нидерланды', 'Англия', '2026-06-28 20:00:00', NULL, NULL, 'scheduled');
