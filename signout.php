<?php 
    session_start();

    //$_SESSION変数の破棄（ローカル） = 空の配列を代入
    $_SESSION = array();

    //セッションを破棄(サーバー)
    // var_dump($_SESSION);
    // echo '<br>';
    session_destroy();
    // var_dump($_SESSION);
    header('Location: signin.php');
    exit();



 ?>