<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
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
        <input type="hidden" name='id' value="{$disp_text.boardid}">
        <td><font class="tw"><p><label>件名:{$disp_text.subject}</font></tb>
        <td><font class="tw"><p><label>名前:{$disp_text.name}</font></tb>
        </tr>
        <tr align=center>
        <td colspan=4><font class="tw"><p><label>メールアドレス:{$disp_text.mail}</font></tb>
        </tr>
        <tr align=center>
        <td><font class="tw"><p><label>本文:</font></td>
        <td colspan=4><font class="tw"><p><label>{$disp_text.maintext}</font></td>
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
        <a href="./index.php"><center>HOME</center></a><br>
    </body>
</html>
