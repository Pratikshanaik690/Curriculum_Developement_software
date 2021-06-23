<?php
	session_start();
	$level_of_course = $pre_requisite = $final_result = "";
	$weekly_theory_hours = $weekly_practical_hours = $total_credits = $total_weeks = $total_theory_hours = $total_practical_hours = 0;

	$level_of_course_err = $pre_requisite_err = "";
	$weekly_theory_hours_err = $weekly_practical_hours_err = $total_credits_err = $total_weeks_err = $total_theory_hours_err = $total_practical_hours_err = "";

	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		if(array_key_exists("BtnSave", $_POST))
		{

			$c = 0;

			if(array_key_exists("TxtLevelOfCourse", $_POST))
			{
				if(empty(trim($_POST["TxtLevelOfCourse"])))
				{
					$level_of_course_err = "Level of course is required";
					$c++;
				}
				else
				{
					$level_of_course = strtoupper(trim($_POST["TxtLevelOfCourse"]));
					$level_of_course_err = "";
				}
			}

			if(array_key_exists("TxtPreRequisite", $_POST))
			{
				if(empty(trim($_POST["TxtPreRequisite"])))
				{
					$pre_requisite_err = "Prerequisite is required";
					$c++;
				}
				else
				{
					$pre_requisite = strtoupper(trim($_POST["TxtPreRequisite"]));
					$pre_requisite_err = "";
				}
			}


			if(array_key_exists("TxtWeeklyTheoryHours", $_POST))
			{
				if(empty(trim($_POST["TxtWeeklyTheoryHours"])))
				{
					$weekly_theory_hours_err = "Weekly theory hours is required";
					$c++;
				}
				else
				{
					$weekly_theory_hours = intval(strtoupper(trim($_POST["TxtWeeklyTheoryHours"])));
					$weekly_theory_hours_err = "";
				}
			}

			if(array_key_exists("TxtWeeklyPracticalHours", $_POST))
			{
				if(empty(trim($_POST["TxtWeeklyPracticalHours"])))
				{
					$weekly_practical_hours_err = "Weekly practical hours is required";
					$c++;
				}
				else
				{
					$weekly_practical_hours = intval(strtoupper(trim($_POST["TxtWeeklyPracticalHours"])));
					$weekly_practical_hours_err = "";
				}
			}

			if(array_key_exists("TxtTotalCredits", $_POST))
			{
				if(empty(trim($_POST["TxtTotalCredits"])))
				{
					$total_credits_err = "Total credit is required";
					$c++;
				}
				else
				{
					$total_credits = intval(strtoupper(trim($_POST["TxtTotalCredits"])));
					$total_credits_err = "";
				}
			}

			if(array_key_exists("TxtTotalWeeks", $_POST))
			{
				if(empty(trim($_POST["TxtTotalWeeks"])))
				{
					$total_weeks_err = "Total weeks are required";
					$c++;
				}
				else
				{
					$total_weeks = intval(strtoupper(trim($_POST["TxtTotalWeeks"])));
					$total_weeks_err = "";
				}
			}

			if(array_key_exists("TxtTotalTheoryHours", $_POST))
			{
				if(empty(trim($_POST["TxtTotalTheoryHours"])))
				{
					$total_theory_hours_err = "Total theory hours are required";
					$c++;
				}
				else
				{
					$total_theory_hours = intval(strtoupper(trim($_POST["TxtTotalTheoryHours"])));
					$total_theory_hours_err = "";
				}
			}

			if(array_key_exists("TxtTotalPracticalHours", $_POST))
			{
				if(empty(trim($_POST["TxtTotalPracticalHours"])))
				{
					$total_practical_hours_err = "Total practical hours are required";
					$c++;
				}
				else
				{
					$total_practical_hours = intval(strtoupper(trim($_POST["TxtTotalPracticalHours"])));
					$total_practical_hours_err = "";
				}
			}

			if($c == 0)
			{
				try
				{
					$con = mysqli_connect("127.0.0.1", "root", "super", "gp_cur_db");
					if($con == false)
                	print("Error: ".mysqli_connect_error());
                	else
                	{
                		$sql = "insert into teaching_scheme (department, semester, subject, subject_code, level_of_course, pre_requisite, weekly_theory_hours, weekly_practical_hours, total_credits, total_weeks, total_theory_hours, total_practical_hours) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
						$ps = mysqli_prepare($con, $sql);
                		if($ps != false)
                		{
                			$dept = $_SESSION["dept"];
							$sem = $_SESSION["sem"];
							$subject = $_SESSION["subject"];
							$subject_code = $_SESSION["subject_code"];

							mysqli_stmt_bind_param($ps,"ssssssiiiiii", $dept, $sem, $subject, $subject_code, $level_of_course, $pre_requisite, $weekly_theory_hours, $weekly_practical_hours, $total_credits, $total_weeks, $total_theory_hours, $total_practical_hours);
                        	mysqli_stmt_execute($ps);
                        	$n = mysqli_stmt_affected_rows($ps);
                        	mysqli_stmt_close($ps);
                        	mysqli_close($con);
                        	if($n == 1)
                        	{
                            	//print("Teaching scheme saved.<br/>");
                            	$final_result = "<font face=calibri size=3pt color=green>Teaching scheme saved.</font><br>";
							}
                        	else
                        	{                        
                        		$final_result = "<font face=calibri size=3pt color=red>Sorry! Teaching scheme not saved.</font><br>";                                
                        	}
                		}
                		else
                		{
                			mysqli_close($con);
                			print("Prepared statement is not created.<br/>");
                		}                		
                	}
				}
				catch(Exception $ex)
				{
					print($ex->getmessage()."<br/>");
				}
			}

		}// end if BtnSave
	} // end if POST

