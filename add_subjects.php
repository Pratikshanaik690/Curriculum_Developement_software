<?php
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
?>

<html>
	<head>
		<title>Government Polyechnic Amravati: Add Subjects</title>
		<meta charset="utf-8">
  		<meta name="viewport" content="width=device-width, initial-scale=1">
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
		<form action="add_subject_next.php" method="post" name="f1">
			<div class="panel panel-default">
  				<div class="panel-heading">
  					<font face="calibri" size="5pt" color="green">
  						Add Subject
  					</font>
  				</div>
  				<div class="panel-body">
  					<table>              
  						<tr>
                <td>Department</td>
  							<td>
  								<select name="DdlDept">
  									<option value="-1">-- Select Department--</option>
                        			<option>COMPUTER</option>
                        			<option>INFORMATION TECHNOLOGY</option>
                        			<option>MECHANICAL</option>                        
                        			<option>ELECTRONICS</option>                       
                        			<option>CIVIL</option>                        		
                        			<option>ELECTRICAL</option>
                        			<option>PLASTIC AND POLYMER</option>                                   
  								</select>
  							</td>  							
  						</tr>  						
  						<tr>
                <td>Semester</td>
  							<td>
  								<select name="DdlSemester">
  									<option value="-1">-- Select Semester--</option>
  									<option>SEMESTER-I</option>
  									<option>SEMESTER-II</option>
  									<option>SEMESTER-III</option>
  									<option>SEMESTER-IV</option>
  									<option>SEMESTER-V</option>
  									<option>SEMESTER-VI</option>
  								</select>
  							</td>  							
  						</tr>              
  						<tr>
                <td></td>
  							<td>
  								<input type="button" value="Next" name="BtnNext" onclick="checkdata()">
  							</td>  							
  						</tr>
  					</table>
  				</div>
			</div>
		</form>
	</body>
</html>