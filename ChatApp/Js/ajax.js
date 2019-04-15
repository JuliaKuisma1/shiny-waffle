/* 
 * jquery ajax call function
 */
function ajax(url, data, func, method="post", dtype="json", ctype="application/json")
{
    if (ctype == "application/json")
        data = JSON.stringify(data);
        $.ajax({
            url: url,
            data: data,
            type: method,
            dataType: dtype,
            contentType: ctype,
            success: func
        });
}


