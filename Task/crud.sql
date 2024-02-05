create database crud;
use crud;

CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    profile_picture VARCHAR(255),
    description TEXT,
    age INT,
    address VARCHAR(255)
);



