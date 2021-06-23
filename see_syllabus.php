<?php
	$dept = $sem = "";
	$dept_err = $sem_err = "";

	//print_r($_POST);
	//print("<br/>");

	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$c = 0;
		if(array_key_exists("DdlDept", $_POST))
  		{
  			if(empty(trim($_POST["DdlDept"])))
  			{
  				$dept_err = "Department is required";
  				$c++;
  			}
  			elseif(trim($_POST["DdlDept"]) == "-1")
  			{
  				$dept_err = "Department is required";
  				$c++;
  			}
  			else
  			{
  				$dept = strtoupper(trim($_POST["DdlDept"]));
  				unset($dept_err);
  				$_SESSION["dept"] = $dept;
  			}
  		}

  		if(array_key_exists("DdlSemester", $_POST))
  		{
  			if(empty(trim($_POST["DdlSemester"])))
  			{
  				$sem_err = "Semester is required";
  				$c++;
  			}
  			elseif(trim($_POST["DdlSemester"]) == "-1")
  			{
  				$sem_err = "Semester is required";
  				$c++;
  			}
  			else
  			{
  				$sem = strtoupper(trim($_POST["DdlSemester"]));
  				unset($sem_err);
  				$_SESSION["sem"] = $sem;
  			}
  		}

  		if($c === 0 && !empty($dept) && !empty($sem))
  		{  							
  			header("location:see_syl_select_subject.php?dept=$dept&sem=$sem");
  		}
	}
?>
<html>
<head>
<!-- to clear browser cache -->
<meta http-equiv="cache-control" content="no-cache">
	<link href="styles/add_subjects.css" rel="stylesheet"/>	
	<style>
        span
        {
            font-family:calibri;
            font-size:17px;
            color:red;
        }
    </style>
    <script>
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
	<form action="" method="post" name="f1">
    <center>
		<table style="text-align:left;">
			<tr>
				<td>Department</td>
				<td>
					<select name="DdlDept">
  							<option value="-1">-- Select Department --</option>
                        	<option <?php if(empty($_POST['DdlDept'])===false) if($_POST['DdlDept'] == 'COMPUTER') { ?>selected="true" <?php }; ?>value="COMPUTER">COMPUTER</option>
                        	<option <?php if(empty($_POST['DdlDept'])===false) if($_POST['DdlDept'] == 'INFORMATION TECHNOLOGY') { ?>selected="true" <?php }; ?>value="INFORMATION TECHNOLOGY">INFORMATION TECHNOLOGY</option>
                        	<option <?php if(empty($_POST['DdlDept'])===false) if($_POST['DdlDept'] == 'MECHANICAL') { ?>selected="true" <?php }; ?>value="MECHANICAL">MECHANICAL</option>                        
                        	<option <?php if(empty($_POST['DdlDept'])===false) if($_POST['DdlDept'] == 'ELECTRONICS') { ?>selected="true" <?php }; ?>value="ELECTRONICS">ELECTRONICS</option>                        
                        	<option <?php if(empty($_POST['DdlDept'])===false) if($_POST['DdlDept'] == 'CIVIL') { ?>selected="true" <?php }; ?>value="CIVIL">CIVIL</option>	
                        	<option <?php if(empty($_POST['DdlDept'])===false) if($_POST['DdlDept'] == 'ELECTRICAL') { ?>selected="true" <?php }; ?>value="ELECTRICAL">ELECTRICAL</option>
                        	<option <?php if(empty($_POST['DdlDept'])===false) if($_POST['DdlDept'] == 'PLASTIC AND POLYMER') { ?>selected="true" <?php }; ?>value="PLASTIC AND POLYMER">PLASTIC AND POLYMER</option>
                        </select>
				</td>
			</tr>
			<?php if(!empty($dept_err))echo("<tr><td></td><td><span>$dept_err</span></td></tr>");?>
			<tr>
				<td>Semester</td>
				<td>
					<select name="DdlSemester">
  						<option value="-1">-- Select Semester --</option>
  						<option <?php if(empty($_POST['DdlSemester'])===false) if($_POST['DdlSemester'] == 'SEMESTER-I') { ?>selected="true" <?php }; ?>value="SEMESTER-I">SEMESTER-I</option>
  						<option <?php if(empty($_POST['DdlSemester'])===false) if($_POST['DdlSemester'] == 'SEMESTER-II') { ?>selected="true" <?php }; ?>value="SEMESTER-II">SEMESTER-II</option>
  						<option <?php if(empty($_POST['DdlSemester'])===false) if($_POST['DdlSemester'] == 'SEMESTER-III') { ?>selected="true" <?php }; ?>value="SEMESTER-III">SEMESTER-III</option>
  						<option <?php if(empty($_POST['DdlSemester'])===false) if($_POST['DdlSemester'] == 'SEMESTER-IV') { ?>selected="true" <?php }; ?>value="SEMESTER-IV">SEMESTER-IV</option>
  						<option <?php if(empty($_POST['DdlSemester'])===false) if($_POST['DdlSemester'] == 'SEMESTER-V') { ?>selected="true" <?php }; ?>value="SEMESTER-V">SEMESTER-V</option>
  						<option <?php if(empty($_POST['DdlSemester'])===false) if($_POST['DdlSemester'] == 'SEMESTER-VI') { ?>selected="true" <?php }; ?>value="SEMESTER-VI">SEMESTER-VI</option>
  						</select>
				</td>
			</tr>
			<?php if(!empty($sem_err)) echo("<tr><td></td><td><span>$sem_err</span></td></tr>");?>
			<tr>
				<td></td>
				<td>
					<!-- <input type="submit" value="Next" name="BtnNext" onclick="checkdata()"> -->
        	<input type="submit" value="Next" name="BtnNext">
				</td>
			</tr>
		</table>
  </center>
	</form>
</body>
</html>