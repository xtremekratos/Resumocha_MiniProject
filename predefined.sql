CREATE DATABASE IF NOT EXISTS resumocha;
USE resumocha;
CREATE TABLE IF NOT EXISTS login_data(email varchar(20) primary key, pass varchar(20) not null, account_type varchar(20));

insert into login_data values("jehad@gmail.com","panda","user");