<?php

//copyマスタ
define('COPY_BLACK_LIST_FILE', '/Users/kameokamasaki/Downloads/test/copy/blacklist_id.list');
//アップロードされたファイルの保存するフォルダ
define('ADD_BLACKLIST_FOLDER', '/Users/kameokamasaki/Downloads/test/backup/add');
define('TMP_DEADD_UPLOAD_FOLDER','/Users/kameokamasaki/Downloads/test/tmp/deadd');
define('TMP_ADD_UPLOAD_FOLDER','/Users/kameokamasaki/Downloads/test/tmp/add');
require_once '../logic/BlackListMonitorLogic.php';

class BlackListMonitorAddCancelAction{
	
	function init(){
		
	}
	
	function execute(){
		
		//CSRF対策
		
		//ディレクトリ内のファイルを取り出す
		$filelist=scandir(TMP_ADD_UPLOAD_FOLDER);
		
		$this->logic = new BlackListMonitorLogic();
				
		$add_blacklist_file_name = null;
		//一時フォルダにあるファイルと同じものをアップロード保存フォルダから削除
		foreach($filelist as $file){
			if(strpos($file,'add_blacklist_id') !== FALSE){
					$add_blacklist_file_name =$file;
					unlink(ADD_BLACKLIST_FOLDER.'/'.$file);
					break;
			}
		}
		
		if($this->logic->is_match_file_exists_in_folder(TMP_DEADD_UPLOAD_FOLDER, 'blacklist_id')){
			//マスタコピーのID取り出し
			$blacklist_ids = $this->logic->get_blacklist_id(COPY_BLACK_LIST_FILE);
			//追加しているIDの取り出し
			$added_blacklist_ids = $this->logic->get_blacklist_id(TMP_ADD_UPLOAD_FOLDER.'/'.$file);
			//省き
			$blacklist_ids = $this->logic->filter_ids_from($added_blacklist_ids, $blacklist_ids)[0];
			
			if($this->logic->copy_blacklist_writer($blacklist_ids, 'w')){
				//エラー処理;
				return;
			}
				
		}else{
			unlink(COPY_BLACK_LIST_FILE);
		}
		
		//一時フォルダにあるファイルをすべて削除
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
	
