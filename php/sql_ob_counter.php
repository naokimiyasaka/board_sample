<?php
    class SqlCounter{
        const FP_LENGTH = 24;
        const NUM_TYPE_MAX = 9;
        private $_counter = 0;
        private $_link = false;

        //コンストラクタ
        //ファイルオープンとカウンタ処理と書き込み処理
        public function __construct()
        {
            $this->_link = $this->connect();//データベースにアクセス
        }

        //デストラクタ　ファイルをクローズする
        public function __destruct()
        {
            $this->disconnect($this->_link);//データベース切断
        }

        function connect()
        {
            //DB接続 処理
            $db_host = "localhost";//サーバーの場所
            $db_user = "root";      //ユーザー
            $db_pass = "0okm9ijn!!";//パスワード

            //$link = mysql_connect($db_host, $db_user, $db_pass);
            $link = mysql_connect($db_host, $db_user, $db_pass);

            if( !$link ) exit("サーバー接続失敗");

            //データベースの選択
            $db_name = "naokimiyasaka";

            $sdb = mysql_select_db($db_name, $link);

            if( !$sdb ) exit("データベース選択失敗");

            return $link;
        }

        function disconnect($link) 
        {
            //サーバー切断
            if( !mysql_close($link) ) exit("データベース削除失敗");
        }

        //カウントアップしてテーブルに値を取得し、更新する
        public function AddCounter()
        {
            $type = COUNTER_TYPE;
            $this->_counter = 0;

            //トランザクションを始める準備
            mysql_query("set autocommit = 0", $this->_link);
            mysql_query("begin", $this->_link);
            
            //データベースから値を取得する
            $result = mysql_query("select * from OB_ACCESS_COUNTER where type=$type");
            $check = mysql_fetch_assoc($result,MYSQL_ASSOC);

            if( $check ) {//レコード存在する
                $this->_counter = $check['counter'];
            }
            else {//レコード存在しない
                mysql_query("insert into OB_ACCESS_COUNTER (type, counter) value($type,  $this->_counter)");
            }

            $this->_counter++;

            $result = mysql_query("update OB_ACCESS_COUNTER set counter=$this->_counter where type=$type");
            
            //トランザクション結果
            if( $result === true ) {
                mysql_query("commit", $this->_link);
            }
            else {
                mysql_query("roolback", $this->_link);
            }
        }

        //画像描画
        public function Dispcounter()
        {
            $format = '%0'.self::FP_LENGTH.'d';
            $new_counter = sprintf($format, $this->_counter);

            for( $i = 0; $i <= self::NUM_TYPE_MAX; $i++ ) {
                $num = $i;
                $tag = "<div><img class=\"img$i\"".' src="all.gif"></div>';
                $new_counter = str_replace($num, $tag, $new_counter);
            }
            
            print "<div class=\"clear\">"."アクセスカウンタ"."</div>";

            print "$new_counter";
        }
    }

    //クラスの実行処理
    $spl_ob_counter = new SqlCounter();//コンストラクターを呼ぶことでアクセスカウンタが増える
    $spl_ob_counter->AddCounter();
    $spl_ob_counter->Dispcounter();
?>
