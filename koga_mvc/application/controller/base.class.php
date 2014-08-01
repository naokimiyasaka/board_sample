<?php

class Base extends Controller {
    public function execute404(){
        $dispatcher = $this->getDispatcher();
        $smarty     = $dispatcher->getSmarty();

        return $smarty->fetch('base/404.tpl');
    }
}
