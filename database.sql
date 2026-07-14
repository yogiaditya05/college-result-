-- --------------------------------------------------------
-- DATABASE & SETTINGS
-- --------------------------------------------------------

CREATE DATABASE IF NOT EXISTS college_result CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE college_result;

-- --------------------------------------------------------
-- DROP TABLES IF EXIST (RESET DATABASE)
-- --------------------------------------------------------

DROP TABLE IF EXISTS results;
DROP TABLE IF EXISTS teacher_assignments;
DROP TABLE IF EXISTS subjects;
DROP TABLE IF EXISTS students;
DROP TABLE IF EXISTS users;

-- --------------------------------------------------------
-- USERS TABLE
-- --------------------------------------------------------

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  email VARCHAR(150) UNIQUE,
  password VARCHAR(255),
  role ENUM('admin','teacher','student') DEFAULT 'student',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 30 REAL USERS (Admin + 9 Teachers + 20 Students)

INSERT INTO users (name,email,password,role) VALUES
('Admin User','admin@gmail.com','$2b$10$GT5tPe/NJKf6LuixsDrgt.l/IT.A/BuwjjD/h1pNNRSkyQFkloKum','admin'),

('Dr. Arun Sharma','arunsharma@gmail.com','$2b$10$YebJ/vCZUrRBGU6H7YKpqe/.dIjYx/0ilZetX27oyzitRN8q03bwq','teacher'),
('Prof. Rekha Gupta','rekhagupta@gmail.com','$2b$10$P464uHA0bWglsELXnOiti.Ow4bxtF1drbn72SuevE0Xiy8SFx7pDW','teacher'),
('Dr. Mohit Singh','mohitsingh@gmail.com','$2b$10$Jwdup5jrdzXqsINcMCge8OtitU1pYRiWvj2uO2RECnQ3lQrBrkQP2','teacher'),
('Prof. Suman Verma','sumanverma@gmail.com','$2b$10$PTlG3OObJiFGfOheLyWRb.sezCI5iDVfbKkcEFAYbXHcdswf3Whwy','teacher'),
('Dr. Pradeep Rao','pradeeprao@gmail.com','$2b$10$94vYkdQ5xpqFu2OBdJXQFu9/Xsic59GAHvEsez5kJ3qrB11zkOv6i','teacher'),
('Prof. Ritesh Tiwari','riteshtiwari@gmail.com','$2b$10$z83KJiOZR9NeM4iB68KV2.UILSP9u29trSE3y0Uev/OFXy3i/tzGu','teacher'),
('Dr. Neha Jain','nehajain@gmail.com','$2b$10$PTg5nP76whW.U62gOjQahu4zgZReN1CB2PRbQpqQF1KkQIhd0MI4q','teacher'),
('Prof. Ankit Khare','ankitkhare@gmail.com','$2b$10$XA5Jxf9cv3/F.l7r1HEY9.syFiH7pV0i0aZXJRtSDED9oxvfFgPnW','teacher'),
('Dr. Kavita Bansal','kavitabansal@gmail.com','$2b$10$2.o1qSEpcDZRLQmjxeLNz.Asbp/HM5dm904q1JUz81Z3PWgGWqGD2','teacher'),

('Rahul Mehta','rahulmehta@gmail.com','$2b$10$BJab9B48Hzh8jQPU1wixlu42pzRpFwGEtZaPKVVjXut.2DUTI1h/m','student'),
('Priya Sharma','priyasharma@gmail.com','$2b$10$sgYYwTLog1HexTpIR3K8POsglT5JEqD3g1IEAGvz3IhCQwSkpgXXq','student'),
('Aman Verma','amanverma@gmail.com','$2b$10$QYXmuk/C2.30gpnltKT1B./LNDgM33i.0AhHxoS3d0S73KbMZSxlS','student'),
('Neha Patel','nehapatel@gmail.com','$2b$10$PTg5nP76whW.U62gOjQahu4zgZReN1CB2PRbQpqQF1KkQIhd0MI4q','student'),
('Rohit Kumar','rohitkumar@gmail.com','$2b$10$C6sfpz8J1O54J3gP/N1FqutTqwvjc6MpooRKF4JV82cmynDemZzBW','student'),
('Sneha Gupta','snehagupta@gmail.com','$2b$10$d5C0WrI8wrnyBmHHxbmHw.fto4dAzGewYBzecgc9K4XE1aDRevnYa','student'),
('Vikas Yadav','vikasyadav@gmail.com','$2b$10$if7ezSV.joz1QsZgH66jveWCrptPLYdDZ8niTTEjftP85HthxaASS','student'),
('Anjali Singh','anjalisingh@gmail.com','$2b$10$xPifg88ogtSkzaa3XIbgA.rceaQJ5pYR8JcFp7ZJvzENgCayR6.QC','student'),
('Deepak Chauhan','deepakchauhan@gmail.com','$2b$10$V2xdQk.XNAARBoO8vauVFesYFldnp.IDCaSbR4JDLIKfaARW9fFAm','student'),
('Simran Kaur','simrankaur@gmail.com','$2b$10$D8CAO8NMYeuZU5BlnTs8z.FoZaoK18FEywXkvk8aS/3WQthXxV34C','student'),

