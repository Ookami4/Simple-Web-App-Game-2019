<?php 

//On démarre la session
session_start();

if(isset($_POST['submit'])){
	$error = "";
	$exist = false;
	if(!empty($_POST['username']) && !empty($_POST['password'])){
		$handle = fopen("users.txt", "r");
		if ($handle) {
			
			while (($line = fgets($handle)) !== false) {
				$entry_array = explode(";",$line);
				if ($entry_array[0] == $_POST['username'] && $entry_array[1] == $_POST['password']) {
					@$_SESSION['username'] = $entry_array[0];
					@$_SESSION['password'] = $entry_array[1];
					@$_SESSION['bestScore'] = $entry_array[2];
					@$_SESSION['logged'] = true;
					$exist = true;
					$error = "find one";
					break;
				}
			}
			
			
			if($exist){
				
				header("Location: game.php");
				
			}else{
				$error = "username or password is incorrect";
			}
			
			
			fclose($handle);
			
		}
		else {
			// error opening the file.
			$error = "file error";
		} 
	}
	else{
		$error = "Please fill in all fields";
	}
}

?>

<html>
    <head>
        <title>dice game</title>
    </head>
	<body>
		<div>
			<form action="" method="POST">
				<fieldset>
					<legend>Login</legend>
					<table>
						<tr>
							<th style="color:red;"><?php echo @$error;?></th>
						</tr>
						<tr>
							<td>Username</td>
							<td><input type="text" name="username"></td>
						</tr>
						<tr>
							<td>Password</td>
							<td><input type="password" name="password"></td>
						</tr>
						<tr>
							<td><input type="submit" name="submit" value="login"></td>
						</tr>
					</table>
				</fieldset>
			</form>
		</div>
	</body>
</html>
