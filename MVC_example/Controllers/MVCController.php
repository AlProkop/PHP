<?php

class MVCController
{
    public function __construct()
    {
        global $fpars;
        global $session;
        $fpars = new FormHandling(); // get form variables
        $session = new Session(); // create session object       
        $model = new MVCDatabase(); // create the database connection   
        date_default_timezone_set('Europe/Helsinki');
    
        if($fpars->login) // if button "Login" was pressed 
            { 
                //get a priority and set a session var with "admin" ir "user" value
                //and fix a time when a client was logged    
                $prior = $model->get_prior($fpars->user_name, $fpars->password);
                switch ($prior)
                {
                    case 0:
                        $session->admin = $fpars->user_name; //set the session's variables
                        $session->time = date("H:i:s");            
                        break;
                    case "1":
                        $session->user = $fpars->user_name; 
                        $session->time = date("H:i:s");    
                        break;
                } 
            }
            
            //loading login form and one of three another form. It depends on login result
            
            include 'Views/loginView.php';     
            //if admin was logged -> add admin form and results of a last searching
            //conditions of searching is stored as a session element of array $_SESSION["search"]
            if($session->admin) 
            {include 'Views/adminView.php';
            
            $res = $model->get_all($session->search->id, $session->search->fname,
               $session->search->sname, $session->search->user, $session->search->pri);
                foreach ($res as $user)
                {
                    echo "<br>Results:<br>Id: ".$user->id. " Name: ".$user->fname."  ".$user->sname
                                ." Username: ". $user->user
                                ." Priority: ". $user->pri
                                ." Description: ".$user->description." <br>";
                }
            }
            //the same operation is running in the user mode
            else if($session->user)
            {
                include 'Views/userView.php';
                $res = $model->get_person($session->search->id, $session->search->fname, $session->search->sname);
                foreach ($res as $person)
                {
                    echo "<br>Person: ".$person->id." ".$person->fname." ".$person->sname;
                }
            }
            // if there was no loggin operations show unogged form
            else 
                include 'Views/unloggedView.php';

            //if button "Logout" was pressed
        if($fpars->logout)
        {   
            session_unset(); //remove the session var
            session_destroy(); // and destroy the session
            header("Refresh:0"); // refresh the page to show login form immediately
          }
            
          
       // list of all records in the DB
        if($fpars->list)
        {
            if ($session->admin) //admin mode
            {
                $res = $model->listAll();
                foreach ($res as $user)
                {
                    echo "Id: ".$user->id. " Name: ".$user->fname."  ".$user->sname
                                ." Username: ". $user->user
                                ." Priority: ". $user->pri
                                ." Description: ".$user->description." <br>";
                }
            }
            else //user and unlogged mode
            {
                $res = $model->listPersons();
                foreach ($res as $person)
                    echo "Person: ".$person->id." ".$person->fname." ".$person->sname." <br>";
            }
        }
        
        //inserting
        if($fpars->insert)
        {
            if ($session->admin)
            { 
                if ($fpars->id&&$fpars->user)
                {
                    $res = $model->adminInsert($fpars->id, $fpars->fname, $fpars->sname, $fpars->user, $fpars->pri,
                    $fpars->passwrd, $fpars->descrpt);
                    if ($res == null)  // no errors
                        echo 'Done.';
                    else 
                        echo 'Error  '.$res; //description of error
                }
                else echo "Fill-in at least an Id and User!";
            }
            if($session->user)
            {
                if ($fpars->id)
                {
                    $res = $model->userInsert($fpars->id, $fpars->fname, $fpars->sname);
                    if ($res == null)  // no errors
                        echo 'Done.';
                    else 
                        echo 'Error  '.$res; //description of error
                }
                else echo "Fill-in at least an Id!";  
            }
        }
        
        //searching
        if ($fpars->search)
        { 
            $session->search = $fpars;  //$frars stores conditions of searching. 
                                        //$session->search will be used to restore searching results during the session
            if($session->admin)
            {   
                             
                $res = $model->get_all($fpars->id, $fpars->fname, $fpars->sname, $fpars->user,$fpars->pri);
                foreach ($res as $user)
                {
                    echo "<br>Results:<br>Id: ".$user->id. " Name: ".$user->fname."  ".$user->sname
                                ." Username: ". $user->user
                                ." Priority: ". $user->pri
                                ." Description: ".$user->description." <br>";
                }
            }
            else
            {
                $res = $model->get_person($fpars->id, $fpars->fname, $fpars->sname);
                foreach ($res as $person)
                {
                    echo "<br>Person: ".$person->id." ".$person->fname." ".$person->sname;
                }         
            }
        }
        //updating
        if($fpars->update)
        {
            if($session->admin)
            {
                if ($fpars->id&&$fpars->user)
                {
                    $res = $model->adminUpdate($fpars->id, $fpars->fname, $fpars->sname, $fpars->user, $fpars->pri,
                    $fpars->passwrd, $fpars->descrpt);
                    if ($res == null)  // no errors
                        echo 'Done.';
                    else 
                        echo 'Error  '.$res; //description of error
                }
                else echo "Fill-in at least an Id and User!";  
            }
            if($session->user)
            {
                if ($fpars->id)
                {
                    $res = $model->userUpdate($fpars->id, $fpars->fname, $fpars->sname);
                    if ($res == null)  // no errors
                        echo 'Done.';
                    else 
                        echo 'Error  '.$res; //description of error
                }
                else echo "Fill-in at least an Id!";  
            }
        }
        
        //deleting
        if($fpars->delete)
        {
            if ($fpars->id)
            {
                $res = $model->delete($fpars->id);
                var_dump($res);
                if ($res == null)  // no errors
                    echo 'Done.';
                else 
                    echo 'Error  '.$res; //description of error
            }
            else echo "Fill-in at least an Id!";  
        }
    }
}
