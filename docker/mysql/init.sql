CREATE DATABASE IF NOT EXISTS user_data;
CREATE USER IF NOT EXISTS 'dc_user'@'%' IDENTIFIED BY 'Water15Blue%%';
GRANT ALL PRIVILEGES ON user_data.* TO 'dc_user'@'%';
FLUSH PRIVILEGES;

USE user_data;
CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  fname VARCHAR(100),
  lname VARCHAR(100),
  email VARCHAR(100),
  cc_email VARCHAR(100),
  cell_phone VARCHAR(15),
  work_phone VARCHAR(15),
  home_phone VARCHAR(15),
  fax VARCHAR(15),
  company_name VARCHAR(100),
  company_addr1 VARCHAR(100),
  company_addr2 VARCHAR(100),
  company_city VARCHAR(50),
  company_state VARCHAR(2),
  company_zip VARCHAR(10)
);
