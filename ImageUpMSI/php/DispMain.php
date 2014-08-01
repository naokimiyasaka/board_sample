<?PHP
/**
 * DispMain
 *
 * <pre>
 * sqlにデータベースにある情報をすべて表示するようにする
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
 * @version    SVN: $Rev: 122 $
 * @access     public
 * @link       $HeadURL: svn+ssh://127.167.180.69/var/svn/develop/PSS/study/trunk/ImageUpMSI/php/DispMain.php $
 */

//ロジッククラスは使用している所のみ定義する
require_once "./Logic.php";

/**
 * DispMain
 *
 * <pre>
 * sqlにデータベースにある情報をすべて表示するようにする
 * </pre>
 *
 * @category   Control
 * @package    Bbs
 * @subpackage Bbs
 * @author     Naoki Miyasaka <naokimiyasaka@gamania.com>
 * @license    http://www.opensource.org/licenses/mit-license.php MIT License
 * @access     public
 * @link       $HeadURL: svn+ssh://127.167.180.69/var/svn/develop/PSS/study/trunk/ImageUpMSI/php/DispMain.php $
 * @access     public
 */
class DispMain
{
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
        $data_array = array();
        $data_array = $this->_db->receptionSqlList();

        $disp_main = $data_array;

        $disp_main = Logic::limitDispStr($disp_main);//文字数制限処理
        $user_info = $this->_login->getLoginInfo();

        $smarty->assign('user_name', $user_info['nama']);
        $smarty->assign('is_login', $this->_login->checkLoginStatus());
        $smarty->assign('disp_text', $disp_main);
        $smarty->display('index.tpl');

        return true;
    }
}
?>