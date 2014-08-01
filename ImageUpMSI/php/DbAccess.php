<?PHP
/**
 * DbAccess
 *
 * <pre>
 * データベース関連
 *
 * PHP versions 5.3
 * </pre>
 *
 * @category   Model
 * @package    DbAccess
 * @subpackage DbAccess
 * @author     Naoki Miyasaka <naokimiyasaka@gamania.com>
 * @copyright  2011-2012 Gamania Degital Entertainment Co.,Ltd.
 * @license    http://www.opensource.org/licenses/mit-license.php MIT License
 * @version    SVN: $Rev: 122 $
 * @access     public
 * @link       $HeadURL: svn+ssh://127.167.180.69/var/svn/develop/PSS/study/trunk/ImageUpMSI/php/DbAccess.php $
 */
require_once "./Logic.php";

 /**
 * DbAccess
 *
 * <pre>
 * データベース関連
 * </pre>
 *
 * @category   Model
 * @package    Bbs
 * @subpackage Bbs
 * @author     Naoki Miyasaka <naokimiyasaka@gamania.com>
 * @license    http://www.opensource.org/licenses/mit-license.php MIT License
 * @access     public
 * @link       $HeadURL: svn+ssh://127.167.180.69/var/svn/develop/PSS/study/trunk/ImageUpMSI/php/DbAccess.php $
 * @access     public
 */
class DbAccess
{
    private $_link = false;
    const   CONNECT_ERR    = -1;
    const   SELECT_DB_ERR  = -2;
    const   NOT_DATA       = -3;
    const   SUCCESS        = 0;

    /**
     * コンストラクタ
     *
     * <pre>
     * データベースに接続
     * </pre>
     *
     * @return none
     * @access public
     */
    public function __construct()
    {
        $this->connect("localhost", "root", "0okm9ijn!!", "naokimiyasaka");//データベースにアクセス
    }

    /**
     * デストラクタ
     *
     * <pre>
     * データベース切断
     * </pre>
     *
     * @return none
     * @access public
     */
    public function __destruct()
    {
        return true;
    }

    /**
     * サーバー、データベースアクセス処理
     *
     * <pre>
     * サーバー、データベースアクセス処理
     * </pre>
     *
     * @return none
     * @access public
     */
    function connect($db_host, $db_user, $db_pass, $db_name)
    {
        //DB接続 処理
        $link = false;

        $link = @mysql_connect($db_host, $db_user, $db_pass, false);

        if ( !$link ) {
            return self::CONNECT_ERR;
        }

        //データベース選択
        $sdb = mysql_select_db($db_name, $link);

        if ( !$sdb ) {
            return self::SELECT_DB_ERR;
        }

        //トランザクション準備と文字コード設定
        mysql_query("set character set utf8");
        mysql_query("set autocommit = 0", $link);
        
        $this->_link = $link;

        return self::SUCCESS;
    }

    /**
     * データベースのハンドルを返す
     *
     * <pre>
     * データベースのハンドルを返す
     * </pre>
     *
     * @return none
     * @access public
     */
    public function getLink()
    {
        return $this->_link;
    }

    /**
     * SQLの命令を送る $commandは""を含むもののみ
     *
     * <pre>
     * SQLの命令を送る $commandは""を含むもののみ
     * </pre>
     *
     * @param string $command sqlクエリを送る
     *
     * @return none
     * @access public
     */
    public function sqlQuery($command)
    {
        //トランザクション開始
        mysql_query("begin", $this->_link);

        // SQL文の実行
        $result = mysql_query($command, $this->_link);

        //トランザクション終了
        if ( $result ) {
            mysql_query("commit", $this->_link);//更新
        } else {
            mysql_query("rollback", $this->_link);//ロールバック
            return false;
        }

        return $result;
    }

    /**
     * SQLの取得した内容を配列にいれる １レコード分
     *
     * <pre>
     * SQLの取得した内容を配列にいれる １レコード分
     * </pre>
     *
     * @param string $data 取得したsql内容
     *
     * @return none
     * @access public
     */
    public function getSqlContents($data)
    {
        $data_array = array();
        if( $data != false ) {
            $data_array = mysql_fetch_assoc($data);
        }

        return $data_array;
    }

    /**
     * SQLの取得した内容を配列にいれる すべてのレコード内容
     *
     * <pre>
     * SQLの取得した内容を配列にいれる すべてのレコード内容
     * </pre>
     *
     * @param string $data 取得したsql内容
     *
     * @return none
     * @access public
     */
    public function getAllSqlContents($data)
    {
        //データベースの情報を配列に入れる　二次元
        $data_array = array();
        if( $data != false ) {
            // 結果セットの各レコードを順次、連想配列に格納する
            while ($arr_record = mysql_fetch_assoc($data)) {
                // 連想配列のキー値をフィールド名に
                // 値をフィールド値として取り出す
                // keyたち boardid,subject,name,mail,maintext
                $data_array[] = $arr_record;
            }
        }
        return $data_array;
    }

