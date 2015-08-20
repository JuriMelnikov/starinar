  <?php
 print_r($_REQUEST);
 
//echo mb_convert_case('это строка', MB_CASE_TITLE, "UTF-8");
function autoload($className) {
	set_include_path('Classes/');
	spl_autoload($className); //replaces include/require
}
spl_autoload_extensions('.php');
spl_autoload_register('autoload');

include_once 'Classes/ToBase.php';

$base=new ToBase();
if(!$base->accessYes('L4')){
	$data["login"]=false;
	exit;
}
include_once 'Classes/Techmap.php';
include_once 'Classes/ModelsList.php';
include_once 'Classes/SectionsList.php';
$tm=new Techmap($base->getConnDB());
//echo "<br>Загружаем файл";

if(!function_exists('mb_ucfirst')) {
    function mb_ucfirst($str, $enc = 'utf-8') { 
    		return mb_strtoupper(mb_substr($str, 0, 1, $enc), $enc).mb_substr($str, 1, mb_strlen($str, $enc), $enc); 
    }
}
//echo "<br>Загружаем файл";

function sumNotes($value)
{
		$value=preg_replace('/,/', '.', $value);
		$res=explode('*', $value);
		if(!($res[0]=='' || $res[1]=='')){
			$multip=$res[0] * $res[1];
		}else{
			$multip=$res[0] + $res[1];
		}
	return $multip;
}

function noteParser($note,$serial,$descript,$section)
{
	$a=range('a','z');
	$notes=explode('+', $note);
	$descripts=explode(',', $descript);
	foreach ($notes as $key => $value) {
		$tab.="<tr><td>".$serial.'.'.($a[$key])."</td><td>".mb_ucfirst(trim($descripts[$key]))."</td><td>"
			.mb_ucfirst($section)."</td><td>".sumNotes($value)."</td></tr>";
		$i++;
	}
	return $tab;
}

function noteParserAddModel($note,$serial,$descript,$model,$time,$section)
{
	$a=range('a','z');
	$notes=explode('+', $note);
	$descripts=explode(',', $descript);
	foreach ($notes as $key => $value) {
		$serial=$serial.'.'.$a[$key];
		$descript=mb_ucfirst(trim($descripts[$key]));
		$model1=mb_ucfirst(trim($model));
		$section=mb_ucfirst($section);
		$time1=sumNotes($value);
		$tm->addTechmap($serial,$descript,$model1,$time1,$section);
		$i++;
	}
}

