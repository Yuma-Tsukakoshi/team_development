
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
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  hidden TINYINT(1) NOT NULL DEFAULT 0,
  is_valid boolean default true
) CHARSET=utf8;

insert into users (id, name, hurigana, sex, birthday, college, faculty, department, division, grad_year, prefecture, mail, phone,created_at,is_valid) values 
(1,"神野豪気","カンノゴウキ","男","2003-09-12","慶應義塾大学","法学部","政治学科","文系","2026","神奈川県","go@gmail.com","010-2929-3150","2023-05-26 18:47:08",true),
(2,"塚越雄真","ツカコシユウマ","男","2002-09-10","慶應義塾大学","理工学部","情報工学科","理系","2025","埼玉県","yuma@gmail.com","012-2348-2389",'2023-05-19 21:45:08',true),
(3,"小野ひなの","オノヒナノ","女","2002-09-10","慶應義塾大学","理工学部","管理工学科","理系","2026","岡山県","hinanu@gmail.com","543-4326-6426","2023-05-12 8:27:18",true),
(4,"竹内菜月","タケウチナツキ","女","2002-09-10","慶應義塾大学","法学部","政治学科","文系","2026","東京都","natuki@gmail.com","366-5473-7354","2023-05-26 11:43:23",true),
(5,"平手美羽","ヒラテミユ","女","2002-09-10","慶應義塾大学","法学部","政治学科","文系","2026","東京都","hirate@gmail.com","036-6456-4536","2023-05-13 21:32:08",true),
(6,"渡辺太郎","ワタナベタロウ","男","2002-02-13","中央大学","法学部","法律学科","文系","2026","千葉県","taro@gmail.com","011-6111-4121","2023-05-29 15:42:22",true),
(7,"宮崎次郎","ミヤザキジロウ","男","2003-11-11","明治大学","政治経済学部","経済学科","文系","2026","茨城県","jiro@gmail.com","848-8182-3261","2023-05-26 11:21:11",true),
(8,"中西花子","ナカニシハナコ","女","2003-04-01","一橋大学","商学部","商学科","文系","2025","栃木県","nakanishi@gmail.com","020-2222-9999",'2023-05-30 03:22:15',true),
(9,"野口三郎","ノグチサブロウ","男","2003-07-01","早稲田大学","政治経済学部","国際政治学科","文系","2026","神奈川県","noguchi@gmail.com","020-7632-8919","2023-05-26 18:47:08",true),
(10,"伊藤美香","イトウミカ","女","2002-03-20","慶應義塾大学","文学部","人文学科","文系","2026","島根県","mika@gmail.com","333-4414-5252","2023-04-12 6:33:18",true),
(11,"山本隆太","ヤマモトリュウタ","男","2003-08-02","ハーバード大学","工学部","建築学科","理系","2025","北海道","yamamoto@gmail.com","333-0000-4946",'2023-04-11 03:10:53',true),
(12,"柳田邦男","ヤナギダクニオ","男","2003-11-30","関東学院大学","文学部","国文学科","文系","2026","神奈川県","tono@gmail.com","090-7632-1111","2023-05-26 18:47:30",true),
(13,"三田武","ミタタケル","男","2002-12-25","慶應義塾大学","経済学部","経済学科","文系","2026","鹿児島県","santa@gmail.com","444-6177-0000","2023-03-24 6:33:32",true),
(14,"目黒啓子","メグロケイコ","女","2003-05-30","京都大学","法学部","法律学科","文系","2026","和歌山県","ahaha@gmail.com","040-5823-5555","2023-04-23 23:47:55",true),
(15,"佐藤加奈","サトウカナ","女","2002-11-29","帝京平成大学","経営学部","経営学科","文系","2026","愛知県","kana@gmail.com","222-4444-7272","2023-04-04 19:47:43",true);


DROP TABLE IF EXISTS label_client_relation;
CREATE TABLE label_client_relation(
  id INT AUTO_INCREMENT PRIMARY KEY,
  client_id INT NOT NULL,
  label_id INT NOT NULL
) CHARSET=utf8;

insert into label_client_relation (id, client_id, label_id) values
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 1, 6),
(7, 1, 7),
(8, 2, 1),
(9, 2, 2),
(10, 2, 3),
(11, 2, 5),
(12, 2, 6),
(13, 2, 7),
(14, 2, 9),
(15, 3, 1),
(16, 3, 3),
(17, 4, 2),
(18, 4, 3),
(19, 4, 5),
(20, 4, 6),
(21, 5, 1),
(22, 5, 5),
(23, 5, 6),
(24, 6, 2),
(25, 6, 5),
(26, 6, 6),
(27, 7, 2),
(28, 7, 5),
(29, 7, 6);


DROP TABLE IF EXISTS clients;
CREATE TABLE clients(
  client_id INT AUTO_INCREMENT PRIMARY KEY,
  agent_name VARCHAR(255) NOT NULL,
  service_name VARCHAR(255) NOT NULL,
  catchphrase VARCHAR(255) NOT NULL,
  recommend_point1 VARCHAR(255) ,
  recommend_point2 VARCHAR(255) ,
  recommend_point3 VARCHAR(255) ,
  started_at date DEFAULT NULL,
  ended_at date DEFAULT NULL,
  logo_img VARCHAR(255) NOT NULL,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  is_valid boolean default true,
  exist boolean default false,
) CHARSET=utf8;


