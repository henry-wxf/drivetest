
DROP DATABASE IF EXISTS drive_test;

CREATE DATABASE drive_test;
GRANT ALL PRIVILEGES ON drive_test.* TO 'drive_admin'@'localhost' IDENTIFIED BY 'henry_g00d';

USE drive_test;

CREATE TABLE questions (
  question_id INT(4) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  question_desc VARCHAR(1000) NOT NULL
);

CREATE TABLE options (
  option_id INT(2) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  option_desc VARCHAR(512) NOT NULL,
  question_id INT(4) UNSIGNED NOT NULL,
  is_answer BIT(1) NOT NULL DEFAULT b'0',
  FOREIGN KEY (question_id) REFERENCES questions(question_id)
);