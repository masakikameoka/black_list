<?php
//�o�^�pcopy�}�X�^��ۑ�����t�H���_
define('COPY_ADD_BLACK_LIST_FILE', '/Users/kameokamasaki/Downloads/test/copy/add/blacklist_id.list');
//�����pcopy�}�X�^��ۑ�����t�H���_
define('COPY_DEADD_BLACK_LIST_FILE', '/Users/kameokamasaki/Downloads/test/copy/deadd/blacklist_id.list');
//�A�b�v���[�h���ꂽ�t�@�C���̕ۑ�����t�H���_
define('ADD_BLACKLIST_FOLDER', '/Users/kameokamasaki/Downloads/test/backup/add');
require_once '../logic/BlackListMonitorLogic.php';

class BlackListMonitorAddCancelAction{
	
	function init(){
		
	}
	
	function execute(){
		
		//CSRF�΍�
		
		
		if(!file_exists(COPY_ADD_BLACK_LIST_FILE)){
			//�G���[
		}
		
		$dir = ADD_BLACKLIST_FOLDER;
		
		//�f�B���N�g�����̃t�@�C�������o��
// 		$filelist=scandir($dir);
		
// 		foreach($filelist as $file){
// 			strstr($file, '')
// 		}
// 		unlink($filelist[count($filelist-1)]);
		unlink(COPY_ADD_BLACK_LIST_FILE);
	}
}

$a = new BlackListMonitorAddCancelAction();
$url = 'http://localhost/black_list/black_list/php/templates/BlackListMonitorAdd.tpl.php';
$a->execute();

if(file_exists(COPY_ADD_BLACK_LIST_FILE) && file_exists(COPY_DEADD_BLACK_LIST_FILE)){
	$url .= '?add_flag=true&deadd_flag=true';
}else if(file_exists(COPY_ADD_BLACK_LIST_FILE)){
	$url .= '?add_flag=true';
}else if(file_exists(COPY_DEADD_BLACK_LIST_FILE)){
	$url .= '?deadd_flag=true';
}

 header("location: ".$url);exit;

	
