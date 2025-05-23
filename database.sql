CREATE DATABASE IF NOT EXISTS blog_db;
USE blog_db;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') NOT NULL DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE post (
	`id` INT(5) NOT NULL AUTO_INCREMENT,
	`username` VARCHAR(16) NOT NULL,
	`content` VARCHAR(255) NOT NULL,
	PRIMARY KEY(`id`)
);

CREATE TABLE comment (
	`id` INT(5) NOT NULL AUTO_INCREMENT,
    `post_id` INT(5) NOT NULL,
	`username` VARCHAR(16) NOT NULL,
	`content` VARCHAR(255) NOT NULL,
	PRIMARY KEY(`id`),
    FOREIGN KEY (`post_id`) REFERENCES post(`id`)
);

ALTER TABLE comment
DROP FOREIGN KEY comment_ibfk_1;

ALTER TABLE comment
ADD CONSTRAINT comment_ibfk_1
FOREIGN KEY (post_id) REFERENCES post(id) ON DELETE CASCADE;v