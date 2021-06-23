<?php
	$department = $semester = "";
	$department_err = $semester_err = "";
	$server = "localhost"; $user_name = "root"; $password = "super"; $database = "gp_cur_db";
	session_start();
	if(!array_key_exists("userid", $_SESSION))
	{
		clearstatcache();		
		header("location:pagenotfound.php");
	} 
	elseif(empty($_SESSION["userid"]))
	{
		clearstatcache();
		header("location:pagenotfound.php");
	}

	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		if(array_key_exists("BtnShow", $_POST))
		{
			$c = 0;

			if(array_key_exists("DdlDept", $_POST))
			{		
				if(empty(trim($_POST["DdlDept"])))
				{
					$department_err = "Department is required";
					$c++;
				}
				elseif(empty(trim($_POST["DdlDept"])) == "-1")
				{
					$department_err = "Department is required";
					$c++;
				}
				else
				{
					$department = strtoupper(trim($_POST["DdlDept"]));
					$_SESSION["department"] = $department;
					$department_err = "";
				}
			}// end if DdlDept


			if(array_key_exists("DdlSemester", $_POST))
			{		
				if(empty(trim($_POST["DdlSemester"])))
				{
					$semester_err = "Semester is required";
					$c++;
				}
				elseif(empty(trim($_POST["DdlSemester"])) == "-1")
				{
					$semester_err = "Semester is required";
					$c++;
				}
				else
				{
					$semester = strtoupper(trim($_POST["DdlSemester"]));
					$_SESSION["semester"] = $semester;
					$semester_err = "";
				}
			}// end if DdlSemester

			if($c == 0)
			{

			}

		} // End if BtnShow
	} // End if POST
?>
<html>
<head>
<!-- to clear browser cache -->
<meta http-equiv="cache-control" content="no-cache">
<link href="styles/add_subjects.css" rel="stylesheet"/>
<link rel="stylesheet" href="bootstrap/bootstrap.min.css">
<script src="bootstrap/jquery.min.js"></script>
<script src="bootstrap/bootstrap.min.js"></script>

<script lang="javascript">
  	function checkdata()
  	{
  		var msg = "";
         
  		if(document.f1.DdlDept.value == "-1")
  		msg = msg + "Department is required\n";

  		if(document.f1.DdlSemester.value == "-1")
  		msg = msg + "Semester is required\n";          

  		if(msg != "")
  		{
  			alert(msg);
  			return;
  		}
  		else
  			document.f1.submit();
  	}
 </script>
