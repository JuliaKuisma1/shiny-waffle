<?php
/**
 * Description of OwnDatabase
 *
 * @author turunent
 */

class MVCExampleDatabase extends PDO
{
    protected $connected;
    public function __construct($user="", $passwd="", $db="")
    {
        $this->connected = TRUE;
        include "Configurations/Mysql.php";
        try
        {
            parent::__construct("mysql:dbname=$db;host=127.0.0.1", $user, $passwd);
            
        }
        catch (Exception $ex)
        {
            $this->connected = FALSE;
        }
    }
    
    public function insert_chat($message)
    {
        $sql = "insert into serverside19_chatMessages values (?)";
        
        $stm = $this->prepare($sql);
        $stm->execute([$message]);
    }
    
    public function get_chat_messages($count = -1)
    {
        $sql = "select * serverside19_chatMessages";
        
        $stm = $this->prepare($sql);
        $stm->execute([$message]);
        return $stm->fetchAll(PDO::FETCH_CLASS);
    }
    
    public function LoggingIn($name) {
        if (isset($name))
        {
            $login = "Logged in";
            return $login;
        }
        
        else
        {
            return "Not logged in";
        }
    }
}
