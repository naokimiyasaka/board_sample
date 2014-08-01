<?php
    //const FP_LENGTH = 24;

    $fp = null;//ファイルポインタを初期化

    //ファイルが存在するかチェック
    if( file_exists("img_access_count.txt") ) {
        if(is_readable("img_access_count.txt") && is_writable("access_count.txt")) {
            $fp = fopen("img_access_count.txt", "r+");//ファイルを開く
        }
    }
    else {
        if( is_writable("./") ) {
            $fp = fopen("img_access_count.txt", "w+");//ファイルを作成
        }
    }

    $counter = 0;

    if( $fp ) {
        if( flock($fp, LOCK_EX) ) {//ロックする
            $counter = fgets($fp, FP_LENGTH);
        }

        if( $counter === false ) {
            $counter = 0;
        }
    }

    $counter++;//カウンタを増やす

    rewind($fp);//ファイルポインタを最初に戻す

    if( flock($fp, LOCK_EX) ) {//ロックする
        fwrite($fp, $counter);//ファイルに書き込む
    }

    flock($fp, LOCK_UN);//ロック解除    

    fclose($fp);

    $format = '%0'.FP_LENGTH.'d';
    $new_counter = sprintf($format, $counter);
    const NUM_TYPE_MAX = 9;
    
    for( $i = 0; $i <= 9; $i++ ) {
        $num = $i;
        $tag = "<div><img class=\"img$i\"".' src="all.gif"></div>';
        $new_counter = str_replace($num, $tag, $new_counter);
    }
    
    print "<div class=\"clear\">"."アクセスカウンタ"."</div>";

    print "$new_counter";
?>