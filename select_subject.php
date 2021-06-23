<?php
    session_start();
    function get_subject_code()
    {
        try
        {
            $con = mysqli_connect("127.0.0.1", "root", "super", "gp_cur_db");
            if($con == false)
            print("Error: ".mysqli_connect_error());
            else
            {
                $d = $_SESSION["dept"];
                $sem = $_SESSION["sem"];
                $subject = $_SESSION["subject"];
                $ss = "";
                $sql = "select subject_code from subjects where department=? and semester=? and subject=?";
                $ps = mysqli_prepare($con, $sql);
                if($ps != false)
                {   
                    mysqli_stmt_bind_param($ps,"sss", $d, $sem, $subject);
                    mysqli_stmt_execute($ps);
                    mysqli_stmt_bind_result($ps, $ss);
                    if(mysqli_stmt_fetch($ps)!==null)
                    {
                        $_SESSION["subject_code"] = $ss;
                        //print($_SESSION["subject_code"]);
                    }
                    mysqli_stmt_close($ps);
                    mysqli_close($con);
                }
                else
                {
                    mysqli_close($con);
                    print("Prepared statement not created.<br/>");
                }                                  
            }
        }
        catch(Exception $ex)
        {
            print($ex->getmessage()."<br/>");
        }
    }
  
    $subject = "";
    $subject_err = "";
    $c = 0;
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
      if(array_key_exists("DdlSubjects", $_POST))
      {
        if ($_POST["DdlSubjects"] == "-1") 
        {
          $subject_err = "Subject is required";
          $c++;
        }
        else
        {
          $subject = $_POST["DdlSubjects"];
          $_SESSION["subject"] = $subject;
          $subject_err = "";
        }
      }

      if(array_key_exists("BtnAddContents", $_POST))
      {
          if($c == 0)
          {
              try
              {
                  $con = mysqli_connect("127.0.0.1", "root", "super", "gp_cur_db");
                  if($con == false)
                  print("Error: ".mysqli_connect_error());
                  else
                  {
                      $d = $_SESSION["dept"];
                      $sem = $_SESSION["sem"];
                      $ss = "";
                      $sql = "select subject_code from subjects where department=? and semester=? and subject=?";
                      $ps = mysqli_prepare($con, $sql);
                      if($ps != false)
                      {   
                          mysqli_stmt_bind_param($ps,"sss", $d, $sem, $subject);
                          mysqli_stmt_execute($ps);
                          mysqli_stmt_bind_result($ps, $ss);
                          if(mysqli_stmt_fetch($ps)!==null)
                          {
                              $_SESSION["subject_code"] = $ss;
                          }
                          mysqli_stmt_close($ps);
                          mysqli_close($con);
                      }
                      else
                      {
                          mysqli_close($con);
                          print("Prepared statement not created.<br/>");
                      }                                  
                  }
              }
              catch(Exception $ex)
              {
                  print($ex->getmessage()."<br/>");
              }

              $_SESSION["subject"] = $subject;
              header("location:add_contents.php");
          }
      } // End if BtnAddContents
      elseif(array_key_exists("BtnAddPracticals", $_POST))
      {
          if($c == 0)
          {
              try
              {
                  $con = mysqli_connect("127.0.0.1", "root", "super", "gp_cur_db");
                  if($con == false)
                  print("Error: ".mysqli_connect_error());
                  else
                  {
                      $d = $_SESSION["dept"];
                      $sem = $_SESSION["sem"];
                      $ss = "";
                      $sql = "select subject_code from subjects where department=? and semester=? and subject=?";
                      $ps = mysqli_prepare($con, $sql);
                      if($ps != false)
                      {   
                          mysqli_stmt_bind_param($ps,"sss", $d, $sem, $subject);
                          mysqli_stmt_execute($ps);
                          mysqli_stmt_bind_result($ps, $ss);
                          if(mysqli_stmt_fetch($ps)!==null)
                          {
                              $_SESSION["subject_code"] = $ss;
                          }
                          mysqli_stmt_close($ps);
                          mysqli_close($con);
                      }
                      else
                      {
                          mysqli_close($con);
                          print("Prepared statement not created.<br/>");
                      }                                  
                  }
              }
              catch(Exception $ex)
              {
                  print($ex->getmessage()."<br/>");
              }
              
              $_SESSION["subject"] = $subject;
              header("location:add_practicals.php");
          }
      } // end if BtnAddPracticals
      elseif(array_key_exists("BtnAddBooks", $_POST))
      {
          if($c == 0)
          {
              try
              {
                  $con = mysqli_connect("127.0.0.1", "root", "super", "gp_cur_db");
                  if($con == false)
                  print("Error: ".mysqli_connect_error());
                  else
                  {
                      $d = $_SESSION["dept"];
                      $sem = $_SESSION["sem"];
                      $ss = "";
                      $sql = "select subject_code from subjects where department=? and semester=? and subject=?";
                      $ps = mysqli_prepare($con, $sql);
                      if($ps != false)
                      {   
                          mysqli_stmt_bind_param($ps,"sss", $d, $sem, $subject);
                          mysqli_stmt_execute($ps);
                          mysqli_stmt_bind_result($ps, $ss);
                          if(mysqli_stmt_fetch($ps)!==null)
                          {
                              $_SESSION["subject_code"] = $ss;
                          }
                          mysqli_stmt_close($ps);
                          mysqli_close($con);
                      }
                      else
                      {
                          mysqli_close($con);
                          print("Prepared statement not created.<br/>");
                      }                                  
                  }
              }
              catch(Exception $ex)
              {
                  print($ex->getmessage()."<br/>");
              }
              
              $_SESSION["subject"] = $subject;
              header("location:add_books.php");
          }
      }// end if BtnAddBooks
      elseif(array_key_exists("BtnAddTeachingScheme", $_POST))
      {
          if($c == 0)
          {
              get_subject_code();
              $_SESSION["subject"] = $subject;
              header("location:add_teaching_scheme.php");
          }
      }// end if BtnAddTeachingScheme
      elseif(array_key_exists("BtnAddExamScheme", $_POST))
      {
          if($c == 0)
          {
              get_subject_code();
              $_SESSION["subject"] = $subject;
              header("location:add_exam_scheme.php");
          }
      }// end if BtnAddExamScheme
      elseif(array_key_exists("BtnAddSpecificationTable", $_POST))
      {
          if($c == 0)
          {
              get_subject_code();
              $_SESSION["subject"] = $subject;
              header("location:add_specification_table.php");
          }
      }// end if BtnAddSpecificationTable
      elseif(array_key_exists("BtnAddCourseOutcomes", $_POST))
      {
          if($c == 0)
          {
              get_subject_code();
              $_SESSION["subject"] = $subject;
              header("location:add_course_outcomes.php");
          } 
      }// end if BtnAddCourseOutcomes
      elseif(array_key_exists("BtnAddSuggestedActivities", $_POST))
      {
          if($c == 0)
          {
              get_subject_code();
              $_SESSION["subject"] = $subject;
              header("location:add_suggested_activities.php");
          } 
      }// end if BtnAddSuggestedActivities
      elseif(array_key_exists("BtnAddSuggestedMicroProjects", $_POST))
      {
          if($c == 0)
          {
              get_subject_code();
              $_SESSION["subject"] = $subject;
              header("location:add_suggested_micro_projects.php");
          } 
      }// end if BtnAddSuggestedMicroProjects



    }// end if request_method = post
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
  	<script>
  		function checkdata()
  		{
  			var msg = "";
  			if(document.f1.DdlSubjects.value == "-1")
  				msg = msg + "Subject is required\n";

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
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" name="f1">
	<div class="panel panel-default">
  		<div class="panel-heading">
        <font face="calibri" size="5pt" color="green">
          Select Subject
        </font><br/>
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
  			</font>
  		</div>
  		<!-- <div class="panel-body"> -->
      <div>
      <table cellpadding="5" cellspacing="0">
			<tr>
				<td>Subject</td>
				<td>
					<select name="DdlSubjects">
  						<option value="-1">-- Select Subject --</option>
  						<?php
  							if(!empty(trim($_SESSION["dept"])) and !empty(trim($_SESSION["sem"])))
  							{
  								try
  								{
  									$dept = strtoupper(trim($_SESSION["dept"]));
  									$sem = strtoupper(trim($_SESSION["sem"]));
  									$sql = "select subject from subjects where department=? and semester=?";
  									$con = mysqli_connect("127.0.0.1", "root", "super", "gp_cur_db");
  									if($con == false)
                					print("Error: ".mysqli_connect_error());
                					else
                					{
                						print("dept = $dept<br/>");
                						print("sem = $sem<br/>");
                						$ps = mysqli_prepare($con, $sql);
                						mysqli_stmt_bind_param($ps,"ss", $dept, $sem);
                						mysqli_stmt_execute($ps);
                						$subject = "";
                						mysqli_stmt_bind_result($ps, $subject);
                							
                						while(mysqli_stmt_fetch($ps))
                						{
                							print("<option value='$subject'");
                              if(empty($_POST['DdlSubjects'])===false) 
                              {
                                  if($_POST['DdlSubjects'] == $subject) 
                                  { 
                                    print("selected=true");
                                  }
                              }
                              print(">$subject</option>");                								
                						}
                						//print("<script>alert($x);</script>");
                						mysqli_stmt_close($ps);
                        		mysqli_close($con);
                					}
  								}
  								catch(Exception $ex)
  								{
  									print($ex->getmessage()."<br/>");
  								}  							
  							}
  						?>
  					</select>
				</td>
			</tr>
      <?php if(!empty($subject_err)) print("<tr><td></td><td><span>$subject_err</span></td></tr>") ?>
			<tr>
				<td></td>
				<td>
					<input type="submit" value="Add Contents" name="BtnAddContents" onclick="checkdata()">
          <input type="submit" value="Add Practical" name="BtnAddPracticals" onclick="checkdata()">
				</td>
			</tr> 
      <tr>
        <td></td>
        <td>
          <br/>
          <input type="submit" value="Add Books" name="BtnAddBooks" onclick="checkdata()">          
          <input type="submit" value="Add Teaching Scheme" name="BtnAddTeachingScheme" onclick="checkdata()">
        </td>
      </tr>
      <tr>
        <td></td>
        <td>
          <br/>
          <input type="submit" value="Add Exam. Scheme" name="BtnAddExamScheme" onclick="checkdata()">          
          <input type="submit" value="Add Specification Table" name="BtnAddSpecificationTable" onclick="checkdata()">
        </td>
      </tr>  
      <tr>
        <td></td>
        <td>
          <br/>
          <input type="submit" value="Add Course Outcomes" name="BtnAddCourseOutcomes" onclick="checkdata()">          
          <input type="submit" value="Add Suggested Activities" name="BtnAddSuggestedActivities" onclick="checkdata()">
        </td>
      </tr>  
      <tr>
        <td></td>
        <td>
          <br/>
          <input type="submit" value="Add Suggested Micro Projects" name="BtnAddSuggestedMicroProjects" onclick="checkdata()">          
          
        </td>
      </tr>  
			</table>
      <a href="add_syllabus.php">Back</a><br/>
        </div>
    </div>
</form>  	
</body>
</html>