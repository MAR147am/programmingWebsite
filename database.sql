-- Create Database
CREATE DATABASE ProgrammingCoursesDB;

-- Use Database
USE ProgrammingCoursesDB;

-- Create Users Table
CREATE TABLE Users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),NOT NULL,
    email VARCHAR(100),NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Create Courses Table
CREATE TABLE Courses (
    course_id INT AUTO_INCREMENT PRIMARY KEY,
    course_name VARCHAR(100),
    description TEXT
);

-- Insert Courses (مهم جدًا قبل Lessons)

INSERT INTO Courses (course_name, description)
VALUES
('Python Programming','Learn Python from basics'),
('Java Programming','Learn Java step by step'),
('HTML & CSS','Web design basics'),
('JavaScript','Interactive web development');

-- Create Lessons Table
CREATE TABLE Lessons (
    lesson_id INT AUTO_INCREMENT PRIMARY KEY,
    course_id INT,
    lesson_title VARCHAR(100),
    FOREIGN KEY (course_id) REFERENCES Courses(course_id)
);

-- Create Enrollments Table
CREATE TABLE Enrollments (
    enrollment_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    course_id INT,
    FOREIGN KEY (user_id) REFERENCES Users(user_id),
    FOREIGN KEY (course_id) REFERENCES Courses(course_id)
);

-- Insert Users

INSERT INTO Users (name, email, password)
VALUES
('Ahmed Ali', 'ahmed@gmail.com', '123456'),
('Sara Mohammed', 'sara@gmail.com', '123456');

-- Insert Lessons

INSERT INTO Lessons (course_id, lesson_title)
VALUES
(1, 'Introduction to Python'),
(1, 'Python Variables'),

(2, 'Java Basics'),
(2, 'Java OOP'),

(3, 'HTML Introduction'),
(3, 'CSS Basics'),

(4, 'JavaScript Basics'),
(4, 'JavaScript Functions');

-- Insert Enrollments

INSERT INTO Enrollments (user_id, course_id)
VALUES
(1,1),
(1,2),
(2,3);