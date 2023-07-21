<?php

class sqlQueries
{
  /* MySQL接続情報 */
  /*練習/本番の切り替えが無いのでここに定義*/
  public static $url = "localhost";
  public static $user = "cakephp";
  public static $pass = "123ryu1c";
  public static $db = "room_temp";
  public static $tableName = "trn_temperature";

  /*
      * 最新数件分のデータを取得する
      * @rows　取得件数
  */
  public static function get_latest_temperature($rows)
  {
    //(1):データーベースに接続(UNIX/Linuxの「mysql -u ユーザー名 -p　パスワード」に対応)
    $link = @mysqli_connect(self::$url, self::$user, self::$pass) or die("MySQLへの接続に失敗しました。");

    //(2):データーベースの選択(MySQLの「use データーベース名」に対応)
    $sdb = mysqli_select_db($link, self::$db) or die("データベースの選択に失敗しました。");

    //(3):SQL文をここで生成
    $sql = "SELECT * FROM trn_temperature order by id desc limit {$rows}";

    //(4):(3)で生成したSQL文をここで実行し、結果を配列に詰め込む
    $result = mysqli_query($link, $sql) or die("クエリの送信に失敗しました。<br />SQL:" . $sql);
    $data = array();//結果を詰め込む為の配列を定義
    $i = 0;//配列の添字

    //(6):検索結果を1件ずつ配列に詰め込む、
    //詰め込み終了と同時にポインタと添字を1ずつ進める。
    //fetch_arrayはポインタなのでwhile文で対応
    while ($rows = mysqli_fetch_array($result)) {
      $data[$i] = $rows;
      $i++;
    }

    return $data;//最終的な結果を画面表示部分に渡す
  }

  public static function insert_temperature($temperature, $humid)
  {
    //(1):データーベースに接続(UNIX/Linuxの「mysql -u ユーザー名 -p　パスワード」に対応)
    $link = @mysqli_connect(self::$url, self::$user, self::$pass) or die("MySQLへの接続に失敗しました。");

    //(2):データーベースの選択(MySQLの「use データーベース名」に対応)
    $sdb = mysqli_select_db($link, self::$db) or die("データベースの選択に失敗しました。");

    // (3):気温データをDBに保存する
    $insert = "INSERT INTO " . self::$tableName . " ";
    $insert .= "(temperature,humid) VALUES (";
    $insert .= $temperature;
    $insert .= " , ";
    $insert .= $humid;
    $insert .= ")";
    $result = mysqli_query($link, $insert) or die("空欄の可能性があります。<br />お手数ですがもう一度入力して下さい。<br />SQL:" . $insert);
    return $result;
  }


}

?>
