CREATE DATABASE IF NOT EXISTS resumocha;
USE resumocha;

CREATE TABLE IF NOT EXISTS login_data(email varchar(20) primary key,
                                        pass varchar(20) not null,
                                        account_type varchar(20));

CREATE TABLE IF NOT EXISTS recruiters(email varchar(20) primary key references login_data(email),
                                        name varchar(20) not null,
                                        company varchar(20),
                                        position varchar(20));

CREATE TABLE IF NOT EXISTS users(email varchar(20) primary key references login_data(email),
                                        name varchar(20) not null,
                                        phone varchar(20),
                                        dob date,
                                        sex varchar(10),
                                        resume varchar(20),
                                        dp varchar(10));

CREATE TABLE IF NOT EXISTS images(email varchar(20) primary key references login_data(email),
                                        image_path varchar(30));

CREATE TABLE IF NOT EXISTS resumes(email varchar(20) primary key references login_data(email),
                                        link varchar(30));

insert into login_data values("jehad@gmail.com","panda","recruiter");
insert into login_data values("jehadz@gmail.com","JED","user");
insert into recruiters values("jehad@gmail.com","Jehad F Luffy","DDX","Design Head");
insert into users values("jehadz@gmail.com","Jehad Mohamed","+91 9113974687","1998-12-26","male");
alter table users add resume varchar(20);
alter table users add dp varchar(20);


CREATE TRIGGER update_dp AFTER INSERT ON images FOR EACH ROW UPDATE users SET dp = 'true' where email=new.email;

CREATE TRIGGER update_resume AFTER INSERT ON resumes FOR EACH ROW UPDATE users SET users.resume = 'true' where email=new.email;


DELIMITER //
CREATE PROCEDURE DeleteAll(IN input_email VARCHAR(20))
 BEGIN
 DELETE from users where email=input_email;
 DELETE from images where email=input_email;
 DELETE from resumes where email=input_email;
 DELETE from login_data where email=input_email;
 END //
DELIMITER ;