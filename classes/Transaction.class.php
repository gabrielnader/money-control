<?php
    $dir = realpath(__DIR__ . '/..');
    require_once $dir.'/config/config.php';
    require_once 'DB.class.php';
class Transaction {
    
    private $id;
    private $value;
    private $type;
    private $date;
    private $description;
    private $db;
    private $currentMoney;

    public function __construct($id){
        $this->db = new DB();
        $this->id = $id;
        $this->cacheTransaction();
    }
    public function cacheTransaction(){
        $db = $this->db;
        $search = $db->query("SELECT * FROM `transaction` WHERE `id`='$this->id'");
        if($row = $search->fetch()){
            $this->value = $row["value"];
            $this->type = $row["type"];
            $this->description = $row["description"];
            $this->date = $row["at"];
        }
    }
    public function getDay(){
        return date("d/m", strtotime($this->date));
    }
    public function getDescription(){
        return $this->description;
    }
    public function getValue(){
        return $this->value;
    }
    public function getType(){
        return $this->type;
    }
    public static function newTransaction($value, $date, $description, $type){
        $db = new DB();
        $id = $db->insertGetLastID("INSERT INTO `transaction` (`id`, `value`, `type`, `description`, `at`) VALUES (NULL, '$value', '$type', '$description', '$date')");
        $currentMoney = Transaction::getCurrentMoney();
        if($type == 0){
            $currentMoney += $value;
        }else{
            $currentMoney -= $value;
        }
        $db->query("INSERT INTO `total_money` (`id`, `money`) VALUES (NULL, '$currentMoney')");
        return new Transaction($id);
    }
    public static function getCurrentMoney(){
        $db = new DB();
        $getCurrentMoney = $db->query("SELECT `money` FROM `total_money` ORDER BY `id` DESC");
        if($row = $getCurrentMoney->fetch()){
            return $row["money"];
        }else{
            return 0;
        }
    }
    public static function getMonthString($month){
        $var = "";
        switch($month){
            case "01":
                $var = "Janeiro";
                break;
            case "02":
                $var = "Fevereiro";
                break;
            case "03":
                $var = "Março";
                break;
            case "04":
                $var = "Abril";
                break;
            case "05":
                $var = "Maio";
                break;
            case "06":
                $var = "Junho";
                break;
            case "07":
                $var = "Julho";
                break;
            case "08":
                $var = "Agosto";
                break;
            case "09":
                $var = "Setembro";
                break;
            case "10":
                $var = "Outubro";
                break;
            case "11":
                $var = "Novemebro";
                break;
            case "12":
                $var = "Dezembro";
                break;
        }
        return $var;
    }
    public static function getMonthBalance($month, $year){
        $db = new DB();
        $balance = 0;
        if($month < 10){
            $month = 0 . $month;
        }
        $search = $db->query("SELECT `value`, `type` FROM `transaction` WHERE YEAR(`at`)='$year' AND MONTH(`at`) = '$month'");
        while($row = $search->fetch()){
            if($row["type"] == "0"){
                $balance += $row["value"];
            }else{
                $balance -= $row["value"];
            }
        } 
        $return = ["month" => Transaction::getMonthString($month), "balance" => $balance];

        return $return;

    }
}