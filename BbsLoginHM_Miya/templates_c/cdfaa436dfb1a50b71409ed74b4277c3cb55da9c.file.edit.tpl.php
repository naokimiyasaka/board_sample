<?php /* Smarty version Smarty-3.1.11, created on 2012-11-27 15:20:49
         compiled from "../templates/edit.tpl" */ ?>
<?php /*%%SmartyHeaderCode:103072054250add745637e13-23760378%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cdfaa436dfb1a50b71409ed74b4277c3cb55da9c' => 
    array (
      0 => '../templates/edit.tpl',
      1 => 1353997804,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '103072054250add745637e13-23760378',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_50add7456bd696_54638360',
  'variables' => 
  array (
    'disp_text' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_50add7456bd696_54638360')) {function content_50add7456bd696_54638360($_smarty_tpl) {?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
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
        <a href="./"><center>HOME</center></a><br>
    </body>
</html>
<?php }} ?>