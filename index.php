<?php 
session_start();
?>



<!DOCTYPE HTML>
<html>
<title></title>
<head>
<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>

<link rel="stylesheet" type="text/css" href="style.css" />

</head>
<body onload="sessionPageLoad()">
<input type='hidden' name='pageNumber' id='pageNumberId' value='<?php echo $_SESSION["pageName"];?>' /> 

<div id="mhead"><h2> Pagination</h2></div>
<div id="pagination" cellspacing="0">
</div>

<script type="text/javascript" src="js/script.js"></script>
</html>