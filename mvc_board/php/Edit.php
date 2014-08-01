<?PHP
/**
 * Edit
 *
 * <pre>
 * 編集関係
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
 * @version    SVN: $Rev: 73 $
 * @access     public
 * @link       $HeadURL: svn+ssh://127.167.180.69/var/svn/develop/PSS/study/trunk/BbsLoginHM/php/Edit.php $
 */

/**
 * Edit
 *
 * <pre>
 * 編集関係
 * </pre>
 *
 * @category   Control
 * @package    Bbs
 * @subpackage Bbs
 * @author     Naoki Miyasaka <naokimiyasaka@gamania.com>
 * @license    http://www.opensource.org/licenses/mit-license.php MIT License
 * @access     public
 * @link       $HeadURL: svn+ssh://127.167.180.69/var/svn/develop/PSS/study/trunk/BbsLoginHM/php/Edit.php $
 * @access     public
 */
class Edit
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
     * データベースのインスタンスを取得
     *
     * <pre>
     * データベースのインスタンスを取得
     * </pre>
     *
     * @return none
     * @access public
     */
    public function getDb()
    {
        return $this->_db;
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
        $data_array = $this->_db->receptionSqlEdit();

        /*if( $data_array == null ) {
            return false;
        }*/

        if ( isset($_POST['send']) ) {//送信
            $this->_db->sqlSendEdit();
            Uitl::redirect("./index.php");
            exit();
        }

        $smarty->assign('disp_text', $data_array);
        $smarty->display('edit.tpl');

        return true;
    }
}
?>