<?php 
include 'config.php';

error_reporting(0);
session_start();



if (!isset($_SESSION['username'])) {
    header("Location: index.php");
}

?>



<!DOCTYPE HTML>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<form name="form1" action="" method="post" enctype="multipart/form-data">
<table>
<tr>
<td>Select File</td>
<td><input type="file" name="f1"></td>
</tr>
<tr>
<td><input type="submit" name="submit1" value="upload"></td>
<td><input type="submit" name="submit2" value="display"></td>
</tr>
</table>
</form>

<?php
$email=$_SESSION['email'];
if(isset($_POST["submit1"]))
{
$image = addslashes(file_get_contents($_FILES['f1']['tmp_name']));
$imagesize = $_FILES['f1']['size'];
$totalsize = $_SESSION['data'] + $imagesize;
$_SESSION['data'] = $totalsize;
echo "$imagesize";
$query1= "insert into images values('','$email','$image','$imagesize')";
$query2= "update users set data='$totalsize' where email='$email'";
mysqli_query($conn,$query1);
mysqli_query($conn,$query2);
}


if(isset($_POST["submit2"]))
{
    $query= "select * from images where email='$email'";
    $res=mysqli_query($conn,$query);
    echo "<table>";
    echo "<tr>";
    
    while($row=mysqli_fetch_array($res))
    {
    echo "<td>"; 
    echo '<img src="data:image/jpeg;base64,'.base64_encode($row['image'] ).'" height="200" width="200"/>';
    echo "<br>";
    ?><a href="delete.php?id=<?php echo $row["id"]; ?>">Delete</a> <?php
    echo "</td>";
   
   
   
   }
   echo "</tr>";
   
   echo "</table>";
  

}

echo "<br><a href='logout.php'>Logout</a>";
echo "<br><a href='mainpage.php'>mainpage</a>";
?>

</body>
</html>
