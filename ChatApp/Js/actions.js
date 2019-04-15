/* 
 * Event handlers for UI buttons
 */
/* global message */
var messagelist = "";

function chat()
{
    //alert("Sending message!");
    //send data using ajax
    data = $("#message").val();
    ajax("index.php?ajax=chat", data, function()
    {
        if (name === "")
        {
            name = "anonymous";
        }
        
        if (messagelist === "")
        {
            messagelist = name+": "+data+" ("+new Date().toLocaleTimeString()+")\n";
        }
        else if (messagelist !== "")
        {
            messagelist += name+": "+data+" ("+new Date().toLocaleTimeString()+")\n";
        }
        $("#chat").html(messagelist);
    });}

function login()
{
    name = $("#user").val();
    alert("Logging in, "+name+"!");
    console.log(name);
    document.getElementById("user").style.visibility = "hidden";
    document.getElementById("loginbutton").style.visibility = "hidden";
    document.getElementById("logoutbutton").style.visibility = "visible";
    ajax("index.php?ajax=login", name, function()
    {
        $("#username").html("Logged as: "+name);
    });
}

function logout()
{
    name = "";
    document.getElementById("user").style.visibility = "visible";
    document.getElementById("loginbutton").style.visibility = "visible";
    document.getElementById("logoutbutton").style.visibility = "hidden";
    
    ajax("index.php?ajax=login", name, function()
    {
        $("#username").html("Logged out");
    });
}
