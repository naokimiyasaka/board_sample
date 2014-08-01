<?php

class Util {
    public function getParameter($key = null){
        if($key){
            if(array_key_exists($key, $_REQUEST)){
                return $_REQUEST[$key];
            }else{
                return null;
            }
        }else{
            return $_REQUEST;
        }
    }

    public function loadModel($model_name, $db){
        $model = null;

        $model_file_path = dirname(__FILE__) . '/../model/' . $model_name . '.class.php';

        if(file_exists($model_file_path)){
            require_once($model_file_path);

            if(class_exists($model_name)){
                $model = new $model_name($db);
            }else{
                throw new ModelException(sprintf('Not found Model class : %s', $model_name));
            }
        }else{
            throw new ModelException(sprintf('Not found Model file : %s', $model_file_path));
        }

        return $model;
    }

    public function loadScript($script_name, $argv, $dispatcher){
        $script = null;

        $script_file_path = dirname(__FILE__) . '/../script/' . $script_name . '.class.php';

        if(file_exists($script_file_path)){
            require_once($script_file_path);

            if(class_exists($script_name)){
                $script = new $script_name($argv, $dispatcher);
            }else{
                throw new ScriptException(sprintf('Not found Script class : %s', $script_name));
            }
        }else{
            throw new ScriptException(sprintf('Not found Script file : %s', $script_file_path));
        }

        return $script;
    }

    public function htmlescape($html){
        $html = htmlspecialchars($html, ENT_QUOTES, 'UTF-8');
        $html = preg_replace('/\n/', '<br>', $html);
        $html = preg_replace('/\r/', '', $html);

        return $html;
    }

    public function redirect($url){
        header(sprintf('Location: %s', $url));
        exit();
    }
}