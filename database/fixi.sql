CREATE DATABASE IF NOT EXISTS fixi
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE fixi;

CREATE TABLE users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    account_type ENUM('client', 'artisan', 'admin') NOT NULL,
    full_name VARCHAR(150) NOT NULL,
    email VARCHAR(190) NOT NULL UNIQUE,
    phone VARCHAR(30) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    city VARCHAR(100) NOT NULL,
    birth_date DATE NOT NULL,
    address_private VARCHAR(255) DEFAULT NULL,
    is_email_verified TINYINT(1) NOT NULL DEFAULT 0,
    account_status ENUM('pending', 'active', 'rejected', 'blocked') NOT NULL DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_user_type_status (account_type, account_status),
    INDEX idx_user_city (city)
) ENGINE=InnoDB;

CREATE TABLE artisan_profiles (
    user_id INT UNSIGNED PRIMARY KEY,
    main_profession VARCHAR(120) NOT NULL,
    bio TEXT DEFAULT NULL,
    experience_years TINYINT UNSIGNED DEFAULT NULL,
    cv_path VARCHAR(255) DEFAULT NULL,
    linkedin_url VARCHAR(255) DEFAULT NULL,
    profile_photo VARCHAR(255) DEFAULT NULL,
    contact_whatsapp VARCHAR(30) DEFAULT NULL,
    contact_phone TINYINT(1) NOT NULL DEFAULT 1,
    contact_email TINYINT(1) NOT NULL DEFAULT 0,
    latitude DECIMAL(10,7) DEFAULT NULL,
    longitude DECIMAL(10,7) DEFAULT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE professions (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name_fr VARCHAR(120) NOT NULL UNIQUE,
    name_ar VARCHAR(120) DEFAULT NULL,
    name_en VARCHAR(120) DEFAULT NULL,
    is_active TINYINT(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB;

CREATE TABLE specialities (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    profession_id INT UNSIGNED DEFAULT NULL,
    name_fr VARCHAR(120) NOT NULL,
    name_ar VARCHAR(120) DEFAULT NULL,
    name_en VARCHAR(120) DEFAULT NULL,
    status ENUM('pending', 'approved', 'rejected') NOT NULL DEFAULT 'approved',
    proposed_by INT UNSIGNED DEFAULT NULL,
    FOREIGN KEY (profession_id) REFERENCES professions(id) ON DELETE SET NULL,
    FOREIGN KEY (proposed_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE artisan_specialities (
    artisan_id INT UNSIGNED NOT NULL,
    speciality_id INT UNSIGNED NOT NULL,
    PRIMARY KEY (artisan_id, speciality_id),
    FOREIGN KEY (artisan_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (speciality_id) REFERENCES specialities(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE services (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    artisan_id INT UNSIGNED NOT NULL,
    title VARCHAR(150) NOT NULL,
    description TEXT DEFAULT NULL,
    pricing_type ENUM('fixed', 'quote') NOT NULL,
    price DECIMAL(10,2) DEFAULT NULL,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    FOREIGN KEY (artisan_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_service_price (price)
) ENGINE=InnoDB;

CREATE TABLE portfolio_items (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    artisan_id INT UNSIGNED NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    caption VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (artisan_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE artisan_areas (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    artisan_id INT UNSIGNED NOT NULL,
    governorate VARCHAR(100) NOT NULL,
    city_or_area VARCHAR(120) DEFAULT NULL,
    FOREIGN KEY (artisan_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_area (governorate, city_or_area)
) ENGINE=InnoDB;

CREATE TABLE artisan_availability (
    artisan_id INT UNSIGNED PRIMARY KEY,
    is_available TINYINT(1) NOT NULL DEFAULT 1,
    working_hours VARCHAR(255) DEFAULT NULL,
    FOREIGN KEY (artisan_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE reviews (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    artisan_id INT UNSIGNED NOT NULL,
    client_id INT UNSIGNED NOT NULL,
    rating TINYINT UNSIGNED NOT NULL,
    comment TEXT DEFAULT NULL,
    service_confirmed TINYINT(1) NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT chk_review_rating CHECK (rating BETWEEN 1 AND 5),
    FOREIGN KEY (artisan_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (client_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_client_artisan_review (client_id, artisan_id)
) ENGINE=InnoDB;

CREATE TABLE email_verifications (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    token_hash CHAR(64) NOT NULL,
    expires_at DATETIME NOT NULL,
    used_at DATETIME DEFAULT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_email_token (token_hash)
) ENGINE=InnoDB;

CREATE TABLE favorites (
    client_id INT UNSIGNED NOT NULL,
    artisan_id INT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (client_id, artisan_id),
    FOREIGN KEY (client_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (artisan_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE complaints (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    sender_id INT UNSIGNED NOT NULL,
    target_user_id INT UNSIGNED DEFAULT NULL,
    subject VARCHAR(180) NOT NULL,
    message TEXT NOT NULL,
    status ENUM('open', 'in_progress', 'closed') NOT NULL DEFAULT 'open',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sender_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (target_user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;

INSERT INTO professions (name_fr, name_ar, name_en) VALUES
('Plomberie', 'السباكة', 'Plumbing'),
('Électricité', 'الكهرباء', 'Electrical work'),
('Climatisation', 'التكييف', 'Air conditioning'),
('Menuiserie', 'النجارة', 'Carpentry'),
('Peinture', 'الدهان', 'Painting'),
('Maçonnerie', 'البناء', 'Masonry');
