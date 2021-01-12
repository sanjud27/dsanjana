<?php
	session_start();  //Start the session
    $con = mysqli_connect("localhost", "root", "", "banksystem"); //database connection establish
	if(!$con)
		{
			die("Connection failed");
		}
	//Set session variable
	$_SESSION['user']=$_POST['user'];
	$_SESSION['sender']=$_SESSION['user'];
?>

<!DOCTYPE html>
<html>
<head>
<title>Spark foundation</title>
<!--CSS-->
<style>
body 
{
	margin:0;
	border:0;
	background-image: url('bank7.jpg');
	background-size:100% 100%;
	background-attachment: fixed;
}
nav
{
	top:0;
	left:0;
	width:100%;
	height:80px;
	line-height:40px;
	background:rgba(0,0,0,0.3);
}
nav .bank
{
	padding :22px 20px;
	height:40px;
	float :left;
	color:#fff;
	font-size:25px;
}
nav ul
{
	float:right;
	margin-right:30px;
}
nav ul li	
{
	list-style-type: none;
	display: inline-block;
	font-size:25px;
	transition:0.8 s all;
}
nav ul li:hover
{
	background-color:orange;
}
nav ul li a
{
	text-decoration:none;
	color:#fff;
	padding:30px;
	font-size:20px;
}
p
{
	color:orange;
	font-size:23px;
}
h3
{
	text-align:center;
	color:#1fcd1a;
	font-family: 'Algerian';
	font-size:38px;
	padding:3;
}
h2
{
	
	color:#1fcd1a;
	font-family: 'Algerian';
	font-size:38px;
	padding:3;
}
.column
{
	float:left;
	color:white;
	margin-top:60px;
}
b
{
color:orange;
}
button
{
	width:180px;
	height:35px;
	font-size:20px;
	font-weight:bold;
	color:#000;
	background:linear-gradient(-45deg,blue,red);
}
</style>
</head>
<body>
	<!--Navbar-->
	<nav>
		<div class="bank">SPARK BANK</div>
		<ul>
			<li><a href="getstart.php">HOME</a></li>
			<li><a href="viewcustomer.php">VIEW CUSTOMER</a></li>
			<li><a href="history.php">TRANSACTION HISTORY</a></li>
		</ul>
	</nav>
	<!--sender detail-->
	<div class="row" style="margin;2%">
		<div class="column" sytle="border:5px solid green;background-color:#800000">
			<h2>CUSTOMER</h2>
			<?php
				if (isset($_SESSION['user']))   //check variable is declare or empty
					{
						$user=$_SESSION['user'];
						$result=mysqli_query($con,"SELECT * FROM customers WHERE customer_name='$user'");
						while($row=mysqli_fetch_array($result))         //fetch user data from database 
							{
								echo "<p><b class='font-weight-bold'>User ID</b> &nbsp;: ".$row['customer_id']."</p><br>";
								echo "<p name='sender'><b class='font-weight-bold'>Name&nbsp;&nbsp;</b>&nbsp;&nbsp;: ".$row['customer_name']."</p><br>";
								echo "<p><b class='font-weight-bold'>Email ID</b> : ".$row['customer_email']."</p><br>";
								echo "<p><b class='font-weight-bold'>Balance</b>&nbsp; :&nbsp;<b>&#8377;</b> ".$row['current_balance']."</p>";
							}         
					}
			?>
		</div>
		<!--money Transfer-->
		<div class="column" style="padding:1% 3%; margin:3%; margin-left:250px; border:5px solid green;background-color:#800000">
			<form action="transfer.php" method="POST">
				<h2>MONEY TRANSFER</h2> 
				<!--sender-->
				<b style="font-size:28px; ">Sender</b> : <span style="font-size:25px;"><input id="myinput" name="sender"  type="text" style="width:120px;border:box;background-color:pink" value='<?php echo "$user";?>'></input></span>
				<br><br><br>
				<!--receiver-->
                <b style="font-size:28px;">Reciever:</b>
					<select  name="reciever" id="dropdown"  style="background-color:pink ;font-weight-bold;" required>
						<option value="">Select Reciever</option>
						<?php
							$db = mysqli_connect("localhost", "root", "", "banksystem");
							$res = mysqli_query($db, "SELECT * FROM customers WHERE customer_name!='$user'");
							while($row = mysqli_fetch_array($res))
								{
									echo("<option> "."  ".$row['customer_name']."</option>");
								}
						?>
					</select>
				<br><br><br>
				<!--Amount-->
                    <b style="font-size:28px; ">Amount  &#8377;:</b>
                    <input name="amount" type="number" style="width:50px;heght:30px; background-color:pink;" min="1"  required>
                    <br><br><br>
                    <a href="transfer.php"><button id="transfer"  name="transfer" class="button" ><b>Transfer</b></button>
            </form>
		</div>
	</div>
</body>
</html>