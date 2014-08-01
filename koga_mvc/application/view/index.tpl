<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SVN Tool</title>
<link href="static/css/bootstrap.css" rel="stylesheet" type="text/css" />
<script type="text/JavaScript" src="static/js/jquery.min.js"></script>
<script type="text/JavaScript" src="static/js/bootstrap-transition.js"></script>
<script type="text/JavaScript" src="static/js/bootstrap-alert.js"></script>
<script type="text/JavaScript" src="static/js/bootstrap-modal.js"></script>
<script type="text/JavaScript" src="static/js/bootstrap-dropdown.js"></script>
<script type="text/JavaScript" src="static/js/bootstrap-scrollspy.js"></script>
<script type="text/JavaScript" src="static/js/bootstrap-tab.js"></script>
<script type="text/JavaScript" src="static/js/bootstrap-tooltip.js"></script>
<script type="text/JavaScript" src="static/js/bootstrap-popover.js"></script>
<script type="text/JavaScript" src="static/js/bootstrap-button.js"></script>
<script type="text/JavaScript" src="static/js/bootstrap-collapse.js"></script>
<script type="text/JavaScript" src="static/js/bootstrap-carousel.js"></script>
<script type="text/JavaScript" src="static/js/bootstrap-typeahead.js"></script>
<script type="text/JavaScript" src="static/js/stupidtable.js"></script>
<script type="text/JavaScript">
  $(function(){
    $("#sorted-table").stupidtable();
  });
</script>
</head>

<body>
<div class="navbar navbar-static">
  <div class="navbar-inner">
    <div class="container" style="width: auto;"> <a class="brand" href="./">SVN Tool</a>
      <ul class="nav">
        <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown">リポジトリ<b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="?mode=repository&action=list">リポジトリ一覧</a></li>
            <li><a href="?mode=repository&action=add">リポジトリ追加</a></li>
            <li class="divider"></li>
            <li><a href="?mode=repository::contents&action=list">コンテンツ一覧</a></li>
            <li><a href="?mode=repository::contents&action=add">コンテンツ追加</a></li>
            <li class="divider"></li>
            <li><a href="?mode=repository::company&action=list">運営会社一覧</a></li>
            <li><a href="?mode=repository::company&action=add">運営会社追加</a></li>
          </ul>
        </li>
        <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown">ユーザー<b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="?mode=user&action=list">ユーザー一覧</a></li>
            <li><a href="?mode=user&action=add">ユーザー追加</a></li>
            <li class="divider"></li>
            <li><a href="?mode=user::post&action=list">部署一覧</a></li>
            <li><a href="?mode=user::post&action=add">部署追加</a></li>
          </ul>
        </li>
      </ul>
      <ul class="nav pull-right">
        <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown">WebSVN<b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="http://pss-rcs.gamania.co.jp/websvn/develop/" target="_blank">develop</a></li>
            <li><a href="http://pss-rcs.gamania.co.jp/websvn/staging/" target="_blank">staging</a></li>
            <li><a href="http://pss-rcs.gamania.co.jp/websvn/production/" target="_blank">production</a></li>
          </ul>
        </li>
      </ul>
      <ul class="nav pull-right">
        <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown">サーバー<b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="http://pss-rcs.gamania.co.jp/usermod/">パスワード変更</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</div>
<div class="container-fluid">
  {$contents}
</div>
</body>
</html>
