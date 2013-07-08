<?php

//copy�}�X�^
define('COPY_BLACK_LIST_FILE', '/Users/kameokamasaki/Downloads/test/copy/blacklist_id.list');
//�A�b�v���[�h���ꂽ�t�@�C���̕ۑ�����t�H���_
define('ADD_BLACKLIST_FOLDER', '/Users/kameokamasaki/Downloads/test/backup/add');
define('TMP_DEADD_UPLOAD_FOLDER','/Users/kameokamasaki/Downloads/test/tmp/deadd');
define('TMP_ADD_UPLOAD_FOLDER','/Users/kameokamasaki/Downloads/test/tmp/add');
require_once '../logic/BlackListMonitorLogic.php';

class BlackListMonitorAddCancelAction{
	
	function init(){
		
	}
	
	function execute(){
		
		//CSRF�΍�
		
		//�f�B���N�g�����̃t�@�C�������o��
		$filelist=scandir(TMP_ADD_UPLOAD_FOLDER);
		
		$this->logic = new BlackListMonitorLogic();
				
		$add_blacklist_file_name = null;
		//�ꎞ�t�H���_�ɂ���t�@�C���Ɠ������̂��A�b�v���[�h�ۑ��t�H���_����폜
		foreach($filelist as $file){
			if(strpos($file,'add_blacklist_id') !== FALSE){
					$add_blacklist_file_name =$file;
					unlink(ADD_BLACKLIST_FOLDER.'/'.$file);
					break;
			}
		}
		
		if($this->logic->is_match_file_exists_in_folder(TMP_DEADD_UPLOAD_FOLDER, 'blacklist_id')){
			//�}�X�^�R�s�[��ID���o��
			$blacklist_ids = $this->logic->get_blacklist_id(COPY_BLACK_LIST_FILE);
			//�ǉ����Ă���ID�̎��o��
			$added_blacklist_ids = $this->logic->get_blacklist_id(TMP_ADD_UPLOAD_FOLDER.'/'.$file);
			//�Ȃ�
			$blacklist_ids = $this->logic->filter_ids_from($added_blacklist_ids, $blacklist_ids)[0];
			
			if($this->logic->copy_blacklist_writer($blacklist_ids, 'w')){
				//�G���[����;
				return;
			}
				
		}else{
			unlink(COPY_BLACK_LIST_FILE);
		}
		
		//�ꎞ�t�H���_�ɂ���t�@�C�������ׂč폜
		foreach($filelist as $file){
			unlink(TMP_ADD_UPLOAD_FOLDER.'/'.$file);
		}
	}
}

$a = new BlackListMonitorAddCancelAction();
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
	
