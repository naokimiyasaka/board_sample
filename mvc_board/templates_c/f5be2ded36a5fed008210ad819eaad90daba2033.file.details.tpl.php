<?php /* Smarty version Smarty-3.1.11, created on 2012-08-23 18:54:22
         compiled from "../templates/details.tpl" */ ?>
<?php /*%%SmartyHeaderCode:4054763015035fdce01b300-73157686%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f5be2ded36a5fed008210ad819eaad90daba2033' => 
    array (
      0 => '../templates/details.tpl',
      1 => 1345530886,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4054763015035fdce01b300-73157686',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'disp_text' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_5035fdce0a5d13_67652740',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5035fdce0a5d13_67652740')) {function content_5035fdce0a5d13_67652740($_smarty_tpl) {?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
 "http://www.w3.org/TR/html4/loose.dtd">

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="./css/body_css.css">
        <title>詳細画面</title>
    </head>
    <body>
        <font class="tw"><hr><center>詳細画面</center><br></font>
        <center>
        <table border=4 width=500 align=center>
        <tr align=center>
        <td><font class="tw"><p><label>件名:<?php echo $_smarty_tpl->tpl_vars['disp_text']->value['subject'];?>
</font></tb>
        <td><font class="tw"><p><label>名前:<?php echo $_smarty_tpl->tpl_vars['disp_text']->value['name'];?>
</font></tb>
        </tr>
        <tr align=center>
        <td colspan=4><font class="tw"><p><label>メールアドレス:<?php echo $_smarty_tpl->tpl_vars['disp_text']->value['mail'];?>
</font></tb>
        </tr>
        <tr align=center>
        <td><font class="tw"><p><label>本文:</font></td>
        <td colspan=4><textarea name="msg" cols=40 rows=4><?php echo $_smarty_tpl->tpl_vars['disp_text']->value['maintext'];?>
</textarea>
        </label></p>
        </tr>
        </label>
        </table>
        <br>
        </center>
        <br>
        <a href="./index.php"><center>HOME</center></a><br>
    </body>
</html>
<?php }} ?>