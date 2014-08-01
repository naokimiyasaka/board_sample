<?PHP
    print_r($_POST);
/*class Registration{
        private $_link = 0;

        //コンストラクタ
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
    }

    //クラスの実行処理
    $spl_ob_counter = new SqlCounter();//コンストラクターを呼ぶことでアクセスカウンタが増える
*/
?>