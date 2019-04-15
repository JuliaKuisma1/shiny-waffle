<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Simple Chat App</title>
        <!-- for using jquery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <!-- own ajax function -->
        <script src="Js/ajax.js"></script>
        <script src="Js/actions.js"></script>
        <!-- Stylesheet used -->
        <link rel="stylesheet" type="text/css" href="./Styles/Style.css">
    </head>
    <body>
        <div id="container">
            <div id="header">
                <h1>Simple Chat App</h1>
            </div>
            <h3>Sign in or continue as anonymous:</h3>
            <div id="username">Not logged in</div>
            
            <!-- login form -->
            <?=
            new Span(
                    [(new Text("user"))
                        ->addAttribute("id", "user"),
                        "<br>",
                    (new Button("act", "Login", "login()"))
                        ->addAttribute("id", "loginbutton"),
                    (new Button("act", "Logout", "logout()"))
                        ->addAttribute("id", "logoutbutton")
                        ->addStyle("visibility", "hidden")]
                    );
            ?>
            <!-- chat form -->
            <?=
            new Span(
                    [(new Div("info"))
                        ->addContent("Write your response:")
                        ->addAttribute("id", "info"),
                    (new Text("message"))
                        ->addAttribute("id", "message"),
                        "<br>",
                   (new Button("act", "Chat", "chat()")),
                        "<br>",
                   (new Textarea("chat"))
                        ->addAttribute("readonly")
                        ->addContent($fpars->chat)
                        ->addAttribute("id", "chat"),
                    ]);
            ?>
            <br>
        </div>
    </body>
</html>