    //各クラスの受信、送信処理を追加する

    /**
     * 登録したテーブルのデータを受信する Delete
     *
     * <pre>
     * 登録したテーブルのデータを受信する Delete
     * </pre>
     *
     * @return none
     * @access public
     */
    public function receptionSqlDelete()
    {
        $boardid = Uitl::getBbsId();

        if ( $boardid === null ) {
            return null;
        }

        $result = $this->sqlQuery("select * from BOARD where boardid=$boardid");

        //掲示板のレイアウトを作成
        $data_array = $this->getSqlContents($result);
        return $data_array;
    }

    /**
     * sqlにsendする Delete
     *
     * <pre>
     * sqlにsendする Delete
     * </pre>
     *
     * @return none
     * @access public
     */
    public function sqlSendDelete()
    {
        $boardid = Uitl::GetPost('id');

        if ( $boardid === null ) {
            return false;
        }

        $this->sqlQuery("delete from BOARD where boardid=$boardid");
        return true;
    }

    /**
     * 登録したテーブルのデータを受信する Details
     *
     * <pre>
     * 登録したテーブルのデータを受信する Details
     * </pre>
     *
     * @return none
     * @access public
     */
    public function receptionSqlDetails()
    {
        $data_array = array();
        $boardid   = Uitl::getGet('id');

        if ( $boardid === null ) {
            return null;
        }

        $result = $this->sqlQuery("select * from BOARD where boardid=$boardid");

        //掲示板のレイアウトを作成
        $data_array = $this->getSqlContents($result);
        return $data_array;
    }

    /**
     * 登録したテーブルのデータを受信する DispMain
     *
     * <pre>
     * 登録したテーブルのデータを受信する DispMain
     * </pre>
     *
     * @return none
     * @access public
     */
    public function receptionSqlList()
    {
        $data_array = array();
        $result = $this->sqlQuery("select * from BOARD");

        if( $result == false ) {
            return null;
        }

        //掲示板のレイアウトを作成
        $data_array = $this->getAllSqlContents($result);
        return $data_array;
    }

    /**
     * 登録したテーブルのデータを受信する Edit
     *
     * <pre>
     * 登録したテーブルのデータを受信する Edit
     * </pre>
     *
     * @return none
     * @access public
     */
    public function receptionSqlEdit()
    {
        $boardid   = Uitl::getBbsId();
        $data_array = array();

        if ( $boardid === null ) {
            return null;
        }

        $result = $this->sqlQuery("select * from BOARD where boardid=$boardid");

        //掲示板のレイアウトを作成
        $data_array = $this->getSqlContents($result);
        return $data_array;
    }

    /**
     * sqlにsendする Edit
     *
     * <pre>
     * sqlにsendする Edit
     * </pre>
     *
     * @return none
     * @access public
     */
    public function sqlSendEdit()
    {
        $boardid = Uitl::getPost('id');
        $main_text = Uitl::getPost('msg');

        if ( $boardid === null || $main_text === null ) {
                return false;
        }

        $this->sqlQuery(
            sprintf(
                'update BOARD set maintext="%s" where boardid=%d',
                $main_text,
                $boardid
            )
        );
        return true;
    }

    /**
     * 送られたデータをsqlに送る Registration
     *
     * <pre>
     * 送られたデータをsqlに送る Registration
     * </pre>
     *
     * @param string $err エラー
     *
     * @return none
     * @access public
     */
    public function sendSqlRegist($err)
    {
        //POSTに入っている値を取得する
        $subject   = Uitl::getPost('subject');
        $name      = Uitl::getPost('name');
        $mail      = Uitl::getPost('mail');
        $main_text = Uitl::getPost('msg');
        $user_id = Uitl::getSessionUserId();

        if (   $subject   === null
            || $name      === null
            || $mail      === null
            || $main_text === null
        ) {
           return false;
        }

        $err = Logic::checkErr($mail, $subject, $name);

        //エラーページ遷移
        if (isset($err[0])) {
            mysql_query("rollback", $this->getLink());//ロールバック
            return false;
        }

        $insert1 = "insert into BOARD (subject, name, mail, maintext, user_id)";
        $insert2 = "value(\"$subject\", \"$name\", \"$mail\", \"$main_text\", \"$user_id\")";

        $this->sqlQuery(
            sprintf("%s %s", $insert1, $insert2)
        );

        return true;
    }

