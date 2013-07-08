<?php
//�A�b�v���[�h���ꂽ�t�@�C���̕ۑ�����t�H���_
define('DEADD_BLACKLIST_FOLDER', '/Users/kameokamasaki/Downloads/test/backup/deadd');
//�}�X�^�t�@�C��
define('ORIGINAL_BLACKLIST_FILE', '/Users/kameokamasaki/Downloads/test/original/blacklist_id.list');
//copy�}�X�^��ۑ�����t�H���_
define('COPY_BLACK_LIST_FILE', '/Users/kameokamasaki/Downloads/test/copy/blacklist_id.list');
define('TMP_ADD_UPLOAD_FOLDER','/Users/kameokamasaki/Downloads/test/tmp/add');
define('TMP_DEADD_UPLOAD_FOLDER','/Users/kameokamasaki/Downloads/test/tmp/deadd');
require_once '../logic/BlackListMonitorLogic.php';
class BlackListMonitorDeaddAction{
	
	function init(){
		
	}
	
	function execute(){
				
		$this->logic = new BlackListMonitorLogic();
		
		//$logic->verify_number_of_digits_and_fill();
		
		//�A�b�v���[�h�t�@�C���擾
		$tmp_file = $_FILES['update_file']['tmp_name'];
		
		$upload_file_name = '/deadd_blacklist_id_'.date('YmdHis').'.list';
		
		
		//�A�b�v���[�h�t�@�C����ۑ�
		$deadd_blacklist_file_path = DEADD_BLACKLIST_FOLDER.$upload_file_name;
		$tmp_deadd_blacklist_file_path = TMP_DEADD_UPLOAD_FOLDER.$upload_file_name;
		
		move_uploaded_file($tmp_file, $deadd_blacklist_file_path);
		copy($deadd_blacklist_file_path,$tmp_deadd_blacklist_file_path);
						
		//��������ID��z��Ŏ擾
		$deadd_blacklist_ids = $this->logic->get_blacklist_id($deadd_blacklist_file_path);
				
	$flag =false;
		
		if(!file_exists(COPY_BLACK_LIST_FILE)){
			//�}�X�^�t�@�C�����R�s�[
			copy(ORIGINAL_BLACKLIST_FILE, COPY_BLACK_LIST_FILE);
			$flag = true;
		}
		
		//�X�^�R�s�[��ID��z��Ŏ擾
		$blacklist_ids = $this->logic->get_blacklist_id(COPY_BLACK_LIST_FILE);
		//��������ID����菜��
		$blacklist_ids = $this->logic->filter_ids_from($deadd_blacklist_ids, $blacklist_ids)[0];
		
		if($this->logic->copy_blacklist_writer($blacklist_ids, 'w')){
			//�G���[����;
			return;
		}
		
		//�Ȃ�ID���v�l
		$this->logic->exclude_easyid_num();
		//������
		count($deadd_blacklist_ids);
		//�����OID��
		count($blacklist_ids);
		//������ID��
		
		return true;
 	}
}

$a = new BlackListMonitorDeaddAction();
$b = new BlackListMonitorLogic();
$result=$a->execute();
$url = 'http://localhost/black_list/black_list/php/templates/BlackListMonitorAdd.tpl.php?result='.$result;
$str = 'blacklist_id';
if($b->is_match_file_exists_in_folder(TMP_ADD_UPLOAD_FOLDER,$str)
		&& $b->is_match_file_exists_in_folder(TMP_DEADD_UPLOAD_FOLDER,$str)){
	$url .= '&add_flag=true&deadd_flag=true';
}else if($b->is_match_file_exists_in_folder(TMP_ADD_UPLOAD_FOLDER,$str)){
	$url .= '&add_flag=true';
}else if($b->is_match_file_exists_in_folder(TMP_DEADD_UPLOAD_FOLDER,$str)){
	$url .= '&deadd_flag=true';
}
header("location: ".$url);exit;