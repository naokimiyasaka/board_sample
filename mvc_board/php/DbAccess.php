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
 * @version    SVN: $Rev: 9 $
 * @access     public
 * @link       $HeadURL$
 */


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
 * @link       $HeadURL$
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
        //$db_host = "localhost";//サーバーの場所
        //$db_user = "root";      //ユーザー
        //$db_pass = "0okm9ijn!!";//パスワード
        $link = false;
        
        $link = @mysql_connect($db_host, $db_user, $db_pass, false);

        if ( !$link ) {
            //exit("サーバー接続失敗");
            return self::CONNECT_ERR;
        }

        //データベースの選択
        //$db_name = "naokimiyasaka";

        $sdb = mysql_select_db($db_name, $link);

        if ( !$sdb ) {
            //exit("データベース選択失敗");
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
        $boardid = Uitl::getGet('id');

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
            //exit( "正しくGetが取得できなかった" );
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
        $boardid   = Uitl::getGet('id');
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

        $insert1 = "insert into BOARD (subject, name, mail, maintext)";
        $insert2 = "value(\"$subject\", \"$name\", \"$mail\", \"$main_text\")";

        $this->sqlQuery(
            sprintf("%s %s", $insert1, $insert2)
        );

        return true;
    }
}
?>