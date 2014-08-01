<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
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
