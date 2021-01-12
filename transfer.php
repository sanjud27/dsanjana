<?php
	session_start();
	$con = mysqli_connect("localhost", "root", "", "banksystem");//database connection
	if(!$con)
	{
		die("Connection failed");
	} 
	$flag=false;
	if (isset($_POST['transfer']))
		{
			$sender=$_SESSION['sender'];
			$receiver=$_POST["reciever"];
			$amount=$_POST["amount"];
		}
?>
<!DOCTYPE html>
<html>
<head>
<title>Spark foundation</title>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

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
button
{
	width:180px;
	height:35px;
	font-size:20px;
	font-weight:bold;
	background:linear-gradient(-45deg,blue,red);
}
.column
{
	float:left;
	color:white;
	margin-top:60px;
}

</style>
</head>
<body>
	<!--navbar-->
	<nav>
		<div class="bank">SPARK BANK</div>
			<ul>
				<li><a href="getstart.php">HOME</a></li>
				<li><a href="viewcustomer.php">VIEW CUSTOMER</a></li>
				<li><a href="history.php">TRANSACTION HISTORY</a></li>
			</ul>
	</nav>
	<center>
		<p style="font-weight-bold; color:#fff; font-size:40px;">TRANSACTION STATUS</p>
	</center>
	<!--transaction status-->
	<?php
		$sql = "SELECT current_balance FROM customers WHERE customer_name='$sender'";
		
		$result = $con->query($sql);
		if ($result->num_rows > 0) 
			{
				while($row = $result->fetch_assoc())
					{
						if($amount>$row["current_balance"] or $row["current_balance"]-$amount<0)  //check whether transaction amount is valid/available
							{
								echo "<script>swal( 'Error','Insufficient Balance!','error' ).then(function() { window. location = 'viewcustomer.php'; });;</script>";
							}
						else
							{
								$sql = "UPDATE `customers` SET current_balance=(current_balance-$amount) WHERE customer_name='$sender'";    //substract amount from sender's account
								if ($con->query($sql) === TRUE) 
									{
										$flag=true;
									} 
								else 
									{
										echo "Error updating record: " . $conn->error;
									}
							}
 
					}
			}
		else
			{
				echo "0 results";
			} 
		if($flag==true)
			{
				$sql = "UPDATE `customers` SET current_balance=(current_balance+$amount) WHERE customer_name='$receiver'";   //add money in reciever account
				if ($con->query($sql) === TRUE)
					{
						$flag=true;  
					} 
				else
					{
						echo "Error updating record: " . $con->error;
					}
			}
		if($flag==true)
			{
				$sql = "INSERT INTO `transferhistory`(`sender`, `receiver`, `amount`,`datetime`) VALUES ('$sender','$receiver','$amount',CURRENT_TIMESTAMP)";     //upload data into history 
				if ($con->query($sql) === TRUE) 	
					{
					}
				else 
					{
						echo "Error updating record: " . $con->error;
					}
			}
		if($flag==true)
			{
				echo "<script>swal('Transfered!', 'Transaction Successfull','success').then(function() { window. location = 'viewcustomer.php'; });;</script>";
			}
		elseif($flag==false)
			{
				echo "<script> $('#text2').show()</script>";
			}
	?>
</body>
</html>