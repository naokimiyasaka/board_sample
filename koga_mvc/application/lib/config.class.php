<?php

class Config {
    private $_config_ary = array();

    public function load($config_file){
        $file_path = dirname(__FILE__) . '/../../config/' . $config_file;
        if(file_exists($file_path)){
            include($file_path);

            $file_name = basename($file_path);
            $config_type = $this->_getConfigType($file_name);

            $this->_config_ary[$config_type] = $config;

            unset($config);
        }else{
            throw new ConfigException(sprintf('Not found Config file : %s', $file_path));
        }
    }

    private function _getConfigType($config_file){
        return str_replace('.inc.php', '', $config_file);
    }

    public function get($type, $key){
        if(array_key_exists($type, $this->_config_ary)){
            if(array_key_exists($key, $this->_config_ary[$type])){
                return $this->_config_ary[$type][$key];
            }
        }

        return null;
    }

    public function set($type, $key, $value){
        if(array_key_exists($type, $this->_config_ary)){
            if(array_key_exists($key, $this->_config_ary[$type])){
                $this->_config_ary[$type][$key] = $value;
            }
        }
    }
}

