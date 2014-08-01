<?PHP
class EditSend{//送信
        private $_link = false;
        //コンストラクタ
        public function __construct()
        {
            $this->_link = $this->connect();//データベースにアクセス
        }

        //デストラクタ　ファイルをクローズする
        public function __destruct()
        {
            $this->disconnect($this->_link);//データベース切断
        }

        //サーバー、データベースアクセス処理
        function connect()
        {
            //DB接続 処理
            $db_host = "localhost";//サーバーの場所
            $db_user = "root";      //ユーザー
            $db_pass = "0okm9ijn!!";//パスワード

            $link = mysql_connect($db_host, $db_user, $db_pass);

            if( !$link ) exit("サーバー接続失敗");

            //データベースの選択
            $db_name = "naokimiyasaka";

            $sdb = mysql_select_db($db_name, $link);

            if( !$sdb ) exit("データベース選択失敗");

            //トランザクション準備と文字コード設定
            mysql_query("set character set utf8");
            mysql_query("set autocommit = 0", $link);

            return $link;
        }

        //サーバー切断
        function disconnect($link)
        {
            //サーバー切断
            if( !mysql_close($link) ) exit("データベース削除失敗");
        }

        //_POSTからデータを取得する
        public function GetPost($key)
        {
            //指定しているキーがあるか？
            if(!isset($_POST[$key])) {
                return null;
            }

            return $_POST[$key];
        }

        //sqlにsendする
        public function SqlSend()
        {
            $boardid = $this->GetPost('id');
            $main_text = $this->GetPost('msg');

            if( $boardid === null || $main_text === null ) exit("値が取れていない");

            //トランザクション開始
            mysql_query("begin", $this->_link);
            //新規登録なので常にレコードを追加する
            $result = mysql_query("update BOARD set maintext=\"$main_text\" where boardid=$boardid", $this->_link);

            //トランザクション終了
            if( $result ) {
                mysql_query("commit", $this->_link);//更新
            }
            else {
                mysql_query("rollback", $this->_link);//ロールバック
            }
        }
    }

    $se_edit = new EditSend();
    $se_edit->SqlSend();
    header("Location: ../index.php");//別のページに遷移させる
    exit();
?>