<?php 
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"/>
    <title>Guessing Game</title>
    <style type="text/css">
    </style>
</head>
<body>
<div id="container">
   
    <div class="rules">
        <h2>Guessing Game</h2>
        <p>
            <b>Game Rules:</b></br>
			- Computer randomly chooses a number from 1-10.
			</br>
            - You have 3 tries to guess the number.		
			</br></br>			
			<b>Hint</b>
			</br>
			- If your guess is 3 or more away from the number, then it shows "Cold"
			</br>
			- If your guess is 2 numbers away from the number, then it shows "Warm"
			</br>
			- If your guess is one number away from the number, then it shows "Hot"
			</br>
        </p>
    </div>
    <div class="result">
        <?php
        if(!isset($_SESSION['number']))
        {
            $number = rand(1,10);
            $_SESSION['number'] = $number;
            $_SESSION['count'] = 0;
            header('Location: index.php');
        }
        else
        {
            ?>
            <form action="index.php" method="post">
                <input style="width:100px;margin-right:20px;" id="num" class="num" type="text" autocomplete="off"  maxlength="2" pattern= "[0-9]{1,2}" name="number"/>
                <input id="button" onclick="return checkValue();" type="submit" value="Guess it" name="" />
				</br><span id="num_err" style="color:red;"></span>
				
				
            </form>
            <?php
            if(isset($_POST['number']) && ( $_SESSION['count'] < 2))
            {
					
                if($_POST['number'] != ''){
					$_SESSION['count']++;
				}
				if($_SESSION['count'] == 1){
					$support_text = "first";
				}
				else if($_SESSION['count'] == 2){
					$support_text = "second";
				}
				else if($_SESSION['count'] == 3){
					$support_text = "last";
				}
				
                if(abs($_POST['number']-$_SESSION['number']) >= 3)
                {
                    echo "<div style='color:brown'>Your ".$support_text." guess is: ".$_POST['number']." (Cold)</div>";
                }
				else if(abs($_POST['number']-$_SESSION['number']) == 2)
                {
                    echo "<div style='color:orange'>Your ".$support_text." guess is: ".$_POST['number']." (Warm)</div>";
                }
				else if(abs($_POST['number']-$_SESSION['number']) == 1)
                {
                    echo "<div style='color:blue'>Your ".$support_text." guess is: ".$_POST['number']." (Hot)</div>";
                }
                else
                {
					echo "<div style='color:green'><b>Right! You have won the game. The number is ".$_SESSION['number']."</b> </br><a href='index.php'><button>Play Again</button></a></div>";                   
                    
                    ?>
					<script>
						document.getElementById('button').style.visibility = 'hidden';
						document.getElementById('num').style.visibility = 'hidden';
					</script>
                    <?php
					unset($_SESSION['number']);
					unset($_SESSION['count']);
                }
            }
            elseif(isset($_POST['number']) && ( $_SESSION['count'] == 2))
            {
				if($_POST['number'] == $_SESSION['number'])
                {
                    echo "<div  style='color:green'><b>Right! You have won the game. The number is ".$_SESSION['number']."</b> </br><a href='index.php'><button>Play Again</button></a></div>";
                }
				else{
					echo "<div  style='color:deeppink'><b>Oops! You lost the game. The correct number is ".$_SESSION['number']."</b> </br><a href='index.php'><button>Play Again</button></a></div>";
				}
				
                $_SESSION['count'] ++;
				
                ?>
                <script>
                    document.getElementById('button').style.visibility = 'hidden';
					document.getElementById('num').style.visibility = 'hidden';
                </script>
                <?php
                unset($_SESSION['number']);
                unset($_SESSION['count']);
            }
        }
        ?>
    </div>
</div>

<script>
function checkValue(){
	if (document.getElementById("num").value == '') {
		document.getElementById("num").style.borderColor = "red";
		document.getElementById("num_err").innerHTML = "Guess any number first";
		document.getElementById("num").focus();
		return false;
	} else {
		document.getElementById("num").style.borderColor = "";
		document.getElementById("num_err").innerHTML = "";
	}
}
</script>
</body>
</html>