<html>
<script type="text/javascript">
function confirm_add(){
	if(window.confirm('登録しますか？')){
		// 「OK」時の処理終了
		return true;
	}
	else{
		// 「キャンセル」時の処理開始
		window.alert('キャンセルされました'); // 警告ダイアログを表示
		return false;
	}
}

function confirm_deadd(){
	if(window.confirm('解除しますか？')){
		// 「OK」時の処理終了
		return true;
	}
	else{
		// 「キャンセル」時の処理開始
		window.alert('キャンセルされました'); // 警告ダイアログを表示
		return false;
	}
}

function confirm_cancel(){
	if(window.confirm('キャンセルしますか？')){
		// 「OK」時の処理終了
		return true;
	}
	else{
		// 「キャンセル」時の処理開始
		window.alert('キャンセルされました'); // 警告ダイアログを表示
		return false;
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
enctype="multipart/form-data" onsubmit="return confirm_add()">
<label for="file">Filename:</label>
<input  type="file" name="update_file" id="file" />
<br />
<input type="submit" name="submit" value="登録する" />
</form>

<?php }elseif($flag == 'true'){?>

現在処理中です。<br>
処理完了後メールをお送り致します。

<form action="/black_list/black_list/php/action/BlackListMonitorAddCancelAction.class.php" method="post"
onsubmit="confirm_cancel">
<input type="submit" name="submit" value="キャンセル">
</form>

<form action="" method="post">
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
enctype="multipart/form-data" onsubmit="return confirm_deadd()">
<label for="file">Filename:</label>
<input type="file" name="update_file" id="file" />
<br />
<input type="submit" name="submit" value="解除する" />
</form>

<?php }elseif($flag == 'true'){?>
現在処理中です。<br>
処理完了後メールをお送り致します。

<form action="/black_list/black_list/php/action/BlackListMonitorDeaddCancelAction.class.php" method="post"
onsubmit="confirm_cancel">
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