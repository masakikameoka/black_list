<html>

<head>
<title>ブラックリスト登録・削除画面</title>
</head>

<body>
<h2>ブラックリストモニター登録</h2>

<form action="/php/action/BlackListMonitorAddAction.class.php" method="post"
enctype="multipart/form-data">

<label for="file">Filename:</label>
<input type="file" name="file" id="file" />
<br />
<input type="submit" name="submit" value="登録する" />
</form>
<br />

<h2>ブラックリストモニター解除</h2>
<form action="upload_file.php" method="post"
enctype="multipart/form-data">
<label for="file">Filename:</label>
<input type="file" name="file" id="file" />
<br />
<input type="submit" name="submit" value="登録する" />
</form>

<br>

<h2>全件ダウンロード</h2>
<form action="" method="post">
<input type="submit" name="submit" value="全件ダウンロード">
</form>
</body>
</html>