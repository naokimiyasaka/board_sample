<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
 "http://www.w3.org/TR/html4/loose.dtd">

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="./css/body_css.css">
        <title>ユーザー登録</title>
    </head>
    <body>
        <font class="tw"><hr><center>ユーザー登録</center><br></font>
        <table border=4 width=500 align=center>
        <form action="./?class=Login&method=registUser" method="POST">
        <tr align=center>
        <td><font class="tw"><p><label>名前:</font></tb>
        <td><input type="text" name="user_name" value="" tabindex="0" accesskey="a"></tb>
        </label>
        </tr>
        <tr align=center>
        <td><font class="tw"><p><label>メールアドレス:</font></tb>
        <td><input type="text" name="user_mail" value="" tabindex="0" accesskey="a"></tb>
        </label>
        </tr>
        <tr align=center>
        <td><font class="tw"><p><label>パスワード</font></tb>
        <td colspan=4><input type="password" name="passwd" value="" tabindex="2" accesskey="c"></tb>
        </label></p>
        </tr>
        </table>
        <br>
        <center>
        <input type=submit name="send" value="登録">
        </center>
        </form>
        <br>
        <a href="./"><center>HOME</center></a><br>
        <font class="tw">{$disp_err}</font>
    </body>
</html>
