<?php /* Smarty version Smarty-3.1.11, created on 2012-12-06 19:40:08
         compiled from "../templates/listbin.tpl" */ ?>
<?php /*%%SmartyHeaderCode:11791297950c06caa635a99-43807949%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '49f0e8df8ed82b21ac68504cf4acbafef0623209' => 
    array (
      0 => '../templates/listbin.tpl',
      1 => 1354791021,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11791297950c06caa635a99-43807949',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_50c06caa68ec90_42110662',
  'variables' => 
  array (
    'image_data' => 0,
    'var' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_50c06caa68ec90_42110662')) {function content_50c06caa68ec90_42110662($_smarty_tpl) {?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
 "http://www.w3.org/TR/html4/loose.dtd">

<!--
$list （0から始まる数添字の配列）に画像の
リンクテキストを入れて

$smarty->assign('image_data', $list);

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
 $_from = $_smarty_tpl->tpl_vars['image_data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['var']->key => $_smarty_tpl->tpl_vars['var']->value){
$_smarty_tpl->tpl_vars['var']->_loop = true;
?>
            <img src="data:<?php echo $_smarty_tpl->tpl_vars['var']->value['type'];?>
;base64,<?php echo $_smarty_tpl->tpl_vars['var']->value['imgdata'];?>
" alt="イラスト２" width=100 height=100>
        <?php } ?>
        <a href="./"><center>HOME</center></a><br>
    </body>
</html>

<?php }} ?>