    //新規登録処理
    public function sendSqlLoginUserRegist($err)
    {
        $user_name   = Uitl::getPost('user_name');
        $user_mail = Uitl::getPost('user_mail');
        $user_passwd = Uitl::getPost('passwd');

        if (   $user_name   === null
            || $user_mail === null
            || $user_passwd === null
        ) {
           return false;
        }
        $err = Logic::checkLoginErr($user_name, $user_passwd, $user_mail);//あとでやる

        //エラーページ遷移
        if (isset($err[0])) {
            return false;
        }

        $crypt_ps = Uitl::crypt( $user_passwd, '' );//パスワードを暗号化

        //セッションにログイン情報をセットする
        $insert1 = "insert into user_logindata (nama, pass, mail)";
        $insert2 = "value(\"$user_name\", \"$crypt_ps\", \"$user_mail\")";

        $this->sqlQuery(
            sprintf("%s %s", $insert1, $insert2)
        );

        return true;
    }

    //ログイン認証処理
    public function checkSqlLoginAuth(&$err)
    {
        $user_name   = Uitl::getPost('user_name');
        $user_passwd = Uitl::getPost('passwd');

        if (   $user_name   === ''
            || $user_passwd === ''
        ) {
            $err = "ユーザー名、パスワードが入力されていません";
           return false;
        }

        $crypt_ps = Uitl::crypt( $user_passwd, '' );//パスワードを暗号化

        //$err = Logic::checkErr($mail, $subject, $name);//あとでやる

        //エラーページ遷移
        /*if (isset($err[0])) {
            mysql_query("rollback", $this->getLink());//ロールバック
            return false;
        }*/

        //セッションにログイン情報をセットする

        $select1 = "select * from user_logindata where nama='$user_name' and pass='$crypt_ps'";
        $result = $this->sqlQuery($select1);

        //掲示板のレイアウトを作成
        $data_array = $this->getSqlContents($result);

        if( $data_array == false ){//一致したものがない
            $err = "掲示板の情報が存在しません";
            return false;
        }

        return $data_array;
    }

    //ユーザー情報を取得
    public function getUserInfo($id)
    {
        if(is_numeric($id) == false) {
            return false;
        }

        $select1 = "select id, nama, mail from user_logindata where id='$id'";
        $result = $this->sqlQuery($select1);

        //掲示板のレイアウトを作成
        $data_array = $this->getSqlContents($result);

        if( $data_array == false )//一致したものがない
            return false;

        return $data_array;
    }

    //データベースにパスを保存
    public function sendSqlPath($path)
    {
        //画像の保存先を保存
        $insert1 = "insert into imgpath (path)";
        $insert2 = "value(\"$path\")";

        $this->sqlQuery(
            sprintf("%s %s", $insert1, $insert2)
        );

        return true;
    }

    //データベースのパスをすべて取得する
    public function receptionSqlPath()
    {
        $select1 = "select * from imgpath";
        $result = $this->sqlQuery($select1);

        $data_array = $this->getAllSqlContents($result);

        if( $data_array == false )//一致したものがない
            return false;

        return $data_array;
    }

    //データベースにバイナリデータを保存させる
    public function sendSqlBinary($data, $type)
    {
        $bar = mysql_real_escape_string( $data );
        $insert1 = "insert into imgbar (imgdata, type)";
        $insert2 = "value(\"$bar\",\"$type\")";
        //$sql = sprintf( 'INSERT INTO imgbar (imgdata ) VALUES ( "%s" )',
        //            mysql_real_escape_string( $data ) );

        $this->sqlQuery(
            sprintf("%s %s", $insert1, $insert2)
        );

        return true;
    }

    //データベースからバイナリデータを取得する
    public function getSqlBinary($id)
    {
        $select1 = "select imgdata from imgbar where id = '$id'";

        $result = $this->sqlQuery($select1);

        $data_array = $this->getAllSqlContents($result);

        if( $data_array == false )//一致したものがない
            return false;

        return $data_array;
    }

    //データベースからバイナリデータを取得する
    public function getAllSqlBinary()
    {
        $select1 = "select * from imgbar";

        $result = $this->sqlQuery($select1);

        $data_array = $this->getAllSqlContents($result);

        if( $data_array == false )//一致したものがない
            return false;

        return $data_array;
    }

    //データベースからバイナリデータを紐づけているＩＤを取得
    public function getSqlBinaryId()
    {
        $select1 = "select id from imgbar";

        $result = $this->sqlQuery($select1);

        $data_array = $this->getAllSqlContents($result);

        if( $data_array == false )//一致したものがない
            return false;

        return $data_array;
    }

}
?>