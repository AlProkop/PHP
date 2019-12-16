<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Simple chat</title>
        <!-- for using jquery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <!-- own ajax function -->
        <script src="Js/ajax.js"></script>
        <script src="Js/actions.js"></script>
    </head>
    <body>
        <?=
        new Span(
                [(new Text("user_name"))
                    ->addStyle("display", $session->admin||$session->user?"none":"inline-block")
                ->addAttribute("id", "user_name"),
                  (new Text("password"))
                    ->addStyle("display", $session->admin||$session->user?"none":"inline-block")
                    ->addAttribute("id", "password")
                    ->addAttribute("type", "password"),
                (new Button("login", "Login", "login()"))
                    ->addStyle("display", $session->admin||$session->user?"none":"inline-block"),
                (new Button("logout", "Logout", "logout()"))
                    ->addStyle("display", $session->admin||$session->user?"inline-block":"none")
                ,//    new Button("t", "Test", "test()")
                ]);
        ?>
        <br><br>
        <div id="forms"></div>
        <div id="results"></div>
     
        </body>
</html>
