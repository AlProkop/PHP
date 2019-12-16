<?php 
// USER FORM
?>
        <?php
            echo "Hello ".$session->user."<br>".
             "You have access to User mode <br>".
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
                  ])]),
            
                    "<br>",
                new Submit("list", "List"),
                new Submit("search", "Search"),
                new Submit("insert", "Insert"),
                new Submit("update", "Update")
            ));
                ?>