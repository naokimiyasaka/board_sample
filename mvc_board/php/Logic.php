<?PHP
/**
 * Logic
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
 * @version    SVN: $Rev: 9 $
 * @access     public
 * @link       $HeadURL$
 */

/**
 * Logic
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
 * @link       $HeadURL$
 * @access     public
 */
class Logic
{
    const SUBJECT_STRMAX = 20;
    const NAME_STRMAX = 10;

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
     * エラーチェック
     *
     * <pre>
     * エラーチェック
     * </pre>
     *
     * @param string $mail    メールアドレス
     * @param string $subject 件名
     * @param string $name    名前
     *
     * @return $err
     * @access public
     */
    static public function checkErr($mail, $subject, $name)
    {
        $err = array();

        //文字チェック
        $ret = false;
        $ret = self::checkHalf($mail);
        if ( $ret === true ) {//全角文字がメールに含まれている
            $err[] = "Err:全角文字がメールに含まれている";
        }

        //文字数チェック
        $ret = false;
        $ret = self::checkStrLen($subject, self::SUBJECT_STRMAX);
        if ( $ret === true ) {//件名文字数チェック
            $err[] = "Err:件名の文字数が２０以上です";
        }

        $ret = false;
        $ret = self::checkStrLen($name, self::NAME_STRMAX);
        if ( $ret === true ) {//名前文字数チェック
            $err[] = "Err:名前の文字数が１０以上です";
        }

        return $err;
    }

    /**
     * 文字数制限
     *
     * <pre>
     * 文字数制限
     * </pre>
     *
     * @param string $str_data エラーチェック
     *
     * @return $err
     * @access public
     */
    static public function limitDispStr($str_data)
    {
        foreach ( $str_data as &$data ) {//参照渡し 文字数制限
            $data['maintext'] = mb_substr($data['maintext'], 0, 10 );
        }

        return $str_data;
    }

    /**
     * 全角、半角チェックする
     * 全角使用時 true 全角不使用時 false
     *
     * <pre>
     * 全角、半角チェックする
     * 全角使用時 true 全角不使用時 false
     * </pre>
     *
     * @param string $text エラーチェック
     *
     * @return $ret
     * @access public
     */
    static public function checkHalf($text)
    {
        $ret = false;
        $len = strlen($text);
        $mblen = mb_strlen($text, "UTF-8");

        if ($len !== $mblen) {
            $ret = true;
        }

        return $ret;
    }

    /**
     * 文字数チェック
     *
     * <pre>
     * 文字数チェック
     * 文字列が指定しているものより大きいときはtrue
     * そうではないときはfalse
     * </pre>
     *
     * @param string $text エラーチェック
     * @param string $len  文字数
     *
     * @return $ret
     * @access public
     */
    static public function checkStrLen($text, $len)
    {
        $mblen = mb_strlen($text, mb_internal_encoding());

        if ( $mblen > $len ) {
            return true;
        }

        return false;
    }
}
?>