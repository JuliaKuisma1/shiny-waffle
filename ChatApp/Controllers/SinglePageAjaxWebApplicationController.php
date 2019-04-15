<?php
/**
 * Description of MVCExampleController
 *
 * @author turunent
 */
class SinglePageAjaxWebApplicationController
{
    public function __construct()
    {
        global $fpars;
        global $session;
        $fpars = new FormHandling(); // get form variables
        $session = new Session(); // create session object
        $model = new MVCExampleDatabase();
        
        // route actions
        switch ($fpars->act)
        {
            case "Chat":
                $fpars->chat = $fpars->message;
                $model->insert_chat($fpars->message);
                break;
            case "Login":
                $session->login = $model->LoggingIn();
                break;
            case "Logout":
                $session->login = ""; // logged out
                break;
            default:
                if (isset($fpars->ajax))
                {
                    switch ($fpars->ajax)
                    {
                    case "chat":
                        // handling ajax call
                        $message = json_decode(file_get_contents('php://input'), true);
                        $model->insert_chat($message); // insert into database

                        //send response to the browser
                        echo json_encode((object)["message" => $message]);
                        exit(0); // end php execution
                        break;
                    case "login":
                        $name = json_decode(file_get_contents('php://input'), true);
                        $model->LoggingIn($name); 
                        
                        //send response to the browser
                        echo json_encode((object)["value" => $name]);
                        exit(0); // end php execution
                        break;
                    case "logout":
                        break;
                    }
                }
        }
    }
}
