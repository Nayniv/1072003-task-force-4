CREATE DATABASE taskforce
  DEFAULT CHARACTER SET utf8mb4
  DEFAULT COLLATE utf8mb4_general_ci;

USE taskforce;

CREATE TABLE category (
  id INT(11) AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL
);

CREATE TABLE city (
  id INT(11) AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(64) NOT NULL,
  lat DECIMAL(11,8) NOT NULL,
  lng DECIMAL(11,8) NOT NULL
);

CREATE TABLE files (
  id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  url VARCHAR(255) NOT NULL
);

CREATE TABLE user (
  id INT(11) AUTO_INCREMENT PRIMARY KEY,
  dt_add DATETIME DEFAULT CURRENT_TIMESTAMP,
  email VARCHAR(128) UNIQUE NOT NULL,
  login CHAR(64) NOT NULL,
  password VARCHAR(255) NOT NULL,
  date_of_birth TIMESTAMP DEFAULT NULL,
  phone CHAR(11) DEFAULT NULL,
  telegram CHAR(64) DEFAULT NULL,
  raiting INT DEFAULT NULL,
  city_id INT NOT NULL,
  avatar_file_id INT DEFAULT NULL
);

CREATE TABLE task (
  id INT(11) AUTO_INCREMENT PRIMARY KEY,
  dt_add DATETIME DEFAULT CURRENT_TIMESTAMP,
  customer_id INT NOT NULL,
  executor_id INT DEFAULT NULL,
  category_id INT NOT NULL,
  title VARCHAR(255) NOT NULL,
  description VARCHAR(1000) NOT NULL,
  budget INT UNSIGNED DEFAULT NULL,
  dt_completion DATE DEFAULT NULL,
  city_id INT,
  file_id INT
);

CREATE TABLE responce (
  id INT(11) AUTO_INCREMENT PRIMARY KEY,
  task_id INT NOT NULL,
  executor_id INT NOT NULL,
  comment VARCHAR(255) DEFAULT NULL,
  budget INT DEFAULT NULL,
  is_refused BOOL DEFAULT 0 NOT NULL
);

CREATE TABLE reviews (
  id INT(11) PRIMARY KEY AUTO_INCREMENT,
  task_id INT NOT NULL,
  rate TINYINT(5) NOT NULL,
  comment VARCHAR(255) NULL
);

CREATE TABLE user_role (
  id INT(11) AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  category_id INT
);

ALTER TABLE user
  ADD FOREIGN KEY (city_id) REFERENCES city (id);
  ADD FOREIGN KEY (avatar_file_id) REFERENCES files (id);

ALTER TABLE task
  ADD FOREIGN KEY (city_id) REFERENCES city (id);
  ADD FOREIGN KEY (file_id) REFERENCES files (id);
  ADD FOREIGN KEY (customer_id) REFERENCES user (id);
  ADD FOREIGN KEY (executor_id) REFERENCES user (id);
  ADD FOREIGN KEY (category_id) REFERENCES category (id);

ALTER TABLE responce
  ADD FOREIGN KEY (task_id) REFERENCES task (id);
  ADD FOREIGN KEY (executor_id) REFERENCES user (id);

ALTER TABLE reviews
  ADD FOREIGN KEY (task_id) REFERENCES task (id);

ALTER TABLE user_role
  ADD FOREIGN KEY (user_id) REFERENCES user (id);
  ADD FOREIGN KEY (category_id) REFERENCES category (id);
