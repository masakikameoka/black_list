<html>
<script type="text/javascript">
function confirm_add(){
	if(window.confirm('�o�^���܂����H')){
		// �uOK�v���̏����I��
		return true;
	}
	else{
		// �u�L�����Z���v���̏����J�n
		window.alert('�L�����Z������܂���'); // �x���_�C�A���O��\��
		return false;
	}
}

function confirm_deadd(){
	if(window.confirm('�������܂����H')){
		// �uOK�v���̏����I��
		return true;
	}
	else{
		// �u�L�����Z���v���̏����J�n
		window.alert('�L�����Z������܂���'); // �x���_�C�A���O��\��
		return false;
	}
}

function confirm_cancel(){
	if(window.confirm('�L�����Z�����܂����H')){
		// �uOK�v���̏����I��
		return true;
	}
	else{
		// �u�L�����Z���v���̏����J�n
		window.alert('�L�����Z������܂���'); // �x���_�C�A���O��\��
		return false;
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
enctype="multipart/form-data" onsubmit="return confirm_add()">
<label for="file">Filename:</label>
<input  type="file" name="update_file" id="file" />
<br />
<input type="submit" name="submit" value="�o�^����" />
</form>

<?php }elseif($flag == 'true'){?>

���ݏ������ł��B<br>
���������チ�[����������v���܂��B

<form action="/black_list/black_list/php/action/BlackListMonitorAddCancelAction.class.php" method="post"
onsubmit="confirm_cancel">
<input type="submit" name="submit" value="�L�����Z��">
</form>

<form action="" method="post">
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
enctype="multipart/form-data" onsubmit="return confirm_deadd()">
<label for="file">Filename:</label>
<input type="file" name="update_file" id="file" />
<br />
<input type="submit" name="submit" value="��������" />
</form>

<?php }elseif($flag == 'true'){?>
���ݏ������ł��B<br>
���������チ�[����������v���܂��B

<form action="/black_list/black_list/php/action/BlackListMonitorDeaddCancelAction.class.php" method="post"
onsubmit="confirm_cancel">
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