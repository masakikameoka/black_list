<?php
define('TMP_UPLOAD_FOLDER','/Users/kameokamasaki/Downloads/test/tmp/deadd');

class BlackListUpdateDeaddFileDownload{
	
	function execute(){
		
		//ディレクトリ内のファイルを取り出す
		$filelist=scandir(TMP_UPLOAD_FOLDER);
		
		foreach ($filelist as $file){
			if(strpos($file, 'deadd_blacklist_id') !== FALSE){
				$update_file = TMP_UPLOAD_FOLDER.'/'.$file;
				
				if (!($fp = fopen($update_file, "r"))) {
					die("Error: Cannot open the file(".$update_file.")");
				}
				fclose($fp);
				
				/* ファイルサイズの確認 */
				if (($content_length = filesize($update_file)) == 0) {
					die("Error: File size is 0.(".$update_file.")");
				}
				
				header('Content-Disposition: inline; filename="'.$update_file.'"');
				header('Content-Length: '.$content_length);
				header('Content-Type: application/octet-stream');
				readfile($update_file);
				}
		}
	}
}

$a =new BlackListUpdateDeaddFileDownload();

$a->execute();