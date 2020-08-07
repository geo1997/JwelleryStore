<html>
<head>
<link href="stylesheet.css" rel="stylesheet"/>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
$(document).ready(function()
{
    $("#btn").click(function()
    {
        var xval=$("#value1").val();
        var yval=$("#value2").val();
        var ope=$("#ope").val();
        if(xval=='' && yval='')
        {
            alert("Please fill out the form");
        }

        else if(xval=='' && yval!==''){alert('Value1 field is required')}
        else if(xval!=='' && yval==''){alert('Value2 field is required')}
        else
        {
            $.post("ajax_response.php",
            {
                x:xval,
                y:yval,
                operation:ope
            },function(result,status){
            
                document.getElementById('response').innerHTML=result;
            
            });
        }
    });
});
</script>
</head>
<body>
<div class="main">
<h2>Simple Calculator</h2>
<hr>
<form id="form" method="post">
<div id="value1"><label>Value 1</label>
<input type="text" name="value1" id="value1" /><br></div>
<div id="value2"><label>Value 2</label>
<input type="text" name="value2" id="value2" /></div>
<label>Select the Operation</label><br><select name="ope" id="ope">
<option value="add">Add</option>
<option value="sub">Substract</option>	
</select>
</form>
<button id="btn">Calculate</button>
<div id="response"></div>
</div>

</body>
</html>