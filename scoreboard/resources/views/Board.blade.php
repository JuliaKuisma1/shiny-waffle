<?php
    $_SESSION['login'] = false;
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Match view</title>
        <script src="js/ajax.js"></script>
        
        <style>
            #container {
                width: 500px;
                margin: auto;
                background-color: lightsalmon;
                box-shadow: 10px 10px grey;
                border: 2px solid lightcoral;
            }
            
            #userinfo {
                padding: 5px;
            }
            
            #body {
                border-radius: 25px;
                background-color: bisque;
                padding: 7px;
                width: 300px;
                margin: auto;
                text-align: center;
            }
            
            #header {
                text-align: center;
            }
            
            button {
                padding: 5px;
                margin-top: 5px;
            }
        </style>
        
    </head>
    <body>
    <div id="container">
        <div id="header">
            <h1>Scoreboard</h1>
        </div>
        <div id="body">
            <h2>Login form</h2>
            <p>Username: admin / password: password</p>
            <?php
            if(isset($_POST['submit']))
            {
                $username = $_POST['username']; 
                $password = $_POST['password'];

                if($username === 'admin' && $password === 'password')
                {
                    $_SESSION['login'] = true;
                    echo "<div class='alert alert-danger'>Logged in!</div>";
                }
                else 
                {
                    echo "<div class='alert alert-danger'>Wrong credentials!</div>";
                }
            }
            if (isset($_POST['logout']))
            {
                $_SESSION['login'] = false;
                echo "<div class='alert alert-danger'>Logged out!</div>";
            }
            ?>
            <table id="userinfo">
                <form method="post" action="">
                    <tr>
                        <td>
                            <label for="username">Username:</label>
                        </td>
                        <td>
                            <input <?php if($_SESSION['login'] == true) {?> disabled="disabled" <?php } ?>
                                type="text" class="form-control" id="username" name="username"> 
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="pwd">Password:</label>
                        </td>
                        <td>
                            <input <?php if($_SESSION['login'] == true) {?> disabled="disabled" <?php } ?>
                                type="password" class="form-control" id="pwd" name="password">
                        </td>
                    </tr>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <tr>
                        <td></td>
                        <td>
                            <button <?php if($_SESSION['login'] == true) {?> disabled="disabled" <?php } ?> 
                                type="submit" name="submit" class="btn btn-default">Login</button>
                            <button <?php if($_SESSION['login'] == false) {?> disabled="disabled" <?php } ?>
                                type="submit" name="logout" class="btn btn-default">logout</button>
                        </td>
                    </tr>
                </form>
            </table>
        </div>
        <button onclick="getContent(document.querySelector('#test'), 'test')"
            >Current game</button>
        <!--<button onclick="getContent(document.querySelector('#test'), 'past')"
            >Past games</button>-->
        <button onclick="getContent(document.querySelector('#test'), 'past')"
                >past games</button>
        <button <?php if($_SESSION['login'] == false) {?> disabled="disabled" <?php } ?>
            onclick="getContent(document.querySelector('#test'), 'add')"
            >Add data</button>
        <table id='test' style="text-align: center">
        </table>
        </div>
    </body>
</html>
