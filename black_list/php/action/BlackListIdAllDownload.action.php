<?php

//�}�X�^�t�@�C��
define('ORIGINAL_BLACKLIST_FILE', '/Users/kameokamasaki/Downloads/test/original/blacklist_id.list');
//�o�^�pcopy�}�X�^��ۑ�����t�H���_
define('COPY_ADD_BLACK_LIST_FILE', '/Users/kameokamasaki/Downloads/test/copy/add/blacklist_id.list');
//�����pcopy�}�X�^��ۑ�����t�H���_
define('COPY_DEADD_BLACK_LIST_FILE', '/Users/kameokamasaki/Downloads/test/copy/deadd/blacklist_id.list');
class BlackListIdAllDownload{

	function execute(){
		

		/* �I�[�v���ł��邩�m�F */
		if (!($fp = fopen(ORIGINAL_BLACKLIST_FILE, "r"))) {
			die("Error: Cannot open the file(".$path_file.")");
		}
		fclose($fp);
		
		/* �t�@�C���T�C�Y�̊m�F */
		if (($content_length = filesize(ORIGINAL_BLACKLIST_FILE)) == 0) {
			die("Error: File size is 0.(".$path_file.")");
		}
		
		$url = 'http://localhost/black_list/black_list/php/templates/BlackListMonitorAdd.tpl.php';
//		header("location: ".$url);exit;
		header('Content-Disposition: inline; filename="'.ORIGINAL_BLACKLIST_FILE.'"');
		header('Content-Length: '.$content_length);
		header('Content-Type: application/octet-stream');
		readfile(ORIGINAL_BLACKLIST_FILE);
	}
}

$a = new BlackListIdAllDownload();
$url = 'http://localhost/black_list/black_list/php/templates/BlackListMonitorAdd.tpl.php';
$a->execute();

if(file_exists(COPY_ADD_BLACK_LIST_FILE) && file_exists(COPY_DEADD_BLACK_LIST_FILE)){
	$url .= '?add_flag=true&deadd_flag=true';
}else if(file_exists(COPY_ADD_BLACK_LIST_FILE)){
	$url .= '?add_flag=true';
}else if(file_exists(COPY_DEADD_BLACK_LIST_FILE)){
	$url .= '?deadd_flag=true';
}

//header("location: ".$url);exit;