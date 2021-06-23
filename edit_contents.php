<?php
	$unit_number = $hours = $marks = $srno = 0;
	$unit_name = $unit_contents = $instructional_strategies = $final_result = "";
	$unit_number_err = $unit_name_err = $unit_contents_err = $hours_err = $marks_err = $instructional_strategies_err = "";
	session_start();

	if($_SERVER["REQUEST_METHOD"] == "GET")
	{
		if(array_key_exists("srno", $_GET))
		{
			if(!empty($_GET["srno"]))
			{
				$srno = intval($_GET["srno"]);
				$_SESSION["srno"] = $srno;

				try
				{
					$con = mysqli_connect("127.0.0.1", "root", "super", "gp_cur_db");
              		if($con ==  false)
              		print("Error: ".mysqli_connect_error());
              		else
              		{
              			$sql = "select unit_number, unit_name, unit_contents, hours, marks, strategies from contents where srno = ?";
						$ps = mysqli_prepare($con, $sql);
						if($ps !== false)              			
						{
							mysqli_stmt_bind_param($ps,"i", $srno);
							mysqli_stmt_execute($ps);
							mysqli_stmt_bind_result($ps, $unit_number, $unit_name, $unit_contents, $hours, $marks, $instructional_strategies);
							if(mysqli_stmt_fetch($ps))
							{
								//print("Unit Number = $unit_number<br>");
								//print("Unit Name = $unit_name<br>");
								//print("Unit contents = $unit_contents<br>");
								//print("Hours = $hours<br>");
								//print("Marks = $marks<br>");
								//print("Instructional Strategies = $instructional_strategies<br>");
							}
							else
							{
								print("Record not fetched<br/>");
							}
							mysqli_stmt_close($ps);
                      		mysqli_close($con);
						}
						else
						{
							mysqli_close($con);
							print("Prepared statement is not created.");
						}
              		}
				}
				catch(Exception $ex)
				{
					print($ex->getmessage()."<br/>");
				}
			}
		}
	}

	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		if(array_key_exists("BtnEdit", $_POST))
		{
			$c = 0;

			if(empty(trim($_POST["TxtUnitNumber"])))
			{
				$unit_number_err = "Unit number is required";
				$c++;
			}
			else
			{
				$unit_number = intval(trim($_POST["TxtUnitNumber"]));
				$unit_number_err="";
			}

			if(empty(trim($_POST["TxtUnitName"])))
			{
				$unit_name_err = "Unit name is required";
				$c++;
			}
			else
			{
				$unit_name = trim($_POST["TxtUnitName"]);
				$unit_name_err="";
			}

			if(empty(trim($_POST["TxtUnitContents"])))
			{
				$unit_contents_err = "Unit contents are required";
				$c++;
			}
			else
			{
				$unit_contents = trim($_POST["TxtUnitContents"]);
				$unit_contents_err="";
			}

			if(empty(trim($_POST["TxtHours"])))
			{
				$hours_err = "Hours is required";
				$c++;
			}
			else
			{
				$hours = intval(trim($_POST["TxtHours"]));
				$hours_err="";
			}

			if(empty(trim($_POST["TxtMarks"])))
			{
				$marks_err = "Marks is required";
				$c++;
			}
			else
			{
				$marks = intval(trim($_POST["TxtMarks"]));
				$marks_err="";
			}

			if(empty(trim($_POST["TxtStrategies"])))
			{
				$instructional_strategies_err = "Instructional strategies required";
				$c++;
			}
			else
			{
				$instructional_strategies = trim($_POST["TxtStrategies"]);
				$instructional_strategies_err="";
			}

			if($c == 0)
			{
				try 
				{
					$con = mysqli_connect("127.0.0.1", "root", "super", "gp_cur_db");
					if($con ==  false)
                  	print("Error: ".mysqli_connect_error());      
                  	else
                  	{
                  		$sql = "update contents set unit_number=?, unit_name=?, unit_contents=?, hours = ?, marks = ?, strategies=? where srno=?";
						$ps = mysqli_prepare($con, $sql);
                      	if($ps != false)
                      	{
                      		//print("Unit number = $unit_number<br/>");
                      		//print("Unit name = $unit_name<br/>");
                      		//print("Unit contents = $unit_contents<br/>");
                      		//print("Hours = $hours<br/>");
                      		//print("Marks = $marks<br/>");
                      		//print("Instructional Strategies = $instructional_strategies<br/>");
                      		
                      		$srno = intval($_SESSION["srno"]);
                      		//print("Srno = $srno<br/>");

                      		mysqli_stmt_bind_param($ps, "issiisi",$unit_number, $unit_name, $unit_contents, $hours, $marks,$instructional_strategies, $srno);
                          	mysqli_stmt_execute($ps);
                          	$n = mysqli_stmt_affected_rows($ps);
                          	mysqli_stmt_close($ps);
                          	mysqli_close($con);
                          	if($n == 1)
                          	{
                              	//print("Contents saved..<br/>");
                              	$final_result = "<font face=calibri size=3pt color=green>Changes saved..</font>";
                          	}
                          	else
                          	{
                              	//print("Contents not saved..<br/>");                       
                              	$final_result = "<font face=calibri size=3pt color=red>Changes not saved...</font>";
                          	}
                      	}
                      	else
                      	{
                      		mysqli_close($con);
                      		print("update: prepared statement not created..");
                      	}
                  	}
				} 
				catch (Exception $ex) 
				{
					print($ex->getmessage()."<br/>");
				}
			}

		}
	} // end if POST
