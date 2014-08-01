<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
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
        <td><a href="registration.php">新規登録</a></td>
        </tr>
        </table>
        <font class="tw"><?PHP include_once("./php/sql_dispmain.php"); ?></font>
    </body>
</html>
