CREATE DATABASE IF NOT EXISTS resumocha;
USE resumocha;

CREATE TABLE IF NOT EXISTS login_data( email varchar(30) primary key,
                                        pass varchar(20) not null,
                                        account_type varchar(20));

CREATE TABLE IF NOT EXISTS recruiters(
                                        rid integer primary key AUTO_INCREMENT,
                                        email varchar(30) unique references login_data(email),
                                        name varchar(30) not null,
                                        company varchar(30),
                                        position varchar(30));

CREATE TABLE IF NOT EXISTS users(       uid integer primary key AUTO_INCREMENT,
                                        email varchar(30) unique references login_data(email),
                                        name varchar(30) not null,
                                        phone varchar(20),
                                        dob date,
                                        sex varchar(10),
                                        resume varchar(20),
                                        dp varchar(10));

CREATE TABLE IF NOT EXISTS images(       iid integer primary key AUTO_INCREMENT,
                                        uid integer references users(uid),
                                        image_path varchar(30));

CREATE TABLE IF NOT EXISTS resumes(     resid integer primary key AUTO_INCREMENT,
                                        uid integer references users(uid),
                                        link varchar(30));


CREATE TRIGGER update_dp AFTER INSERT ON images 
FOR EACH ROW UPDATE users SET dp = 'true' where uid=new.uid;

CREATE TRIGGER update_resume AFTER INSERT ON resumes 
FOR EACH ROW UPDATE users SET users.resume = 'true' where uid=new.uid;


DELIMITER //
CREATE PROCEDURE DeleteAll(IN input_email VARCHAR(20),IN input_uid integer)
 BEGIN
 DELETE from users where email=input_email;
 DELETE from images where uid=input_uid;
 DELETE from resumes where uid=input_uid;
 DELETE from login_data where email=input_email;
 END //
DELIMITER ;


/*Resume generator*/
CREATE TABLE login_data(email varchar(30) primary key,
                        pass varchar(20) not null);

CREATE TABLE user_info(
    uid integer primary key AUTO_INCREMENT,
    email varchar(30) unique references login_data(email),
    name varchar(30) not null,
    phone varchar(20),
    byline varchar(40),
    skills VARCHAR(40),
    languages VARCHAR(40),
    10_name VARCHAR(30),
    10_marks VARCHAR(5),
    10_year  CHAR(4),
    12_name VARCHAR(30),
    12_marks VARCHAR(5),
    12_year  CHAR(4),
    colg_name VARCHAR(30),
    colg_marks VARCHAR(5),
    colg_year  CHAR(4)
);

CREATE TABLE experience(
    eid integer primary key AUTO_INCREMENT,
    uid integer references user_info(uid),
    name VARCHAR(30),
    role VARCHAR(30),
    desc VARCHAR(200),
    year CHAR(4)
);

CREATE TABLE project(
    pid integer primary key AUTO_INCREMENT,
    uid integer references user_info(uid),
    title VARCHAR(30),
    desc VARCHAR(200)
);

CREATE TABLE achievement(
    pid integer primary key AUTO_INCREMENT,
    uid integer references user_info(uid),
    title VARCHAR(30),
    desc VARCHAR(200)
);