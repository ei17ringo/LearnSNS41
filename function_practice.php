<?php

// 練習問題１
// 「seedくん」という文字列を出力する「nexseed」という名前の関数を作成してみましょう。（引数はなし）

//同じ関数名の関数を宣言するとエラーになるので、コメント
// function nexseed(){
//   echo "seedくん";
// }

// 練習問題2
// nexseed();

// 練習問題3
// 練習問題２で作成した「nexseed」関数に、「greeting」という引数を追加して「△△△△△、seedくん」と表示されるように呼び出してみましょう。
// ※「△△△△△」のところに、受け取った$greetingの値が入るようにしてください。
// function nexseed($greeting){
//   echo $greeting.",seedくん";
// }

// nexseed("こんにちは");
// echo "<br>";
// $aisatu = "Hello";
// nexseed($aisatu);

// 練習問題４
// 練習問題３で作成した「nexseed」関数に、「name」という引数を追加して「△△△△△、○○さん」と表示されるように呼び出してみましょう。
// ※「△△△△△」には$greetingの値が、「○○」には$nameの値が入るようにしてください。
// function nexseed($greeting,$name){
//   echo $greeting.",".$name."さん";
// }

// nexseed("こんにちは","としき");
// echo "<br>";
// $aisatu = "Hello";
// nexseed($aisatu,"たくと");

function plus($num1,$num2){
  $result = $num1 + $num2;
  return $result;
  //ここから下は、実行しない
  echo "足し算終わりました"; //<-ここの処理は行われない
}

//点数をチェックして合否を返す関数
function checExam($score){

  // returnは条件分岐で何回も使用できる
  if ($score > 80){
    return "合格！";
  }else{
    return "不合格！";
  }


  //実際は↓の書き方も良い書き方
  $kekka = "";
  if ($score > 80){
    $kekka = "合格！";
  }else{
    $kekka = "不合格！";
  }

  return $kekka;
}

// 練習問題５
// 練習問題４で作成した「nexseed」関数が、あいさつ文を戻り値として返すように修正しましょう。（関数内では出力しない）
// ※戻り値を受け取ってから出力してください。
function nexseed($greeting,$name){
  return $greeting.",".$name."さん";
}

//どっちもOK
// echo nexseed("かむばっく","いまじん");
$aisatsu = nexseed("かむばっく","いまじん");

echo $aisatsu;













?>