<?php
/**
 * паттерн Singleton
 *
 */
class DBH
{
    /**
     * Статическая переменная, в которой мы
     * будем хранить экземпляр класса
     *
     * @var DBH
     */
    protected static $_DBH;
    private $dbname="jvmee_starinar";
    private $pass="Starinar=Nikitin";
    private $user="jvmee_starinar";
    private $host="%";
    private $port = "";
     
    /**
     * Закрываем доступ к функции вне класса.
     * Паттерн Singleton не допускает вызов
     * этой функции вне класса
     *
     */
    private function __construct(){
        /**
         * При этом в функцию можно вписать
         * свой код инициализации. Также можно
         * использовать деструктор класса.
         * Эти функции работают по прежднему,
         * только не доступны вне класса
         */
    try { 
        $DBH = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->user, $this->pass);
        //$connDB=mysql_connect($this->host.':'.$this->port,$this->user, $this->pass); 
        $DBH->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING ); 
    }catch(PDOException $e) {  
        echo "Проблемы подключения к базе"; 
        file_put_contents('PDOErrors.txt', $e->getMessage(), FILE_APPEND);  

    }
    $this->_DBH=$DBH;
    }
 
    /**
     * Закрываем доступ к функции вне класса.
     * Паттерн Singleton не допускает вызов
     * этой функции вне класса
     *
     */
    private function __clone(){
    }
    /**
     * Статическая функция, которая возвращает
     * экземпляр класса или создает новый при
     * необходимости
     *
     * @return DBH
     */
    public static function connDB() {
        // проверяем актуальность экземпляра
        if (null === self::$_DBH) {
            // создаем новый экземпляр
            self::$_DBH = new self();
        }
        // возвращаем созданный или существующий экземпляр
        return self::$_DBH;
    }
}