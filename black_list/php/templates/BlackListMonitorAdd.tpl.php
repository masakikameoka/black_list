<html>
<script type="text/javascript">
function window_open()
{
	if(window.confirm('�o�^���܂����H')){
		document.add_form.action = "/black_list/black_list/php/action/BlackListMonitorAddAction.class.php";
		document.add_form.submit();
	}
	// �uOK�v���̏����I��

	// �u�L�����Z���v���̏����J�n
	else{
		window.alert('�L�����Z������܂���'); // �x���_�C�A���O��\��
	}
}
</script>

<head>
<title>�u���b�N���X�g�o�^�E�폜���</title>
</head>

<body>
<h2>�u���b�N���X�g���j�^�[�o�^</h2>

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
<input type="submit" value="�o�^����" />
</form>
<?php }elseif($flag == 'true'){?>
���ݏ������ł��B<br>
���������チ�[����������v���܂��B
<form action="/black_list/black_list/php/action/BlackListMonitorAddCancelAction.class.php" method="post">
<input type="submit" name="submit" value="�L�����Z��">
</form>
<form action="/black_list/black_list/php/action/BlackListUpdateAddFileDownLoad.class.php" method="post">
<input type="submit" name="submit" value="�t�@�C���m�F">
</form>
<br />
<?php }?>

<h2>�u���b�N���X�g���j�^�[����</h2>
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
<input type="submit" name="submit" value="��������" />
</form>
<?php }elseif($flag == 'true'){?>
���ݏ������ł��B<br>
���������チ�[����������v���܂��B
<form action="/black_list/black_list/php/action/BlackListMonitorDeaddCancelAction.class.php" method="post">
<input type="submit" name="submit" value="�L�����Z��">
</form>
<form action="" method="post">
<input type="submit" name="submit" value="�t�@�C���m�F">
</form>
<br />
<?php }?>
<br>

<h2>�S���_�E�����[�h</h2>
<form action="/black_list/black_list/php/action/BlackListIdAllDownload.action.php" method="post">
<input type="submit" name="submit" value="�S���_�E�����[�h">
</form>
</body>
</html>