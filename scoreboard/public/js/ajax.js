
function getContent (element, url)
{
    if (window.XMLHttpRequest)
    {
        xmlhttp = new XMLHttpRequest();
    }
    
    else
    {
        xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
    }
    
    xmlhttp.onreadystatechange = function ()
    {
        if (this.readyState === 4 && this.status === 200)
        {
            element.innerHTML = xmlhttp.responseText;
        }
    };
    
    xmlhttp.open('GET', url, true);
    xmlhttp.send();
}

