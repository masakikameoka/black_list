<?php
//アップロードされたファイルの保存するフォルダ
define('ADD_BLACKLIST_FOLDER', '/Users/kameokamasaki/Downloads/test/backup/add');
//マスタファイル
define('ORIGINAL_BLACKLIST_FILE', '/Users/kameokamasaki/Downloads/test/original/blacklist_id.list');
//copyマスタを保存するフォルダ
define('COPY_BLACK_LIST_FILE', '/Users/kameokamasaki/Downloads/test/copy/blacklist_id.list');
define('TMP_ADD_UPLOAD_FOLDER','/Users/kameokamasaki/Downloads/test/tmp/add');
define('TMP_DEADD_UPLOAD_FOLDER','/Users/kameokamasaki/Downloads/test/tmp/deadd');
//ブラックリスト登録数上限値
define('MAX_REGISTER_ID_NUM',500000);
require_once '../logic/BlackListMonitorLogic.php';
class BlackListMonitorAddAction{
	
	function init(){
		
	}
	
	function execute(){
		
		$this->logic = new BlackListMonitorLogic();
		if($this->logic->is_match_file_exists_in_folder(TMP_ADD_UPLOAD_FOLDER, 'add_blacklist_id')){
			return "既にアップロード済みです。";
		}
		
		$this->logic = new BlackListMonitorLogic();
		
		//$logic->verify_number_of_digits_and_fill();
		
		//アップロードファイル取得
		$tmp_file = $_FILES['update_file']['tmp_name'];

		$upload_file_name = '/add_blacklist_id_'.date('YmdHis').'.list';
		
		//アップロードファイルを保存
		$add_blacklist_file_path = ADD_BLACKLIST_FOLDER.$upload_file_name;
		$tmp_add_blacklist_file_path = TMP_ADD_UPLOAD_FOLDER.$upload_file_name;
		
		move_uploaded_file($tmp_file, $add_blacklist_file_path);
		copy($add_blacklist_file_path,$tmp_add_blacklist_file_path);
				
		//追加するIDを配列で取得
		$add_blacklist_ids = $this->logic->get_blacklist_id($add_blacklist_file_path);
		
		
		//省きID取得
		$not_blacklist_all_ids = $this->logic->get_exclude_blacklist_all_ids();		
		$add_blacklist_ids = $this->logic->filter_ids_from($not_blacklist_all_ids, $add_blacklist_ids)[0];
		
		$flag =false;
		
		if(!file_exists(COPY_BLACK_LIST_FILE)){
			//マスタファイルをコピー
			copy(ORIGINAL_BLACKLIST_FILE, COPY_BLACK_LIST_FILE);
			$flag = true;
		}
		
		//マスタコピーファイルのIDを配列で取得
		$black_list_ids = $this->logic->get_blacklist_id(COPY_BLACK_LIST_FILE);

		//登録後のID数が上限値より多い場合
		if(count($black_list_ids) + count($add_blacklist_ids) >= MAX_REGISTER_ID_NUM){		

			if($flag){
				unlink(COPY_BLACK_LIST_FILE);
			}
			
			unlink($add_blacklist_file_path);
			unlink($tmp_add_blacklist_file_path);
			$result="登録可能件数を超過しています。運用チームに連絡してください。";
			return $result;
		}
		
		$added_blacklist_ids =$this->logic->unique_check(
				$this->logic->merge_lists($black_list_ids, $add_blacklist_ids));
		
		if($this->logic->copy_blacklist_writer($added_blacklist_ids, 'w')){
			//エラー処理;
			return;
		}
		
		//追加ID数
		count($add_blacklist_ids);
		//追加前ID数
		count($black_list_ids);
		//追加後ID数
		count($added_blacklist_ids);
		//省きID合計（BUDU）
		$this->logic->exclude_easyid_num();
		
		return true;
 	}
}

$a = new BlackListMonitorAddAction();
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