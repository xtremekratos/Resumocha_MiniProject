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
                                        sex varchar(10));

insert into login_data values("jehad@gmail.com","panda","recruiter");
insert into login_data values("jehadz@gmail.com","JED","user");
insert into recruiters values("jehad@gmail.com","Jehad F Luffy","DDX","Design Head");
insert into users values("jehadz@gmail.com","Jehad Mohamed","+91 9113974687","1998-12-26","male");