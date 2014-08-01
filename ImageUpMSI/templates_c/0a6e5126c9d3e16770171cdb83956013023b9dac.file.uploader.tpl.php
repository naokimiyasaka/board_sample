<?php /* Smarty version Smarty-3.1.11, created on 2012-12-06 19:00:09
         compiled from "../templates/uploader.tpl" */ ?>
<?php /*%%SmartyHeaderCode:135086019650b8435f8a3649-87301320%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0a6e5126c9d3e16770171cdb83956013023b9dac' => 
    array (
      0 => '../templates/uploader.tpl',
      1 => 1354788633,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '135086019650b8435f8a3649-87301320',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_50b8435f8f61b0_69547100',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_50b8435f8f61b0_69547100')) {function content_50b8435f8f61b0_69547100($_smarty_tpl) {?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
 "http://www.w3.org/TR/html4/loose.dtd">

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>画像アップロード</title>
    </head>

    <body>
        <font class="tw"><hr><center>画像アップロード</center><br></font>

        <form action="./?class=UpLoad&method=upLoad" method="POST" enctype="multipart/form-data">
        <input type="file" name="up_img" value="select">
        <br />
        <input type="submit" name="sbmt_up" value="upload">
        <input type="button" value="imgList" onclick="window.location.href='./?class=UpLoad&method=dispPage&status=1'">
        </form>
        <br />
        <font class="tw"><hr><center>画像アップロードバイナリ</center><br></font>
        <form action="./?class=UpLoad&method=upLoadBinary" method="POST" enctype="multipart/form-data">
        <input type="file" name="up_img" value="select">
        <br />
        <input type="submit" name="sbmt_up" value="upload">
        <input type="button" value="imgList" onclick="window.location.href='./?class=UpLoad&method=dispPage&status=2'">
        </form>
        <br />
    </body>
</html>
<?php }} ?>