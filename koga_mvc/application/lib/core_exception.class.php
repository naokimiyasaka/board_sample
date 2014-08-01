<?php

abstract class CoreException extends Exception{
    public function display($dispatcher){
        $smarty = $dispatcher->getSmarty();
        $config = $dispatcher->getConfig();

        if($config->get('app', 'debug')){
            $smarty->assign('trace', $this->getTrace());
            $smarty->assign('message', $this->getMessage());

            $contents = $smarty->fetch('exception/debug.tpl');
        }else{
            $smarty->assign('message', $this->getMessage());

            $contents = $smarty->fetch('exception/release.tpl');
        }

        $smarty->assign('contents', $contents);
        $smarty->display('index.tpl');
    }
}

?>