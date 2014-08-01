<?PHP
/**
 * Bbs
 *
 * <pre>
 * Bbsのメインクラス
 *
 * PHP versions 5.3
 * </pre>
 *
 * @category   Core
 * @package    Bbs
 * @subpackage Bbs
 * @author     Naoki Miyasaka <naokimiyasaka@gamania.com>
 * @copyright  2011-2012 Gamania Degital Entertainment Co.,Ltd.
 * @license    http://www.opensource.org/licenses/mit-license.php MIT License
 * @version    SVN: $Rev: 107 $
 * @access     public
 * @link       $HeadURL: svn+ssh://127.167.180.69/var/svn/develop/PSS/study/branches/BbsLoginHM_Miya/php/Bbs.php $
 */

//エラーが発生した場合にエラー表示をする設定
ini_set('display_errors', 1);
//Smartyインストールディレクトリを定数定義
define('SMARTY_DIR', '../smarty/libs/');
//Smartyを使うための準備
require_once SMARTY_DIR . 'Smarty.class.php';

require_once "./Uitl.php";
require_once "./DbAccess.php";
require_once "./Login.php";


define('LOGIN_SEED', '12345');
define('PASS_SEED', '67890');


/**
 * Bbs
 *
 * <pre>
 * Bbsの基礎クラス。
 * sqlにデータベースにある情報をすべて表示するようにする
 * </pre>
 *
 * @category   Core
 * @package    Bbs
 * @subpackage Bbs
 * @author     Naoki Miyasaka <naokimiyasaka@gamania.com>
 * @license    http://www.opensource.org/licenses/mit-license.php MIT License
 * @access     public
 * @link       $HeadURL: svn+ssh://127.167.180.69/var/svn/develop/PSS/study/branches/BbsLoginHM_Miya/php/Bbs.php $
 * @access     public
 */
class Bbs
{
    private $_smarty = null;
    private $_db = null;
    private $_login = null;
    const  FILE_CHECK_ERR    = -1;
    const  FILE_CLASS_ERR    = -2;
    const  FILE_METHOD_ERR  = -3;
    const  SUCCESS              = 0;
    /**
     * コンストラクタ
     *
     * <pre>
     * smarty関係の設定
     * </pre>
     *
     * @return none
     * @access public
     */
    public function __construct()
    {
        $this->_smarty = new Smarty();
        $this->_smarty->caching = 0;
        $this->_smarty->template_dir = '../templates/';
        $this->_smarty->compile_dir  = '../templates_c/';
        $this->_smarty->config_dir   = '../configs/';
        $this->_smarty->cache_dir    = '../cache/';

        $this->_db = new DbAccess();
        $this->_login = new Login($this->_db);

        return true;
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
     * 一番最初にページに遷移するための処理
     *
     * <pre>
     * クラス、メソットを引数でもらい
     * 各コントローラーの処理を起動する
     * </pre>
     *
     * @param string $class_name クラス名
     * @param string $method     メソット名
     *
     * @return none
     * @access public
     */
    public function runBoot($class_name, $method)
    {
        $file_path = sprintf("./%s.php", $class_name);

        //ファイルが存在するか
        if ( !file_exists($file_path) ) {
            return self::FILE_CHECK_ERR;
        }

        //クラスが定義されているファイルをインクルードする
        include_once $file_path;

        //クラスが存在するか
        if ( !class_exists($class_name) ) {
            return self::FILE_CLASS_ERR;
        }
/*
        $this->_db = new DbAccess();
        $this->_login = new Login($this->_db);

        if($class_name != 'Login') {
            //クラスのインスタンスを作成
            $class = new $class_name($this->_db, $this->_login);
        } else {
            $class = $this->_login;
        }
*/

        $class = new $class_name($this->_db, $this->_login);

        //メソットが存在するか
        if ( !method_exists($class, $method) ) {
            return self::FILE_METHOD_ERR;
        }

        $class->$method($this->_smarty);//クラスのDispが呼ばれる
        return self::SUCCESS;
    }

    /**
     * 掲示板の機能で使用するクラスを動的に宣言し処理を行う
     *
     * <pre>
     * _GETから値によって起動するクラスを振り分ける
     * </pre>
     *
     * @return none
     * @access public
     */
    public function mainRun()
    {
        $class_name = Uitl::getGet('class');
        $method = Uitl::getGet('method');

        if( $this->runBoot($class_name, $method) == self::SUCCESS ) {
            return true;
        }

        return false;
    }
}
?>