<?php
define('TMP_UPLOAD_FOLDER','/Users/kameokamasaki/Downloads/test/tmp/add');

class BlackListUpdateAddFileDownload{
	
	function execute(){
		
		//ディレクトリ内のファイルを取り出す
		$filelist=scandir(TMP_UPLOAD_FOLDER);
		
		foreach ($filelist as $file){
			if(strpos($file, 'add_blacklist_id') !== FALSE){
				$update_file = TMP_UPLOAD_FOLDER.'/'.$file;
				header('Content-Disposition: inline; filename="'.$update_file.'"');
				header('Content-Length: '.$content_length);
				header('Content-Type: application/octet-stream');
				readfile($update_file);
			}
		}
	}
}

$a =new BlackListUpdateAddFileDownload();

$a->execute();