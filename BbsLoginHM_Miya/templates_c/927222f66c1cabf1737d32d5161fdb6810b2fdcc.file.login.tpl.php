<?php /* Smarty version Smarty-3.1.11, created on 2012-11-15 14:11:23
         compiled from "../templates/login.tpl" */ ?>
<?php /*%%SmartyHeaderCode:178968070250a328f6608207-09016133%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '927222f66c1cabf1737d32d5161fdb6810b2fdcc' => 
    array (
      0 => '../templates/login.tpl',
      1 => 1352956843,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '178968070250a328f6608207-09016133',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_50a328f664dba8_26900696',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_50a328f664dba8_26900696')) {function content_50a328f664dba8_26900696($_smarty_tpl) {?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
 "http://www.w3.org/TR/html4/loose.dtd">

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="./css/body_css.css">
        <title>ログイン</title>
    </head>
    <body>
        <font class="tw"><hr><center>ログイン</center><br></font>
        <table border=4 width=500 align=center>
        <form action="./?class=Login&method=loginAuth" method="POST">
        <tr align=center>
        <td><font class="tw"><p><label>名前:</font></tb>
        <td><input type="text" name="user_name" value="" tabindex="0" accesskey="a"></tb>
        </label>
        </tr>
        <tr align=center>
        <td><font class="tw"><p><label>パスワード</font></tb>
        <td colspan=4><input type="password" name="passwd" value="" tabindex="2" accesskey="c"></tb>
        </label></p>
        </tr>
        </table>
        <br>
        <center>
        <input type=submit name="send" value="ログイン">
        <a href="./?class=Login&method=dispPage&status=1">
        <input type=button name="button" value="新規登録">
        </a>
        </center>
        </form>
        <br>
        <a href="./"><center>HOME</center></a><br>
    </body>
</html>
<?php }} ?>