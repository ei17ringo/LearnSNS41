<?php

// サインインしているユーザーの情報を取得して、返す関数
// 引数$dbh:データベース接続オブジェクト
// 引数$user_id:サインインしてるユーザーのid
//  使い方はget_signin_user($dbh,$_SESSION["id"]);

function get_signin_user($dbh,$user_id){
  $sql = 'SELECT * FROM `users` WHERE `id`=?';
  $data = array($user_id);
  $stmt = $dbh->prepare($sql);
  $stmt->execute($data);

  // $signin_user　に取り出したレコードを代入する
  $signin_user = $stmt->fetch(PDO::FETCH_ASSOC);

  return $signin_user;

}

//ログイン済みかチェックし、未ログインであれば、ログイン画面に戻す
function check_signin($user_id){
  if (!isset($user_id)){
      header("Location: signin.php");
      exit(); //このタイミングで処理を中断する
  }
}


?>