?>
<html>
	<head>
		<style>
        span
        {
            font-family:calibri;
            font-size:17px;
            color:red;
        }
    	</style>	
	  	<link href="styles/add_subjects.css" rel="stylesheet"/>
	  	<link rel="stylesheet" href="bootstrap/bootstrap.min.css">      
  		<script src="bootstrap/jquery.min.js"></script>
  		<script src="bootstrap/bootstrap.min.js"></script>
	</head>
<body>
	<form action = "" method="post" name="f1">
		<div class="panel panel-default">
  		<div class="panel-heading">
  			<font face="calibri" size="3pt" color="green">  					
  				Department: 
  				<?php 
  					if(array_key_exists("dept", $_SESSION))
  					{
  						if(isset($_SESSION["dept"]))
  						{
  							$dept = $_SESSION["dept"];
  							echo $dept, "<br/>";
  						}
  					}
  				?>
  				Semester:
  				<?php
  					if(array_key_exists("sem", $_SESSION)) 
  					{
  						if(isset($_SESSION["sem"]))
  						{
  							$sem = $_SESSION["sem"];
  							echo $sem, "<br/>";
  						}
  					}  				
  				?>
  				Subject:
  				<?php
  					if(array_key_exists("subject", $_SESSION)) 
  					{
  						if(isset($_SESSION["subject"]))
  						{
  							$subject = $_SESSION["subject"];
  							echo $subject, "<br/>";
  						}
  					}  				
  				?>
  				Subject Code:
  				<?php
  					if(array_key_exists("subject_code", $_SESSION)) 
  					{
  						if(isset($_SESSION["subject_code"]))
  						{
  							$subject_code = $_SESSION["subject_code"];
  							echo $subject_code, "<br/>";
  						}
  					}
  				?>
  			</font>
  		</div>
		<div>
			<table>
				<tr>
					<td>Unit Number</td>
					<td><input type="text" name="TxtUnitNumber" <?php if(array_key_exists("TxtUnitNumber", $_POST)) if(!empty($_POST["TxtUnitNumber"])) print("value='".trim($_POST["TxtUnitNumber"])."'"); if(!empty($unit_number)) print("value='".$unit_number."'"); ?>></td>
				</tr>
				<?php
					if(!empty($unit_number_err))
					print("<tr><td></td><td><span>$unit_number_err</span></td></tr>");
				?>
				<tr>
					<td>Unit Name</td>
					<td><input type="text" name="TxtUnitName" <?php if(array_key_exists("TxtUnitName", $_POST)){ if(!empty($_POST["TxtUnitName"])) print("value='".trim($_POST["TxtUnitName"])."'");}elseif(!empty($unit_name)) print("value='".$unit_name."'"); ?>></td>
				</tr>
				<?php
					if(!empty($unit_name_err))
					print("<tr><td></td><td><span>$unit_name_err</span></td></tr>");
				?>
				<tr>
					<td>Unit Contents</td>
					<td><textarea name="TxtUnitContents" cols="60" rows="7"><?php if(array_key_exists("TxtUnitContents", $_POST)){ if(!empty($_POST["TxtUnitContents"])) print(trim($_POST["TxtUnitContents"]));}elseif(!empty($unit_contents)) print($unit_contents); ?></textarea></td>
				</tr>
				<?php
					if(!empty($unit_contents_err))
					print("<tr><td></td><td><span>$unit_contents_err</span></td></tr>");
				?>
				<tr>
					<td>Hours</td>
					<td><input type="text" name="TxtHours" <?php if(array_key_exists("TxtHours", $_POST)){ if(!empty($_POST["TxtHours"])) print("value='".trim($_POST["TxtHours"])."'");}elseif(!empty($hours)) print("value='".$hours."'"); ?>></td>
				</tr>
				<?php
					if(!empty($hours_err))
					print("<tr><td></td><td><span>$hours_err</span></td></tr>");
				?>
				<tr>
					<td>Marks</td>
					<td><input type="text" name="TxtMarks" <?php if(array_key_exists("TxtMarks", $_POST)){ if(!empty($_POST["TxtMarks"])) print("value='".trim($_POST["TxtMarks"])."'");}elseif(!empty($marks)) print("value='".$marks."'"); ?>></td>
				</tr>
				<?php
					if(!empty($marks_err))
					print("<tr><td></td><td><span>$marks_err</span></td></tr>");
				?>							
				<tr>
					<td>Instructional Strategies</td>
					<td><textarea name="TxtStrategies" cols="60" rows="7"><?php if(array_key_exists("TxtStrategies", $_POST)){ if(!empty($_POST["TxtStrategies"])) print(trim($_POST["TxtStrategies"]));}elseif(!empty($instructional_strategies)) print($instructional_strategies); ?></textarea></td>
				</tr>
				<?php
					if(!empty($instructional_strategies_err))
					print("<tr><td></td><td><span>$instructional_strategies_err</span></td></tr>");
				?>
				<tr>
					<td></td>
					<td><input type="submit" name="BtnEdit" value="Save Changes"></td>
				</tr>
				<?php
					if(!empty($final_result))
						print("<tr><td></td><td>$final_result</td></tr>");
				?>
			</table>
		</div>
	</div>
	</form>
</body>	
</html>