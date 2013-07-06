<?php

class BlackListMonitorLogic{
	
	function verify_number_of_digits_and_fill ($file)
	{
		$reader = new FileReader($file);//�vimport
		$number_of_lines = count(file( $file ));
		$verify_number_results =array();
		$error_line_array = array();
		$empty_line_array = array();
		
		
		foreach ($reader as $pos => $current_line) {
	
			$current_line = chop($current_line);
	
			// ��s�̃`�F�b�N
			if (! strlen($current_line) > 0) {
				$empty_line_array[] = $current_line;
				continue;
			}
	
			// 11���ȏ�ID�̃`�F�b�N
			if (strlen($current_line) > 11) {
				$error_line_array[] = $current_line;
				continue;
			}
	
			// �����ł͂Ȃ������̃`�F�b�N
			if (! preg_match("/^[0-9]+\$/", $current_line)) {
				$error_line_array[] = $current_line;
				continue;
			}
	
			// Count the number of zeroes and add them starting from the left
			// 11���ȉ�������΁A11���܂ō����疄�߂�
			$character_count = strlen( $current_line );
			$zeros_to_add = 11 - $character_count;
			if ($zeros_to_add > 0) {
				for (; $zeros_to_add > 0; $zeros_to_add--) {
					$current_line = '0' . $current_line;
				}
			}
		}
		
		//�S�s��
		if(count($number_of_lines) > 0){
			$verify_number_results['$number_of_lines'] = $number_of_lines;
		}
		
		//�G���[�̂������s
		if(count($error_line_array) > 0){
			$verify_number_results['error_line_array'] =$error_line_array; 
		}
		
		//��s
		if(count($empty_line_array) > 0){
			$verify_number_results['empty_line_array'] =$error_line_array;
		}
		
		return $verify_number_results;
	}
	
	// Remove the ids from another list
	// list_to_remove��array��ID��list_to_fix����Ȃ��܂��B
	// �Ȃ�����A�V�������X�g�ƃG���[�J�E���g��Array��return����B
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
	// �ǉ����X�g��ID�ƑO��Blacklist��ID���}�[�W���܂��B
	// �d���f�[�^�̊m�F���܂���B
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
	// Blacklist��ID��ǉ����X�g�Ɣ�ׂāA
	// �d���f�[�^���Ȃ��悤�Ƀ`�F�b�N���āA
	// �d���ł���΂���ID�𖳎�����B�����ł͂Ȃ���΁AID��ǉ�����B
	//
	function unique_check ($list_to_fix)
	{

		$uniqued_array = array_unique($list_to_fix);
	
		// Method to know which IDs were repeated.
		// �d�����Ă���ID�𒲂ׂ���@
		$uniqued_ids = array_unique(array_diff_assoc($list_to_fix, $uniqued_array));
		foreach ($uniqued_ids as $uniqued_ids_item) {
			$logger->append('Repeated ID: ' . $uniqued_ids_item);
   		 }
	
	    sort($uniqued_array);
	    return $uniqued_array;
	}
}