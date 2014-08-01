<?php
    function connect()
    {
        //DB接続 処理
        $db_host = "localhost";//サーバーの場所
        $db_user = "root";      //ユーザー
        $db_pass = "0okm9ijn!!";//パスワード

        $link = mysql_connect($db_host, $db_user, $db_pass);

        if( !$link ) print "サーバー接続失敗";

        //データベースの選択
        $db_name = "naokimiyasaka";

        $sdb = mysql_select_db($db_name, $link);

        if( !$sdb ) print "データベース選択失敗";

        return $link;
    }

    function disconnect($link) 
    {
        //サーバー切断
        if( !mysql_close($link) ) print "データベース削除失敗";
    }

    /*******************実処理*********************/
    const COUNTER_TYPE = 0;
    const FP_LENGTH = 24;
    $type = COUNTER_TYPE;
    $link = 0;
    $link = connect();//mysqlデータベースにアクセス

    $counter = 0;
    //トランザクションを始める準備
    mysql_query("set autocommit = 0", $link);

    mysql_query("begin", $link);

    //データベースから値を取得する
    $result = mysql_query("select count(*) from ACCESS_COUNTER");
    $row = mysql_fetch_assoc($result,MYSQL_ASSOC);

    //レコードがない
    if( $row['count(*)'] == 0 ) {
        mysql_query("insert into ACCESS_COUNTER (type, counter) value($type, $counter)");
    }
    else {//レコードがある場合はテーブルからデータベースからデータを取得
        $result = mysql_query("select counter from ACCESS_COUNTER");
        $row = mysql_fetch_assoc($result,MYSQL_ASSOC);
        $counter = $row['counter'];
    }

    $counter++;
    
    $result = mysql_query("update ACCESS_COUNTER set counter=$counter where type=$type");

    if($result === true ) {
        mysql_query("commit", $link);
    }
    else {
        mysql_query("rollback", $link);
    }

    disconnect($link);//閉じる

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