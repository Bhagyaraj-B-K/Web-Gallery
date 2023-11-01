<?php
include 'config.php';

error_reporting(0);
session_start();

$id=$_GET["id"];
$query="select * from images where id=$id";
$result= mysqli_query($conn,$query);
$row= mysqli_fetch_assoc($result);
$size= $_SESSION['data'] - $row['size'];
$email= $_SESSION['email'];
$_SESSION['data']=$size;
$delQuery= "delete from images where id='$id'";
$dataQuery="update users set data='$size' where email='$email' ";
mysqli_query($conn,$dataQuery);
mysqli_query($conn,$delQuery);

?>


<script type="text/javascript">
window.location ="mainpage.php";
</script>