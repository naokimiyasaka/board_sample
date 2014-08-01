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
 * @version    SVN: $Rev: 9 $
 * @access     public
 * @link       $HeadURL$
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
 * @link       $HeadURL$
 * @access     public
 */
class DispMain
{
    private $_db = null;

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
    public function __construct($db_o)
    {
        $this->_db = $db_o;
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

        if( $data_array == null ) {
            return false;
        }

        $disp_main = $data_array;

        $disp_main = Logic::limitDispStr($disp_main);//文字数制限処理

        $smarty->assign('disp_text', $disp_main);
        $smarty->display('index.tpl');

        return true;
    }
}
?>