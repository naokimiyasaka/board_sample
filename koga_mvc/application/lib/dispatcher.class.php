<?php
class Dispatcher {
    private $_mode;
    private $_action;
    private $_action_function;
    private $_config;
    private $_util;
    private $_smarty;
    private $_db;

    public function __construct(){
    }

    public function __destruct(){
        if($this->_db){
            mysql_close($this->_db);
        }
    }

    private function _initDispatcher(){
        $this->_config = new Config();
        $this->_util   = new Util();
        $this->_smarty = new Smarty();

        // 初期化
        $this->_initConfig();
        $this->_initSmarty();
        $this->_initDb();

        if($this->_util->getParameter('mode')){
            $this->_mode = $this->_util->getParameter('mode');
        }else{
            $this->_mode = $this->_config->get('app', 'default_mode');
        }

        if($this->_util->getParameter('action')){
            $this->_action = $this->_util->getParameter('action');
        }else{
            $this->_action = $this->_config->get('app', 'default_action');
        }

        $this->_action_function = $this->_convertAction();
    }

    private function _initConfig(){
        $this->_config->load('app.inc.php');
        $this->_config->load('db.inc.php');
        $this->_config->load('smarty.inc.php');
    }

    private function _initSmarty(){
        $this->_smarty->template_dir = $this->_config->get('smarty', 'template_dir');
        $this->_smarty->compile_dir  = $this->_config->get('smarty', 'compile_dir');
        $this->_smarty->cache_dir    = $this->_config->get('smarty', 'cache_dir');
        $this->_smarty->caching      = $this->_config->get('smarty', 'caching');
    }

    private function _initDb(){
        $host = $this->_config->get('db', 'host');
        $user = $this->_config->get('db', 'user');
        $pass = $this->_config->get('db', 'pass');
        $name = $this->_config->get('db', 'name');

        $this->_db = mysql_connect($host, $user, $pass, true);
        if(!$this->_db){
            throw new ModelException("Can't connect Database Server.");
        }

        $res = mysql_select_db($name, $this->_db);
        if(!$res){
            throw new ModelException(sprintf("Can't selected Database : %s", $name));
        }

        $res = mysql_query('SET NAMES utf8', $this->_db);
        if(!$res){
            throw new ModelException("Can't issue Query : set names utf8");
        }
    }

    private function _checkAction($actions){
        if(method_exists($actions, $this->_action_function)){
            return true;
        }else{
            return false;
        }
    }

    private function _convertAction(){
        // 要素を分割
        $element_ary = explode("_", $this->_action);

        $replaced_element_ary = array();
        foreach($element_ary as $element){
            $replaced_element_ary[] = ucwords($element);
        }

        return 'execute' . implode("", $replaced_element_ary);
    }

    private function _convertModeToFile(){
        $element_ary = explode("::", $this->_mode);

        $replaced_element_ary = array();
        foreach($element_ary as $element){
            $replaced_element_ary[] = strtolower($element);
        }

        return implode("/", $replaced_element_ary);
    }

    private function _convertModeToClass(){
        $element_ary = explode("::", $this->_mode);

        $replaced_element_ary = array();
        foreach($element_ary as $element){
            $replaced_element_ary[] = strtolower($element);
        }

        $last_element = array_pop($replaced_element_ary);
        return ucwords($last_element);
    }

    private function _getControllerFile(){
        $controller_path = $this->_config->get('app', 'controller_path');
        $file_name       = $this->_convertModeToFile() . '.class.php';

        return $controller_path . $file_name;
    }

    private function _checkControllerFile(){
        return file_exists($this->_getControllerFile());
    }

    private function _checkControllerClass(){
        $class = $this->_convertModeToClass();
        return class_exists($class);
    }

    private function _checkMode(){
        if($this->_checkControllerClass()){
            return true;
        }else{
            return false;
        }
    }

    private function _loadController(){
        if($this->_checkControllerFile()){
            require_once($this->_getControllerFile());
        }
    }

    public function getUtil(){
        return $this->_util;
    }

    public function getSmarty(){
        return $this->_smarty;
    }

    public function getDb(){
        return $this->_db;
    }

    public function getConfig(){
        return $this->_config;
    }

    public function run(){
        try{
            $this->_initDispatcher();
            $this->_loadController();

            $error_flg = 0;

            if($this->_checkControllerClass()){
                $class      = $this->_convertModeToClass();
                $controller = new $class($this);

                if($this->_checkAction($controller)){
                    $contents = $controller->{$this->_action_function}();
                }else{
                    $error_flg = 1;
                }
            }else{
                $error_flg = 1;
            }

            if($error_flg){
                $this->_mode            = $this->_config->get('app', '404_error_mode');
                $this->_action          = $this->_config->get('app', '404_error_action');
                $this->_action_function = $this->_config->get('app', '404_error_function');

                $this->_loadController();

                if($this->_checkControllerClass()){
                    $class      = $this->_convertModeToClass();
                    $controller = new $class($this);
                    $contents   = $controller->{$this->_action_function}();
                }else{
                    throw new ActionException('Internal Server Error.');
                }
            }

            $this->_smarty->assign('contents', $contents);
            $this->_smarty->display('index.tpl');
        }catch(Exception $e){
            $e->display($this);
        }
    }

    public function runscript($script_name, $argv){
        $this->_initDispatcher();

        $script = $this->_util->loadScript($script_name, $argv, $this);
        $script->execute();
    }
}
