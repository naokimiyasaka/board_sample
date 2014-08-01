<?php /* Smarty version Smarty-3.1.11, created on 2012-11-27 15:25:19
         compiled from "../templates/loginregister.tpl" */ ?>
<?php /*%%SmartyHeaderCode:108048111750a32c42688412-26147628%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'beebdd1671145d22527594e782de7f238da138c0' => 
    array (
      0 => '../templates/loginregister.tpl',
      1 => 1353997794,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '108048111750a32c42688412-26147628',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_50a32c426d0ef5_00562311',
  'variables' => 
  array (
    'disp_err' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_50a32c426d0ef5_00562311')) {function content_50a32c426d0ef5_00562311($_smarty_tpl) {?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
 "http://www.w3.org/TR/html4/loose.dtd">

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="./css/body_css.css">
        <title>ユーザー登録</title>
    </head>
    <body>
        <font class="tw"><hr><center>ユーザー登録</center><br></font>
        <table border=4 width=500 align=center>
        <form action="./?class=Login&method=registUser" method="POST">
        <tr align=center>
        <td><font class="tw"><p><label>名前:</font></tb>
        <td><input type="text" name="user_name" value="" tabindex="0" accesskey="a"></tb>
        </label>
        </tr>
        <tr align=center>
        <td><font class="tw"><p><label>メールアドレス:</font></tb>
        <td><input type="text" name="user_mail" value="" tabindex="0" accesskey="a"></tb>
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
        <input type=submit name="send" value="登録">
        </center>
        </form>
        <br>
        <a href="./"><center>HOME</center></a><br>
        <font class="tw"><?php echo $_smarty_tpl->tpl_vars['disp_err']->value;?>
</font>
    </body>
</html>
<?php }} ?>