('Amit Sharma','amitsharma@gmail.com','$2b$10$37gqhv9xafUBi3oMKuupAOp0yxbf1k/FpKpFOlC.xK7tarsJocNgm','student'),
('Karan Johar','karanjohar@gmail.com','$2b$10$Eb00qg0ibJSzIOcBC3oAFOEpchtKsuhcT/ukmhQHFvnzJOYduXlee','student'),
('Siddharth Malhotra','siddharth@gmail.com','$2b$10$rVKQgMUYRFmHIo5qfzuYMOJ.UKrWqOg9z4vAdSdy8tJ8vap9NJw5y','student'),
('Varun Dhawan','varundhawan@gmail.com','$2b$10$h8pfokm2i0h1PCdfRHLZ9ui8gCpy48s71hlfSsRsX.7uRt2zy7mZO','student'),
('Alia Bhatt','aliabhatt@gmail.com','$2b$10$dja00qhjL/xRTJnllLU0NuM8IrrZFFkTtrTHjcuKYNSDPbiNyPdE.','student'),
('Kiara Advani','kiaraadvani@gmail.com','$2b$10$wAR5WOhlHnjwxxxlcRxiZu8JZsKL/wokUHTGXyqFJeXrWb5CFm9Du','student'),
('Shraddha Kapoor','shraddha@gmail.com','$2b$10$kmwVh0GJZafksCHiCqLdd.NEAdM7lfj.7tpHDdrexxngekOGP0xcm','student'),
('Kriti Sanon','kritisanon@gmail.com','$2b$10$FevY41RIcoKEMrrI3wg8CekmbhVmXN6/RYnpwcmhojOOYsI3qCDW2','student'),
('Rajkummar Rao','rajkummar@gmail.com','$2b$10$9co5kvDy8sGtq5LRewNZIOfATXpEjUOUP1.gtlXshw1PLr1wIeyOK','student'),
('Ayushmann Khurrana','ayushmann@gmail.com','$2b$10$u1dYHkaxtYJw/RVrQNxKMOkzMh0seEH/hBt6I.b0YlYAtZrrQcTi6','student');


-- --------------------------------------------------------
-- STUDENTS TABLE
-- --------------------------------------------------------

