/* 
 * jquery ajax call function
 */
function ajax(url, data="", dtype="json", func, method="post", ctype="application/json")
{
    if (ctype == "application/json")
        data = JSON.stringify(data);
        $.ajax({
            url: url,
            data: data,
            type: method,
            dataType: dtype,
            contentType: ctype,
            success: func,
            error: function(XMLHttpRequest, textStatus, errorThrown) { 
                    alert("Status: " + textStatus); alert("Error: " + errorThrown); 
                } 
        });
}


