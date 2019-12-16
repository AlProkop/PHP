<?php 
// GUEST FORM
?>
        <?=       // creates an interface (elements within the form)
            new Form(array("Guest mode",
              (new Element("table", "", "", [
                  new Element("tr","","",[
                    new Element("th","","", "id"),
                    new Element("th","","", "fname"),
                    new Element("th","","", "sname")  
                  ]), 
                  new Element("tr","","",[
                    new Element("td","","", new Text("id")),
                    new Element("td","","", new Text("fname")),
                    new Element("td","","", new Text("sname")),
                    new Element("td","","", new Submit("search", "Search")),
                    new Element("td","","", new Submit("list", "List"))
                  ])
              ])))); 
        ?>