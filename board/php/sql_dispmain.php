<?PHP
//すべて出来上がったときに継承などを使用してリファクタリングする
class DispMain {//sqlにデータベースにある情報をすべて表示するようにする
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

        //登録したテーブルのデータを受信する
        public function ReceptionSql()
        {
            //トランザクション開始
            mysql_query("begin", $this->_link);
            // SQL文の実行
            $result = mysql_query("select * from BOARD",$this->_link);

            //掲示板のレイアウトを作成
            $this->CreateLayout($result);

            //トランザクション終了
            if( $result ) {
                mysql_query("commit", $this->_link);//更新
            }
            else {
                mysql_query("rollback", $this->_link);//ロールバック
            }
        }

        //サーバー、データベースアクセス処理
        public function connect()
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
        public function disconnect($link)
        {
            //サーバー切断
            if( !mysql_close($link) ) exit("データベース削除失敗");
        }

        //掲示板のレイアウトを作る  メイン
        public function CreateLayout($sql_data)
        {
            print("<table border=4 width=500 align=center>");

            // 結果セットの各レコードを順次、連想配列に格納する
            while($arr_record = mysql_fetch_assoc($sql_data))
            {
                // 連想配列のキー値をフィールド名に、値をフィールド値として取り出す
                $this->CreateLayoutSub($arr_record);
                print("<br>\n");
            }

            print("</table>");
        }

        //実際のレイアウトをここで
        public function CreateLayoutSub($arr_data)
        {
            $boardid  = $arr_data['boardid'];
            $subject  = $arr_data['subject'];
            $name     = $arr_data['name'];
            $mail     = $arr_data['mail'];
            $maintext = $arr_data['maintext'];

            print("<tr>");
            print("<td><font class=\"tw\" style=\"position:relative; float:left;\" ><p><label>件名:$subject</font>");

            print("<font class=\"tw\"><p><label>&nbsp;&nbsp;名前:$name</font></tb>");
            print("<br>");

            print("<a href=\"./edit.php?id={$boardid}\"><button name=\"edit_bt\">編集</button></a>");
            print("<a href=\"./delete.php?id={$boardid}\"><button name=\"delete_bt\">削除</button></a>");
            print("<a href=\"./details.php?id={$boardid}\"><button name=\"delete_bt\">詳細</button></a>");
            print("</tr>");

            print("<tr><td colspan=4><font class=\"tw\">$maintext</font></td></tr>");
        }

    }

    $disp = new DispMain();
    $disp->ReceptionSql();
?>