insert into clients(client_id, agent_name, service_name, catchphrase,recommend_point1,recommend_point2,recommend_point3,started_at ,ended_at,logo_img,is_valid,exist) values
-- exist 企業の申請が通ったらexistを1に変更⇒exist1の企業を表示する ANDで追加する
(1,"doda株式会社","doda新卒エージェント","豊富な掲載企業","パーソルとベネッセの合弁会社","取引企業数は常時5,500社以上と豊富","2022年は14万人の就活生に利用される",'2023-02-01', '2023-08-12',"https://doda-student.jp/assets/img/header_logo_01.svg",true,1),
(2,'株式会社マイナビ', 'マイナビ新卒紹介',"丁寧なES添削指導","新卒情報サイトNo.1のマイナビ","大手企業の補欠枠から中小企業がメイン","学歴によって紹介企業を切り分けている",'2023-05-13', '2023-08-19',"https://転職サイト比較ナビ.com/wp-content/uploads/2017/07/d56de24e779423b861e32052727d7fc8.jpg",true,1),
(3,'NaS株式会社', 'DiG UP CAREER',"スピード内定","LINEやビデオ通話などを利用した手軽で密なコミュニケーションが取れる","オンラインで企業とのマッチングイベントが開催されており地方学生でも参加できる","特に自己分析のサポートに力を入れている",'2023-04-03', '2023-07-01',"https://nas-inc.co.jp/lp/digupcareer/assets/img/logo.svg",true,1),
(4,'Jobspirng株式会社', 'JobSpring',"適性検査実施","学生の価値観や適性に合う求人のみを紹介","適性検査を活かしたマッチング","内定承諾率は70%",'2023-04-23', '2023-06-10',"https://jobspring.jp/assets/img/lp/05/JobSpring_logo_v2-min.png?1653983874",true,1),
(5,"Goodfind","Goodfindエージェントサービス","顧客に寄り添う","ややハイスペ学生向け","外資系企業やメガベンチャー企業メイン","優秀な学生には特別選考ルートを案内",'2023-05-02', '2023-07-29',"https://img.goodfind.jp/company/logo/company_1.jpg",true,1),
(6,"株式会社アカリク","アカリク就活エージェント","手厚いサポート受け放題","修士・博士・ポスドクに特化した求人紹介を受けられる","大学院在籍経験のあるアドバイザーが多数在籍している","利用者の選考突破率が8割",'2023-06-01', '2023-07-28',"https://expo.nikkeibp.co.jp/xtech/online/static/assets/images/sponsor/logo_booth_8573.png",true,1),
(7,"株式会社リクナビ","リクナビ就活エージェント","手厚いサポート受け放題","修士・博士・ポスドクに特化した求人紹介を受けられる","大学院在籍経験のあるアドバイザーが多数在籍している","利用者の選考突破率が8割",'2023-02-01', '2023-04-21',"https://www.hiryu.co.jp/wp/wp-content/uploads/2021/07/unnamed.jpg",true,1);

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
(6,6,"担当者六郎","営業部","rokku@gmail.com","224-5437-5437"),
(7,7,"担当者七郎","営業部","nanana@gmail.com","224-5567-5997");


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
  user_id INT NOT NULL,
  client_id VARCHAR(255) NOT NULL,
  valid int NOT NULL default false
);

insert into user_register_client(user_id, client_id,valid) values
(1,1,0),
(1,3,0),
(2,2,0),
(3,4,0),
(3,2,0),
(3,6,0),
(4,3,0),
(5,2,0),
(6,1,1),
(6,4,2),
(7,1,1),
(8,1,2),
(9,2,2),
(9,3,1),
(10,6,1),
(11,3,2),
(12,2,2),
(14,6,0),
(15,3,0),
(15,4,0),
(15,3,0);

DROP TABLE IF EXISTS boozer_register_client;
CREATE TABLE boozer_register_client(
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  password VARCHAR(255) NOT NULL,
  mail VARCHAR(255) NOT NULL
);

insert into boozer_register_client(id, name, password, mail) values
(1,"管理者太郎","password","kakaka@gmail.com");

DROP TABLE IF EXISTS invalid_reason;
CREATE TABLE invalid_reason(
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  client_id INT NOT NULL,
  reason VARCHAR(255) NOT NULL
);

insert into invalid_reason(id, user_id, client_id, reason) values
(1,6,1,"メールで連絡つかない"),
(2,6,4,"電話で連絡つかない"),
(3,7,1,"電話で連絡つかない"),
(4,8,1,"所属大学が不明で連絡つかない"),
(5,9,2,"メールで連絡つかない"),
(6,9,3,"メールで連絡つかない"),
(7,10,6,"電話で連絡つかない"),
(8,11,3,"メールで連絡つかない"),
(9,12,2,"連絡がつかない");

