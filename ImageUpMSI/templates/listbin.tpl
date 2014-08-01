<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
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
        {foreach from=$image_data item=var}
            <img src="data:{$var.type};base64,{$var.imgdata}" alt="イラスト２" width=100 height=100>
        {/foreach}
        <a href="./"><center>HOME</center></a><br>
    </body>
</html>

