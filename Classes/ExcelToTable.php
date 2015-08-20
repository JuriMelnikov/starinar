<?php
class ExcelToTable{
    private $filepath;
    public function __construct($filepath)
    {
       
        $this->filepath=$filepath;
        echo "ExcelToTable-".$this->filepath;
    }
    private function readExelFile($filepath){
        echo "readExelFile";
        require_once('Classes/PHPExcel.php'); //подключаем наш фреймворк
        $ar=array(); // инициализируем массив
        $inputFileType = PHPExcel_IOFactory::identify($filepath);  // узнаем тип файла, excel может хранить файлы в разных форматах, xls, xlsx и другие
        $objReader = PHPExcel_IOFactory::createReader($inputFileType); // создаем объект для чтения файла
        $objPHPExcel = $objReader->load($filepath); // загружаем данные файла в объект
        $ar = $objPHPExcel->getActiveSheet()->toArray(); // выгружаем данные из объекта в массив
    return $ar; //возвращаем массив
    }
    public function getTable(){
        echo "<br>hello2!"; 
         $ar=$this->readExelFile($this->filename); 
         print_r($ar);
         $tab="<!DOCTYPE html>
                 <html lang='en'>
                 <head>
                 </head>
                 <body>
                    <p>Проверьте пожалуйста соответствие таблицы вашим ожиданиям. 
                    Если записи неправильные, то нажмите кнопку \"Отменить\" и 
                    отредактируйте загружаемый файл с именем ".basename($upFile)."</p>
                    <table border='1'>";

            foreach ($ar as $row => $ar_cols) {
                
                if($ar_cols[0]=='' && $row == 1){
                    $model=$ar_cols[1];
                    $tab.="<tr><td colspan='5'>Название модели: ".$model."</td></tr>
                    <tr><td>Nr. операции</td><td>Описание операции</td><td>Раздел</td><td>
                    Время</td><td>Пояснения</td><tr>";
                }
                if($ar_cols[0]!=''){
                    $serial=$ar_cols[0];
                    $descript=$ar_cols[1];
                    $section=$ar_cols[2];
                    $time=$ar_cols[3];
                    $price='';
                    $note=$ar_cols[4];
                    $tab.="<tr><td>".$serial."</td><td>".$descript."</td><td>"
                    .$section."</td><td>".$time."</td><td>".$note."</td></tr>";
                    
                }
            }
        $tab.="</table>
                <form method='post' action='upload.php'>
                    <input type='reset' id='cansel' value='Отменить''>
                    <input type='submit' id='onWrite' name='ok' value='Все верно, записать!''>
                    </form>
                </body>
                </html>"; 
        return $tab;
    }
    
        //echo "getTab-uploadFile=".$this->$file;
        //  require_once "Classes/PHPExcel.php"; //подключаем наш фреймворк
        //  $ar=array(); // инициализируем массив
        //  $inputFileType = PHPExcel_IOFactory::identify($this->uploadFile);  // узнаем тип файла, excel может хранить файлы в разных форматах, xls, xlsx и другие
        //  echo "getTab";$objReader = PHPExcel_IOFactory::createReader($inputFileType); // создаем объект для чтения файла
        //  $objPHPExcel = $objReader->load($this->uploadFile); // загружаем данные файла в объект
        //  $ar = $objPHPExcel->getActiveSheet()->toArray(); // выгружаем данные из объекта в массив
         
        //  $tab="<!DOCTYPE html>
        //          <html lang='en'>
        //          <head>
        //          </head>
        //          <body>
        //             <p>Проверьте пожалуйста соответствие таблицы вашим ожиданиям. 
        //             Если записи неправильные, то нажмите кнопку \"Отменить\" и 
        //             отредактируйте загружаемый файл с именем ".basename($upFile)."</p>
        //             <table border='1'>";

        //     foreach ($ar as $row => $ar_cols) {
                
        //         if($ar_cols[0]=='' && $row == 1){
        //             $model=$ar_cols[1];
        //             $tab.="<tr><td colspan='5'>Название модели: ".$model."</td></tr>
        //             <tr><td>Nr. операции</td><td>Описание операции</td><td>Раздел</td><td>
        //             Время</td><td>Пояснения</td><tr>";
        //         }
        //         if($ar_cols[0]!=''){
        //             $serial=$ar_cols[0];
        //             $descript=$ar_cols[1];
        //             $section=$ar_cols[2];
        //             $time=$ar_cols[3];
        //             $price='';
        //             $note=$ar_cols[4];
        //             $tab.="<tr><td>".$serial."</td><td>".$descript."</td><td>"
        //             .$section."</td><td>".$time."</td><td>".$note."</td></tr>";
                    
        //         }
        //     }
        // $tab.="</table>
        //         <form method='post' action='upload.php'>
        //             <input type='reset' id='cansel' value='Отменить''>
        //             <input type='submit' id='onWrite' name='ok' value='Все верно, записать!''>
        //             </form>
        //         </body>
        //         </html>"; 
        // return $tab;  
    //}
    
}