<?php
    const FP_LENGTH = 24;

    $fp = null;//ファイルポインタを初期化

    //ファイルが存在するかチェック
    if( file_exists("access_count.txt") ) {
        if(is_readable("access_count.txt") && is_writable("access_count.txt")) {
            $fp = fopen("access_count.txt", "r+");//ファイルを開く
        }
    }
    else {
        if( is_writable("./") ) {
            $fp = fopen("access_count.txt", "w+");//ファイルを作成
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

    print "クラスを使用していない アクセスカウンターの人数:$counter\n";
?>
