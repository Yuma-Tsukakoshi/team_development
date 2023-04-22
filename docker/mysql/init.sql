DROP DATABASE IF EXISTS shukatsu;
CREATE DATABASE shukatsu;
USE shukatsu;


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

-- 都道府県テーブル追加する場合に書く(better)
-- DROP TABLE IF EXISTS prefecture;
-- CREATE TABLE prefecture (
--   id INT NOT NULL,
--   name VARCHAR(255) NOT NULL
-- ) CHARSET=utf8;

-- INSERT INTO prefecture (id,name) values
-- (,),
-- (,),


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
(1,"神野豪気","カンノゴウキ","男","20030912","慶應義塾大学","法学部","政治学科","文系","2026","神奈川県","go@gmail.com","010-2929-3150","0"),
(1,"塚越雄真","ツカコシユウマ","男","20020910","慶應義塾大学","理工学部","情報工学科","理系","2025","埼玉県","yuma@gmail.com","012-2348-2389","0"),
(1,"小野ひなの","オノヒナノ","女","20020910","慶應義塾大学","理工学部","管理工学科","理系","2026","岡山県","hinanu@gmail.com","543-4326-6426","0"),
(1,"竹内菜月","タケウチナツキ","女","20020910","慶應義塾大学","法学部","政治学科","文系","2026","東京都","natuki@gmail.com","366-5473-7354","0"),
(1,"平手美羽","ヒラテミユ","女","20020910","慶應義塾大学","法学部","政治学科","文系","2026","東京都","hirate@gmail.com","036-6456-4536","0");

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
  recomend_point VARCHAR(255) NOT NULL,
  started_at date DEFAULT NULL,
  ended_at date DEFAULT NULL,
  area VARCHAR(255),
  logo_img VARCHAR(255) NOT NULL
) CHARSET=utf8;

insert into clients(id, client_id, agent_name, service_name, catchphrase,recomend_point, started_at ,ended_at, area, logo_img) values
(1,1,"doda株式会社","doda新卒エージェント","豊富な掲載企業","6か月","東京、大阪","https://doda-student.jp/assets/img/header_logo_01.svg"),
(2,2,'株式会社マイナビ', 'マイナビ新卒紹介',"豊富な掲載企業","6か月","東京、大阪","https://doda-student.jp/assets/img/header_logo_01.svg"),
(3,3,'NaS株式会社', 'DiG UP CAREER',"豊富な掲載企業","6か月","東京、大阪","https://doda-student.jp/assets/img/header_logo_01.svg"),
(4,4,'Jobspirng株式会社', 'JobSpring',"豊富な掲載企業","6か月","東京、大阪","https://doda-student.jp/assets/img/header_logo_01.svg"),
(5,5,"Goodfind","Goodfindエージェントサービス","豊富な掲載企業","6か月","東京、大阪","https://doda-student.jp/assets/img/header_logo_01.svg"),
(6,6,"株式会社アカリク","アカリク就活エージェント","豊富な掲載企業","6か月","東京、大阪","https://doda-student.jp/assets/img/header_logo_01.svg"),


DROP TABLE IF EXISTS managers;
CREATE TABLE managers(
  manager_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  client_id INT NOT NULL,
  manager VARCHAR(255) NOT NULL,
  depart VARCHAR(255) NOT NULL,
  mail VARCHAR(255) NOT NULL,
  phone VARCHAR(255) NOT NULL
);

insert into managers(client_id, manager_id, manager, depart, mail, phone) values
(1,1,"担当者太郎","営業部","tatata@gmail.com","555-5555-5555"),
(2,2,"担当者次郎","営業部","jijiji@gmail.com","234-4323-5432"),
(3,3,"担当者三郎","営業部","sansan@gmail.com","542-7654-7335"),
(4,4,"担当者四郎","営業部","sisi@gmail.com","765-9206-2775"),
(5,5,"担当者五郎","営業部","gogo@gmail.com","976-2852-6326"),
(6,6,"担当者六郎","営業部","rokku@gmail.com","224-5437-5437");


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

