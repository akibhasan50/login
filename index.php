<?php

	$row=0;
	$dsn="mysql:host=localhost; dbname=test_db;";
	$uname="root";
	$upass="";

	try {
		$conn=new PDO("$dsn,$uname,$upass");
		$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	} catch (PDOException $e) {
		echo "connection failed".$e->getMessage();
	}
	if (isset($_REQUEST['submit'])) {
		if(($_REQUEST['name']=="") || ($_REQUEST['roll']=="") ||($_REQUEST['address']=="")){
			echo "fill all field";
		}else{
			$sql="INSERT INTO student (name,roll,address) VALUES(:name,:roll,:address)";

			$result=$conn->prepare($sql);

			$name=$_REQUEST['name'];
			$roll=$_REQUEST['roll'];
			$address=$_REQUEST['address'];

			$result->execute(array(':name'=>$name,':roll'=>$roll,':address'=>$address));
		}
		unset($result);
	}

	if(isset($_REQUEST['delete'])){
		$sql="DELETE FROM student WHERE id=:id";

		$result=$conn->prepare($sql);
		$result->bindParam(':id',$id);
		$id=$_REQUEST['id'];
		$result->execute();
	}
	unset($result);
	if(isset($_REQUEST['edit'])){
		$sql="SELECT *  FROM student WHERE id=:id";
		$result=$conn->prepare($sql);

		$result->bindParam(':id',$id);
		$id=$_REQUEST['id'];
		$result->execute();
		$row=$result->fetch(PDO::FETCH_ASSOC);
	}
	unset($result);
	if (isset($_REQUEST['update'])) {
		if(($_REQUEST['name']=="") || ($_REQUEST['roll']=="") ||($_REQUEST['address']=="")){
			echo "fill all field";
		}else{
			$sql="UPDATE  student  SET name=:name, roll=:roll,address= :address  WHERE id=:id";

			$result=$conn->prepare($sql);

			$result->bindParam(':name',$name);
			$result->bindParam(':roll',$roll);
			$result->bindParam(':address',$address);
			$result->bindParam(':id',$id);

			$name=$_REQUEST['name'];
			$roll=$_REQUEST['roll'];
			$address=$_REQUEST['address'];
			$id=$_REQUEST['id'];

			$result->execute();
		}
		unset($result);
	}
?>

?>




<!DOCTYPE html>
<html lang="en">
<head>
	<title>CRUD WITH PDO</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="images/img-01.png" alt="IMG">
				</div>

				<form class="login100-form validate-form" action="" method="POST">
					<span class="login100-form-title">
						Member Login
					</span>
						
					<div class="wrap-input100 validate-input" >
						<input class="input100" type="text" name="name" placeholder="Name" value="<?php if(isset($row['name'])){echo $row['name'];}?>">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" >
						<input class="input100" type="text" name="roll" placeholder="Roll" value="<?php if(isset($row['roll'])){echo $row['roll'];}?>">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					<div class="wrap-input100 validate-input" >
						<input class="input100" type="text" name="address" placeholder="Address" value="<?php if(isset($row['address'])){echo $row['address'];}?>">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					
					<div class="btn-group">
							
							
							<button class="btn btn-success" type="submit" name="submit">
							submit
							</button>
						
					</div>
					<div class="btn-group">
							
							<input type="hidden" name="id" value="<?php echo $row['id'];?>">
							<button class="btn btn-info" type="submit" name="update">
							update
							</button>
						
					</div>


					<div class="text-center p-t-12">
						<span class="txt1">
							Forgot
						</span>
						<a class="txt2" href="#">
							Username / Password?
						</a>
					</div>
					
					<div class="text-center p-t-136">
						<a class="txt2" href="#">
							Create your Account
							<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	
<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="container">
					<span class="login100-form-title">
						Member Data
					</span>
						<?php
						
							$sql = "SELECT * FROM student";
							$result=$conn->prepare($sql);

							$result->execute();
						     

						      if($result->rowCount()> 0){
						  		echo '<table class="table">';
						    	echo'<thead>';
						      	echo '<tr>
								        <th>ID</th>
								        <th>NAME</th>
								        <th>ROLL</th>
								        <th>ADDRESS</th>
										<th>DELETE</th>
										<th>EDIT</th>
						      		</tr>';
						    	echo '</thead>';
						    echo '<tbody>';
						    while($row= $result->fetch(PDO::FETCH_ASSOC)){
						      echo '<tr>';
						        echo '<td>'.$row["id"].'</td>';
						        echo '<td>'.$row["name"].'</td>';
						        echo '<td>'.$row["roll"].'</td>';
						        echo '<td>'.$row["address"].'</td>';
					        	echo'<td>
					        		<form action="" method="POST">
					        			<input type="hidden" name="id" value='.$row["id"].'>
					        			<input type="submit" class="btn btn-danger" name="delete" value="delete">
					        		</form>

					        		</td>';
					        	echo'<td>
					        		<form action="" method="POST">
					        			<input type="hidden" name="id" value='.$row["id"].'>
					        			<input type="submit" class="btn btn-success" name="edit" value="edit">
					        		</form>

					        		</td>';
					

						      echo '</tr>';
						      }
						      
						     echo '</tbody>';
						  echo '</table>';
						}else{
							echo "0 record";
						}
						?>
																


					</div>


				
			</div>
		</div>
		
</div>

	
<!--===============================================================================================-->	
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/tilt/tilt.jquery.min.js"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>