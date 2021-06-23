<?php	
	$dept = $sem = $subject = $subject_code = "";
	$unit_number = $unit_name = $unit_content = $hours = $marks = $strategies = $final_result = "";
	$unit_number_err = $unit_name_err = $unit_content_err = $hours_err = $marks_err = $strategies_err = "";

	session_start();
	if(empty($_SESSION["userid"]))
	{
		clearstatcache();
		header('Window-target:_top');
		header("location:pagenotfound.php");
	}
	else
	{
		//print_r($_POST);
		if(array_key_exists("DdlSubjects", $_POST))
		{
			if(!empty(trim($_POST["DdlSubjects"])))
			{
				$subject = $_POST["DdlSubjects"];
				$_SESSION["subject"] = $subject;
				if(array_key_exists("dept", $_SESSION) and array_key_exists("sem", $_SESSION))
				{
					if(!empty($_SESSION["dept"]) && isset($_SESSION["sem"]))
					{
						$dept = $_SESSION["dept"];
						$sem = $_SESSION["sem"];
						$sql = "select subject_code from subjects where department=? and semester=? and subject=?";
						try 
						{
							$con = mysqli_connect("127.0.0.1", "root", "super", "gp_cur_db");
  							if($con == false)
                			print("Error: ".mysqli_connect_error());
                			else
                			{
                				$ps = mysqli_prepare($con, $sql);
                				mysqli_stmt_bind_param($ps,"sss", $dept, $sem, $subject);
                				mysqli_stmt_execute($ps);
                				$subject_code = "";
                				mysqli_stmt_bind_result($ps, $subject_code);
                				mysqli_stmt_fetch($ps);
                				mysqli_stmt_close($ps);
                        mysqli_close($con);
                        $_SESSION["subject_code"] = $subject_code;
                			}
						} 
						catch (Exception $ex) 
						{
							print($ex->getmessage()."<br/>");
						}	
					}
				}
			}
		}
	}


	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		//print_r($_POST);
		//print("<br/>");
		$c = 0;

		if(array_key_exists("b2", $_POST))
		{
			unset($unit_number_err);
			unset($unit_name_err);
			unset($unit_content_err);
			unset($final_result);
		}
		else
		{
			if(array_key_exists("TxtUnitNumber", $_POST))
			{
				if(empty(trim($_POST["TxtUnitNumber"])))
				{
					$unit_number_err = "Unit number is required";
					$c++;
				}
				else
				{
					$unit_number = trim($_POST["TxtUnitNumber"]) + 0;
					unset($unit_number_err);
				}
			}

			if(array_key_exists("TxtUnitName", $_POST))
			{
				if(empty(trim($_POST["TxtUnitName"])))
				{
					$unit_name_err = "Unit name is required";
					$c++;
				}
				else
				{
					$unit_name = trim($_POST["TxtUnitName"]);
					unset($unit_name_err);
				}
			}	

			if(array_key_exists("TxtUnitContents", $_POST))
			{
				if(empty(trim($_POST["TxtUnitContents"])))
				{
					$unit_content_err = "Unit contents are required";
					$c++;
				}
				else
				{
					$unit_content = trim($_POST["TxtUnitContents"]);
					unset($unit_content_err);
				}
			}

      if(array_key_exists("TxtHours", $_POST))
      {
        if(empty(trim($_POST["TxtHours"])))
        {
          $hours_err = "Hours are required";
          $c++;
        }
        else
        {
          $hours = trim($_POST["TxtHours"]);
          unset($hours_err);
        }
      }

      if(array_key_exists("TxtMarks", $_POST))
      {
        if(empty(trim($_POST["TxtMarks"])))
        {
          $marks_err = "Marks are required";
          $c++;
        }
        else
        {
          $marks = trim($_POST["TxtMarks"]);
          unset($marks_err);
        }
      }

      if(array_key_exists("TxtStrategies", $_POST))
      {
        if(empty(trim($_POST["TxtStrategies"])))
        {
          $strategies_err = "Strategies are required";
          $c++;
        }
        else
        {
          $strategies = trim($_POST["TxtStrategies"]);
          unset($strategies_err);
        }
      }

			/*
			print("c = $c<br/>");
			print("dept = $dept<br/>");
			print("sem = $sem<br/>");
			print("Subject = $subject<br/>");
			print("Subject code = $subject_code<br/>");
			print("unit number = $unit_number<br/>");
			print("Unit Name = $unit_name<br/>");
			print("Unit Contents = $unit_content<br/>");
			*/
			if(array_key_exists("b1", $_POST))
      {
          $dept = $_SESSION["dept"];
          $sem = $_SESSION["sem"];
          $subject = $_SESSION["subject"];
          $subject_code = $_SESSION["subject_code"];
          if($c == 0 && !empty($dept) && !empty($sem) && !empty($subject) && !empty($subject_code) && !empty($unit_number) && !empty($unit_name) && !empty($unit_content) && !empty($hours) && !empty($marks) && !empty($strategies))
          {
              try
              {       
                  $sql = "insert into contents (department, semester, subject, subject_code, unit_number, unit_name, unit_contents, hours, marks, strategies) values(?,?,?,?,?,?,?,?,?,?)";
                  $con = mysqli_connect("127.0.0.1", "root", "super", "gp_cur_db");
                  if($con ==  false)
                  print("Error: ".mysqli_connect_error());      
                  else
                  {
                      $ps = mysqli_prepare($con, $sql);
                      if($ps != false)
                      {
                          mysqli_stmt_bind_param($ps, "ssssissiis",$dept, $sem, $subject, $subject_code, $unit_number,$unit_name, $unit_content, $hours, $marks, $strategies);
                          mysqli_stmt_execute($ps);
                          $n = mysqli_stmt_affected_rows($ps);
                          mysqli_stmt_close($ps);
                          mysqli_close($con);                    
                          if($n == 1)
                          {
                              //print("Contents saved..<br/>");
                              $final_result = "<font face=calibri size=3pt color=green>Contents saved...</font>";
                          }
                          else
                          {
                              //print("Contents not saved..<br/>");                       
                              $final_result = "<font face=calibri size=3pt color=red>Contents not saved...</font>";
                          }
                      }
                      else
                      {
                          print("Prepared Statement not created..");
                          mysqli_close($con);
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
	}
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
  	<script>
  		function checkdata()
  		{
  			var msg = "";
  			if(document.f1.TxtUnitNumber.value.trim().length <= 0)
  			msg = msg + "Unit number is required\n";

  			if(document.f1.TxtUnitName.value.trim().length <= 0)
  			msg = msg + "Unit name is required\n";

  			if(document.f1.TxtUnitContents.value.trim().length <= 0)
  			msg = msg + "Unit contents are required\n";

        if(document.f1.TxtHours.value.trim().length <= 0)
        msg = msg + "Hours are required\n";

        if(document.f1.TxtMarks.value.trim().length <= 0)
        msg = msg + "Marks are required\n";

        if(document.f1.TxtStrategies.value.trim().length <= 0)
        msg = msg + "Instructional strategies are required\n";

  			if(msg!="")
  			{
  				alert(msg);
  				return;
  			}
  			else
  			document.f1.submit();
  		}

  		function cleardata()
  		{
  			document.f1.TxtUnitNumber.value = "";
  			document.f1.TxtUnitName.value = "";
  			document.f1.TxtUnitContents.value = "";
        document.f1.TxtHours.value = "";
        document.f1.TxtMarks.value = "";
        document.f1.TxtStrategies.value = "";
  			document.f1.submit();
  		}
  	</script>
</head>
<body>
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" name="f1">
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
  		<!-- <div class="panel-body"> -->
        <div>
        	<table>
        		<tr>
        			<td>Unit Number</td>
        			<td><input type="text" name="TxtUnitNumber" <?php if(array_key_exists("TxtUnitNumber", $_POST)) if(empty(trim($_POST['TxtUnitNumber']))===false) echo "value=".trim($_POST['TxtUnitNumber']); ?>></td>
        		</tr>
        		<?php if(!empty($unit_number_err)) echo("<tr><td></td><td><span>$unit_number_err</span></td></tr>");?>
        		<tr>
        			<td>Unit Name</td>
        			<td><input type="text" name="TxtUnitName" <?php if(array_key_exists("TxtUnitName", $_POST)) if(empty(trim($_POST['TxtUnitName']))===false) echo "value=".trim($_POST['TxtUnitName']); ?>></td>
        		</tr>
        		<?php if(!empty($unit_name_err)) echo("<tr><td></td><td><span>$unit_name_err</span></td></tr>");?>
        		<tr>
        			<td>Unit Contents</td>
        			<td>
        				<!--Note: Write the entire coding of textarea on the same 
        					line otherwise it will contail leading blank spaces-->
        				<textarea name="TxtUnitContents" cols="120" rows="10"><?php if(array_key_exists("TxtUnitContents", $_POST)) if(empty(trim($_POST['TxtUnitContents'])) === false) echo trim($_POST['TxtUnitContents']); ?></textarea>
        			</td>
        		</tr>
        		<?php if(!empty($unit_content_err)) echo("<tr><td></td><td><span>$unit_content_err</span></td></tr>");?>
            <tr>
              <td>Hours</td>
              <td><input type="text" name="TxtHours" <?php if(array_key_exists("TxtHours", $_POST)) if(empty(trim($_POST['TxtHours']))===false) echo "value=".trim($_POST['TxtHours']); ?>></td>
            </tr>
            <?php if(!empty($hours_err)) echo("<tr><td></td><td><span>$hours_err</span></td></tr>");?>
            <tr>
              <td>Marks</td>
              <td><input type="Text" name="TxtMarks" <?php if(array_key_exists("TxtMarks", $_POST)) if(empty(trim($_POST['TxtMarks']))===false) echo "value=".trim($_POST['TxtMarks']); ?>></td>
            </tr>
            <?php if(!empty($marks_err)) echo("<tr><td></td><td><span>$marks_err</span></td></tr>");?>
            <tr>
              <td>Instructional<br/>Strategies</td>
              <td>
                <textarea rows="5" cols="120" name="TxtStrategies"><?php if(array_key_exists("TxtStrategies", $_POST)) if(empty(trim($_POST['TxtStrategies']))===false) echo trim($_POST['TxtStrategies']); ?></textarea>
              </td>
            </tr>
            <?php if(!empty($strategies_err)) echo("<tr><td></td><td><span>$strategies_err</span></td></tr>");?>
        		<tr>
        			<td></td>
        			<td>
                <input type="Submit" value="Save" name="b1" onclick="checkdata()">                
        				<input type="submit" value="Clear" name="b2" onclick="cleardata()">        				        				
        			</td>
        		</tr>
        		<?php if(!empty($final_result)) echo("<tr><td></td><td>$final_result</td></tr>");?>
        	</table>
        </div>
    </div>
    <hr style='border:none;height:1px;background-color:orange;'/>
    <a href="select_subject.php">Back</a><br/>
    <!--Content List-->
    <div>
      <?php
          $dept = $_SESSION["dept"];
          $sem = $_SESSION["sem"];
          $subject = $_SESSION["subject"];
          $subject_code = $_SESSION["subject_code"];
          //print("Department = $dept<br/>");
          //print("Semester = $sem<br/>");
          //print("Subject = $subject<br/>");
          //print("Subject Code = $subject_code<br/>");

          try
          {              
              $con = mysqli_connect("127.0.0.1", "root", "super", "gp_cur_db");
              if($con ==  false)
              print("Error: ".mysqli_connect_error());
              else
              {
                  $sql = "select srno, unit_number, unit_name, unit_contents, hours, marks, strategies from contents where department=? and semester=? and subject=? and subject_code=?";
                  $ps = mysqli_prepare($con, $sql);
                  if($ps !== false)
                  {
                      mysqli_stmt_bind_param($ps,"ssss", $dept, $sem, $subject, $subject_code);
                      mysqli_stmt_execute($ps);
                      $srno = $unit_number = $hours = $marks = 0;
                      $unit_name = $unit_contents = $strategies = "";
                      mysqli_stmt_bind_result($ps, $srno,$unit_number, $unit_name, $unit_contents, $hours, $marks, $strategies);
                      while(mysqli_stmt_fetch($ps)) // while(mysqli_stmt_fetch($ps) != null)
                      {
                          print("<table cellspacing='0' cellpadding='5' border='1px' width='50%' style='font-family:calibri;font-size:17px;'>");

                          print("<tr>");
                          print("<th style='width:200px;'>Unit Number</th>");
                          print("<td style='text-align:justify;'>$unit_number</td>");
                          print("</tr>");

                          print("<tr>");
                          print("<th>Unit Name</th>");
                          print("<td style='text-align:justify;'>$unit_name</td>");
                          print("</tr>");

                          print("<tr>");
                          print("<th>Unit Contents</th>");
                          print("<td style='text-align:justify;'>$unit_contents</td>");
                          print("</tr>");

                          print("<tr>");
                          print("<th>Hours</th>");
                          print("<td style='text-align:justify;'>$hours</td>");
                          print("</tr>");

                          print("<tr>");
                          print("<th>Marks</th>");
                          print("<td style='text-align:justify;'>$marks</td>");
                          print("</tr>");

                          print("<tr>");
                          print("<th>Instructional Strategies</th>");
                          print("<td style='text-align:justify;'>$strategies</td>");
                          print("</tr>");

                          print("<tr>");                          
                          print("<td colspan='2' style='text-align:right;'>");
                          print("<a href='delete_contents.php?srno=$srno'>Delete</a>");
                          print("&nbsp;");
                          print("<a href='edit_contents.php?srno=$srno'>Edit</a>");
                          print("</td>");
                          print("</tr>");

                          print("</table>");
                          print("<hr style='border:none;height:1px;background-color:orange;'/>");
                      }
                      mysqli_stmt_close($ps);
                      mysqli_close($con);
                  }
                  else
                  {
                      mysqli_close($con);
                      print("Prepared statement is not created..<br/>");
                  }                
              }              
          }
          catch(Exception $ex)
          {
              print($ex->getmessage()."<br/>");
          }
      ?>
    </div>
	</form>
</body>
</html>