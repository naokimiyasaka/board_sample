<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
 "http://www.w3.org/TR/html4/loose.dtd">

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="./css/body_css.css">
        <title>ログイン</title>
    </head>
    <body>
        <font class="tw"><hr><center>ログイン</center><br></font>
        <table border=4 width=500 align=center>
        <form action="./?class=Login&method=loginAuth" method="POST">
        <tr align=center>
        <td><font class="tw"><p><label>名前:</font></tb>
        <td><input type="text" name="user_name" value="" tabindex="0" accesskey="a"></tb>
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
        <input type=submit name="send" value="ログイン">
        <a href="./?class=Login&method=dispPage&status=1">
        <input type=button name="button" value="新規登録">
        </a>
        </center>
        </form>
        <br>
        <a href="./"><center>HOME</center></a><br>
    </body>
</html>
