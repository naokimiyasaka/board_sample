<?php
    class SqlCounter{
        const FP_LENGTH = 24;
        const NUM_TYPE_MAX = 9;
        private $_counter = 0;
        private $_link = 0;
        private $_format;
        private $_new_counter;

        //コンストラクタ
        //ファイルオープンとカウンタ処理と書き込み処理
        public function __construct()
        {
            $this->_link = self::connect();//データベースにアクセス
        }

        //デストラクタ　ファイルをクローズする
        public function __destruct()
        {
            self::disconnect($this->_link);//データベース切断
        }

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

        //カウントアップしてテーブルに値を取得し、更新する
        public function AddCounter()
        {
            $type = COUNTER_TYPE;
            $this->_counter = 0;

            //トランザクションを始める準備
            mysql_query("set autocommit = 0", $this->_link);
            mysql_query("begin", $this->_link);
            
            $result = mysql_query("select count(*) from OB_ACCESS_COUNTER");
            $row = mysql_fetch_assoc($result,MYSQL_ASSOC);

            //レコードがない
            if( $row['count(*)'] == 0 ) {
                mysql_query("insert into OB_ACCESS_COUNTER (type, counter) value($type, $this->_counter)");
            }
            else {//レコードがある場合はテーブルからデータベースからデータを取得
                $result = mysql_query("select counter from OB_ACCESS_COUNTER");
                $row = mysql_fetch_assoc($result,MYSQL_ASSOC);
                $this->_counter = $row['counter'];
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
            $this->_format = '%0'.self::FP_LENGTH.'d';
            $this->_new_counter = sprintf($this->_format, $this->_counter);

            for( $i = 0; $i <= self::NUM_TYPE_MAX; $i++ ) {
                $num = $i;
                $tag = "<div><img class=\"img$i\"".' src="all.gif"></div>';
                $this->_new_counter = str_replace($num, $tag, $this->_new_counter);
            }
            
            print "<div class=\"clear\">"."アクセスカウンタ"."</div>";

            print "$this->_new_counter";
        }
    }

    //クラスの実行処理
    $spl_ob_counter = new SqlCounter();//コンストラクターを呼ぶことでアクセスカウンタが増える
    $spl_ob_counter->AddCounter();
    $spl_ob_counter->Dispcounter();
?>
