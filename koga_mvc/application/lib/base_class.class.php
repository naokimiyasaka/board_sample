<?php

class BaseClass {
    public function __call($method, $arg){
        throw new ClassException();
    }

    public function __toString(){
    }

    public function __set($key, $value){
        throw new ClassException();
    }

    public function __get($key){
        throw new ClassException();
    }
}
