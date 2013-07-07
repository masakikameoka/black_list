<?php
//BU�EDU
define('BU_IDS_FOR_TESTING', '/Users/kameokamasaki/Downloads/test/BUDU/not_blacklist_id_BU.list');//TODO �f�B���N�g���܂ł̃p�X
define('DU_IDS_FOR_TESTING', '/Users/kameokamasaki/Downloads/test/BUDU/not_blacklist_id_DU.list');


class BlackListMonitorLogic{


	function verify_number_of_digits_and_fill ($file_name){

		if(!($file = fopen($file_name, 'r+'))){
			echo 'BlackListMonitorLogic#123';
		}
		while (($current_line = fgets($file)) !== false){
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
					fwrite($file, $current_line);
				}
			}
			fclose($file_name);
			$number_of_lines = $current_line;
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

		sort($uniqued_array);
		return $uniqued_array;
	}

	//�t�@�C������ID�擾
	function get_blacklist_id($file_name){

		if(!($file = fopen($file_name, 'r'))){
			echo 'BlackListMonitorLogic#123';
		}

		$contents = array();

		while (($line = fgets($file)) !== false){

			// ��s�͓ǂݔ�΂�
			if (($line = rtrim($line)) === '') {
				continue;
			}
			$contents[] = $line;
		}

		fclose($file);

		return $contents;
	}

	function get_not_blacklist_all_ids(){
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
}