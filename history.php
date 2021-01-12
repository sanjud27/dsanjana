<?php
    $con = mysqli_connect("localhost", "root", "", "banksystem");        //database connection
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
customertable
{
	color:yellow;
}
table
{
	text-align:center;
	font-size:25px;
	font-wight:bold;
	color:yellow;}
tr th
{
	color:orange;
}
h3
{
	text-align:center;
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
	background:linear-gradient(-45deg,blue,green);
}
	
</style>
</head>
<body>
	<div id="main">
		<!--navbar-->
		<nav>
			<div class="bank">SPARK BANK</div>
			<ul>
				<li><a href="getstart.php">HOME</a></li>
				<li><a href="viewcustomer.php">VIEW CUSTOMER</a></li>
				<li><a href="history.php">TRANSACTION HISTORY</a></li>
			</ul>
		</nav>
		<div class="transactiontable">
			<h3 >TRANSACTION HISTORY</h3>
			<center>
				<table id="myTable" border="1">
					<tr>
						<th>SENDER</th>
						<th>RECEIVER</th>
						<th>AMOUNT</th>
						<th>DATE</th>
					</tr>
				<?php
					$sql = "SELECT * FROM `transferhistory`";
					$result = mysqli_query($con, $sql);
					while($row = mysqli_fetch_assoc($result))
					{
						echo "<tr>";
						echo "<td>". $row['sender'] . "</td>
							  <td>". $row['receiver'] . "</td>
							  <td>". $row['amount'] . "</td>
							  <td>". $row['datetime'] ."</td>";
						echo  "</tr>";
					}
				?>
          
				</table>
			</center>
		</div>
</body>
</html>