<?php
    // for と foreach
    $members = array('A', 'B', 'C', 'D', 'E');
    
    $c = count($members);

    // forは自分で繰り返し回数の基準決めれる
    for ($i=0; $i < $c; $i++) { 
        echo $members[$i];
    }

    echo '<br>';echo '<br>';

    // foreachは配列が必須で必要（配列の要素数で回数が決まる）
    foreach ($members as $member) {
        // $member = $members[0]; ← 0の部分は繰り上がる
        echo $member;
    }


?>










