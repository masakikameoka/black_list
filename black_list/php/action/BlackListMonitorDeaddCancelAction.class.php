<?php
//登録用copyマスタを保存するフォルダ
define('COPY_ADD_BLACK_LIST_FILE', '/Users/kameokamasaki/Downloads/test/copy/add/blacklist_id.list');
//解除用copyマスタを保存するフォルダ
define('COPY_DEADD_BLACK_LIST_FILE', '/Users/kameokamasaki/Downloads/test/copy/deadd/blacklist_id.list');
//アップロードされたファイルの保存するフォルダ
define('DEADD_BLACKLIST_FOLDER', '/Users/kameokamasaki/Downloads/test/backup/deadd');

define('TMP_UPLOAD_FOLDER','/Users/kameokamasaki/Downloads/test/tmp/deadd');

require_once '../logic/BlackListMonitorLogic.php';

class BlackListMonitorDeaddCancelAction{
	
	function init(){
		
	}
	
	function execute(){
		
			if(!file_exists(COPY_DEADD_BLACK_LIST_FILE)){
				return "既にキャンセルされています。";
			}
		
		//ディレクトリ内のファイルを取り出す
		$filelist = scandir(TMP_UPLOAD_FOLDER);
		
		//一時フォルダにあるファイルと同じものをアップロード保存フォルダから削除
		foreach($filelist as $file){
			if(strpos($file, 'deadd_blacklist_id') !== FALSE){
				unlink(DEADD_BLACKLIST_FOLDER.'/'.$file);
			}
		}
		//一時フォルダにあるファイルをすべて削除
		foreach($filelist as $file){
			unlink(TMP_UPLOAD_FOLDER.'/'.$file);
		}
		unlink(COPY_DEADD_BLACK_LIST_FILE);
	}
}

$a = new BlackListMonitorDeaddCancelAction();
$result = $a->execute();
$url = 'http://localhost/black_list/black_list/php/templates/BlackListMonitorAdd.tpl.php?result='.$result;
if(file_exists(COPY_ADD_BLACK_LIST_FILE) && file_exists(COPY_DEADD_BLACK_LIST_FILE)){
	$url .= '&add_flag=true&deadd_flag=true';
}else if(file_exists(COPY_ADD_BLACK_LIST_FILE)){
	$url .= '&add_flag=true';
}else if(file_exists(COPY_DEADD_BLACK_LIST_FILE)){
	$url .= '&deadd_flag=true';
}

 header("location: ".$url);exit;

	
