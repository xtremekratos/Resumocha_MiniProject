CREATE DATABASE IF NOT EXISTS resumocha;
USE resumocha;

CREATE TABLE IF NOT EXISTS login_data(email varchar(20) primary key,
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
                                        uid varchar(30) unique references users(uid),
                                        image_path varchar(30));

CREATE TABLE IF NOT EXISTS resumes(     resid integer primary key AUTO_INCREMENT,
                                        uid varchar(30) unique references users(uid),
                                        link varchar(30));


CREATE TRIGGER update_dp AFTER INSERT ON images FOR EACH ROW UPDATE users SET dp = 'true' where uid=new.uid;

CREATE TRIGGER update_resume AFTER INSERT ON resumes FOR EACH ROW UPDATE users SET users.resume = 'true' where uid=new.email;


DELIMITER //
CREATE PROCEDURE DeleteAll(IN input_email VARCHAR(20),IN input_uid integer)
 BEGIN
 DELETE from users where email=input_email;
 DELETE from images where uid=input_uid;
 DELETE from resumes where uid=input_uid;
 DELETE from login_data where email=input_email;
 END //
DELIMITER ;
