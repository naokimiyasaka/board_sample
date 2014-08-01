<?php
/**
 *
 * Utilクラスの単体テスト
 *
 * Utilクラスの各種メソッドの単体テスト。
 * redirectメソッドのテストをどうしようか・・・。
 *
 * @author      Seiki Koga <seikikoga@gamania.com>
 * @copyright   Gamania.co.jp
 * @license     GPL
 * @version     $Rev: 2 $
 * @access      public
 */

/**
 * 依存モジュール
 *
 * 使用しているモジュールのrequire
 */
require_once(dirname(__FILE__) . '/../../lib/util.class.php');
require_once(dirname(__FILE__) . '/../../lib/model.class.php');


/**
 * UtilTestクラス
 *
 * PHPUnitを利用したUtilクラスのテストクラス
 *
 * @package     lib
 * @subpackage  util
 * @access      public
 */
class UtilTest extends PHPUnit_Framework_TestCase{
    /**
     * utilオブジェクト
     *
     * クラス内用utilオブジェクト
     *
     * @var object utilオブジェクト
     */
    private $_util;


    /**
     * テストの初期化処理
     *
     * utilクラスのインスタンス生成。
     *
     * @param  void
     * @return void
     * @access public
     */
    public function setUp(){
        $this->_util = new Util();
    }


    /**
     * getParameterのテスト
     *
     * $_REQUESTでの値を正常に取得できるか。
     * 値が存在しない場合はnullを返す。
     *
     * @param  void
     * @return void
     * @access public
     */
    public function testGetParameter(){
        $util = $this->_util;

        $_REQUEST = array();
        $_REQUEST['test1'] = 'value1';
        $_REQUEST['test2'] = 'value2';

        $this->assertEquals('value1', $util->getParameter('test1'));
        $this->assertEquals('value2', $util->getParameter('test2'));
        $this->assertNull($util->getParameter('test'));
        $this->assertEquals(2, count($util->getParameter()));
    }


    /**
     * loadModelのテスト
     *
     * Modelクラスの読み込みテスト。
     * 存在しないModelクラスならnull。
     *
     * @param  void
     * @return void
     * @access public
     */
    public function testLoadModule(){
        $util = $this->_util;

        $this->assertInstanceOf('model_repository_master', $util->loadModel('model_repository_master', null));
        $this->assertNull($util->loadModel('model_hoge', null));
    }
}

?>