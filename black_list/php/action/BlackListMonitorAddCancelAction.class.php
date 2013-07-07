<?php
//登録用copyマスタを保存するフォルダ
define('COPY_ADD_BLACK_LIST_FILE', '/Users/kameokamasaki/Downloads/test/copy/add/blacklist_id.list');
//解除用copyマスタを保存するフォルダ
define('COPY_DEADD_BLACK_LIST_FILE', '/Users/kameokamasaki/Downloads/test/copy/deadd/blacklist_id.list');
//アップロードされたファイルの保存するフォルダ
define('ADD_BLACKLIST_FOLDER', '/Users/kameokamasaki/Downloads/test/backup/add');

define('TMP_UPLOAD_FOLDER','/Users/kameokamasaki/Downloads/test/tmp/add');
require_once '../logic/BlackListMonitorLogic.php';

class BlackListMonitorAddCancelAction{
	
	function init(){
		
	}
	
	function execute(){
		
		//CSRF対策
		
		
		if(!file_exists(COPY_ADD_BLACK_LIST_FILE)){
			//エラー
		}
		
		//ディレクトリ内のファイルを取り出す
		$filelist=scandir(TMP_UPLOAD_FOLDER);
		
		//一時フォルダにあるファイルと同じものをアップロード保存フォルダから削除
		foreach($filelist as $file){
			if(strpos($file, 'add_blacklist_id')){
				unlink(ADD_BLACKLIST_FOLDER.'/'.$file);
			}
		}
		//一時フォルダにあるファイルをすべて削除
		foreach($filelist as $file){
			unlink(TMP_UPLOAD_FOLDER.'/'.$file);
		}
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

	
