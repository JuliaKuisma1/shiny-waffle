<?php

// class identitydatabase which extends PDO:
// PHP Data Objects
class IdentityDatabase extends PDO
{
    protected $connected;
    
    // constructor
    public function __construct($user="", $passwd="", $db="")
    {
        $this->connected = TRUE;
        include "Configurations/Mysql.php";
        
        try
        {
            // parent constructor: database name and host, username, password
            parent::__construct("mysql:dbname=$db;host=127.0.0.1", $user, $passwd);
            
        }
        catch (Exception $ex)
        {
            // connection false
            $this->connected = FALSE;
        }
    }
    // login function
    public function login($user, $passwd)
    {
        $stm = $this->prepare(
            // unsafe way, because of sql injections:
            // "select pri from serverside19_users where user = '".$_POST["user"]."' and pwd = '".md5($_POST["passwd"])."'");
            // $stm->execute();
            // more safer way is to use ?
            "select pri from serverside19_users where user = ? and pwd = ?");
        $stm->execute([$user, md5($passwd)]);

        // Fetches the next row and returns it as an object
        $res = $stm->fetchAll(PDO::FETCH_CLASS);
        // if res is longer than 0
        if (count($res) > 0)
        {
            return $res[0]->pri;
        }
        else // else fail
        {
            return FALSE;
        }
    }
    
    // search person function, taking as parameters: id, fname, sname and boolean clean
    public function search_person($id, $fname, $sname, $clean = TRUE)
    {
        // if clean is true
        if ($clean)
        {
            // prepare to run sql sentence that gets information out from database
            // via joining two tables
            $stm = $this->prepare(
                "select p.id, p.fname, p.sname, u.user, u.description from "
                    ."serverside19_persons as p left join serverside19_users as u "
                    ."on p.id = u.id "
                    ."where p.id = ?"
                    ." or p.fname = ? or p.sname = ?");
        }
        else 
        {
            // using like operator 
            $stm = $this->prepare(
                "select p.id, p.fname, p.sname, u.user, u.description from "
                    ."serverside19_persons as p left join serverside19_users as u "
                    ."on p.id = u.id where p.id like ?"
                    ." or p.fname like ? or p.sname like ?");
        }
        
        $stm->execute([$id, $fname, $sname]);
        // using fetch class from PDO
        $res = $stm->fetchAll(PDO::FETCH_CLASS);
        
        // if res is longer than zero
        if (count($res) > 0)
        {
            return $res;
        }
        else // fail
        {
            return FALSE;
        }
    }
    
    // function for deleting
    public function delete_person($id)
    {
        // using id to define deleted person
        $stm = $this->prepare(
            "delete  from serverside19_persons where id = ?");
        $stm->execute([$id]);
        // using PDO function 
        return $stm->rowCount();
    }
    
    // function for inserting
    public function insert_person($id, $fname, $sname, $uname, $pwd, $description)
    {
        // asking values: id, firstname and surname
        $stm = $this->prepare(
            //"insert into serverside19_persons values (?, ?, ?, ?, ?)");
                "insert into serverside19_persons"
                ."(id, fname, sname) values (?, ?, ?);");
        $stm->execute([$id, $fname, $sname]);
        $stm2 = $this->prepare(
            //"insert into serverside19_persons values (?, ?, ?, ?, ?)");
                "insert into serverside19_users"
                ."(user, pwd, pri, description, id) values (?, md5(?), ?, ?, ?);");
        $stm2->execute([$uname, $pwd, 1, $description, $id]);
        // using PDO function 
        return $stm->rowCount();
    }
}
