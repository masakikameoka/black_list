<?php
//�o�^�pcopy�}�X�^��ۑ�����t�H���_
define('COPY_BLACK_LIST_FILE', '/Users/kameokamasaki/Downloads/test/copy/blacklist_id.list');
//�A�b�v���[�h���ꂽ�t�@�C���̕ۑ�����t�H���_
define('DEADD_BLACKLIST_FOLDER', '/Users/kameokamasaki/Downloads/test/backup/deadd');

define('TMP_ADD_UPLOAD_FOLDER','/Users/kameokamasaki/Downloads/test/tmp/add');
define('TMP_DEADD_UPLOAD_FOLDER','/Users/kameokamasaki/Downloads/test/tmp/deadd');

require_once '../logic/BlackListMonitorLogic.php';

class BlackListMonitorDeaddCancelAction{
	
	function init(){
		
	}
	
	function execute(){

		
		//�f�B���N�g�����̃t�@�C�������o��
		$filelist = scandir(TMP_DEADD_UPLOAD_FOLDER);
		$this->logic = new BlackListMonitorLogic();
		
		$deadd_blacklist_file_name = null;
		//�ꎞ�t�H���_�ɂ���t�@�C���Ɠ������̂��A�b�v���[�h�ۑ��t�H���_����폜
		foreach($filelist as $file){
			if(strpos($file, 'deadd_blacklist_id') !== FALSE){				
				$deadd_blacklist_file_name = $file;
				unlink(DEADD_BLACKLIST_FOLDER.'/'.$file);
				break;
			}
		}
		
		if($this->logic->is_match_file_exists_in_folder(TMP_ADD_UPLOAD_FOLDER, 'blacklist_id')){
			$deadd_blacklist_file = TMP_DEADD_UPLOAD_FOLDER.'/'.$deadd_blacklist_file_name;
			$deadd_blacklist_ids = $this->logic->get_blacklist_id($deadd_blacklist_file);
			
			if($this->logic->copy_blacklist_writer($deadd_blacklist_ids, 'a')){
				//�G���[����;
				return;
			}
						
		}else{
			unlink(COPY_BLACK_LIST_FILE);
		}
		//�ꎞ�t�H���_�ɂ���t�@�C�������ׂč폜
		foreach($filelist as $file){
			unlink(TMP_DEADD_UPLOAD_FOLDER.'/'.$file);
		}
		unlink(COPY_DEADD_BLACK_LIST_FILE);
	}
}

$a = new BlackListMonitorDeaddCancelAction();
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
	

	
