<?php
//BU・DU
define('BU_IDS_FOR_TESTING', '/Users/kameokamasaki/Downloads/test/BUDU/not_blacklist_id_BU.list');//TODO ディレクトリまでのパス
define('DU_IDS_FOR_TESTING', '/Users/kameokamasaki/Downloads/test/BUDU/not_blacklist_id_DU.list');
//マスタファイル
define('COPY_BLACK_LIST_FILE', '/Users/kameokamasaki/Downloads/test/copy/blacklist_id.list');



class BlackListMonitorLogic{

	function verify_number_of_digits_and_fill ($file)
	{
		$reader = new FileReader($file);//要import
		$number_of_lines = count(file( $file ));
		$verify_number_results =array();
		$error_line_array = array();
		$empty_line_array = array();


		foreach ($reader as $pos => $current_line) {

			$current_line = chop($current_line);

			// 空行のチェック
			if (! strlen($current_line) > 0) {
				$empty_line_array[] = $current_line;
				continue;
			}

			// 11桁以上IDのチェック
			if (strlen($current_line) > 11) {
				$error_line_array[] = $current_line;
				continue;
			}

			// 数字ではない文字のチェック
			if (! preg_match("/^[0-9]+\$/", $current_line)) {
				$error_line_array[] = $current_line;
				continue;
			}

			// Count the number of zeroes and add them starting from the left
			// 11桁以下があれば、11桁まで左から埋める
			$character_count = strlen( $current_line );
			$zeros_to_add = 11 - $character_count;
			if ($zeros_to_add > 0) {
				for (; $zeros_to_add > 0; $zeros_to_add--) {
					$current_line = '0' . $current_line;
				}
			}
		}

		//全行数
		if(count($number_of_lines) > 0){
			$verify_number_results['$number_of_lines'] = $number_of_lines;
		}

		//エラーのあった行
		if(count($error_line_array) > 0){
			$verify_number_results['error_line_array'] =$error_line_array;
		}

		//空行
		if(count($empty_line_array) > 0){
			$verify_number_results['empty_line_array'] =$error_line_array;
		}

		return $verify_number_results;
	}

	// Remove the ids from another list
	// list_to_removeのarrayのIDをlist_to_fixから省きます。
	// 省いた後、新しいリストとエラーカウントのArrayをreturnする。
	//
	function filter_ids_from ( $list_to_remove, $list_to_fix)
	{
		$number_of_lines_removed = 0;

		foreach ($list_to_fix as $key_to_remove => $list_to_fix_item) {
			foreach ($list_to_remove as $list_to_remove_item) {

				if ($list_to_fix_item == $list_to_remove_item) {
					unset( $list_to_fix[ $key_to_remove ] );
					$number_of_lines_removed++;
				}
			}
		}

		$results = array($list_to_fix, $number_of_lines_removed);
		return $results;
	}

	// Merge two lists
	// 追加リストのIDと前のBlacklistのIDをマージします。
	// 重複データの確認しません。
	//
	function merge_lists ($original_ids_array, $to_add_ids_array)
	{
		array_splice(
		$original_ids_array,
		count($original_ids_array),
		0,
		$to_add_ids_array
		);

		return $original_ids_array;
	}

	// Remove repeated items, and sort the result
	// BlacklistのIDを追加リストと比べて、
	// 重複データがないようにチェックして、
	// 重複であればそのIDを無視する。そうではなければ、IDを追加する。
	//
	function unique_check ($list_to_fix)
	{

		$uniqued_array = array_unique($list_to_fix);

		sort($uniqued_array);
		return $uniqued_array;
	}

	//ファイルからID取得
	function get_blacklist_id($file_name){

		if(!($file = fopen($file_name, 'r'))){
			echo 'BlackListMonitorLogic#123';
		}

		$contents = array();

		while (($line = fgets($file)) !== false){

			// 空行は読み飛ばす
			if (($line = rtrim($line)) === '') {
				continue;
			}
			$contents[] = $line;
		}

		fclose($file);

		return $contents;
	}

	function get_exclude_blacklist_all_ids(){
		//BU
		$not_blacklist_ids_BU = $this->get_blacklist_id(BU_IDS_FOR_TESTING);
		//DU
		$not_blacklist_ids_DU = $this->get_blacklist_id(DU_IDS_FOR_TESTING);
		$not_blacklist_all_ids = $this->merge_lists(
				$not_blacklist_ids_BU,
				$not_blacklist_ids_DU
		);

		return $not_blacklist_all_ids;

	}
	
	function is_match_file_exists_in_folder($folder_path,$file_name){
		
		$result = FALSE;
		
		$files = scandir($folder_path);
		foreach ($files as $file){
			if(strpos($file, $file_name)){
				$result = TRUE;
				break;
			}
		}
		
		return $result;
	}
	
	//マスターコピーファイルに書き込みを行う
	function copy_blacklist_writer($blacklist_ids,$mode){
		//マスタコピーファイルオープン
		if (!($fp = fopen(COPY_BLACK_LIST_FILE, $mode))) {
			return false;
		}
		
		foreach ($blacklist_ids as $id){
				
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
	
	function exclude_easyid_num(){
		$count = count($this->get_exclude_blacklist_all_ids());
		
		return $count;
	}
}