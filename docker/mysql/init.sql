DROP DATABASE IF EXISTS shukatsu;
CREATE DATABASE shukatsu;
USE shukatsu;


-- user-tableとか作る

DROP TABLE IF EXISTS labels;
CREATE TABLE labels (
  label_id INT AUTO_INCREMENT PRIMARY KEY,
  label_name VARCHAR(255) NOT NULL
) CHARSET=utf8;

insert into labels (label_id, label_name) values 
(1,"文系"),
(2,"理系"),
(3,"メール"),
(4,"電話"),
(5,"オフライン"),
(6,"東京"),
(7,"大阪"),
(8,"名古屋"),
(9,"福岡");
-- 今後都道府県とか追加するなら都道府県テーブルで別に作っても良いかも：better

DROP table IF EXISTS users;
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  hurigana VARCHAR(255) NOT NULL,
  sex VARCHAR(255) NOT NULL,
  birthday VARCHAR(255) NOT NULL,
  college VARCHAR(255) NOT NULL,
  faculty VARCHAR(255) NOT NULL,
  department VARCHAR(255) NOT NULL,
  division VARCHAR(255) NOT NULL,
  grad_year VARCHAR(255) NOT NULL,
  prefecture VARCHAR(255) NOT NULL,
  mail VARCHAR(255) NOT NULL,
  phone VARCHAR(255) NOT NULL,
  valid int NOT NULL default false
) CHARSET=utf8;

insert into users (id, name, hurigana, sex, birthday, college, faculty, department, division, grad_year, prefecture, mail, phone, valid) values 
(1,"神野豪気","カンノゴウキ","男","20030912","慶應義塾大学","法学部","政治学科","文系","2026","神奈川県","go@gmail.com","010-2929-3150","1");


DROP TABLE IF EXISTS label_client_relation;
CREATE TABLE label_client_relation(
  id INT AUTO_INCREMENT PRIMARY KEY,
  client_id INT NOT NULL,
  label_id INT NOT NULL
) CHARSET=utf8;

insert into label_client_relation (id, client_id, label_id) values
(1, 1, 2);


DROP TABLE IF EXISTS clients;
CREATE TABLE clients(
  id INT AUTO_INCREMENT PRIMARY KEY,
  client_id INT NOT NULL,
  agent_name VARCHAR(255) NOT NULL,
  service_name VARCHAR(255) NOT NULL,
  catchphrase VARCHAR(255) NOT NULL,
  post_period VARCHAR(255) NOT NULL,
  area VARCHAR(255) NOT NULL,
  logo_img VARCHAR(255) NOT NULL
) CHARSET=utf8;

insert into clients(id, client_id, agent_name, service_name, catchphrase, post_period, area, logo_img) values
(1,1,"doda新卒エージェント","不明","豊富な掲載企業","6か月","東京、大阪","https://doda-student.jp/assets/img/header_logo_01.svg");

DROP TABLE IF EXISTS managers;
CREATE TABLE managers(
  client_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  manager_id INT NOT NULL,
  manager VARCHAR(255) NOT NULL,
  depart VARCHAR(255) NOT NULL,
  mail VARCHAR(255) NOT NULL,
  phone VARCHAR(255) NOT NULL
);

insert into managers(client_id, manager_id, manager, depart, mail, phone) values
(1,1,"担当者太郎","営業部","tatata@gmail.com","555-5555-5555");

DROP TABLE IF EXISTS client_login;
CREATE TABLE client_login(
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  client_id int NOT NULL,
  password VARCHAR(255) NOT NULL
);

insert into client_login(id, client_id, password) values
(1,1,"password");

DROP TABLE IF EXISTS user_register_client;
CREATE TABLE user_register_client(
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  client_id VARCHAR(255) NOT NULL
);

insert into user_register_client(id, user_id, client_id) values
(1,1,1);

DROP TABLE IF EXISTS boozer_register_client;
CREATE TABLE boozer_register_client(
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  password VARCHAR(255) NOT NULL,
  mail VARCHAR(255) NOT NULL
);

insert into boozer_register_client(id, name, password, mail) values
(1,"管理者太郎","password","kakaka@gmail.com");

