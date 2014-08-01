<?php /* Smarty version Smarty-3.1.11, created on 2012-11-29 16:15:20
         compiled from "../templates/registration.tpl" */ ?>
<?php /*%%SmartyHeaderCode:134065329350b70b880d5d81-76995944%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '95a1b22ee60c80d318b6baf4896a9e048d24c583' => 
    array (
      0 => '../templates/registration.tpl',
      1 => 1353997787,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '134065329350b70b880d5d81-76995944',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'login_info' => 0,
    'err_code' => 0,
    'disp_err' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_50b70b8819a741_75181237',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_50b70b8819a741_75181237')) {function content_50b70b8819a741_75181237($_smarty_tpl) {?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
 "http://www.w3.org/TR/html4/loose.dtd">

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="./css/body_css.css">
        <title>新規登録画面</title>
    </head>
    <body>
        <font class="tw"><hr><center>登録画面</center><br></font>
        <table border=4 width=500 align=center>
        <form action="../php/index.php?class=Registration&method=dispPage" method="POST">
        <tr align=center>
        <td><font class="tw"><p><label>件名:</font></tb>
        <td><input type="text" name="subject" value="" tabindex="0" accesskey="a"></tb>
        </label>
        <td><font class="tw"><label>お名前:</font></tb>
        <td><font class="tw"><?php echo $_smarty_tpl->tpl_vars['login_info']->value['nama'];?>
</font></tb>
        </label></p>
        </tr>
        <tr align=center>
        <td><font class="tw"><p><label>メールアドレス</font></tb>
        <td colspan=4><font class="tw"><?php echo $_smarty_tpl->tpl_vars['login_info']->value['mail'];?>
</font></tb>
        </label></p>
        </tr>
        <tr align=center>
        <td><font class="tw"><p><label>本文:</font></td>
        <td colspan=4><textarea name="msg" cols=40 rows=4></textarea>
        </label></p>
        </tr>
        </table>

        <input type="hidden" name="name" value="<?php echo $_smarty_tpl->tpl_vars['login_info']->value['nama'];?>
">
        <input type="hidden" name="mail" value="<?php echo $_smarty_tpl->tpl_vars['login_info']->value['mail'];?>
">

        <br>
        <center>
        <input type=submit name="send" value="送信">
        </center>
        </form>
        <br>
        <center>
        <?php  $_smarty_tpl->tpl_vars['disp_err'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['disp_err']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['err_code']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['loopname']['iteration']=0;
foreach ($_from as $_smarty_tpl->tpl_vars['disp_err']->key => $_smarty_tpl->tpl_vars['disp_err']->value){
$_smarty_tpl->tpl_vars['disp_err']->_loop = true;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['loopname']['iteration']++;
?>
        <br>
        <font class="tw"><?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['loopname']['iteration'];?>
<?php echo $_smarty_tpl->tpl_vars['disp_err']->value;?>
</font>
        <?php } ?>
        </center>
        <a href="./"><center>HOME</center></a><br>
    </body>
</html>
<?php }} ?>