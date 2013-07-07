<?php
//登録用copyマスタを保存するフォルダ
define('COPY_ADD_BLACK_LIST_FILE', '/Users/kameokamasaki/Downloads/test/copy/add/blacklist_id.list');
//解除用copyマスタを保存するフォルダ
define('COPY_DEADD_BLACK_LIST_FILE', '/Users/kameokamasaki/Downloads/test/copy/deadd/blacklist_id.list');
//アップロードされたファイルの保存するフォルダ
define('DEADD_BLACKLIST_FOLDER', '/Users/kameokamasaki/Downloads/test/backup/deadd');
require_once '../logic/BlackListMonitorLogic.php';

class BlackListMonitorDeaddCancelAction{
	
	function init(){
		
	}
	
	function execute(){
		
		//CSRF対策
		
		
		if(!file_exists(COPY_DEADD_BLACK_LIST_FILE)){
			//エラー
		}
		
		$dir = DEADD_BLACKLIST_FOLDER;
		
		//ディレクトリ内のファイルを取り出す
// 		$filelist=scandir($dir);
		
// 		foreach($filelist as $file){
// 			strstr($file, '')
// 		}
// 		unlink($filelist[count($filelist-1)]);
		unlink(COPY_DEADD_BLACK_LIST_FILE);
	}
}

$a = new BlackListMonitorDeaddCancelAction();
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

	
