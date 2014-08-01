<?php /* Smarty version Smarty-3.1.11, created on 2012-12-04 19:29:04
         compiled from "../templates/list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:38939708650bdc602a82922-16435276%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c63c4e722d610db91a72130e0215108793d26872' => 
    array (
      0 => '../templates/list.tpl',
      1 => 1354617591,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '38939708650bdc602a82922-16435276',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_50bdc602b0b2c8_73972958',
  'variables' => 
  array (
    'listImgLink' => 0,
    'var' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_50bdc602b0b2c8_73972958')) {function content_50bdc602b0b2c8_73972958($_smarty_tpl) {?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
 "http://www.w3.org/TR/html4/loose.dtd">

<!--
$list （0から始まる数添字の配列）に画像の
リンクテキストを入れて

$smarty->assign('listImgLink', $list);

のように渡すとリスト表示されます
-->

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>画像一覧</title>
    </head>

    <body>
        <font class="tw"><hr><center>画像一覧</center><br></font>
        <?php  $_smarty_tpl->tpl_vars['var'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['var']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['listImgLink']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['var']->key => $_smarty_tpl->tpl_vars['var']->value){
$_smarty_tpl->tpl_vars['var']->_loop = true;
?>
            <p><a href="http://<?php echo $_smarty_tpl->tpl_vars['var']->value['path'];?>
"><?php echo $_smarty_tpl->tpl_vars['var']->value['path'];?>
</a></p>
        <?php } ?>
        <a href="./"><center>HOME</center></a><br>
    </body>
</html>

<?php }} ?>