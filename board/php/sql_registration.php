<?PHP
class Registration{
        private $_link = false;
        const SUBJECT_STRMAX = 20;
        const NAME_STRMAX = 10;
        const ERR_HALF    = -1;
        const ERR_SUBJECT = -2;
        const ERR_NAME    = -3;
        private $_err = array();

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

        //送られたデータをsqlに送る
        public function SendSql()
        {
            //POSTに入っている値を取得する
            $subject   = $this->GetPost('subject');
            $name      = $this->GetPost('name');
            $mail      = $this->GetPost('mail');
            $main_text = $this->GetPost('msg');

            if($subject === null || $name === null || $mail === null || $main_text === null) {
                exit("値を取得できていません");
            }
            //エラーページ遷移管理用
            $err_page_flag = false;

            //文字チェック
            $ret = false;
            $ret = $this->CheckHalf($mail);
            if( $ret === true ) {//全角文字がメールに含まれている
                $this->_err[0] = self::ERR_HALF;
                $err_page_flag = true;
            }

            //文字数チェック
            $ret = false;
            $ret = $this->CheckStrLen($subject, self::SUBJECT_STRMAX);
            if( $ret === true ) {//件名文字数チェック
                $this->_err[1] = self::ERR_SUBJECT;
                $err_page_flag = true;
            }

            $ret = false;
            $ret = $this->CheckStrLen($name, self::NAME_STRMAX);
            if( $ret === true ) {//名前文字数チェック
                $this->_err[2] = self::ERR_NAME;
                $err_page_flag = true;
            }

            //エラーページ遷移
            if($err_page_flag === true ) {
                $this->CreateErrPage();
                mysql_query("rollback", $this->_link);//ロールバック
                return false;
            }
            //トランザクション開始
            mysql_query("begin", $this->_link);

            //新規登録なので常にレコードを追加する
            $result = mysql_query("insert into BOARD (subject, name, mail, maintext) value(\"$subject\", \"$name\", \"$mail\", \"$main_text\")", $this->_link);

            //トランザクション終了
            if( $result ) {
                mysql_query("commit", $this->_link);//更新
            }
            else {
                mysql_query("rollback", $this->_link);//ロールバック
            }

            return true;
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

        //_POSTからデータを取得する
        public function GetPost($key)
        {
            //指定しているキーがあるか？
            if(!isset($_POST[$key])) {
                return null;
            }

            return $_POST[$key];
        }

        //全角、半角チェックする　全角使用時 true 全角不使用時 false
        public function CheckHalf($text)
        {
            $ret = false;
            $len = strlen($text);
            $mblen = mb_strlen($text, mb_internal_encoding());

            if($len !== $mblen) {
                $ret = true;
            }

            return $ret;
        }

        //文字数チェック 文字列が指定しているものより大きいときはtrue そうではないときはfalse
        public function CheckStrLen($text, $len)
        {
            $mblen = mb_strlen($text, mb_internal_encoding());

            if( $mblen > $len ) {
                return true;
            }

            return false;
        }

        //エラーページ作成と新規登録画面
        public function CreateErrPage()
        {
            print("<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01//EN\"");
            print("\"http://www.w3.org/TR/html4/loose.dtd\">");
            print("<html>");
            print("<head>");
            print("<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">");
            print("<link rel=\"stylesheet\" type=\"text/css\" href=\"./css/body_css.css\">");
            print("<title>新規登録画面</title>");
            print("</head>");
            print("<body>");
            print("<font class=\"tw\"><hr><center>登録画面</center><br></font>");
            print("<table border=4 width=500 align=center>");
            print("<form action=\"./sql_registration.php\" method=\"POST\">");
            print("<tr align=center>");
            print("<td><font class=\"tw\"><p><label>件名:</font></tb>");
            print("<td><input type=\"text\" name=\"subject\" value=\"\" tabindex=\"0\" accesskey=\"a\"></tb>");
            print("</label>");
            print("<td><font class=\"tw\"><label>お名前:</font></tb>");
            print("<td><input type=\"text\" name=\"name\" value=\"\" tabindex=\"1\" accesskey=\"b\"></tb>");
            print("</label></p>");
            print("</tr>");
            print("<tr align=center>");
            print("<td><font class=\"tw\"><p><label>メールアドレス</font></tb>");
            print("<td colspan=4><input type=\"text\" name=\"mail\" value=\"\" tabindex=\"2\" accesskey=\"c\"></tb>");
            print("</label></p>");
            print("</tr>");
            print("<tr align=center>");
            print("<td><font class=\"tw\"><p><label>本文:</font></td>");
            print("<td colspan=4><textarea name=\"msg\" cols=40 rows=4></textarea>");
            print("</label></p>");
            print("</tr>");
            print("</table>");
            print("<br>");
            print("<center>");
            print("<input type=submit value=\"送信\">");
            print("</center>");
            print("</form>");
            print("<br>");
            print("<center>");
            foreach( $this->_err as $value ){
                if($value == self::ERR_HALF) {
                    print("<br>");
                    print("<font class=\"tw\"><p><label>エラー:メールアドレスに全角が入っています</font>");
                }
                else if($value == self::ERR_SUBJECT) {
                    print("<br>");
                    print("<font class=\"tw\"><p><label>エラー:件名の文字数が２０以上超えています</font>");
                }
                else if($value == self::ERR_NAME) {
                    print("<br>");
                    print("<font class=\"tw\"><p><label>エラー:名前の文字数が1０以上超えています</font>");
                }
            }
             print("</center>");

            print("<a href=\"index.php\"><center>HOME</center></a><br>");
            print("</body>");
            print("</html>");
        }
    }

    $new_registration = new Registration();
    $result = $new_registration->SendSql();

    if( $result === true ) {
        header("Location: ../index.php");//別のページに遷移させる
        exit();
    }
?>