<?PHP
/**
 * Delete
 *
 * <pre>
 * 削除関係
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

/**
 * Delete
 *
 * <pre>
 * 削除関係
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
class Delete
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
        $data_array = $this->_db->receptionSqlDelete();

        if ( isset($_POST['send']) ) {//送信
            $this->_db->sqlSendDelete();
            header("Location: ./index.php");//別のページに遷移させる
            exit();
        }

        $smarty->assign('disp_text', $data_array);
        $smarty->display('delete.tpl');
    }
}
?>