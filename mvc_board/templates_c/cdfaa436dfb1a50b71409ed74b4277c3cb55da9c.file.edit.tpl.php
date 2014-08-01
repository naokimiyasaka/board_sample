<?php /* Smarty version Smarty-3.1.11, created on 2012-08-23 18:54:15
         compiled from "../templates/edit.tpl" */ ?>
<?php /*%%SmartyHeaderCode:12771261065035fdc761a855-08644782%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cdfaa436dfb1a50b71409ed74b4277c3cb55da9c' => 
    array (
      0 => '../templates/edit.tpl',
      1 => 1345713221,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12771261065035fdc761a855-08644782',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'disp_text' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_5035fdc76b4647_45524477',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5035fdc76b4647_45524477')) {function content_5035fdc76b4647_45524477($_smarty_tpl) {?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
 "http://www.w3.org/TR/html4/loose.dtd">

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="./css/body_css.css">
        <title>編集画面</title>
    </head>
    <body>
        <font class="tw"><hr><center>編集画面</center><br></font>
        <center>
        <!-----ループさせる　start------->
        <table border=4 width=500 align=center>
        <form action="../php/index.php?class=Edit&method=dispPage" method="POST">
        <table border=4 width=500 align=center>
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
        <td colspan=4><textarea name="msg" cols=40 rows=4><?php echo $_smarty_tpl->tpl_vars['disp_text']->value['maintext'];?>
</textarea>
        </label></p>
        </tr>
        </label>
        </table>
        <br>
        <center>
        <input type=submit name="send" value="送信">
        </center>
        </form>
        </table>
        <!-----ループさせる　end------->
        </center>
        <br>
        <a href="./index.php"><center>HOME</center></a><br>
    </body>
</html>
<?php }} ?>