<?php
	  session_start();
    $topic_no = $marks_per_topic = $times_marks = $actual_alloted_marks = 0;
    $q1_marks = $q2_marks = $q3_marks = $q4_marks = $q5_marks = $q6_marks = $final_result = "";

    $topic_no_err = $marks_per_topic_err = $times_marks_err = $actual_alloted_marks_err = "";
    $q1_marks_err = $q2_marks_err = $q3_marks_err = $q4_marks_err = $q5_marks_err = $q6_marks_err = "";

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if(array_key_exists("BtnSave", $_POST))
        {
            $c = 0;

            if(array_key_exists("TxtTopicNo", $_POST))
            {
                if(empty(trim($_POST["TxtTopicNo"])))
                {
                    $topic_no_err = "Topic number is required";
                    $c++;
                }
                else
                {
                    $topic_no = intval(strtoupper(trim($_POST["TxtTopicNo"])));
                    $topic_no_err = "";
                }
            }

            if(array_key_exists("TxtMarksPerTopic", $_POST))
            {
                if(empty(trim($_POST["TxtMarksPerTopic"])))
                {
                    $marks_per_topic_err = "Marks/Topic is required";
                    $c++;
                }
                else
                {
                    $marks_per_topic = intval(strtoupper(trim($_POST["TxtMarksPerTopic"])));
                    $marks_per_topic_err = "";
                }
            }

            if(array_key_exists("TxtTimesMarks", $_POST))
            {
                if(empty(trim($_POST["TxtTimesMarks"])))
                {
                    $times_marks_err = "1.5 times marks is required";
                    $c++;
                }
                else
                {
                    $times_marks = intval(strtoupper(trim($_POST["TxtTimesMarks"])));
                    $times_marks_err = "";
                }
            }

            if(array_key_exists("TxtQ1Marks", $_POST))
            {
                if(empty(trim($_POST["TxtQ1Marks"])))
                {
                    $q1_marks_err = "Q.1 marks is required";
                    $c++;
                }
                else
                {
                    $q1_marks = strtoupper(trim($_POST["TxtQ1Marks"]));
                    $q1_marks_err = "";
                }
            }

            if(array_key_exists("TxtQ2Marks", $_POST))
            {
                if(empty(trim($_POST["TxtQ2Marks"])))
                {
                    $q2_marks_err = "Q.2 marks is required";
                    $c++;
                }
                else
                {
                    $q2_marks = strtoupper(trim($_POST["TxtQ2Marks"]));
                    $q2_marks_err = "";
                }
            }

            if(array_key_exists("TxtQ3Marks", $_POST))
            {
                if(empty(trim($_POST["TxtQ3Marks"])))
                {
                    $q3_marks_err = "Q.3 marks is required";
                    $c++;
                }
                else
                {
                    $q3_marks = strtoupper(trim($_POST["TxtQ3Marks"]));
                    $q3_marks_err = "";
                }
            }

            if(array_key_exists("TxtQ4Marks", $_POST))
            {
                if(empty(trim($_POST["TxtQ4Marks"])))
                {
                    $q4_marks_err = "Q.4 marks is required";
                    $c++;
                }
                else
                {
                    $q4_marks = strtoupper(trim($_POST["TxtQ4Marks"]));
                    $q4_marks_err = "";
                }
            }

            if(array_key_exists("TxtQ5Marks", $_POST))
            {
                if(empty(trim($_POST["TxtQ5Marks"])))
                {
                    $q5_marks_err = "Q.5 marks is required";
                    $c++;
                }
                else
                {
                    $q5_marks = strtoupper(trim($_POST["TxtQ5Marks"]));
                    $q5_marks_err = "";
                }
            }

            if(array_key_exists("TxtQ6Marks", $_POST))
            {
                if(empty(trim($_POST["TxtQ6Marks"])))
                {
                    $q6_marks_err = "Q.6 marks is required";
                    $c++;
                }
                else
                {
                    $q6_marks = strtoupper(trim($_POST["TxtQ6Marks"]));
                    $q6_marks_err = "";
                }
            }

            if(array_key_exists("TxtActualAllotedMarks", $_POST))
            {
                if(empty(trim($_POST["TxtActualAllotedMarks"])))
                {
                    $actual_alloted_marks_err = "Actual alloted marks is required";
                    $c++;
                }
                else
                {
                    $actual_alloted_marks = intval(strtoupper(trim($_POST["TxtActualAllotedMarks"])));
                    $actual_alloted_marks_err = "";
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
                        $sql = "insert into specification_table (department, semester, subject, subject_code, topic_no, marks_per_topic, times_marks, q1_marks, q2_marks, q3_marks, q4_marks, q5_marks, q6_marks, actual_alloted_marks) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                        $ps = mysqli_prepare($con, $sql);
                        if($ps != false)
                        {
                            $dept = $_SESSION["dept"];
                            $sem = $_SESSION["sem"];
                            $subject = $_SESSION["subject"];
                            $subject_code = $_SESSION["subject_code"];

                            mysqli_stmt_bind_param($ps,"ssssiiissssssi", $dept, $sem, $subject, $subject_code, $topic_no, $marks_per_topic, $times_marks, $q1_marks, $q2_marks, $q3_marks, $q4_marks, $q5_marks, $q6_marks, $actual_alloted_marks);
                            mysqli_stmt_execute($ps);
                            $n = mysqli_stmt_affected_rows($ps);
                            mysqli_stmt_close($ps);
                            mysqli_close($con);
                            if($n == 1)
                            {                                
                                $final_result = "<font face=calibri size=3pt color=green>Specification table saved.</font><br>";
                            }
                            else
                            {                        
                                $final_result = "<font face=calibri size=3pt color=red>Sorry! Specification table not saved.</font><br>";                                
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

    }// end if POST

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
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" name="f1">
	<div class="panel panel-default">
  		<div class="panel-heading">
        	<font face="calibri" size="5pt" color="green">
          		Add Specification Table
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
                <td>Topic No.</td>
                <td><input type="text" name="TxtTopicNo" <?php if(array_key_exists("TxtTopicNo", $_POST)) if(!empty($_POST["TxtTopicNo"])) print("value='".$_POST["TxtTopicNo"]."'"); ?>></td>
              </tr>
              <?php
                if(!empty($topic_no_err))
                print("<tr><td></td><td><span>$tpoic_no_err</span></td></tr>");
              ?>
              <tr>
                <td>Marks Per Topic</td>
                <td><input type="text" name="TxtMarksPerTopic" <?php if(array_key_exists("TxtMarksPerTopic", $_POST)) if(!empty($_POST["TxtMarksPerTopic"])) print("value='".$_POST["TxtMarksPerTopic"]."'"); ?>></td>
              </tr>
              <?php
                if(!empty($marks_per_topic_err))
                print("<tr><td></td><td><span>$marks_per_topic_err</span></td></tr>");
              ?>
              <tr>
                <td>1.5 Times Marks</td>
                <td><input type="text" name="TxtTimesMarks" <?php if(array_key_exists("TxtTimesMarks", $_POST)) if(!empty($_POST["TxtTimesMarks"])) print("value='".$_POST["TxtTimesMarks"]."'"); ?>></td>
              </tr>
              <?php
                if(!empty($times_marks_err))
                print("<tr><td></td><td><span>$times_marks_err</span></td></tr>");
              ?>
              <tr>
                <td>Q.1 Marks</td>
                <td><input type="text" name="TxtQ1Marks" <?php if(array_key_exists("TxtQ1Marks", $_POST)) if(!empty($_POST["TxtQ1Marks"])) print("value='".$_POST["TxtQ1Marks"]."'"); ?>></td>
              </tr>
              <?php
                if(!empty($q1_marks_err))
                print("<tr><td></td><td><span>$q1_marks_err</span></td></tr>");
              ?>
              <tr>
                <td>Q.2 Marks</td>
                <td><input type="text" name="TxtQ2Marks" <?php if(array_key_exists("TxtQ2Marks", $_POST)) if(!empty($_POST["TxtQ2Marks"])) print("value='".$_POST["TxtQ2Marks"]."'"); ?>></td>
              </tr>
              <?php
                if(!empty($q2_marks_err))
                print("<tr><td></td><td><span>$q2_marks_err</span></td></tr>");
              ?>
              <tr>
                <td>Q.3 Marks</td>
                <td><input type="text" name="TxtQ3Marks" <?php if(array_key_exists("TxtQ3Marks", $_POST)) if(!empty($_POST["TxtQ3Marks"])) print("value='".$_POST["TxtQ3Marks"]."'"); ?>></td>
              </tr>
              <?php
                if(!empty($q3_marks_err))
                print("<tr><td></td><td><span>$q3_marks_err</span></td></tr>");
              ?>
              <tr>
                <td>Q.4 Marks</td>
                <td><input type="text" name="TxtQ4Marks" <?php if(array_key_exists("TxtQ4Marks", $_POST)) if(!empty($_POST["TxtQ4Marks"])) print("value='".$_POST["TxtQ4Marks"]."'"); ?>></td>
              </tr>
              <?php
                if(!empty($q4_marks_err))
                print("<tr><td></td><td><span>$q4_marks_err</span></td></tr>");
              ?>
              <tr>
                <td>Q.5 Marks</td>
                <td><input type="text" name="TxtQ5Marks" <?php if(array_key_exists("TxtQ5Marks", $_POST)) if(!empty($_POST["TxtQ5Marks"])) print("value='".$_POST["TxtQ5Marks"]."'"); ?>></td>
              </tr>
              <?php
                if(!empty($q5_marks_err))
                print("<tr><td></td><td><span>$q5_marks_err</span></td></tr>");
              ?>
              <tr>
                <td>Q.6 Marks</td>
                <td><input type="text" name="TxtQ6Marks" <?php if(array_key_exists("TxtQ6Marks", $_POST)) if(!empty($_POST["TxtQ6Marks"])) print("value='".$_POST["TxtQ6Marks"]."'"); ?>></td>
              </tr>
              <?php
                if(!empty($q6_marks_err))
                print("<tr><td></td><td><span>$q6_marks_err</span></td></tr>");
              ?>
              <tr>
                <td>Actual Alloted Marks</td>
                <td><input type="text" name="TxtActualAllotedMarks" <?php if(array_key_exists("TxtActualAllotedMarks", $_POST)) if(!empty($_POST["TxtActualAllotedMarks"])) print("value='".$_POST["TxtActualAllotedMarks"]."'"); ?>></td>
              </tr>
              <?php
                if(!empty($actual_alloted_marks_err))
                print("<tr><td></td><td><span>$actual_alloted_marks_err</span></td></tr>");
              ?>
              <tr>
                <td></td>
                <td><input type="Submit" value="Save" name="BtnSave"></td>
              </tr>
              <?php
                  if(!empty($final_result))
                  print("<tr><td></td><td>$final_result</td></tr>");
              ?>
          </table>
      </div>
    </div>
    <!--Specification Table-->
    <div>
      <a href="select_subject.php">Back</a><br/>
        <?php
            function load_specification_table($dept, $sem, $subject, $subject_code)
            {
                try
                {
                    $con = mysqli_connect("127.0.0.1", "root", "super", "gp_cur_db");
                    if($con ==  false)
                    print("Error: ".mysqli_connect_error());
                    else
                    {
                        $sql = "select srno, topic_no, marks_per_topic, times_marks, q1_marks, q2_marks, q3_marks, q4_marks, q5_marks, q6_marks, actual_alloted_marks from specification_table where department=? and semester=? and subject=? and subject_code = ?";
                        $ps = mysqli_prepare($con, $sql);
                        if($ps != false)                        
                        {
                            mysqli_stmt_bind_param($ps,"ssss", $dept, $sem, $subject, $subject_code);
                            mysqli_stmt_execute($ps);

                            $srno = $topic_no = $marks_per_topic = $times_marks = $actual_alloted_marks = 0;
                            $q1_marks = $q2_marks = $q3_marks = $q4_marks = $q5_marks = $q6_marks = "";
                            mysqli_stmt_bind_result($ps, $srno, $topic_no, $marks_per_topic, $times_marks, $q1_marks, $q2_marks, $q3_marks, $q4_marks, $q5_marks, $q6_marks, $actual_alloted_marks);
                            print("<table width='100%' cellspacing='0' cellpadding='5' border='1' style='text-align:center;'>");
                            print("<tr><th rowspan='3'>TOPIC NO.</th><th rowspan='3'>MARKS/TOPIC</th><th rowspan='3'>1.5 TIMES MARKS</th><th colspan='6'>QUESTION NO. &#38; IT'S MARKS</th><th rowspan='3'>ACTUAL ALLOTED MARKS</th></tr>");
                            print("<tr><th>01</th><th>02</th><th>03</th><th>04</th><th>05</th><th>06</th></tr>");
                            print("<tr><th>(20)</th><th>(12)</th><th>(12)</th><th>(12)</th><th>(12)</th><th>(12)</th></tr>");                            
                            while(mysqli_stmt_fetch($ps))
                            {                                
                                print("<tr>");
                                print("<td>$topic_no</td>");
                                print("<td>$marks_per_topic</td>");
                                print("<td>$times_marks</td>");
                                print("<td>$q1_marks</td>");
                                print("<td>$q2_marks</td>");
                                print("<td>$q3_marks</td>");
                                print("<td>$q4_marks</td>");
                                print("<td>$q5_marks</td>");
                                print("<td>$q6_marks</td>");
                                print("<td>$actual_alloted_marks</td>");                                
                                print("</tr>");
                                //print("<tr><td colspan='10'><a href='delete_specific.php?srno=$srno'>Delete</a</td></tr>");
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
            } // end function load_specification_table

            print("<br/>");
            print("<font face='calibri' size='4pt' color='black'>");
            print("<b>SPECIFICATION TABLE:</b><br/>");
            print("</font>");            
            print("<b>Note:</b> All paper setter are instructed to use following specification table for paper setting<br/>");
            load_specification_table($dept, $sem, $subject, $subject_code);
            print("<b>Note:</b> 15% questions should be of application level.<br/>");
            print("The Government Board of Dtudies has approved the above course curriculum.<br/>");
        ?>
    </div>
  </form>
</body>
</html>