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
}