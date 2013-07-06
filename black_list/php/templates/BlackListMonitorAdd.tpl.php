<html>

<head>
<title>ブラックリスト登録・削除画面</title>
</head>

<body>
<h2>ブラックリストモニター登録</h2>

<?php if($update_flag == false || isset($update_flag)){?>
<form action="/black_list/black_list/php/action/BlackListMonitorAddAction.class.php" method="post"
enctype="multipart/form-data">

<label for="file">Filename:</label>
<input type="file" name="file" id="file" />
<br />
<input type="submit" name="submit" value="登録する" />
</form>
<?php }elseif ($update_flag = true){?>
現在処理中です。<br>
処理完了後メールをお送り致します。
<form action="" method="post">
<input type="submit" name="submit" value="キャンセル">
</form>
<form action="" method="post">
<input type="submit" name="submit" value="ファイル確認">
</form>
<br />
<?php }?>

<h2>ブラックリストモニター解除</h2>
<form action="/black_list/black_list/php/action/BlackListMonitorDeaddAction.class.php" method="post"
enctype="multipart/form-data">
<label for="file">Filename:</label>
<input type="file" name="file" id="file" />
<br />
<input type="submit" name="submit" value="解除する" />
</form>

<br>

<h2>全件ダウンロード</h2>
<form action="" method="post">
<input type="submit" name="submit" value="全件ダウンロード">
</form>
</body>
</html>