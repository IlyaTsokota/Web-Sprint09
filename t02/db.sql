DROP DATABASE IF EXISTS sword;
CREATE DATABASE IF NOT EXISTS sword;
USE sword;
CREATE TABLE users (
  u_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  u_login VARCHAR(30) NOT NULL UNIQUE,
  u_password VARCHAR(30) NOT NULL,
  u_name VARCHAR(50) NOT NULL,
  u_email VARCHAR(50) NOT NULL,
  u_isadmin BOOLEAN NOT NULL
);