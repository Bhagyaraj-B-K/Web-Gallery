<?php 

include 'config.php';

session_start();

error_reporting(0);

$echeck=0;
if (isset($_SESSION['username'])) {
    header("Location: mainpage.php");
}

if (isset($_POST['submit'])) {
	$email = $_POST['email'];
	$password = md5($_POST['password']);

	$sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
	$result = mysqli_query($conn, $sql);
	if ($result->num_rows > 0) {
		$row = mysqli_fetch_assoc($result);

		//Global data
		$_SESSION['username'] = $row['username'];
		$_SESSION['email'] = $row['email'];
		$_SESSION['data'] = $row['data'];
		header("Location: mainpage.php");
	} else {
		$echeck=1;
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" type="text/css" href="styles/style.css">

	<title>Login to Web Gallery</title>
</head>
<body>
	<div class="container">
		<form action="" method="POST" class="login-email">
			<p class="login-text" style="font-size: 2rem; font-weight: 800;">Login</p>
			<div class="input-group">
				<input type="email" placeholder="Email" name="email" value="<?php echo $email; ?>" required>
			</div>
			<div class="input-group">
				<input type="password" placeholder="Password" name="password" value="<?php echo $_POST['password']; ?>" required><br>
				<p class="ierror" style="color:red; font-size:small; margin-left: 20px"> <?php if($echeck==1) echo "*Invalid email or password"; ?> </p>
			</div>
			
			<div class="input-group">
				<button name="submit" class="btn">Login</button>
			</div>
			<p class="login-register-text">Don't have an account? <a href="register.php">Register Here</a>.</p>
		</form>
	</div>
</body>
</html>