CREATE TABLE students (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT DEFAULT NULL UNIQUE,
  roll_no VARCHAR(50),
  name VARCHAR(150),
  class VARCHAR(50),
  section VARCHAR(20),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

-- 20 REAL STUDENTS WITH ROLL NUMBERS LIKE 0827CS251000
INSERT INTO students (user_id,roll_no,name,class,section) VALUES
(11,'0827CS251000','Rahul Mehta','B.Tech CSE','A'),
(12,'0827CS251001','Priya Sharma','B.Tech CSE','A'),
(13,'0827CS251002','Aman Verma','B.Tech CSE','A'),
(14,'0827CS251003','Neha Patel','B.Tech CSE','A'),
(15,'0827CS251004','Rohit Kumar','B.Tech CSE','A'),
(16,'0827CS251005','Sneha Gupta','B.Tech CSE','B'),
(17,'0827CS251006','Vikas Yadav','B.Tech CSE','B'),
(18,'0827CS251007','Anjali Singh','B.Tech CSE','B'),
(19,'0827CS251008','Deepak Chauhan','B.Tech CSE','B'),
(20,'0827CS251009','Simran Kaur','B.Tech CSE','B'),

(21,'0827CS251010','Amit Sharma','B.Tech CSE','C'),
(22,'0827CS251011','Karan Johar','B.Tech CSE','C'),
(23,'0827CS251012','Siddharth Malhotra','B.Tech CSE','C'),
(24,'0827CS251013','Varun Dhawan','B.Tech CSE','C'),
(25,'0827CS251014','Alia Bhatt','B.Tech CSE','C'),
(26,'0827CS251015','Kiara Advani','B.Tech CSE','D'),
(27,'0827CS251016','Shraddha Kapoor','B.Tech CSE','D'),
(28,'0827CS251017','Kriti Sanon','B.Tech CSE','D'),
(29,'0827CS251018','Rajkummar Rao','B.Tech CSE','D'),
(30,'0827CS251019','Ayushmann Khurrana','B.Tech CSE','D');

-- --------------------------------------------------------
-- SUBJECTS TABLE
-- --------------------------------------------------------

CREATE TABLE subjects (
  id INT AUTO_INCREMENT PRIMARY KEY,
  code VARCHAR(50),
  title VARCHAR(200)
);

-- 20 SUBJECTS (CODES CS101–CS120)
INSERT INTO subjects (code,title) VALUES
('CS101','Engineering Mathematics-I'),
('CS102','Engineering Physics'),
('CS103','Basic Electrical Engineering'),
('CS104','Programming in C'),
('CS105','Data Structures'),
('CS106','Discrete Mathematics'),
('CS107','Digital Electronics'),
('CS108','Object Oriented Programming in C++'),
('CS109','Computer Organization & Architecture'),
('CS110','Operating Systems'),
('CS111','Database Management Systems'),
('CS112','Theory of Computation'),
('CS113','Computer Networks'),
('CS114','Compiler Design'),
('CS115','Software Engineering'),
('CS116','Design & Analysis of Algorithms'),
('CS117','Python Programming'),
('CS118','Cyber Security'),
('CS119','Artificial Intelligence'),
('CS120','Machine Learning');

-- --------------------------------------------------------
-- TEACHER ASSIGNMENTS TABLE
-- --------------------------------------------------------

CREATE TABLE teacher_assignments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  teacher_id INT NOT NULL,
  class VARCHAR(100) NOT NULL,
  subject_id INT DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (teacher_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE SET NULL
);

-- 20 TEACHER ASSIGNMENTS
INSERT INTO teacher_assignments (teacher_id,class,subject_id) VALUES
(2,'B.Tech CSE',1),
(3,'B.Tech CSE',2),
(4,'B.Tech CSE',3),
(5,'B.Tech CSE',4),
(6,'B.Tech CSE',5),
(7,'B.Tech CSE',6),
(8,'B.Tech CSE',7),
(9,'B.Tech CSE',8),
(10,'B.Tech CSE',9),
(2,'B.Tech CSE',10),
(3,'B.Tech CSE',11),
(4,'B.Tech CSE',12),
(5,'B.Tech CSE',13),
(6,'B.Tech CSE',14),
(7,'B.Tech CSE',15),
(8,'B.Tech CSE',16),
(9,'B.Tech CSE',17),
(10,'B.Tech CSE',18),
(2,'B.Tech CSE',19),
(3,'B.Tech CSE',20);

-- --------------------------------------------------------
-- RESULTS TABLE
-- --------------------------------------------------------

CREATE TABLE results (
  id INT AUTO_INCREMENT PRIMARY KEY,
  student_id INT,
  subject_id INT,
  marks INT,
  grade VARCHAR(10),
  term VARCHAR(50),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
  FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE CASCADE
);

-- 20 RESULTS (REALISTIC MARKS)
INSERT INTO results (student_id,subject_id,marks,grade,term) VALUES
(1,4,88,'A','Semester 1'),
(2,5,76,'B','Semester 1'),
(3,6,69,'C','Semester 1'),
(4,7,92,'A+','Semester 1'),
(5,8,81,'A','Semester 1'),
(6,9,55,'D','Semester 1'),
(7,10,67,'C','Semester 1'),
(8,11,71,'B','Semester 1'),
(9,12,84,'A','Semester 1'),
(10,13,73,'B','Semester 1'),
(11,14,77,'B','Semester 1'),
(12,15,89,'A','Semester 1'),
(13,16,90,'A+','Semester 1'),
(14,17,64,'C','Semester 1'),
(15,18,59,'D','Semester 1'),
(16,19,82,'A','Semester 1'),
(17,20,74,'B','Semester 1'),
(18,10,63,'C','Semester 1'),
(19,11,87,'A','Semester 1'),
(20,12,91,'A+','Semester 1');
