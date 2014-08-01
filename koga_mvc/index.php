<?php

require_once('config/app.inc.php');
require_once('config/db.inc.php');
require_once('application/lib/base_class.class.php');
require_once('application/lib/config.class.php');
require_once('application/lib/dispatcher.class.php');
require_once('application/lib/util.class.php');
require_once('application/lib/controller.class.php');
require_once('application/lib/model.class.php');
require_once('application/lib/core_exception.class.php');
require_once('application/lib/model_exception.class.php');
require_once('application/lib/action_exception.class.php');
require_once('application/lib/script_exception.class.php');
require_once('application/lib/config_exception.class.php');
require_once('application/vendor/Smarty/Smarty.class.php');

$dispatcher = new Dispatcher();
$dispatcher->run();

