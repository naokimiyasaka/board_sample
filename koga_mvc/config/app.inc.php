<?php

$config = array();

$config['debug'] = false;

$config['default_mode']   = 'repository';
$config['default_action'] = 'list';

$config['controller_path'] = dirname(__FILE__) . '/../application/controller/';

$config['404_error_mode']     = 'base';
$config['404_error_action']   = '404';
$config['404_error_function'] = 'execute404';

