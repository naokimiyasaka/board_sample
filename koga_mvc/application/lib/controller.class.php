<?php
/**
 * Controller
 *
 * Controllerの基礎クラス
 *
 * PHP versions 5
 *
 * @category   Controller
 * @package    Controller
 * @subpackage Controller
 * @author     Seiki Koga <seikikoga@gamania.com>
 * @copyright  2011-2011 Gamania Degital Entertainment Co.,Ltd.
 * @license    http://www.opensource.org/licenses/mit-license.php MIT License
 * @version    SVN: $Rev: 26 $
 * @access     public
 * @link       10.119.10.100:/var/svn/KC/backend
 */

/**
 * Controller
 *
 * Controllerの基礎クラス
 *
 * @category   Controller
 * @package    Controller
 * @subpackage Controller
 * @author     Seiki Koga <seikikoga@gamania.com>
 * @license    http://www.opensource.org/licenses/mit-license.php MIT License
 * @access     public
 * @link       10.119.10.100:/var/svn/KC/backend
 * @access     public
 */
abstract class Controller {
    /**
     * Dispatcherのインスタンス
     *
     * Dispatcherから渡されるインスタンス。
     *
     * @var object Dispatcher
     */
    private $_dispatcher;

    /**
     * ErrorFlag
     *
     * 登録/修正時にエラーが合った場合に真になる。
     *
     * @var integer エラーフラグ
     */
    private $_error_flg = 0;

    /**
     * Error内容
     *
     * 登録/修正時にエラーが合った場合にエラー情報が入る。
     *
     * @var array エラー情報
     */
    private $_error_ary = array();

    /**
     * コンストラクタ
     *
     * 渡されたDispatcherのインスタンスを保持する。
     *
     * @param  object $dispatcher Dispatcher
     * @return void
     * @access public
     */
    public function __construct($dispatcher){
        $this->_dispatcher = $dispatcher;
    }

    /**
     * Dispatcher取得
     *
     * 保持しているDispatcherのインスタンスを返す。
     *
     * @param  void
     * @return object Dispatcher
     * @access public
     */
    public function getDispatcher(){
        return $this->_dispatcher;
    }

    /**
     * エラーフラグ取得
     *
     * 保持しているエラーフラグを返す。
     *
     * @param  void
     * @return integer エラーフラグ
     * @access public
     */
    public function getErrorFlg(){
        return $this->_error_flg;
    }

    public function setErrorFlg($flg){
        $this->_error_flg = $flg;
    }

    /**
     * エラー情報取得
     *
     * 保持しているエラー情報を返す。
     *
     * @param  void
     * @return string エラー情報
     * @access public
     */
    public function getErrorArray(){
        return $this->_error_ary;
    }

    public function setErrorArray($string){
        $this->_error_ary[] = $string;
    }

    /**
     * リスト画面表示
     *
     * リスト画面を表示する。
     * データベースデータを変更する場合は
     * customColumnを実装する事。
     * getListDataはリスト表示するデータを取得する。
     *
     * @param  void
     * @return string HTML
     * @access public
     */
    public function executeList(){
        $dispatcher = $this->getDispatcher();
        $smarty     = $dispatcher->getSmarty();

        $data = $this->getListData();
        $this->customColumn(&$data);

        $smarty->assign('data',     $data);
        $smarty->assign('etc_data', $this->getEtcListAssignData());

        return $smarty->fetch($this->getTemplateName('list'));
    }

    public function getListData(){
        return array();
    }

    public function customColumn($data){
    }

    public function getEtcListAssignData(){
        return array();
    }

    public function executeAdd(){
        $dispatcher = $this->getDispatcher();
        $smarty     = $dispatcher->getSmarty();
        $util       = $dispatcher->getUtil();

        if($util->getParameter('submit')){
            if(!$this->validationAdd()){
                $param = $this->beforeAddProcess($util->getParameter());

                $inserted_id = $this->registData($param);

                $this->afterAddProcess($inserted_id);
            }
        }

        $smarty->assign('error_flg', $this->getErrorFlg());
        $smarty->assign('error_ary', $this->getErrorArray());
        $smarty->assign('etc_data',  $this->getEtcAddAssignData());

        return $smarty->fetch($this->getTemplateName('add'));
    }

    public function beforeAddProcess($param){
        return $param;
    }

    public function registData($param){
        return 0;
    }

    public function afterAddProcess($inserted_id){
    }

    public function getEtcAddAssignData(){
        return array();
    }

    public function validationAdd(){
        return $this->getErrorFlg();
    }

    public function executeEdit(){
        $dispatcher = $this->getDispatcher();
        $smarty     = $dispatcher->getSmarty();
        $util       = $dispatcher->getUtil();

        $unique_id = $util->getParameter('id');

        if($util->getParameter('submit')){
            if(!$this->validationEdit()){
                $param = $this->beforeEditProcess($util->getParameter());

                $this->updateData($unique_id, $param);

                $this->afterEditProcess($unique_id);
            }
        }

        $data = $this->getEditData($unique_id);
        $this->customEditData(&$data);

        $smarty->assign('error_flg', $this->getErrorFlg());
        $smarty->assign('error_ary', $this->getErrorArray());
        $smarty->assign('data',      $data);
        $smarty->assign('etc_data',  $this->getEtcEditAssignData($unique_id));

        return $smarty->fetch($this->getTemplateName('edit'));
    }

    public function validationEdit(){
        return $this->getErrorFlg();
    }

    public function beforeEditProcess($param){
        return $param;
    }

    public function updateData($unique_id, $param){
    }

    public function afterEditProcess($unique_id){
    }

    public function getEditData($unique_id){
        return array();
    }

    public function customEditData($data){
    }

    public function getEtcEditAssignData($unique_id){
        return array();
    }

    public function executeDelete(){
        $dispatcher = $this->getDispatcher();
        $smarty     = $dispatcher->getSmarty();
        $util       = $dispatcher->getUtil();

        $unique_id = $util->getParameter('id');

        $data = $this->getDeleteData($unique_id);
        $this->customDeleteData(&$data);

        $smarty->assign('data',     $data);
        $smarty->assign('etc_data', $this->getEtcDeleteAssignData($unique_id));

        if($util->getParameter('submit')){
            $this->beforeDeleteProcess($unique_id);

            $this->deleteData($unique_id);

            $this->afterDeleteProcess($unique_id);
        }

        return $smarty->fetch($this->getTemplateName('delete'));
    }

    public function beforeDeleteProcess($unique_id){
    }

    public function deleteData($unique_id){
    }

    public function afterDeleteProcess($unique_id){
    }

    public function getDeleteData($unique_id){
        return array();
    }

    public function customDeleteData($data){
    }

    public function getEtcDeleteAssignData($unique_id){
        return array();
    }
}
