<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
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
        <td><font class="tw">{$login_info.nama}</font></tb>
        </label></p>
        </tr>
        <tr align=center>
        <td><font class="tw"><p><label>メールアドレス</font></tb>
        <td colspan=4><font class="tw">{$login_info.mail}</font></tb>
        </label></p>
        </tr>
        <tr align=center>
        <td><font class="tw"><p><label>本文:</font></td>
        <td colspan=4><textarea name="msg" cols=40 rows=4></textarea>
        </label></p>
        </tr>
        </table>

        <input type="hidden" name="name" value="{$login_info.nama}">
        <input type="hidden" name="mail" value="{$login_info.mail}">

        <br>
        <center>
        <input type=submit name="send" value="送信">
        </center>
        </form>
        <br>
        <center>
        {foreach from=$err_code item=disp_err name=loopname}
        <br>
        <font class="tw">{$smarty.foreach.loopname.iteration}{$disp_err}</font>
        {/foreach}
        </center>
        <a href="./"><center>HOME</center></a><br>
    </body>
</html>