if(isset($_REQUEST['cancel'])){
	$dir=__DIR__."/uploads";
	$files=scandir($dir);
	foreach ($files as $value) {
		if($value !='.' and $value !=".."){
			$fileName=$value;
		}
	}
	$uploadfile=__DIR__."/uploads/$fileName";
	unlink($uploadfile);
	header('location:techmap.php');
}elseif(isset($_REQUEST['upload'])){
//echo "<br> Загружаем файл";
	if(!is_uploaded_file ( $_FILES['file']['tmp_name'])){
			$res= "Файл не загружен.".$phpFileUploadErrors[$_FILES['userfile']['error']];
			return false;
		}
//		echo "<br>Проверяем размер";
		if($_FILES['size']>10000000){
			$res= "Файл не загружен.".$phpFileUploadErrors[$_FILES['userfile']['error']];
			return false;
		}
	$originalName=basename($_FILES['file']['name']);
		$nameArray=explode('.', $originalName);
		$fileType=$nameArray[sizeof($nameArray)-1];
		$validFileTypes = array('xls','xlsx');
		$uploadfile = __DIR__."/uploads/".$originalName;
		if(in_array( strtolower($fileType), $validFileTypes)){
			if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
				echo $res= "Файл корректен и был успешно загружен.";
			} else {
				echo $res= "Файл не загружен.";
			}
		}

	require_once "Classes/PHPExcel.php"; //подключаем наш фреймворк
	$ar=array(); // инициализируем массив
	$inputFileType = PHPExcel_IOFactory::identify($uploadfile);  // узнаем тип файла, excel может хранить файлы в разных форматах, xls, xlsx и другие
	$objReader = PHPExcel_IOFactory::createReader($inputFileType); // создаем объект для чтения файла
	$objPHPExcel = $objReader->load($uploadfile); // загружаем данные файла в объект
	$ar = $objPHPExcel->getActiveSheet()->toArray(); // выгружаем данные из объекта в массив
	$tab="<!DOCTYPE html>
				 <html lang='en'>
				 <meta charset='utf-8'>
				 <head>
				    <link rel='stylesheet' href='./style/reset.css'>
				    <link rel='stylesheet' href='./style/upload.css'>
				 </head>
				 <body>
				 	<div id='container'>
				 	<div id='row1'>
						<p>Проверьте соответствие таблицы.</p>
						<p>Если записи неправильные, то нажмите кнопку \"Отменить\" и 
						отредактируйте файл с именем <span>".$originalName."</span></p>
						<p>Правила простые: 
							<ul>
								<li>- на второй строке во втором столбце напишите
								название модели.
								<li>- с пятой строки пишите названия операций. 
							</ul>
						</p>
						<p>Внимание! Все пронумерованные строки, начиная с пятой, будут добавлены в базу.
						</p>
					</div>
					<div id='row2'>
					<table>";
		foreach ($ar as $row => $ar_cols) {
			if($ar_cols[0]=='' && $row == 1){
				$model=$ar_cols[1];
				$tab.="
				<tr><td></td><td></td><td></td><td></td><tr>
				<tr class='tr-top'><td> </td><td>".$model."</td><td> </td><td> </td></tr>
				<tr><td></td><td></td><td></td><td></td><tr>
				<tr class='tr-tytle'><td>Nr.</td><td>Описание операции</td><td>Раздел</td><td>
				Время</td><tr>";
			}
			if($ar_cols[0]!=''){
				$serial=trim($ar_cols[0]);
				$descript=trim($ar_cols[1]);
				$section=trim($ar_cols[2]);
				$time=trim(preg_replace("/,/", ".", $ar_cols[3]));
				$note=trim($ar_cols[4]);
				if($note != ''){
					$tab.=noteParser($note,$serial,$descript,$section);
				}else{
					$tab.="<tr><td>".$serial."</td><td>".mb_ucfirst($descript)."</td><td>"
					.mb_ucfirst($section)."</td><td>".$time."</td></tr>";
				}
				
			}
		}
		 $tab.="</table>
		 		</div>
		 		<div id='row3'>
					<form method='post' action='upload.php'>
						<input type='submit' id='onCancel' name='cancel' value='Отменить''>
						<input type='submit' id='onWrite' name='ok' value='Все верно, записать в базу!''>
					</form>
				</div>
				</div>
				</body>
				</html>";
	echo $tab;
}elseif(isset($_REQUEST['ok'])){

	$dir=__DIR__."/uploads";
	$files=scandir($dir);
	foreach ($files as $value) {
		if($value !='.' and $value !=".."){
			$fileName=$value;
		}
	}
	//echo $fileName;
	$uploadfile=__DIR__."/uploads/$fileName";
	//require_once "auth/newMyClass.php";
	$base=new ToBase();
	require_once "Classes/PHPExcel.php"; //подключаем наш фреймворк
	$ar=array(); // инициализируем массив
	$inputFileType = PHPExcel_IOFactory::identify($uploadfile);  // узнаем тип файла, excel может хранить файлы в разных форматах, xls, xlsx и другие
	$objReader = PHPExcel_IOFactory::createReader($inputFileType); // создаем объект для чтения файла
	$objPHPExcel = $objReader->load($uploadfile); // загружаем данные файла в объект
	$ar = $objPHPExcel->getActiveSheet()->toArray(); // выгружаем данные из объекта в массив
	
		foreach ($ar as $row => $ar_cols){
			if($ar_cols[0]=='' && $row == 1){
				$model=trim(mb_convert_encoding($ar_cols[1], 'utf-8', mb_detect_encoding($ar_cols[1])));
			}
			if($ar_cols[0]!=''){
				$serial=trim(mb_convert_encoding($ar_cols[0], 'utf-8', mb_detect_encoding($ar_cols[0])));
				$descript=trim(mb_convert_encoding($ar_cols[1], 'utf-8', mb_detect_encoding($ar_cols[1])));
				$section = trim(mb_convert_encoding($ar_cols[2], 'utf-8', mb_detect_encoding($ar_cols[2])));
				$time=trim(mb_convert_encoding($ar_cols[3], 'utf-8', mb_detect_encoding($ar_cols[3])));
				$note=trim(mb_convert_encoding($ar_cols[4], 'utf-8', mb_detect_encoding($ar_cols[4])));
				if($note != ''){
					$a=range('a','z');
					$notes=explode('+', $note);
					$descripts=explode(',', $descript);
					foreach ($notes as $key => $value) {
						$serial1=$serial.'.'.$a[$key];
						$descript1=mb_ucfirst(trim($descripts[$key]));
						$model1=mb_ucfirst(trim($model));
						$section1=mb_ucfirst($section);
						$time1=sumNotes($value);
						$tm->addTechmap($serial1,$descript1,$model1,$time1,$section1);
					}
				}else{
					if($tm->addTechmap($serial,mb_ucfirst($descript),mb_ucfirst($model),$time,mb_ucfirst($section)))
						echo "ok";
				}
			}
		}
		 unlink($uploadfile);
		 header('location:techmap.php');
}
