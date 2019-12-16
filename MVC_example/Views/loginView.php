<!--The very first form index.php call -->
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="Styles/style.css" rel="stylesheet">
        <title></title>
    </head>
    <body>
        <div>                
            <?= (new Element("fieldset", "", "",[
                          new Element("legend", "", "", "Login"),
                          new Form([
                           "Username: ", new Text("user_name"),
                           "Password: ", (new Text("password"))->addAttribute("type", "password"),
                           "<br><br>",
                           new Submit("login", "Login")
                           ])]))
                         ->addAttribute("id", "login")       
                        ->addStyle("visibility", $session->admin||$session->user?"hidden":"visible"); 
             ?>
             <?=(new Form(new Submit("logout", "Logout")))
                     ->addStyle("visibility", $session->admin||$session->user?"visible":"hidden")
                     ->addAttribute("id", "logout");
             ?>
  
        </div>
                
    </body>
</html>

