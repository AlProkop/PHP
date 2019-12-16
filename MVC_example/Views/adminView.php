<?php 
// ADMIN FORM
?>
        <?php      
            echo "Hello ".$session->admin."<br>".
             "You have access to Admin mode <br>".
             "Login time: ".$session->time."<br>";
        ?>
        <?=       // creates an interface (elements within the form)
            new Form(array(
              new Element("table", "", "", [
                  new Element("tr","","",[
                    new Element("th","","", "id"),
                    new Element("th","","", "fname"),
                    new Element("th","","", "sname")  
                  ]), 
                  new Element("tr","","",[
                    new Element("td","","", new Text("id")),
                    new Element("td","","", new Text("fname")),
                    new Element("td","","", new Text("sname"))
                  ])
              ]),
                "<br>",
              (new Element("div","","",[
                 new Element("table", "", "", [
                  new Element("tr","","",[
                    new Element("th","","", "user name"),
                    new Element("th","","", "priority"),
                    new Element("th","","", "password"),
                    new Element("th","","", "description")
                  ]), 
                  new Element("tr","","",[
                    new Element("td","","", new Text("user")),
                    new Element("td","","", new Text("pri")),
                    new Element("td","","", (new Text("passwrd"))->addAttribute("type", "password")), //type-password hides symbols
                    new Element("td","","", new Text("descrpt"))
                  ])]),
                "<br>",
                new Submit("list", "List"),
                new Submit("search", "Search"),
                new Submit("delete", "Delete"),
                new Submit("insert", "Insert"),
                new Submit("update", "Update")
            ]))));
        ?>