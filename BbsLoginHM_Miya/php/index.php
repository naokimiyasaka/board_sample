<?PHP
/**
 * index
 *
 * <pre>
 * ページ移動
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
 * @version    SVN: $Rev: 85 $
 * @access     public
 * @link       $HeadURL: svn+ssh://127.167.180.69/var/svn/develop/PSS/study/branches/BbsLoginHM_Miya/php/index.php $
 */
require_once "./Bbs.php";
$bbs = new Bbs();

//_GET[]にデータがない場合は、メインページを表示させる
if ( !isset($_GET['class']) && !isset($_GET['method']) ) {
    $bbs->runBoot("DispMain", "dispPage");
    //$bbs->runBoot("Login", "dispPage");
} else {
    $bbs->mainRun();
}

?>