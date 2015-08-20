<?php
class UploadFile{
	// private $phpFileUploadErrors = array(
	// 		0 => 'Ошибок не возникло',
	// 		1 => 'Размер принятого файла превысил максимально допустимый размер, который задан директивой upload_max_filesize конфигурационного файла php.ini',
	// 		2 => 'Размер загружаемого файла превысил значение MAX_FILE_SIZE, указанное в HTML-форме.ё',
	// 		3 => 'Загружаемый файл был получен только частично.',
	// 		4 => 'Файл не был загружен.',
	// 		6 => 'Отсутствует временная папка.',
	// 		7 => 'Не удалось записать файл на диск.',
	// 		8 => 'Не удалось записать файл на диск.',
	// 	);
	// private $uploadFile;

	// public function __construct(){
	// 	echo "UploadFile класс";
	// 	if(!is_uploaded_file ( $_FILES['file']['tmp_name'])){
	// 		echo $res= "Файл не загружен.".$phpFileUploadErrors[$_FILES['userfile']['error']];
	// 		return false;
	// 	}
	// 	//echo "UploadFile класс2";
	// 	if($_FILES['size']>10000000){
	// 		echo $res= "Файл не загружен.".$phpFileUploadErrors[$_FILES['userfile']['error']];
	// 		return false;
	// 	}
	// 	$originalName=basename($_FILES['file']['name']);
	// 	$nameArray=explode('.', $originalName);
	// 	$fileType=$nameArray[sizeof($nameArray)-1];
	// echo "fileType=".$fileType."<br>";
	// 	$validFileTypes = array('xls','xlsx');
	// 	$uploadFile = __DIR__."/uploads/". $originalName;
	// 		if(in_array( strtolower($fileType), $validFileTypes)){
	// 			move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile);
	// 			$this->uploadFile=$uploadFile;
	// 			echo $res= "Файл корректен и был успешно загружен.";
	// 			return true;
	// 		} else {
	// 			echo $res= $phpFileUploadErrors[$_FILES['userfile']['error']];
	// 			return false;
	// 		}
	// }
	// public function getUploadFile()
	// {
	// 	return $this->uploadFile;
	// }
	public function noteParser($note,$serial,$descript,$section)
	{
		$notes=explode('+', $note);
		pritn_r($notes);
		$descripts=explode(',', $descript);
		$i=1;
		foreach ($notes as $key => $value) {
			$tab.="<tr><td>".$serial.'.'.$i."</td><td>".$descripts[$i]."</td><td>"
				.$section."</td><td>".$notes[$i]."</td><td> </td></tr>";
				
		}
		return $tab;


	}
	
}