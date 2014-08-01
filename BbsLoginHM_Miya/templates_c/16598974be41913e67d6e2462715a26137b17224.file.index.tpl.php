<?php /* Smarty version Smarty-3.1.11, created on 2012-11-27 15:19:38
         compiled from "../templates/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:209006811250a328d618e6a8-41457044%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '16598974be41913e67d6e2462715a26137b17224' => 
    array (
      0 => '../templates/index.tpl',
      1 => 1353986465,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '209006811250a328d618e6a8-41457044',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_50a328d6248882_05886559',
  'variables' => 
  array (
    'is_login' => 0,
    'user_name' => 0,
    'disp_text' => 0,
    'disp_data' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_50a328d6248882_05886559')) {function content_50a328d6248882_05886559($_smarty_tpl) {?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
 "http://www.w3.org/TR/html4/loose.dtd">

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="./css/body_css.css">
        <title>掲示板 一覧画面</title>
    </head>
    <body><!--見えずらいから全部白-->
        <font class="tw"><strong><center>目次</center></strong></font><br>
        <table border=1 width=350 align=center>
        <tr align=center>
        <td><a href="../php/index.php?class=Registration&method=dispPage">記事の投稿</a></td>
        </tr>
        <tr align=center>

        <?php if ($_smarty_tpl->tpl_vars['is_login']->value==true){?>
        <td>
          <font class="tw" style="position:relative; float:left;" > <?php echo $_smarty_tpl->tpl_vars['user_name']->value;?>
 </font>
          <a href="../php/index.php?class=Login&method=logout">ログアウト</a>
        </td>
        <?php }else{ ?>
        <td><a href="../php/index.php?class=Login&method=dispPage&status=0">ログイン</a></td>
        <?php }?>

        </tr>
        </table>
        <table border=4 width=500 align=center>
        <!-----ループさせる　start------->
        <?php  $_smarty_tpl->tpl_vars['disp_data'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['disp_data']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['disp_text']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['disp_data']->key => $_smarty_tpl->tpl_vars['disp_data']->value){
$_smarty_tpl->tpl_vars['disp_data']->_loop = true;
?>
        <tr>
        <td><font class="tw" style="position:relative; float:left;" >件名:<?php echo $_smarty_tpl->tpl_vars['disp_data']->value['subject'];?>
</font>
        <br>
        <font class="tw">名前:<?php echo $_smarty_tpl->tpl_vars['disp_data']->value['name'];?>
</font>
        <br>
        <a href="../php/index.php?class=Edit&method=dispPage&id=<?php echo $_smarty_tpl->tpl_vars['disp_data']->value['boardid'];?>
"><button name="edit_bt">編集</button></a>
        <a href="../php/index.php?class=Delete&method=dispPage&id=<?php echo $_smarty_tpl->tpl_vars['disp_data']->value['boardid'];?>
"><button name="delete_bt">削除</button></a>
        <a href="../php/index.php?class=Details&method=dispPage&id=<?php echo $_smarty_tpl->tpl_vars['disp_data']->value['boardid'];?>
"><button name="delete_bt">詳細</button></a></td>
        </tr>
        <tr><td colspan=4><font class="tw"><?php echo $_smarty_tpl->tpl_vars['disp_data']->value['maintext'];?>
</font></td></tr>
        <?php } ?>
        <!-----ループさせるend------->
        </table>
    </body>
</html>
<?php }} ?>