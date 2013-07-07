<?php
//アップロードされたファイルの保存するフォルダ
define('DEADD_BLACKLIST_FOLDER', '/Users/kameokamasaki/Downloads/test/backup/deadd');
//マスタファイル
define('ORIGINAL_BLACKLIST_FILE', '/Users/kameokamasaki/Downloads/test/original/blacklist_id.list');
//登録用copyマスタを保存するフォルダ
define('COPY_ADD_BLACK_LIST_FILE', '/Users/kameokamasaki/Downloads/test/copy/add/blacklist_id.list');
//解除用copyマスタを保存するフォルダ
define('COPY_DEADD_BLACK_LIST_FILE', '/Users/kameokamasaki/Downloads/test/copy/deadd/blacklist_id.list');

define('TMP_UPLOAD_FOLDER','/Users/kameokamasaki/Downloads/test/tmp/deadd');
require_once '../logic/BlackListMonitorLogic.php';
class BlackListMonitorDeaddAction{
	
	function init(){
		
	}
	
	function execute(){
		
		if(file_exists(COPY_ADD_BLACK_LIST_FILE)){
			return "既にアップロード済みです。";
		}
		
		$this->logic = new BlackListMonitorLogic();
		
		//$logic->verify_number_of_digits_and_fill();
		
		//アップロードファイル取得
		$tmp_file = $_FILES['update_file']['tmp_name'];
// 		/* 日にち毎にフォルダを作成 */
// 		$folder_name = DEADD_BLACKLIST_FOLDER.'/'.date('Y-m-d');
// 		mkdir($folder_name);
		
		$upload_file_name = '/deadd_blacklist_id_'.date('YmdHis').'.list';
		
		
		//アップロードファイルを保存
		$deadd_blacklist_file_path = DEADD_BLACKLIST_FOLDER.$upload_file_name;
		$tmp_deadd_blacklist_file_path = TMP_UPLOAD_FOLDER.$upload_file_name;
		
		move_uploaded_file($tmp_file, $deadd_blacklist_file_path);
		copy($deadd_blacklist_file_path,$tmp_deadd_blacklist_file_path);
						
		//追加するIDを配列で取得
		$deadd_blacklist_ids = $this->logic->get_blacklist_id($deadd_blacklist_file_path);
		
		//マスタファイルをコピー
		copy(ORIGINAL_BLACKLIST_FILE, COPY_DEADD_BLACK_LIST_FILE);
		
		//マスタコピーファイルのIDを取得
		$black_list_ids = $this->logic->get_blacklist_id(COPY_DEADD_BLACK_LIST_FILE);
		
		$black_list_ids = $this->logic->filter_ids_from($deadd_blacklist_ids, $black_list_ids)[0];
		//マスタコピーファイルオープン
		if (!($fp = fopen(COPY_DEADD_BLACK_LIST_FILE, 'w'))) {
			// エラー処理
				return $br;
		}
		
		foreach ($black_list_ids as $id){
			
			// ファイルの書き込み
			if (!fwrite($fp, $id . "\n")) {
				// エラー処理
				echo 'マスタファイル書き込みエラー';
				break;
			}
		}
		fclose($fp);
		return true;
 	}
}

$a = new BlackListMonitorDeaddAction();
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