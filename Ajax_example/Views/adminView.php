        <?php
            $form = new Span(array(
              new Element("p","","", "Hello ".$session->admin."<br>".
             "You have access to Admin mode <br>".
             "Login time: ".$session->time."<br>"),  
  
                  new Element("table", "", "", [
                    new Element("tr","","",[
                    new Element("th","","", "id"),
                    new Element("th","","", "fname"),
                    new Element("th","","", "sname")  
                  ]), 
                  new Element("tr","","",[
                    new Element("td","","", (new Text("id"))->addAttribute("id", "id")),
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
                new Button("id_list", "List", "list()"),
                new Button("id_search", "Search", "search()"),
                new Button("id_delete", "Delete", "del()"),
                new Button("id_insert", "Insert", "insert()"),
                new Button("id_update", "Update", "update()")
            ]))));
            $form->addAttribute("id", "form1");
            echo $form;
        ?>