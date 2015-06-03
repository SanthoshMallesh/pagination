<?php
$limit = 2;
$adjacent = 3;
$con = mysqli_connect("localhost","root","","ajaxpagination");
if(mysqli_connect_errno()){
echo "Database did not connect";
exit();
}

?>