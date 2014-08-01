<?PHP
/**
 * Details
 *
 * <pre>
 * 詳細関係
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
 * @link       $HeadURL: svn+ssh://127.167.180.69/var/svn/develop/PSS/study/branches/BbsLoginHM_Miya/php/Details.php $
 */

/**
 * Details
 *
 * <pre>
 * 詳細関係
 * </pre>
 *
 * @category   Control
 * @package    Bbs
 * @subpackage Bbs
 * @author     Naoki Miyasaka <naokimiyasaka@gamania.com>
 * @license    http://www.opensource.org/licenses/mit-license.php MIT License
 * @access     public
 * @link       $HeadURL: svn+ssh://127.167.180.69/var/svn/develop/PSS/study/branches/BbsLoginHM_Miya/php/Details.php $
 * @access     public
 */
class Details
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
     * データベースのインスタンス取得
     *
     * <pre>
     * データベースのインスタンス取得
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
        $data_array = $this->_db->receptionSqlDetails();

        if( $data_array == null ) {
            return false;
        }

        $smarty->assign('disp_text', $data_array);
        $smarty->display('details.tpl');

        return true;
    }
}
?>