<?php
    session_start();
    // require(dbconnect)
    require("dbconnect.php");
    // SELECT usersテーブルから　$_SESSIONに保存されているidを使って一件だけ取り出す
    $sql = 'SELECT * FROM `users` WHERE `id`=?';
    $data = array($_SESSION['id']);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    // $signin_user　に取り出したレコードを代入する
    $signin_user = $stmt->fetch(PDO::FETCH_ASSOC);

    //　写真と名前をレコードから取り出す
    // 写真のファイル名をechoする
    // ユーザ名をechoする
    // var_dump($signin_user);

    // echo $signin_user['name']; //ユーザ名
    // echo $signin_user['img_name'];  //画像ファイル名

    $errors = array();

    // ボタン押したとき
    if (!empty($_POST)) {
        $feed = $_POST['feed'];

        if( $feed != '' ) {
            //空じゃないとき
            // 2. SQL文の実行（投稿処理）
            $sql = 'INSERT INTO `feeds` SET `feed`=?, `user_id`=?, `created`=NOW()';
            $data = array($feed, $signin_user['id']);
            $stmt = $dbh->prepare($sql);
            $stmt->execute($data);

            header('Location: timeline.php');
            exit();
        }
        else {
            //空の時　エラー処理
            $errors['feed'] = 'blank';
        }
    }

    //検索ボタンが押されたら、あいまい検索
    //検索ボタンが押された=GET送信されたsearch_wordというキーのデータが有る
    if (isset($_GET['search_word']) == true){
      //あいまい検索用SQL(LIKE演算子)
      $sql = 'SELECT `f`.*,`u`.`name`,`u`.`img_name` FROM `feeds` AS `f` LEFT JOIN `users` AS `u` ON `f`.`user_id`=`u
      `.`id` WHERE `f`.`feed` LIKE "%'.$_GET['search_word'].'%" ORDER BY `f`.`created` DESC';
    }else{
      // 通常（検索ボタンを押していない）は全件取得
      // LEFT JOINで全件取得
      $sql = 'SELECT `f`.*,`u`.`name`,`u`.`img_name` FROM `feeds` AS `f` LEFT JOIN `users` AS `u` ON `f`.`user_id`=`u`.`id` WHERE 1 ORDER BY `f`.`created` DESC';
    }

    
    $data = array();
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
    // executeで取得したタイミングでは
    // Object型 → Array型に変換する
    // PDOでは、fetch()を使用する
    // var_dump($stmt);

    // 表示用の配列を初期化
    $feeds = array();
    // $arr = array();

    while (true) {
        $record = $stmt->fetch(PDO::FETCH_ASSOC); 

  //       $record = array(9) {
  //   ["id"]=>
  //   string(1) "6"
  //   ["feed"]=>
  //   string(36) "どこにいるの？公園かな？"
  //   ["user_id"]=>
  //   string(2) "13"
  //   ["img_name"]=>
  //   string(27) "20180426105011doraemon.jpeg"
  //   ["like_count"]=>
  //   string(1) "0"
  //   ["comment_count"]=>
  //   string(1) "0"
  //   ["created"]=>
  //   string(19) "2018-05-17 09:36:22"
  //   ["updated"]=>
  //   string(19) "2018-05-22 09:27:45"
  //   ["name"]=>
  //   string(12) "重えもん",
        // ["like_cnt"]=>6 <-こんなふうに1データの中にLike数も入ってると表示できそう
  // }

        if ($record == false) {
            break;
        }

        // like数を取得するSQL文を作成
        $like_sql = "SELECT COUNT(*) AS `like_cnt` FROM `likes` WHERE `feed_id` = ?";

        $like_data = array($record["id"]);

        // SQL文を実行
        $like_stmt = $dbh->prepare($like_sql);
        $like_stmt->execute($like_data);

        // like数を取得
        $like = $like_stmt->fetch(PDO::FETCH_ASSOC); 
        // $like = array("like_cnt"=>5); 

        $record["like_cnt"] = $like["like_cnt"];
        $feeds[] = $record;
        // $arr[] = 'ほげ';
    }

    // echo '<pre>';
    // var_dump($feeds);
    // echo '</pre>';

    $c = count($feeds);

    // for ($i=0; $i < $c; $i++) {
    //     echo $feeds[$i]['feed'];
    //     echo '<br>';
    // }

    // foreach ($feeds as $feed) {
    //     // $feed = $feeds[$i];
    //     echo $feed['feed'];
    //     echo '<br>';
    // }

    // exit();

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>Learn SNS</title>
  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="assets/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body style="margin-top: 60px; background: #E4E6EB;">

<!-- preタグ -->
<!-- <pre>
ほげほげ
ほげほげ
ほげ
    ほげ
          ほげほげ
  ほげ
</pre> -->

  <div class="navbar navbar-default navbar-fixed-top">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse1" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">Learn SNS</a>
      </div>
      <div class="collapse navbar-collapse" id="navbar-collapse1">
        <ul class="nav navbar-nav">
          <li class="active"><a href="#">タイムライン</a></li>
          <li><a href="#">ユーザー一覧</a></li>
        </ul>
        <form method="GET" action="" class="navbar-form navbar-left" role="search">
          <div class="form-group">
            <input type="text" name="search_word" class="form-control" placeholder="投稿を検索">
          </div>
          <button type="submit" class="btn btn-default">検索</button>
        </form>
        <ul class="nav navbar-nav navbar-right">
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img src="user_profile_img/<?php echo $signin_user['img_name']; ?>" width="18" class="img-circle"> <?php echo $signin_user['name']; ?> <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="#">マイページ</a></li>
              <li><a href="signout.php">サインアウト</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="row">
      <div class="col-xs-3">
        <ul class="nav nav-pills nav-stacked">
          <li class="active"><a href="timeline.php?feed_select=news">新着順</a></li>
          <li><a href="timeline.php?feed_select=likes">いいね！済み</a></li>
          <!-- <li><a href="timeline.php?feed_select=follows">フォロー</a></li> -->
        </ul>
      </div>
      <div class="col-xs-9">
        <div class="feed_form thumbnail">
          <form method="POST" action="">
            <div class="form-group">
              <textarea name="feed" class="form-control" rows="3" placeholder="Happy Hacking!" style="font-size: 24px;"></textarea><br>
              <?php if( isset($errors['feed']) && $errors['feed']=='blank') { ?>
                <p class="alert alert-danger">投稿データを入力してください</p>
              <?php } ?>
            </div>
            <input type="submit" value="投稿する" class="btn btn-primary">
          </form>
        </div>

        <!-- 繰り返し -->
        <?php foreach ($feeds as $feed) { ?>
          <div class="thumbnail">
            <div class="row">
              <div class="col-xs-1">
                <img src="user_profile_img/<?php echo $feed['img_name']; ?>" width="40">
              </div>
              <div class="col-xs-11">
                <?php echo $feed['name']; ?><br>
                <a href="#" style="color: #7F7F7F;">2018-03-03</a>
              </div>
            </div>
            <div class="row feed_content">
              <div class="col-xs-12" >
                <span style="font-size: 24px;"><?php echo $feed['feed']; ?></span>
              </div>
            </div>
            <div class="row feed_sub">
              <div class="col-xs-12">
                <form method="POST" action="" style="display: inline;">
                  <input type="hidden" name="feed_id" >
                  
                    <input type="hidden" name="like" value="like">
                    <button type="submit" class="btn btn-default btn-xs"><i class="fa fa-thumbs-up" aria-hidden="true"></i>いいね！</button>
                </form>

                <?php if ($feed["like_cnt"] > 0){ ?>
                <span class="like_count">いいね数 : <?php echo $feed["like_cnt"]; ?></span>
                <?php } ?>

                <span class="comment_count">コメント数 : 9</span>
                  <?php if ($feed["user_id"] == $_SESSION["id"] ){ ?>
              
                  <a href="edit.php?feed_id=<?php echo $feed["id"] ?>" class="btn btn-success btn-xs">編集</a>
                  <a onclick="return confirm('ほんとに消すの？');" href="delete.php?feed_id=<?php echo $feed["id"] ?>" class="btn btn-danger btn-xs">削除</a>
                  
                  <?php } ?>

              </div>
            </div>
          </div>
        <?php } ?>
        <!-- 繰り返し終了 -->

        <div aria-label="Page navigation">
          <ul class="pager">
            <li class="previous disabled"><a href="#"><span aria-hidden="true">&larr;</span> Older</a></li>
            <li class="next"><a href="#">Newer <span aria-hidden="true">&rarr;</span></a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <script src="assets/js/jquery-3.1.1.js"></script>
  <script src="assets/js/jquery-migrate-1.4.1.js"></script>
  <script src="assets/js/bootstrap.js"></script>
</body>
</html>

