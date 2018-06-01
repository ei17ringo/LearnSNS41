<?php
session_start();
require("dbconnect.php");
echo "<pre>";
var_dump($_POST);
echo "</pre>";

$login_user_id = $_SESSION["id"];
$comment = $_POST["write_comment"];
$feed_id = $_POST["feed_id"];

// ※like.phpやdelete.phpが参考になります

// コメントをInsertするSQL文作成
$sql = "INSERT INTO `comments`(`comment`, `user_id`, `feed_id`, `created`) VALUES (?,?,?,now());";

$data = array($comment,$login_user_id,$feed_id);

// SQL文実行
$stmt = $dbh->prepare($sql);
$stmt->execute($data);

// timeline.php(一覧)にもどる
header("Location: timeline.php");


?>