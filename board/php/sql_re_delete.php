<?PHP
class DeleteReLayout{//受信してレイアウト作成
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
            $boardid   = $this->GetGet('id');

            if( $boardid === null ) exit("GETの情報を受け取れなかった");
            //トランザクション開始
            mysql_query("begin", $this->_link);

            // SQL文の実行
            $result = mysql_query("select * from BOARD where boardid=$boardid",$this->_link);

            //トランザクション終了
            if( $result ) {
                mysql_query("commit", $this->_link);//更新
            }
            else {
                mysql_query("rollback", $this->_link);//ロールバック
            }

            //掲示板のレイアウトを作成
            $this->CreateLayout($result);

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

        //_GETからデータを取得する
        public function GetGet($key)
        {
            //指定しているキーがあるか？
            if(!isset($_GET[$key])) {
                return null;
            }

            return $_GET[$key];
        }

        //掲示板のレイアウトを作る  メイン
        public function CreateLayout($sql_data)
        {
            print("<table border=4 width=500 align=center>");

            // 結果セットの各レコードを順次、連想配列に格納する
            while($arr_record = mysql_fetch_assoc($sql_data))
            {
                $this->CreateLayoutSub($arr_record);
                print "<br>\n";
            }

            print("</table>");
        }

        public function CreateLayoutSub($arr_data)
        {
            $boardid  = $arr_data['boardid'];
            $subject  = $arr_data['subject'];
            $name     = $arr_data['name'];
            $mail     = $arr_data['mail'];
            $maintext = $arr_data['maintext'];

            print("<form action=\"./php/sql_se_delete.php\" method=\"POST\">");
            print("<table border=4 width=500 align=center>");
            print("<tr align=center>");
            print("<input type=\"hidden\" name='id' value=\"$boardid\">");//ID
            print("<td><font class=\"tw\"><p><label>件名:$subject</font></tb>");
            print("<td><font class=\"tw\"><p><label>名前:$name</font></tb>");
            print("</tr>");
            print("<tr align=center>");
            print("<td colspan=4><font class=\"tw\"><p><label>メールアドレス:$mail</font></tb>");
            print("</tr>");
            print("<tr align=center>");
            print("<td><font class=\"tw\"><p><label>本文:</font></td>");
            print("<td colspan=4><font class=\"tw\"><p><label>$maintext</font></td>");
            print("</label></p>");
            print("</tr>");
            print("</label>");
            print("</table>");
            print("<br>");
            print("<center>");
            print("<input type=submit value=\"削除\">");
            print("</center>");
            print("</form>");
        }
    }

    $de_re_edit = new DeleteReLayout();
    $de_re_edit->ReceptionSql();
?>