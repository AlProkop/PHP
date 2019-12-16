<?php

class AjaxController
{
    public function __construct()
    {
        global $fpars;
        global $session;
        $fpars = new FormHandling(); // get form variables
        $session = new Session(); // create session object
        $model = new MVCDatabase();
        date_default_timezone_set('Europe/Helsinki');
                if (isset($fpars->ajax))  
                {
                    switch ($fpars->ajax)   //route
                    {
                    case "login":
                    
                       $data = json_decode(file_get_contents('php://input'), true); //serverside gets json and decode it
                       $prior = $model->get_prior($data['name'], $data['pass']);    // gets priority
                       if($prior==-1)       // -1 is a guest mode
                       {echo "guest";}      // sends data back to a client 
                        if($prior==0)       // admin   
                        {
                            $session->admin = $data['name']; //sets the session's variables
                            $session->time = date("H:i:s");  // time when session was started 
                            require 'Views/adminView.php';   // shows admin form
                        }
                        if($prior==1)    //user
                        {    
                            $session->user = $data["name"]; //the same actions as admin has 
                            $session->time = date("H:i:s");
                            require 'Views/userView.php';
                        }
                        
                        $session->prior = $prior;  //stores priority in order to know
                                                    //which of three froms must be loaded after client refreshes page
                                                    //or re-opens it  (case "load")  
                        exit(0); 
                    break;
                        
                    case "logout":
                        session_unset(); //remove the session var
                        session_destroy(); // and destroy the session
                        require 'Views/unloggedView.php';
                        
                        exit(0);
                        break;
                    
                    case "load":                   //when the page was looad there must be some of three forms on it
                         if($session->prior!=NULL)
                        {
                            if($session->prior==0)
                            {
                                require 'Views/adminView.php';
                            }
                            if($session->prior==1)
                            {    
                                require 'Views/userView.php';
                            } 
                            if($session->prior==-1)
                            {    
                                require 'Views/unloggedView.php';
                            }
                        }
                        else   //the very first time when page was loaded (there is no $session->prior)
                            require 'Views/unloggedView.php';
                        exit(0);
                        break;
                        
                    case "showSearch":
                        if ($session->search!=NULL)   //$session->search stores search results
                        {echo $session->search;}      //adds search results to the page  
                        exit(0);
                        break;
                      
                    case "list":   // shows all records
                        if ($session->admin) //admin mode
                        {
                            $res = $model->listAll();
                            foreach ($res as $user)
                            {
                                $res1 .= "<br>Id: ".$user->id. " Name: ".$user->fname."  ".$user->sname
                                            ." Username: ". $user->user
                                            ." Priority: ". $user->pri
                                            ." Description: ".$user->description." <br>";
                            }
                        }
                        else //user and unlogged mode
                        {
                            $res = $model->listPersons();
                            foreach ($res as $person)
                                $res1 .= "<br>Person: ".$person->id." ".$person->fname." ".$person->sname." <br>";
                        }
                        echo $res1;
                        exit(0);
                        break;    
                        
                    case "insert":
                       $data = json_decode(file_get_contents('php://input'), true);
                        if ($session->admin)
                        { 
                            if (($data["2"]!="")&&($data["5"]!=""))
                            {
                                $res = $model->adminInsert($data["2"], $data["3"], $data["4"], $data["5"], $data["6"],
                                $data["7"], $data["8"]);
                                if ($res == null)  // no errors
                                    echo 'Done.';
                                else 
                                    echo 'Error  '.$res; //description of error
                            }
                            else echo "Fill-in at least an Id and User!";
                        }
                        if($session->user)
                        {
                            if ($data["2"]!="")
                            {
                                $res = $model->userInsert($data["2"], $data["3"], $data["4"]);
                                if ($res == null)  // no errors
                                    echo 'Done.';
                                else 
                                    echo 'Error  '.$res; //description of error
                            }
                            else echo "Fill-in at least an Id!";  
                        }
                        exit(0);
                    break;    
                    
                    case "search":
                        $data = json_decode(file_get_contents('php://input'), true);
                        if ($session->admin)
                        {
                            $searchResult = $model->get_all($data["2"], $data["3"], $data["4"], $data["5"], $data["6"]);
                            $res1 = "<br>Results:<br>";
                            foreach ($searchResult as $user)
                                $res1 .=  "Id: ".$user->id. " Name: ".$user->fname."  ".$user->sname
                                ." Username: ". $user->user
                                ." Priority: ". $user->pri
                                ." Description: ".$user->description." <br>";   
                        }
                        else
                        {
                            $searchResult = $model->get_person($data["2"], $data["3"], $data["4"]);
                            foreach ($searchResult as $person)
                                $res1 .=  "Results:<br>Id: ".$person->id. " Name: ".$person->fname."  ".$person->sname;
                        }
                        $session->search = $res1;
                        echo $res1;    //sends results back to the client side
                            exit(0);
                            break;
                     
                    case "delete":
                        $id = file_get_contents('php://input'); //gets id from server
                        if($id!="")
                        {
                            $res = $model->delete($id); 
                            if ($res == null)  // no errors
                                echo 'Done.';
                            else 
                                echo 'Error  '.$res; //description of error
                        }
                        else echo "Fill-in at least an Id!"; 
                        exit(0);
                        break;
                        
                    case "update":
                        $data = json_decode(file_get_contents('php://input'), true); //gets array ("input" values)
                        if ($session->admin)
                        {
                        $res = $model->adminUpdate($data["2"], $data["3"], $data["4"], $data["5"], $data["6"],
                            $data["7"], $data["8"]);
                        if ($res == null)  // no errors
                            echo 'Done.';
                        else 
                            echo 'Error  '.$res; //description of error

                        }
                        else echo "Fill-in at least an Id and User!";
                        
                        if($session->user)
                        {
                            if ($data["2"]!="")
                            {
                                $res = $model->userInsert($data["2"], $data["3"], $data["4"]);
                                if ($res == null)  // no errors
                                    echo 'Done.';
                                else 
                                    echo 'Error  '.$res; //description of error
                            }
                            else echo "Fill-in at least an Id!";  
                        }
                        exit(0);
                    break;             
             }        
        }
    }
}