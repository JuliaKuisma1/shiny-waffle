<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class MVCController
{
    public function __construct()
    {
        // creating new database and form
        global $formData;
        global $session;
        
        $session = new Session();
        $identityDB = new IdentityDatabase();
        $formData = new FormHandling();

        // if users status is not set -> not logged in
        if (!isset($formData->status)) 
            {
                $formData->status = "Not logged in";
            }

        // switch case for buttons
        switch ($formData->act)
        {
            case "Login":
                $login = $identityDB->login($formData->user, $formData->passwd);
                
                // if pri is 0 in database -> login (admin login)
                if ($login === "0")
                {
                    // status is set
                    $formData->status = "Logged as Admin";
                }
                // login as normal user
                elseif ($login === 1)
                {
                     // status is set
                    $formData->status = "Logged as Normal user";
                }
                
                else
                {
                    $formData->status = "Not logged in";
                }

                break;

            case "Logout":
                // if user status is not logged in
                $formData->status = "Not logged in";
                break;

            case "Search":
                // using search_person function on IdentityDatabase
                // parameters id, fname and sname, user needs status logged in
                $rows = $identityDB->search_person($formData->id, $formData->fname, $formData->sname, $formData->status != "Logged in");

                if ($rows) 
                {
                    // checking each row for matching parameters
                    foreach ($rows as $row)
                    {
                        // creating <p> element for output
                        $formData->rows .= "<p>$row->id, $row->fname, $row->sname, $row->user, $row->description<p>";
                    }
                }
                break;

            case "Insert":
                // if person doesn't exist, insert it
                if ($identityDB->insert_person($formData->id, $formData->fname, $formData->sname, $formData->uname, $formData->description, $formData->pwd)>0)
                {
                    // displaying the result as <p> element
                    $formData->rows .= "<p>$formData->id, $formData->fname, $formData->sname, $formData->uname, $formData->description - inserted<p>";
                }
                // if some parameter already exists, it doesn't insert user to database
                else
                {
                    // displaying the result as "error"
                    // incase of id is matching!
                    $formData->rows .= "<p>$formData->id, $formData->fname, $formData->sname, $formData->uname, $formData->description - not inserted<p>";
                }
                break;

            case "Delete":
                // if id exists, using delete_person function
                if ($identityDB->delete_person($formData->id) > 0)
                {
                    // displays id of deleted person
                    $formData->rows .= "<p>$formData->id - deleted<p>";
                }

                // if can't delete person, diplay "error"
                else
                {
                    $formData->rows .= "<p>$formData->id - not deleted<p>";
                }
                break;
        }
    }
}

