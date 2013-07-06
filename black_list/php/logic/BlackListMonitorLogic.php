<?php

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
	
		// Method to know which IDs were repeated.
		// 重複していたIDを調べる方法
		$uniqued_ids = array_unique(array_diff_assoc($list_to_fix, $uniqued_array));
		foreach ($uniqued_ids as $uniqued_ids_item) {
			$logger->append('Repeated ID: ' . $uniqued_ids_item);
   		 }
	
	    sort($uniqued_array);
	    return $uniqued_array;
	}
}