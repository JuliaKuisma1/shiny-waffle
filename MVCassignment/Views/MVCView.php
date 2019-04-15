<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="Styles/MVCStyle.css">
        <title>Person Identity Data Handling</title>
    </head>
    <body>
        <table>
            <tr>
                <td>
              <!--
              First displaying users status (logged in or out).
              There are table that wraps the whole structure.
              Wanted to add different colors to logged in and out texts...
              -->
              
        <?= new Form([
            (new Text("status", $formData->status))
                ->addAttribute("readonly")
                ->addAttribute("id", "status")
                ->addStyle("font-weight", "bold")
                ->addStyle("border-width", 0)
                ->addStyle("font-size", "large")
                ->addStyle("color", "red"),
            "</td>", "</tr>", 
            
            // username and password fields
            // also login and logout buttons
            // these elements didn't like table rows, so needed to take them out
            // login and logout buttons aren't visible at the same time
            // their visibility debends on status
            "<tr>", "<td>",
            (new Element("span", "", "", [
                "Username: ", new Text("user"), "<br>",
                "Password: ", new Password("passwd"), "<br>",
                (new Submit("act", "Login"))
                ->addAttribute("class", "button")
                ->addAttribute("id", "login")
                ]))
                ->addStyle("visibility", ($formData->status)=="Not logged in"?"visible":"hidden"),
                (new Submit("act", "Logout"))
                ->addStyle("visibility", ($formData->status)=="Not logged in"?"hidden":"visible")
                ->addAttribute("class", "button")
                ->addAttribute("id", "logout"),
            "</td>", "</tr>", 
            
            // text to descripe actions
            "<tr>", "<td>",
                "<h3>Insert, search or delete persons<h3>",
            "</td>", "</tr>", 
            
            // Person id field
            "<tr>", "<td>",
                "Person Id: ","</td>", "<td>", new Text("id"),
            "</td>", "</tr>", 
            
            // forname field
            "<tr>", "<td>",
                "Forename: ", "</td>", "<td>", new Text("fname"),
            "</td>", "</tr>", 
            
            // surname field
            "<tr>", "<td>",
                "Surname: ","</td>", "<td>", new Text("sname"), 
            "</td>", "</tr>", 
            
            // username field
            "<tr>", "<td>",
                "Username: ","</td>", "<td>", new Text("uname"), 
            "</td>", "</tr>", 
            
            // description field
            "<tr>", "<td>",
                "Description: ","</td>", "<td>", new Text("description"), 
            "</td>", "</tr>", 
            
            // password field
            "<tr>", "<td>",
                "Password: ","</td>", "<td>", new Password("pwd"), 
            "</td>", "</tr>", 
            
            // search, insert and delete buttons, hidden if user is logged out
            "<tr>", "<td>",
            new Submit("act", "Search"),
                (new Element("span", "", "", [
                new Submit("act", "Insert"),
                new Submit("act", "Delete")
                ]))
                ->addStyle("visibility", ($formData->status)=="Not logged in"?"hidden":"visible"),
            "</td>", "</tr>",
            "<tr>", "<td>",
            // at the end it displays data
            $formData->rows
        ]);
        ?>
            </tr></td></table>
    </body>
</html>
