// after the page was loaded browser sends ajax query
//and gets a form (admin, user, or guest) and search results if they exist
$(function() {
    $.post("index.php?ajax=load", function(result1)
        {        
            $("#forms").html(result1);
        });    
    $.post("index.php?ajax=showSearch", function(result2)
        {        
            $("#results").html(result2);
        });    
});

function login()
{
    var data = { //an object with username and password which will be stringify and send to the server as a JSON
                    name:$("#user_name").val(), 
                    pass:$("#password").val()
                };
    ajax("index.php?ajax=login", data, "text", function(result) // gets result from server that stores a form (admin, user, guest)
    {
        if(result!="guest")
        {
            $("#user_name").hide();
            $("#password").hide();
            $("#login").hide();
            $("#logout").show();
            $("#forms").html(result);
        }
    });
}
function logout()
{
    $.post("index.php?ajax=logout", function(result) //result is the unlogged form
    {
        $("#user_name").show();
        $("#user_name").val("");
        $("#password").show();
        $("#password").val("");
        $("#login").show();
        $("#logout").hide();
        $("#forms").html(result);
        $("#results").html("");
     });
}

function list()
{
    clearDiv(); //clears div with old data
    $.post("index.php?ajax=list", function(result)//result is a list with all DB records
    {        
        $("#results").html(result);
     });
}

function insert()
{   
    clearDiv();
    var formData = getInputs(); //gets values from all "input" fields
    ajax("index.php?ajax=insert", formData, "text", function(result) // result is "Done" or "Error"
    {
       $("#results").html(result);
     });
}

function update()000
{   
    clearDiv();
    var formData = getInputs();
    ajax("index.php?ajax=update", formData, "text", function(result) //  result is "Done" or "Error"
    {
       $("#results").html(result);
     });
}

function search()
{
    clearDiv();
    var formData = getInputs();
    ajax("index.php?ajax=search", formData, "text", function(result) //result is list of record that were found
    {
        $("#results").html(result);
     });
}

function del()
{   
    clearDiv();
    var id = $("#id").val();
    $.post("index.php?ajax=delete", id, function(result) //  result is "Done" or "Error"
    {
     $("#results").html(result);
     });
}

function getInputs()
{  //creates an array that contains values of "input" fields
    var values = $("input");
    var arr = $.map(values, function(value) {
       return $(value).val();});
    return arr;   
}

function clearDiv()
{
    if($("#results").html().length==0)
       $("#results").html("");
}
