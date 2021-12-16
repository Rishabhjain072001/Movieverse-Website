<?php

if (isset($_POST['signup-submit'])){
	require 'dbh.inc.php';
	
	$username = $_POST['uid'];
	$email = $_POST['mail'];
	$password = $_POST['pwd'];
	$passwordRepeat = $_POST['pwd-repeat'];

	if (empty($username) || empty($email) || empty($password) || empty($passwordRepeat)){
		header("Location: ../signupfromhomepage.php?error=emptyfields&uid=".$username."&mail=".$email);
		exit();
	}
	else if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username)){
		header("Location: ../signupfromhomepage.php?error=invalidmailuid");
		exit();
	}
	else if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
		header("Location: ../signupfromhomepage.php?error=invalidmail&uid=".$username);
		exit();
	}
	else if(!preg_match("/^[a-zA-Z0-9]*$/", $username)){
		header("Location: ../signupfromhomepage.php?error=invaliduid&mail=".$email);
		exit();
	}
	else if ($password !== $passwordRepeat){
		header("Location: ../signupfromhomepage.php?error=passwordcheck&uid=".$username."&mail=".$email);
		exit();
	} 
	else{
	  $sql = "SELECT emailUsers FROM users WHERE emailUsers=?";	
	  $stmt = mysqli_stmt_init($conn);
	  if (!mysqli_stmt_prepare($stmt, $sql)) {
		header("Location: ../signupfromhomepage.php?error=sqlerror");
		exit();

	  }
	  else{
		mysqli_stmt_bind_param($stmt, "s", $email);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_store_result($stmt);
		$resultCheck = mysqli_stmt_num_rows($stmt);
		if ($resultCheck > 0){
			header("Location: ../signupfromhomepage.php?error=emailtaken&uid=".$username);
			exit();
		}
		else{
		  $sql = "INSERT INTO users(uidUsers, emailUsers, pwdUsers) VALUES(?, ?, ?)";
		  $stmt = mysqli_stmt_init($conn);
		  if (!mysqli_stmt_prepare($stmt, $sql)) {
			header("Location: ../signupfromhomepage.php?error=sqlerror");
			exit();
		  }
		  else{
			$hashedPwd = password_hash($password, PASSWORD_DEFAULT);

			mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashedPwd);
			mysqli_stmt_execute($stmt);
			
			$sql = "SELECT * FROM users WHERE uidUsers='$username' AND emailUsers='$email'";
			$result = mysqli_query($conn, $sql);
			if(mysqli_num_rows($result) > 0){
				while($row = mysqli_fetch_assoc($result)){
					$idUsers = $row['idUsers'];
					$sql = "INSERT INTO profileimg (idUsers, status)  VALUES ('$idUsers', 1)";
					mysqli_query($conn, $sql);
				}
	
			}else{
				echo "you have an error!";
			}
		  }	
		}
	  }
	}
	$sql = "SELECT * FROM users WHERE emailUsers=?;";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt, $sql)){
	     header("Location: ../loginfromhomepage.php?error=sqlerror");
	     exit();
	}
	else{
	    mysqli_stmt_bind_param($stmt, "s", $email);
	    mysqli_stmt_execute($stmt);
	    $result = mysqli_stmt_get_result($stmt);
            if ($row = mysqli_fetch_assoc($result)){
		$pwdCheck = password_verify($password, $row['pwdUsers']);
		
	        if ($pwdCheck == true){
		  	session_start();
			$_SESSION['userId'] = $row['idUsers'];
			$_SESSION['userUid'] = $row['uidUsers'];
			
			header("Location: ../index.php?login=success");
		    	exit();
		}
		
	    }
        }

	mysqli_stmt_close( $stmt);
	mysqli_close($conn);
}

else{
	header("Location: ../index.php");
	exit();  

}