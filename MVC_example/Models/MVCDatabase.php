<?php

class MVCDatabase extends PDO
{
    public $connected;  
    public function __construct($user="", $passwd="", $db="")  
    {
        $this->connected = TRUE; //by default flag is true
        include "Configurations/Mysql.php";  // file with a db name, a user name, a password 
        try
        {
            parent::__construct("mysql:dbname=$db;host=127.0.0.1", $user, $passwd); //trying to connect to the database
        }
        catch (Exception $ex)
        {
            echo "Error. Connection is failed";
        }
    }
    
    // getting priority that means rights to log in
    public function get_prior($user, $passwd){    
        $stm = $this->prepare(        // prepare an SQL query
            "select pri from serverside19_users where user = ? and pwd = ?;");
        $stm->execute([$user, md5($passwd)]);  //execute query
        $res = $stm->fetchAll(PDO::FETCH_CLASS);  //$res contains the result rows of the data
        if (count($res) > 0)
            return $res[0]->pri;
        else
            return "-1"; // priority was't found
    }

    //list data from table "serverside19_persons")
    public function listPersons() {
        $stm = $this->prepare("select id, fname, sname from serverside19_persons");
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_CLASS); 
    }
    //list data from table "serverside19_persons")
    public function listAll() {
        $stm = $this->prepare("select p.id, p.fname, p.sname, u.user, u.pri, u.description from"
                    . " serverside19_persons as p left join serverside19_users as u"
                    . " on p.id = u.id");
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_CLASS); 
    }
    
    // searching the data of the persons in the "guest" and "user" mode (just from one table "serverside19_persons")
    public function get_person($id, $fn, $sn)
    {
        //db's records can contain empty fields, 
        //so if function gets parameters with ""-value it leads to the wrong results. 
        //to avoid it change empty value to some unusable value
        $fn=($fn=="")?"-":$fn;   
        $sn=($sn=="")?"-":$sn;
        $stm = $this->prepare(     
                "select id, fname, sname from serverside19_persons where "
                . "id = :id or fname = :fname or sname = :sname");            
        $stm->execute(array(':id' => $id, ':fname' => $fn, ':sname' => $sn)); 
        return $stm->fetchAll(PDO::FETCH_CLASS); 
    }
    
    // searching the data of the persons in the "login" mode from both tables
    public function get_all($id, $fn, $sn, $un, $pri)
    {
        //db's records can contain empty fields, 
        //so if function gets parameters with ""-value it leads to the wrong results. 
        //to avoid it change empty value to some unusable value
        $fn=($fn=="")?"-":$fn;   
        $sn=($sn=="")?"-":$sn;  
        $pri=($pri=="")?"-1":$pri;
        //now it ok to get data from the the db
         $stm = $this->prepare(
                "select p.id, p.fname, p.sname, u.user, u.pri, u.description from"
                    . " serverside19_persons as p left join serverside19_users as u"
                    . " on p.id = u.id where p.id = :id or p.fname = :fname"
                    . " or p.sname = :sname or u.user = :un or u.pri = :pri");
        $stm->execute(array(':id' => $id, ':fname' => $fn, ':sname' => $sn,
            ':un' => $un, ':pri' => $pri));
        return $stm->fetchAll(PDO::FETCH_CLASS);
    }
    
    //inserting data
    public function adminInsert($id, $fn, $sn, $un, $pri, $pwd, $discr)
    {
       
        //into the table serverside19_persons
        $stm1 = $this->prepare(    
                "insert into serverside19_persons values (?,?,?)"); 
        $stm1->execute([$id, $fn, $sn]);
        
        //into the table serverside19_users
        $stm2 = $this->prepare(
                "insert into serverside19_users values (?,?,?,?,?)"); 
        $stm2->execute([$un, md5($pwd), $pri, $id, $discr]);
      
        //collecting possible errors
        if(($err1=$stm1->errorInfo()[2])!=NULL)
            $err1="<br>1 query - ".$err1;
        if(($err2=$stm2->errorInfo()[2])!=NULL)
           $err2="<br>2 query - ".$err2;
        return $err1.$err2; //info about error (if it exists) 
    }
    public function userInsert($id, $fn, $sn)
    {
        //into the table serverside19_persons
        $stm1 = $this->prepare(    
                "insert into serverside19_persons values (?,?,?)"); 
        $stm1->execute([$id, $fn, $sn]);
     
        //collecting possible errors
        return $stm1->errorInfo()[2];//info about error (if it exists) 
        }
    
    //deleting data using Id
    public function delete($id)
    {
        $stm = $this->prepare("delete from serverside19_persons where id = ?");
        $stm->execute([$id]);
        return $stm->errorInfo()[2];
    }

    //updating data
    public function adminUpdate($id, $fn, $sn, $un, $pri, $pwd, $discr)
    {
        // in the table serverside19_users
        $stm1 = $this->prepare(
                "update serverside19_users "
                . "set user = ?, pwd =?, pri = ?, description = ?"
                . "where id = ?");
        $stm1->execute([$un, md5($pwd), $pri, $discr, $id]);
        
        // in the table serverside19_persons
                $stm2 = $this->prepare(
                "update serverside19_persons "
                . "set fname =?, sname = ? where id = ?"); 
        $stm2->execute([$fn, $sn, $id]);
        
        //collecting possible errors
        if(($err1=$stm1->errorInfo()[2])!=NULL)
            $err1="<br>1 query - ".$err1;
        if(($err2=$stm2->errorInfo()[2])!=NULL)
           $err2="<br>2 query - ".$err2;
        return $err1.$err2; //info about error (if it exists) 
    }
    public function userUpdate($id, $fn, $sn)
    {
        // in the table serverside19_persons
                $stm2 = $this->prepare(
                "update serverside19_persons "
                . "set fname =?, sname = ? where id = ?"); 
        $stm2->execute([$fn, $sn, $id]);
        return $stm2->errorInfo()[2];
        
    }
}