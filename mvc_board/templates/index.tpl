<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
 "http://www.w3.org/TR/html4/loose.dtd">

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="../css/body_css.css">
        <title>掲示板 一覧画面</title>
    </head>
    <body><!--見えずらいから全部白-->
        <font class="tw"><strong><center>目次</center></strong></font><br>
        <table border=1 width=350 align=center>
        <tr align=center>
        <td><a href="../php/index.php?class=Registration&method=dispPage">新規登録</a></td>
        </tr>
        </table>
        <table border=4 width=500 align=center>
        <!-----ループさせる　start------->
        {foreach from=$disp_text item=disp_data}
        <tr>
        <td><font class="tw" style="position:relative; float:left;" >件名:{$disp_data.subject}</font>
        <br>
        <font class="tw">名前:{$disp_data.name}</font>
        <br>
        <a href="../php/index.php?class=Edit&method=dispPage&id={$disp_data.boardid}"><button name="edit_bt">編集</button></a>
        <a href="../php/index.php?class=Delete&method=dispPage&id={$disp_data.boardid}"><button name="delete_bt">削除</button></a>
        <a href="../php/index.php?class=Details&method=dispPage&id={$disp_data.boardid}"><button name="delete_bt">詳細</button></a></td>
        </tr>
        <tr><td colspan=4><font class="tw">{$disp_data.maintext}</font></td></tr>
        {/foreach}
        <!-----ループさせるend------->
        </table>
    </body>
</html>
