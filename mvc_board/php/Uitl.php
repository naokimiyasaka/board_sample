<?PHP
/**
 * Uitl
 *
 * <pre>
 * ユーティールクラス
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
 * Uitl
 *
 * <pre>
 * ユーティールクラス
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
class Uitl
{
    /**
     * コンストラクタ
     *
     * <pre>
     *
     * </pre>
     *
     * @return none
     * @access public
     */
    public function __construct()
    {
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
     * _POSTからデータを取得する
     *
     * <pre>
     * _POSTからデータを取得する
     * </pre>
     *
     * @param string $key POST
     *
     * @return none
     * @access public
     */
    static public function getPost($key)
    {
        //指定しているキーがあるか？
        if ( !isset($_POST[$key]) ) {
            return null;
        }

        return $_POST[$key];
    }

    /**
     * _GETからデータを取得する
     *
     * <pre>
     * _GETからデータを取得する
     * </pre>
     *
     * @param string $key GET
     *
     * @return none
     * @access public
     */
    static public function getGet($key)
    {
        //指定しているキーがあるか？
        if ( !isset($_GET[$key]) ) {
            return null;
        }

        return $_GET[$key];
    }
    
    static public function redirect($url)
    {
        header("Location: $url");//別のページに遷移させる
        exit();
    }
}
?>