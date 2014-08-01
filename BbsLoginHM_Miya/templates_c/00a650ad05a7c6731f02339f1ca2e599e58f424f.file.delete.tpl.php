<?php /* Smarty version Smarty-3.1.11, created on 2012-11-27 15:19:46
         compiled from "../templates/delete.tpl" */ ?>
<?php /*%%SmartyHeaderCode:90403471450add74e8e7da1-92301804%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '00a650ad05a7c6731f02339f1ca2e599e58f424f' => 
    array (
      0 => '../templates/delete.tpl',
      1 => 1353997768,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '90403471450add74e8e7da1-92301804',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_50add74e98c2a4_89561527',
  'variables' => 
  array (
    'disp_text' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_50add74e98c2a4_89561527')) {function content_50add74e98c2a4_89561527($_smarty_tpl) {?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
 "http://www.w3.org/TR/html4/loose.dtd">

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="./css/body_css.css">
        <title>削除画面</title>
    </head>
    <body>
        <font class="tw"><hr><center>削除画面</center></font><br>
        <center>
        <table border=4 width=500 align=center>
        <form action="../php/index.php?class=Delete&method=dispPage" method="POST">
        <tr align=center>
        <input type="hidden" name='id' value="<?php echo $_smarty_tpl->tpl_vars['disp_text']->value['boardid'];?>
">
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
        <td colspan=4><font class="tw"><p><label><?php echo $_smarty_tpl->tpl_vars['disp_text']->value['maintext'];?>
</font></td>
        </label></p>
        </tr>
        </label>
        </table>
        <br>
        <center>
        <input type=submit name="send" value="削除">
        </center>
        </form>
        </center>
        <br>
        <a href="./"><center>HOME</center></a><br>
    </body>
</html>
<?php }} ?>