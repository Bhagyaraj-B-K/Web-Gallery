<?php 
include 'config.php';

error_reporting(0);
session_start();



if (!isset($_SESSION['username'])) {
    header("Location: index.php");
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
<title>Web Gallery</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="styles/styles2.css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
</head>
<body>
<header>
    <h2></h2>
    <nav>
      <div><i class="fa fa-user"></i> User: <?php echo $_SESSION['username'] ?></div>
      <div style="padding: 5px;"><br><i class="fa fa-sign-out"></i><a style="text-decoration:none; color:white;" href='logout.php'> Logout</a></div>
    </nav>
</header>

<section>
  <nav class="LHSnav">
    <p style="background-color: black; color:white; padding:15px; text-align:center; border-radius:10px;"><strong>Storage Used:</strong> <?php 
    $totalsize = $_SESSION['data'] / 1000000;
    echo round($totalsize, 2);
    ?>mb / 500mb</p>

    <form name="form1" action="" method="post" enctype="multipart/form-data" style="background-color:black; color: white; padding:10px; border-radius:5px;" >
    <p style="text-align: center; color:white;"><strong>Select Photo</strong><p>
    <input class="LHSfile" type="file" name="f1" style="margin:10px;" ><br>
    <p style="text-align:center;"> <?php if($_SESSION['typecheck']==1){echo "Choose Image file<br>"; $_SESSION['typecheck']=0;} ?> </p>
    <p style="text-align:center;"> <?php if($_SESSION['sizecheck']==1){echo "File size too large<br>"; $_SESSION['sizecheck']=0;} ?> </p>
    <input class="LHSbutton" type="submit" name="submit1" value="Upload" style="margin:10px; width:94%;">
    </form>
  </nav>
  
  <article>
    <h1 style="background-color: rgb(1, 1, 21); color: white; width: 100%; text-align: center; padding: 20px; margin: -17px; font-family: Georgia, 'Times New Roman', Times, serif;">Photos</h1>
    <br><br>
    <article style="width: 100%; overflow-y: scroll; height: 400px; margin-top: 10px;">
        <?php
            $email=$_SESSION['email'];

            
            if(isset($_POST["submit1"]))
            {
                
                $image = addslashes(file_get_contents($_FILES['f1']['tmp_name']));
                $imagesize = $_FILES['f1']['size'];
                $imagetype = $_FILES['f1']['type'];
                if($imagetype!= "image/gif" && $imagetype!= "image/png" && $imagetype!= "image/jpeg" && $imagetype!= "image/JPEG" && $imagetype!= "image/PNG" && $imagetype!= "image/GIF"){
                  $_SESSION['typecheck']= 1;
                  header("Location: mainpage.php");
                }else{
                //echo "$imagesize";
                if($imagesize>1000000){
                  $_SESSION['sizecheck']=1;
                  header("Location: mainpage.php");
                }else{
                $_SESSION['imgsize'] = $imagesize;
                $totalsize = $_SESSION['data'] + $imagesize;
                $_SESSION['data'] = $totalsize;
                if($totalsize<500000000 && $_FILES['f1']['name'])
                {
                    $query1= "insert into images values('','$email','$image','$imagesize')";
                    $query2= "update users set data='$totalsize' where email='$email'";
                    mysqli_query($conn,$query1);
                    mysqli_query($conn,$query2);
                    header("Location: mainpage.php");
                }else if($totalsize>500000000){
                    echo "<p>Storage full !!</p><br>";
                }
                }
              }
            }


            if(true)
            {
                $query= "select * from images where email='$email'";
                $res=mysqli_query($conn,$query);
                
                while($row=mysqli_fetch_array($res))
                {
                echo "<div style='float: left; margin: 7px; background-color: rgba(10, 82, 189, 0.651); padding: 5px; border-radius:10px;'>"; 
                echo '<img style="border-radius:5px; padding: 3px; background-color: black;" src="data:image/jpeg;base64,'.base64_encode($row['image'] ).'" height="200" width="200"/>';
                echo "<br>";
                ?><a style="color:white; float:right; background-color:black; padding:5px; border-radius:10px;" href="delete.php?id=<?php echo $row["id"]; ?>">Delete</a> <?php
                echo "</div>";
            
            
            
                }
            

            }
        ?>
    </article>

    
  </article>
</section>

<footer>
  <p><a href="https://github.com/Bhagyaraj-B-K" style="text-decoration:none; color:white"><i class="fa fa-github"></i> Bhagyaraj-B-K</p>
</footer>

</body>
</html>
