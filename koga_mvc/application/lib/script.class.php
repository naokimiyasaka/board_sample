<?php

abstract class Script {
    private $_argv;
    private $_dispatcher;

    public function __construct($argv, $dispatcher){
        $this->_argv       = $argv;
        $this->_dispatcher = $dispatcher;
    }

    public function getDispatcher(){
        return $this->_dispatcher;
    }

    public function getArgv($index){
        if(array_key_exists($index, $this->_argv)){
            return $this->_argv[$index];
        }

        return null;
    }
}
