<html>

<head>
<title>�u���b�N���X�g�o�^�E�폜���</title>
</head>

<body>
<h2>�u���b�N���X�g���j�^�[�o�^</h2>

<?php if($update_flag == false || isset($update_flag)){?>
<form action="/black_list/black_list/php/action/BlackListMonitorAddAction.class.php" method="post"
enctype="multipart/form-data">

<label for="file">Filename:</label>
<input type="file" name="file" id="file" />
<br />
<input type="submit" name="submit" value="�o�^����" />
</form>
<?php }elseif ($update_flag = true){?>
���ݏ������ł��B<br>
���������チ�[����������v���܂��B
<form action="" method="post">
<input type="submit" name="submit" value="�L�����Z��">
</form>
<form action="" method="post">
<input type="submit" name="submit" value="�t�@�C���m�F">
</form>
<br />
<?php }?>

<h2>�u���b�N���X�g���j�^�[����</h2>
<form action="/black_list/black_list/php/action/BlackListMonitorDeaddAction.class.php" method="post"
enctype="multipart/form-data">
<label for="file">Filename:</label>
<input type="file" name="file" id="file" />
<br />
<input type="submit" name="submit" value="��������" />
</form>

<br>

<h2>�S���_�E�����[�h</h2>
<form action="" method="post">
<input type="submit" name="submit" value="�S���_�E�����[�h">
</form>
</body>
</html>