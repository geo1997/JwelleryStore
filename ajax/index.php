


<!Doctype html>
<html>
<head>
<title>Search</title>
</title>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript">
function searchq()
{
    var searchTxt=$("input[name='search']").val();

    $.post("search.php",{searchVal:searchTxt},function(output){
        $("#output").html(output);
    });
}
</script>
</head>

<body>

<form action="index.php" method="post">
    <input type="text" name="search" placeholder="Search" onkeydown="searchq();">
    <input type="submit" value="search">
</form>

<div id="output">

</div>

</body>
</html>