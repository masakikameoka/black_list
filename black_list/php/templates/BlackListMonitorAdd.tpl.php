<html>
<script type="text/javascript">
function window_open()
{
	if(window.confirm('登録しますか？')){
		document.add_form.action = "/black_list/black_list/php/action/BlackListMonitorAddAction.class.php";
		document.add_form.submit();
	}
	// 「OK」時の処理終了

	// 「キャンセル」時の処理開始
	else{
		window.alert('キャンセルされました'); // 警告ダイアログを表示
	}
}
</script>

<head>
<title>ブラックリスト登録・削除画面</title>
</head>

<body>
<h2>ブラックリストモニター登録</h2>

<?php
$flag = null;
if(isset($_GET['add_flag'])){
	$flag = $_GET['add_flag'];
}
if($flag == 'false' ||  $flag == null){?>
<form action="/black_list/black_list/php/action/BlackListMonitorAddAction.class.php" method="post"
enctype="multipart/form-data" id="add_form">

<label for="file">Filename:</label>
<input type="file" name="update_file" id="file" />
<br />
<input type="submit" value="登録する" />
</form>
<?php }elseif($flag == 'true'){?>
現在処理中です。<br>
処理完了後メールをお送り致します。
<form action="/black_list/black_list/php/action/BlackListMonitorAddCancelAction.class.php" method="post">
<input type="submit" name="submit" value="キャンセル">
</form>
<form action="/black_list/black_list/php/action/BlackListUpdateAddFileDownLoad.class.php" method="post">
<input type="submit" name="submit" value="ファイル確認">
</form>
<br />
<?php }?>

<h2>ブラックリストモニター解除</h2>
<?php
$flag = null;
if(isset($_GET['deadd_flag'])){
	$flag = $_GET['deadd_flag'];
}
if($flag == 'false' ||  $flag == null){?>
<form action="/black_list/black_list/php/action/BlackListMonitorDeaddAction.class.php" method="post"
enctype="multipart/form-data">
<label for="file">Filename:</label>
<input type="file" name="update_file" id="file" />
<br />
<input type="submit" name="submit" value="解除する" />
</form>
<?php }elseif($flag == 'true'){?>
現在処理中です。<br>
処理完了後メールをお送り致します。
<form action="/black_list/black_list/php/action/BlackListMonitorDeaddCancelAction.class.php" method="post">
<input type="submit" name="submit" value="キャンセル">
</form>
<form action="" method="post">
<input type="submit" name="submit" value="ファイル確認">
</form>
<br />
<?php }?>
<br>

<h2>全件ダウンロード</h2>
<form action="/black_list/black_list/php/action/BlackListIdAllDownload.action.php" method="post">
<input type="submit" name="submit" value="全件ダウンロード">
</form>
</body>
</html>