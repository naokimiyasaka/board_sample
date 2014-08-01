<?PHP
/**
 * Registration
 *
 * <pre>
 * ロジック関係
 *
 * PHP versions 5.3
 * </pre>
 *
 * @category   Control
 * @package    Bbs
 * @subpackage Bbs
 * @author     Naoki Miyasaka <naokimiyasaka@gamania.com>
 * @copyright  2011-2012 Gamania Degital Entertainment Co.,Ltd.
 * @license    http://www.opensource.org/licenses/mit-license.php MIT License
 * @version    SVN: $Rev: 86 $
 * @access     public
 * @link       $HeadURL: svn+ssh://127.167.180.69/var/svn/develop/PSS/study/branches/BbsLoginHM_Miya/php/Registration.php $
 */

require_once "./Logic.php";

/**
 * Registration
 *
 * <pre>
 * ロジック関係
 * </pre>
 *
 * @category   Control
 * @package    Bbs
 * @subpackage Bbs
 * @author     Naoki Miyasaka <naokimiyasaka@gamania.com>
 * @license    http://www.opensource.org/licenses/mit-license.php MIT License
 * @access     public
 * @link       $HeadURL: svn+ssh://127.167.180.69/var/svn/develop/PSS/study/branches/BbsLoginHM_Miya/php/Registration.php $
 * @access     public
 */
class Registration
{
    private $_err = array();
    private $_db = null;
    private $_login = null;

    /**
     * コンストラクタ
     *
     * <pre>
     * データベースに接続
     * </pre>
     *
     * @param Object $db_o データベースクラス
     *
     * @return none
     * @access public
     */
    public function __construct($db_o, $login_o)
    {
        $this->_db = $db_o;
        $this->_login = $login_o;
    }

    /**
     * デストラクタ
     *
     * <pre>
     * デストラクタ
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
     * 表示
     *
     * <pre>
     * 表示
     * </pre>
     *
     * @param Object $smarty スマーティクラス
     *
     * @return none
     * @access public
     */
    public function dispPage($smarty)
    {
        // ログイン情報の取得
        $login_info = $this->_login->getLoginInfo();

        /*if($login_info == false) {
            // 現在のクラス情報を保存
            Uitl::saveSession("class", get_class($this));
            Uitl::redirect("./index.php?class=Login&method=dispPage&status=0");
            exit();
        }*/
        $this->_login->loginTransition(get_class($this), 0);

        $err_code = array();
        $result = false;

        if ( isset($_POST['send']) ) {//送信
            $result = $this->_db->sendSqlRegist(&$this->_err);

            if ( $result === true ) {
                Uitl::redirect("./index.php");
            }
            $err_code = $this->_err;
        }

        $smarty->assign('login_info', $login_info);
        $smarty->assign('err_code', $err_code);
        $smarty->display('registration.tpl');

        return $result;
    }
}
?>