?>
<html>
<head>
	<style>
      span
      {
          font-family: Calibri;
          font-size: 17px;
          color: red;
      }
    </style>
	<!-- to clear browser cache -->
    <meta http-equiv="cache-control" content="no-cache">
	  <link href="styles/add_subjects.css" rel="stylesheet"/>
	  <link rel="stylesheet" href="bootstrap/bootstrap.min.css">      
  	<script src="bootstrap/jquery.min.js"></script>
  	<script src="bootstrap/bootstrap.min.js"></script>
</head>
<body>
	<form action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" name="f1">
	<div class="panel panel-default">
  		<div class="panel-heading">
        	<font face="calibri" size="5pt" color="green">
          		Add Teaching Scheme
        	</font><br/>
  			<font face="calibri" size="3pt" color="green">  				
  				<?php  					
  					if(array_key_exists("dept", $_SESSION))
  					{
  						if(isset($_SESSION["dept"]))
  						{
  							$dept = $_SESSION["dept"];
  							echo "Department:", $dept, "<br/>";
  						}
  					}
  								
  					if(array_key_exists("sem", $_SESSION)) 
  					{
  						if(isset($_SESSION["sem"]))
  						{
  							$sem = $_SESSION["sem"];
  							echo "Semester:", $sem, "<br/>";
  						}
  					}

  					if(array_key_exists("subject", $_SESSION)) 
  					{
  						if(isset($_SESSION["subject"]))
  						{
  							$subject = $_SESSION["subject"];
  							echo "Subject:", $subject, "<br/>";
  						}
  					}

  					if(array_key_exists("subject_code", $_SESSION)) 
  					{
  						if(isset($_SESSION["subject_code"]))
  						{
  							$subject_code = $_SESSION["subject_code"];
  							echo "Subject Code:", $subject_code, "<br/>";
  						}
  					}
  				?>
  			</font>
  		</div>
  		<!-- <div class="panel-body"> -->
      <div>
   			<table>
   				<tr>
   					<td>Level of Course</td>
   					<td><input type="text" name="TxtLevelOfCourse" <?php if(array_key_exists("TxtLevelOfCourse", $_POST)) if(!empty($_POST["TxtLevelOfCourse"])) print("value='".$_POST["TxtLevelOfCourse"]."'"); ?>></td>
   				</tr>
   				<?php
      				if(!empty($level_of_course_err))
      					print("<tr><td></td><td><span>$level_of_course_err</span></td></tr>");
      			?>
   				<tr>
   					<td>Pre-requisite</td>
   					<td><input type="text" name="TxtPreRequisite" <?php if(array_key_exists("TxtPreRequisite", $_POST)) if(!empty($_POST["TxtPreRequisite"])) print("value='".$_POST["TxtPreRequisite"]."'"); ?>></td>
   				</tr>
   				<?php
      				if(!empty($pre_requisite_err))
      					print("<tr><td></td><td><span>$pre_requisite_err</span></td></tr>");
      			?>
   				<tr>
   					<td>Weekly Theory Hours</td>
   					<td><input type="text" name="TxtWeeklyTheoryHours" <?php if(array_key_exists("TxtWeeklyTheoryHours", $_POST)) if(!empty($_POST["TxtWeeklyTheoryHours"])) print("value='".$_POST["TxtWeeklyTheoryHours"]."'"); ?>></td>
   				</tr>
   				<?php
      				if(!empty($weekly_theory_hours_err))
      					print("<tr><td></td><td><span>$weekly_theory_hours_err</span></td></tr>");
      			?>
   				<tr>
   					<td>Weekly Practical Hours</td>
   					<td><input type="text" name="TxtWeeklyPracticalHours" <?php if(array_key_exists("TxtWeeklyPracticalHours", $_POST)) if(!empty($_POST["TxtWeeklyPracticalHours"])) print("value='".$_POST["TxtWeeklyPracticalHours"]."'"); ?>></td>
   				</tr>
   				<?php
      				if(!empty($weekly_practical_hours_err))
      					print("<tr><td></td><td><span>$weekly_practical_hours_err</span></td></tr>");
      			?>
   				<tr>
   					<td>Total Credits</td>
   					<td><input type="text" name="TxtTotalCredits" <?php if(array_key_exists("TxtTotalCredits", $_POST)) if(!empty($_POST["TxtTotalCredits"])) print("value='".$_POST["TxtTotalCredits"]."'"); ?>></td>
   				</tr>
   				<?php
      				if(!empty($total_credits_err))
      					print("<tr><td></td><td><span>$total_credits_err</span></td></tr>");
      			?>
   				<tr>
   					<td>Total Weeks</td>
   					<td><input type="text" name="TxtTotalWeeks" <?php if(array_key_exists("TxtTotalWeeks", $_POST)) if(!empty($_POST["TxtTotalWeeks"])) print("value='".$_POST["TxtTotalWeeks"]."'"); ?>></td>
   				</tr>
   				<?php
      				if(!empty($total_weeks_err))
      					print("<tr><td></td><td><span>$total_weeks_err</span></td></tr>");
      			?>
   				<tr>
   					<td>Total Theory Hours</td>
   					<td><input type="text" name="TxtTotalTheoryHours" <?php if(array_key_exists("TxtTotalTheoryHours", $_POST)) if(!empty($_POST["TxtTotalTheoryHours"])) print("value='".$_POST["TxtTotalTheoryHours"]."'"); ?>></td>
   				</tr>
   				<?php
      				if(!empty($total_theory_hours_err))
      					print("<tr><td></td><td><span>$total_theory_hours_err</span></td></tr>");
      			?>
   				<tr>
   					<td>Total Practical Hours</td>
   					<td><input type="text" name="TxtTotalPracticalHours" <?php if(array_key_exists("TxtTotalPracticalHours", $_POST)) if(!empty($_POST["TxtTotalPracticalHours"])) print("value='".$_POST["TxtTotalPracticalHours"]."'"); ?>></td>
   				</tr>
   				<?php
      				if(!empty($total_practical_hours_err))
      					print("<tr><td></td><td><span>$total_practical_hours_err</span></td></tr>");
      			?>
   				<tr>
   					<td></td>
   					<td><input type="submit" name="BtnSave" value="Save"></td>
   				</tr>
   				<?php
      				if(!empty($final_result))
      					print("<tr><td></td><td>$final_result</td></tr>");
      			?>
   			</table>
      </div>
    </div>

    <!--Teaching Scheme-->
    <div>
      <a href="select_subject.php">Back</a><br/>
    	<?php
    		function load_teaching_scheme($dept, $sem, $subject, $subject_code)
    		{
    			try
    			{
    				$con = mysqli_connect("127.0.0.1", "root", "super", "gp_cur_db");
    				if($con ==  false)
                    print("Error: ".mysqli_connect_error());
                    else
                    {
                    	$sql = "select srno, level_of_course, pre_requisite, weekly_theory_hours, weekly_practical_hours, total_credits, total_weeks, total_theory_hours, total_practical_hours from teaching_scheme where department=? and semester=? and subject=? and subject_code=?";
						$ps = mysqli_prepare($con, $sql);
						if($ps != false)
						{
							mysqli_stmt_bind_param($ps,"ssss", $dept, $sem, $subject, $subject_code);
                        	mysqli_stmt_execute($ps);
                        	$srno = $weekly_theory_hours = $weekly_practical_hours = $total_credits = $total_weeks = $total_theory_hours = $total_practical_hours = 0;
                        	$level_of_course = $pre_requisite = "";
                        	print("<table width='100%' cellspacing='0' cellpadding='5' border='1' style='text-align:center;'>");
                        	print("<tr><th rowspan='2'>LEVEL OF COURSE</th><th rowspan='2'>PREREQUISITE</th><th colspan='2'>WEEKLY CONTACT HR</th><th rowspan='2'>TOTAL CREDIT</th><th rowspan='2'>TOTAL WEEKS</th><th colspan='2'>TOTAL CONTACT HOURS</th></tr>");
                        	print("<tr><th>TH</th><th>PR</th><th>TH</th><th>PR</th></tr>");
                        	mysqli_stmt_bind_result($ps, $srno, $level_of_course, $pre_requisite,$weekly_theory_hours, $weekly_practical_hours, $total_credits, $total_weeks, $total_theory_hours, $total_practical_hours);
							if(mysqli_stmt_fetch($ps))
							{
								print("<tr>");
								print("<td>$level_of_course</td>");
								print("<td>$pre_requisite</td>");
								print("<td>$weekly_theory_hours</td>");
								print("<td>$weekly_practical_hours</td>");
								print("<td>$total_credits</td>");
								print("<td>$total_weeks</td>");
								print("<td>$total_theory_hours</td>");
								print("<td>$total_practical_hours</td>");								
								print("</tr>");
								//print("<tr><td colspan='8'><a href='delete_teaching_scheme.php?srno=$srno'>Delete</a></td></tr>");
							}
							print("</table>");
                        	mysqli_stmt_close($ps);
                        	mysqli_close($con);
						}   
						else
						{
							mysqli_close($con);
                        	print("Prepared Statement not created..<br/>");
						}                 	
                    }
    			}
    			catch(Exception $ex)
    			{
    				print($ex->getmessage()."<br/>");
    			}
    		}// end of function load_teaching_scheme
    		print("<font face='calibri' size='5pt' color='black'>TEACHING SCHEME</font><br/>");
    		load_teaching_scheme($dept, $sem, $subject, $subject_code);
    	?>
    </div>
</form>
</body>
</html>