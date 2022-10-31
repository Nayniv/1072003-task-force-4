CREATE DATABASE taskforce
  DEFAULT CHARACTER SET utf8mb4
  DEFAULT COLLATE utf8mb4_general_ci;

USE taskforce;

CREATE TABLE categories (
  id INT(11) AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  icon VARCHAR(255) NOT NULL
);

CREATE TABLE cities (
  id INT(11) AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(64) NOT NULL,
  lat DECIMAL(11,8) NOT NULL,
  lng DECIMAL(11,8) NOT NULL
);

CREATE TABLE files (
  id INT(11) AUTO_INCREMENT PRIMARY KEY,
  url VARCHAR(255) NOT NULL
);

CREATE TABLE users (
  id INT(11) AUTO_INCREMENT PRIMARY KEY,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  email VARCHAR(128) UNIQUE NOT NULL,
  login CHAR(64) NOT NULL,
  password VARCHAR(255) NOT NULL,
  date_of_birth TIMESTAMP DEFAULT NULL,
  phone CHAR(11) DEFAULT NULL,
  telegram CHAR(64) DEFAULT NULL,
  rating INT DEFAULT NULL,
  city_id INT NOT NULL,
  avatar_file_id INT DEFAULT NULL,
  is_customer BOOL DEFAULT NULL
);

CREATE TABLE tasks (
  id INT(11) AUTO_INCREMENT PRIMARY KEY,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  customer_id INT NOT NULL,
  executor_id INT DEFAULT NULL,
  category_id INT NOT NULL,
  title VARCHAR(255) NOT NULL,
  description VARCHAR(1000) NOT NULL,
  budget INT UNSIGNED DEFAULT NULL,
  completed_at DATE DEFAULT NULL,
  city_id INT,
  file_id INT,
  status TINYINT(5) NOT NULL DEFAULT 1
);

CREATE TABLE responses (
  id INT(11) AUTO_INCREMENT PRIMARY KEY,
  task_id INT NOT NULL,
  executor_id INT NOT NULL,
  comment VARCHAR(255) DEFAULT NULL,
  budget INT DEFAULT NULL,
  status BOOL DEFAULT 0 NOT NULL
);

CREATE TABLE reviews (
  id INT(11) PRIMARY KEY AUTO_INCREMENT,
  task_id INT NOT NULL,
  rate TINYINT(5) NOT NULL,
  comment VARCHAR(255) NULL
);

CREATE TABLE executor_categories (
  id INT(11) AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  category_id INT
);

ALTER TABLE users
  ADD FOREIGN KEY (city_id) REFERENCES cities (id);
ALTER TABLE users
  ADD FOREIGN KEY (avatar_file_id) REFERENCES files (id);

ALTER TABLE tasks
  ADD FOREIGN KEY (city_id) REFERENCES cities (id);
ALTER TABLE tasks
  ADD FOREIGN KEY (file_id) REFERENCES files (id);
ALTER TABLE tasks
  ADD FOREIGN KEY (customer_id) REFERENCES users (id);
ALTER TABLE tasks
  ADD FOREIGN KEY (executor_id) REFERENCES users (id);
ALTER TABLE tasks
  ADD FOREIGN KEY (category_id) REFERENCES categories (id);

ALTER TABLE responses
  ADD FOREIGN KEY (task_id) REFERENCES tasks (id);
ALTER TABLE responses
  ADD FOREIGN KEY (executor_id) REFERENCES users (id);

ALTER TABLE reviews
  ADD FOREIGN KEY (task_id) REFERENCES tasks (id);

ALTER TABLE executor_categories
  ADD FOREIGN KEY (user_id) REFERENCES users (id);
ALTER TABLE executor_categories
  ADD FOREIGN KEY (category_id) REFERENCES categories (id);
