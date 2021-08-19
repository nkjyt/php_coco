<?php
class DBhelper {
    private $pdo;
    const DSN = "mysql:host=localhost;dbname=co_19_356_99sv_coco_com";
    const USER = "co-19-356.99sv-c";
    const PASS = "Zv63jCKw";

    public function __construct(){
        try{
            $this->pdo = new PDO(self::DSN, self::USER, self::PASS);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, pdo::ERRMODE_EXCEPTION);   
        } catch (PDOException $e) {
            die("エラー：" . $e->getMessage());
        }
    }   
    
    public function isRegistered($uid){
        $sql = "SELECT registered FROM users WHERE uid = :uid";
        $stmt = $this-> pdo -> prepare($sql);
        $stmt -> execute(array(':uid' => $uid));
        $result = $stmt -> fetchAll(PDO::FETCH_ASSOC);
        if (empty($result)){
            return false;
        }
        return $result[0]['registered'];
    }

    public function queryUser($uid){
        $stmt = $this -> pdo -> prepare("SELECT * FROM users WHERE uid = ?");
        $stmt -> execute(array($uid));
        $result = $stmt -> fetchall(PDO::FETCH_ASSOC);
        return $result[0];
    }
    

//ログイントークン関係
    public function get_login_token($uid){
        $exist = $this -> pdo -> prepare("SELECT * FROM auto_login WHERE uid=?");
        $exist -> execute(array($uid));
        return $exist;
    }
    public function insert_login_token($token, $uid){
        $state=$this->pdo->prepare("INSERT INTO auto_login VALUES(?,?)");
        $state->execute(array(
            $uid,
            $token
        ));
    }
    public function update_login_token($token, $uid){
        $update_key = $this->pdo->prepare("UPDATE auto_login SET auto_login_key =? WHERE uid=?");
        $update_key->execute(array(
            $token,
            $uid
        ));
    }
}
?>