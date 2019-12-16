<?php 
// USER FORM
?>
        <?php
            echo "Hello ".$session->user."<br>".
             "You have access to User mode <br>".
             "Login time: ".$session->time."<br>";
        ?>
        
       <?=       // creates an interface (elements within the form)
            (new Span(array(
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
                  ])]),
            
                    "<br>",
                new Button("id_list", "List", "list()"),
                new Button("id_search", "Search", "search()"),
                new Button("id_insert", "Insert", "insert()"),
                new Button("id_update", "Update", "update()")
            )))->addAttribute("id", "form");
                ?>