<?php /* Smarty version Smarty-3.1.11, created on 2012-11-27 15:27:51
         compiled from "../templates/err.tpl" */ ?>
<?php /*%%SmartyHeaderCode:8905001350b4583da96ae4-44409933%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '855fe4a52949b3a4c4c09b7d8bd0abb67be5899c' => 
    array (
      0 => '../templates/err.tpl',
      1 => 1353997812,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8905001350b4583da96ae4-44409933',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_50b4583dadbbe5_79535782',
  'variables' => 
  array (
    'err_message' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_50b4583dadbbe5_79535782')) {function content_50b4583dadbbe5_79535782($_smarty_tpl) {?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
 "http://www.w3.org/TR/html4/loose.dtd">

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="./css/body_css.css">
        <title>エラー画面</title>
    </head>
    <body><!--見えずらいから全部白-->
        <font class="tw"><strong><center>エラー</center></strong></font><br>
        <font class="tw"><center><?php echo $_smarty_tpl->tpl_vars['err_message']->value;?>
</center></font><br><br>
        <a href="./"><center>HOME</center></a><br>
    </body>
</html>
<?php }} ?>