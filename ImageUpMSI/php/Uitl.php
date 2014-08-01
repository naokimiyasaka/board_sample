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
 * @version    SVN: $Rev: 132 $
 * @access     public
 * @link       $HeadURL: svn+ssh://127.167.180.69/var/svn/develop/PSS/study/trunk/ImageUpMSI/php/Uitl.php $
 */


define('DEFAULT_SEED', 'xxxxxxxx');

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
 * @link       $HeadURL: svn+ssh://127.167.180.69/var/svn/develop/PSS/study/trunk/ImageUpMSI/php/Uitl.php $
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
     * IPアドレスを取得する
     *
     * <pre>
     * IPアドレスを取得する
     * </pre>
     *
     * @param none
     *
     * @return ipaddress
     * @access public
     */
    static public function getIp()
    {
        //指定しているキーがあるか？
        if ( !isset($_SERVER['HTTP_HOST'])) {
            return null;
        }

        return $_SERVER['HTTP_HOST'];
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

    /**
     * _FILESからデータを取得する
     *
     * <pre>
     * _FILESからデータを取得する
     * </pre>
     *
     * @param string $key GET
     *
     * @return none
     * @access public
     */
    static public function getFiles($key)
    {
        //指定しているキーがあるか？
        if ( !isset($_FILES[$key]) ) {
            return null;
        }

        return $_FILES[$key];
    }

    
    static public function redirect($url)
    {
        header("Location: $url");//別のページに遷移させる
        exit();
    }

    //暗号化処理
    static public function crypt($string, $seed)
    {
        $seed_key = DEFALUT_SEED;
        if( $seed != '' ) { //引数でseedが指定されている場合は引数の値を使用する
            $seed_key = $seed;
        }

        //暗号化
        $result = hash_hmac('sha256', $string, $seed_key);

        return $result;
    }

    //復号可能な暗号化
    static public function encoding($input, $key)
    {
        $td = mcrypt_module_open(MCRYPT_TRIPLEDES,'','cbc','');

        // key（最大キー長に）
        $ks = mcrypt_enc_get_key_size($td);
        $key = substr(md5($key), 0, $ks);

        // iv
        $ivsize = mcrypt_enc_get_iv_size($td);
        $iv = substr(md5($key), 0, $ivsize);
        
        //暗号と復号が同じKeyじゃないとダメみたい。
        //srand();
        //$iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);

        mcrypt_generic_init($td, $key, $iv);
        $encrypted_data = mcrypt_generic($td, $input);

        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        return $encrypted_data;
    }

    //復号
    static public function decoding($input, $key)
    {
        $td = mcrypt_module_open(MCRYPT_TRIPLEDES,'','cbc','');
    
        // key（最大キー長に）
        $ks = mcrypt_enc_get_key_size($td);
        $key = substr(md5($key), 0, $ks);

        // iv
        $ivsize = mcrypt_enc_get_iv_size($td);
        $iv = substr(md5($key), 0, $ivsize);
        
        mcrypt_generic_init($td, $key, $iv);
        $decrypted_data = mdecrypt_generic($td, $input);

        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);

        return rtrim($decrypted_data,"\0");
    }

    //セッションに情報の保存
    static public function saveSession($key, $string)
    {
        if (session_id() == '') session_start();

        $_SESSION["$key"] = $string;
    }

    //セッションに情報の保存
    static public function getSession($key)
    {
        if (session_id() == '') session_start();

        if( ! isset($_SESSION["$key"])) {
            return false;
        }

        return $_SESSION["$key"];
    }

    // セッションのユーザーIDを取得する
    static function getSessionUserId()
    {
        //セッション情報を取得
        if(!isset($_SESSION["login_info"])) {
            return false;
        }

        $login_info = Uitl::decoding($_SESSION["login_info"], LOGIN_SEED);
        $login_info_array = explode(",", $login_info);
        return $login_info_array[0];
    }

    //セッションに情報の保存
    static public function getBbsId()
    {
        $bbs_id = Uitl::getGet('id');

        if ($bbs_id == null) {
            $bbs_id = Uitl::getSession('bbs_id');
        }

        return $bbs_id;
    }

    //セッション情報スタート
    static public function startSession()
    {
       if (session_id() == '') session_start();
    }

    //セッション情報スタート
    static public function endSession()
    {
       session_destroy();
    }

    //イメージファイルの読み込み
    static public function imageLoad($filename)
    {
        $fp = fopen("$filename", 'rb');
        $image = fread($fp, filesize("$filename"));

        return $image;
    }

}
?>