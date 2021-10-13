<?php


session_start();

if(isset($_SESSION['logged']) && $_SESSION['logged'] == true){
	
	function saveBestScoreToFile($score) {

		//Créer le fichier
		if (!file_exists('users.txt')) {
			fclose(fopen('users.txt', 'w+'));
		}

		$file = fopen('users.txt', 'r+');
		
		if ($_SESSION['bestScore'] < $score) {
			$bestScore = $score;
			$content = file_get_contents(‘users.txt’);
			$content = str_replace($_SESSION['username'].';'.$_SESSION['password'].';'.$_SESSION['bestScore'], $_SESSION['username'].';'.$_SESSION['password'].';'.$bestScore, $content);
			file_put_contents(‘users.txt’, $content);
			$_SESSION['bestScore'] = $bestScore;
		}
		
		
		
		fclose($file);
		return $_SESSION['bestScore'];
	}

	$showForm = True;

	if (isset($_GET['exit'])) {
		//We quit the game by deleting the data of the session
		session_unset();
		header('Location: login.php');
		exit;
	}




	if (!empty($_POST)) {


		$endGame = False;

		$diceroll = $_POST['dice'];

		$diceroll = intval($diceroll);



		if ($diceroll != 1 && $diceroll != 2 && $diceroll != 3) {

			echo 'You must enter the number of the die from 1 to 3';
			
		} else {

			$res = rand(1, 6);

			echo("Result of the dice = $res ");

			
			if ($diceroll == 1) {

				//Check that this dice has not been thrown yet
				//We check the data we already have in the session
				//If we already have a result for the first dice.
				if (isset($_SESSION['dice1'])) {

					$error = 1;
				} else {

					//we check that the result obtained leaves a chance to win
					if ($res > 4) {
						
						$endGame = True;
					} else {
						 
						$_SESSION['dice1'] = $res;
					}
				}
			} else if ($diceroll == 2) {


				//Check that this dice has not been thrown yet
				//We check the data we already have in the session
				//If we already have a result for the second dice.
				if (isset($_SESSION['dice2'])) {

					$error = 2;
				} else {

					//check that the result obtained is lower than the result of the dice 1 if it is already rolled
					if ((isset($_SESSION['dice1']) && $res <= $_SESSION['dice1'] ) ||  $res == 6 || $res==1) {

						$endGame = True;
					} else {
						
						$_SESSION['dice2'] = $res;
					}
				}
			}
			else {


				//Check that this dice has not been thrown yet
				//We check the data we already have in the session
				//If we already have a result for the third dice.
				if (isset($_SESSION['dice3'])) {

					$error = 3;
				} else {
					
					if ((isset($_SESSION['dice1']) && $res <= $_SESSION['dice1']) || (isset($_SESSION['dice2']) && $res <= $_SESSION['dice2']) || $res < 3) {

						$endGame = True;
					} else {
						
						$_SESSION['dice3'] = $res;
					}
				}
			}


			$gameover = False;
			$score = 0;
			
			if (isset($error)) {
				$score = -1;
				echo "<p> Score  = -1 because you rolled the $error dice twice  </p> ";
				$gameover = True;
			}else if (isset($_SESSION['dice1']) && isset($_SESSION['dice2']) && isset($_SESSION['dice3'])) {

				if ($_SESSION['dice1'] < $_SESSION['dice2'] && $_SESSION['dice2'] < $_SESSION['dice3']) {
					$score = ( $_SESSION['dice1'] + $_SESSION['dice2'] + $_SESSION['dice3']);
					echo "<p> Score  = " . $score . " </p> ";
				} else {
					echo "<p> Score  = 0 </p> ";
				}

				$gameover = True;
			} else if ($endGame) {
				echo "<p> Score  = 0  </p> ";
				$gameover = True;
			}



			if ($gameover) {

				$showForm = False;
				$bestCore =    saveBestScoreToFile($score);
				echo "Best Score =" . $bestCore;
				session_unset();
			}
		}
	}
}else{
	header('Location: login.php');
}
?>



<html>
    <head>
        <title>simple game</title>
    </head>
    <body>
		<h1> <?php echo $_SESSION['username']; ?></small></h1>
		<br>
		
        <?php
        if ($showForm) {
            ?>

            <p>Enter the dice number and click on the roll button</p> 
            <form method="POST">

                <label>Dice Number</label>
                <input type="text" name="dice"  />
                <input type="submit" value="Roll" /> 

            </form>



            <?php
        } else {
            echo '<br><a href="?exit=1">Exit</a>';
        }
        ?>
    </body>
</html>