</head>
<body>
<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" name="f1">
	<center>
		<table>
			<tr>
				<td>Department</td>
				<td>Semester</td>
				<td></td>
			</tr>
			<tr>
				<td>
					<select name="DdlDept">
  						<option value="-1">-- Select Department--</option>
                        <option <?php if(empty($_POST['DdlDept'])===false) if($_POST['DdlDept'] == 'COMPUTER') print("selected=true"); ?> value="COMPUTER">COMPUTER</option>
                        <option <?php if(empty($_POST['DdlDept'])===false) if($_POST['DdlDept'] == 'INFORMATION TECHNOLOGY') print("selected=true"); ?> value="INFORMATION TECHNOLOGY">INFORMATION TECHNOLOGY</option>
                        <option <?php if(empty($_POST['DdlDept'])===false) if($_POST['DdlDept'] == 'MECHANICAL') print("selected=true"); ?> value="MECHANICAL">MECHANICAL</option>                        
                        <option <?php if(empty($_POST['DdlDept'])===false) if($_POST['DdlDept'] == 'ELECTRONICS') print("selected=true"); ?> value="ELECTRONICS">ELECTRONICS</option>                       
                        <option <?php if(empty($_POST['DdlDept'])===false) if($_POST['DdlDept'] == 'CIVIL') print("selected=true"); ?> value="CIVIL">CIVIL</option>                        		
                        <option <?php if(empty($_POST['DdlDept'])===false) if($_POST['DdlDept'] == 'ELECTRICAL') print("selected=true"); ?> value="ELECTRICAL">ELECTRICAL</option>
                        <option <?php if(empty($_POST['DdlDept'])===false) if($_POST['DdlDept'] == 'PLASTIC AND POLYMER') print("selected=true"); ?> value="PLASTIC AND POLYMER">PLASTIC AND POLYMER</option>                                   
  					</select>
				</td>
				<td>
					<select name="DdlSemester">
  						<option value="-1">-- Select Semester--</option>
  						<option <?php if(empty($_POST['DdlSemester'])===false) if($_POST['DdlSemester'] == 'SEMESTER-I') print("selected=true"); ?> value="SEMESTER-I">SEMESTER-I</option>
  						<option <?php if(empty($_POST['DdlSemester'])===false) if($_POST['DdlSemester'] == 'SEMESTER-II') print("selected=true"); ?> value="SEMESTER-II">SEMESTER-II</option>
  						<option <?php if(empty($_POST['DdlSemester'])===false) if($_POST['DdlSemester'] == 'SEMESTER-III') print("selected=true"); ?> value="SEMESTER-III">SEMESTER-III</option>
  						<option <?php if(empty($_POST['DdlSemester'])===false) if($_POST['DdlSemester'] == 'SEMESTER-IV') print("selected=true"); ?> value="SEMESTER-IV">SEMESTER-IV</option>
  						<option <?php if(empty($_POST['DdlSemester'])===false) if($_POST['DdlSemester'] == 'SEMESTER-V') print("selected=true"); ?> value="SEMESTER-V">SEMESTER-V</option>
  						<option <?php if(empty($_POST['DdlSemester'])===false) if($_POST['DdlSemester'] == 'SEMESTER-VI') print("selected=true"); ?> value="SEMESTER-VI">SEMESTER-VI</option>
  					</select>
  				</td>
				<td>
					<input type="submit" value="Show Subjects" name="BtnShow" onclick="checkdata()">
				</td>
			</tr>
			<tr>
				<td><?php if(!empty($department_err)) print($department_err); ?></td>
				<td><?php if(!empty($semester_err)) print($department_err); ?></td>
				<td></td>
			</tr>
		</table>
		<?php
			//if(!empty($department) && !empty($semester) && strlen($department)>0 && strlen($semester)>0)
			if(array_key_exists("department", $_SESSION) and array_key_exists("semester", $_SESSION))
			{
				$con = mysqli_connect($server, $user_name, $password, $database);
				if($con == false)
				print("Error: ". mysqli_connect_error() ."<br/>");
				else
				{
					$department = $_SESSION["department"];
					$demester = $_SESSION["semester"];
					$sql = "select srno, subject, subject_code from subjects where department = ? and semester = ?";
					$ps = mysqli_prepare($con, $sql);
					if($ps != false)
					{
						mysqli_stmt_bind_param($ps, "ss", $department, $semester);
						$srno = $index = 0; $subject = $subject_code = "";
						mysqli_stmt_execute($ps);						
						mysqli_stmt_bind_result($ps, $srno, $subject, $subject_code);

						print("<table style='width:100%;font-family:calibri;font-size:medium;text-align:center;' border='1px' cellspacint='0' cellpadding='5'>");
						print("<tr>");						
						print("<td><b>Sr. No.</b></td>");
						print("<td><b>Course Code</b></td>");
						print("<td><b>Subject Name</b></td>");
						print("<td><b>Delete</b></td>");
						print("</tr>");
						while(mysqli_stmt_fetch($ps) != null)
						{
							$index++;
							print("<tr>");
							print("<td>$index</td>");
							print("<td>$subject_code</td>");
							print("<td>$subject</td>");
							print("<td><a href='delete_subject.php?srno=$srno'>Delete</a></td>");
							print("</tr>");
						}

						mysqli_stmt_close($ps);
						mysqli_close($con);
					}
					else
					{
						mysqli_close($con);
						print("Prepared Statement is not created..<br/>");
					}

				} // end if $con == false

			}
		?>
	</center>
</form>
</body>
</html>