<?php

/* ドライバ呼び出しを使用して MySQL データベースに接続する */
// $dsn = 'mysql:dbname=shukatsu;host=db';
// $user = 'root';
// $password = 'root';

// $pdo = new PDO($dsn, $user, $password);

class Database {
  private static $db;

  static function get() {
      if(!isset(self::$db))
          self::$db = new PDO('mysql:dbname=shukatsu;host=db;', 'root', 'root');
          self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          self::$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

      return self::$db;
  }
}

?>
