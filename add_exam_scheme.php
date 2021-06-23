<?php
    $final_result = ""; 
    $max_paper_marks = $min_paper_marks = $max_pa_marks = $max_th_marks = $min_th_marks = 0;
    $max_pr_marks =  $min_pr_marks = $max_tw_marks = $min_tw_marks = $max_thpr_marks = 0;

    $max_paper_marks_err = $min_paper_marks_err = $max_pa_marks_err = $max_th_marks_err = $min_th_marks_err = 0;
    $max_pr_marks_err =  $min_pr_marks_err = $max_tw_marks_err = $min_tw_marks_err = $max_thpr_marks_err = 0;
    session_start();

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if(array_key_exists("BtnSave", $_POST))
        {
            $c = 0;

            if(array_key_exists("TxtMaxPaperMarks", $_POST))
            {
                if(empty(trim($_POST["TxtMaxPaperMarks"])))
                {
                    $max_paper_marks_err = "Maximum paper marks is required";
                    $c++;
                }
                else
                {
                    $max_paper_marks = intval(strtoupper(trim($_POST["TxtMaxPaperMarks"])));
                    $max_paper_marks_err = "";
                }
            }

            if(array_key_exists("TxtMinPaperMarks", $_POST))
            {
                if(empty(trim($_POST["TxtMinPaperMarks"])))
                {
                    $min_paper_marks_err = "Minimum paper marks is required";
                    $c++;
                }
                else
                {
                    $min_paper_marks = intval(strtoupper(trim($_POST["TxtMinPaperMarks"])));
                    $min_paper_marks_err = "";
                }
            }

            if(array_key_exists("TxtMaxPaMarks", $_POST))
            {
                if(empty(trim($_POST["TxtMaxPaMarks"])))
                {
                    $max_pa_marks_err = "Maximum PA marks is required";
                    $c++;
                }
                else
                {
                    $max_pa_marks = intval(strtoupper(trim($_POST["TxtMaxPaMarks"])));
                    $max_pa_marks_err = "";
                }
            }

            if(array_key_exists("TxtMaxThMarks", $_POST))
            {
                if(empty(trim($_POST["TxtMaxThMarks"])))
                {
                    $max_th_marks_err = "Maximum theory marks is required";
                    $c++;
                }
                else
                {
                    $max_th_marks = intval(strtoupper(trim($_POST["TxtMaxThMarks"])));
                    $max_th_marks_err = "";
                }
            }

            if(array_key_exists("TxtMinThMarks", $_POST))
            {
                if(empty(trim($_POST["TxtMinThMarks"])))
                {
                    $min_th_marks_err = "Minimum theory marks is required";
                    $c++;
                }
                else
                {
                    $min_th_marks = intval(strtoupper(trim($_POST["TxtMinThMarks"])));
                    $min_th_marks_err = "";
                }
            }

            if(array_key_exists("TxtMaxPrMarks", $_POST))
            {
                if(empty(trim($_POST["TxtMaxPrMarks"])))
                {
                    $max_pr_marks_err = "Maximum practical marks is required";
                    $c++;
                }
                else
                {
                    $max_pr_marks = intval(strtoupper(trim($_POST["TxtMaxPrMarks"])));
                    $max_pr_marks_err = "";
                }
            }

            if(array_key_exists("TxtMinPrMarks", $_POST))
            {
                if(empty(trim($_POST["TxtMinPrMarks"])))
                {
                    $min_pr_marks_err = "Minimum practical marks is required";
                    $c++;
                }
                else
                {
                    $min_pr_marks = intval(strtoupper(trim($_POST["TxtMinPrMarks"])));
                    $min_pr_marks_err = "";
                }
            }

            if(array_key_exists("TxtMaxTwMarks", $_POST))
            {
                if(empty(trim($_POST["TxtMaxTwMarks"])))
                {
                    $max_tw_marks_err = "Maximum TW marks is required";
                    $c++;
                }
                else
                {
                    $max_tw_marks = intval(strtoupper(trim($_POST["TxtMaxTwMarks"])));
                    $max_tw_marks_err = "";
                }
            }

            if(array_key_exists("TxtMinTwMarks", $_POST))
            {
                if(empty(trim($_POST["TxtMinTwMarks"])))
                {
                    $min_tw_marks_err = "Minimum TW marks is required";
                    $c++;
                }
                else
                {
                    $min_tw_marks = intval(strtoupper(trim($_POST["TxtMinTwMarks"])));
                    $min_tw_marks_err = "";
                }
            }

            if(array_key_exists("TxtMaxThPrMarks", $_POST))
            {
                if(empty(trim($_POST["TxtMaxThPrMarks"])))
                {
                    $max_thpr_marks_err = "Maximum (TH + PR) marks is required";
                    $c++;
                }
                else
                {
                    $max_thpr_marks = intval(strtoupper(trim($_POST["TxtMaxThPrMarks"])));
                    $max_thpr_marks_err = "";
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
                        $sql = "insert into exam_scheme (department, semester, subject, subject_code, max_paper_marks, min_paper_marks, max_pa_marks, max_th_marks, min_th_marks, max_pr_marks, min_pr_marks, max_tw_marks, min_tw_marks, max_thpr_marks) values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                        $ps = mysqli_prepare($con, $sql);
                        if($ps != false)
                        {
                            $dept = $_SESSION["dept"];
                            $sem = $_SESSION["sem"];
                            $subject = $_SESSION["subject"];
                            $subject_code = $_SESSION["subject_code"]; 

                            mysqli_stmt_bind_param($ps,"ssssiiiiiiiiii", $dept, $sem, $subject, $subject_code, $max_paper_marks, $min_paper_marks, $max_pa_marks, $max_th_marks, $min_th_marks, $max_pr_marks, $min_pr_marks, $max_tw_marks, $min_tw_marks, $max_thpr_marks);
                            mysqli_stmt_execute($ps);
                            $n = mysqli_stmt_affected_rows($ps);
                            mysqli_stmt_close($ps);
                            mysqli_close($con);
                            if($n == 1)
                            {                                
                                $final_result = "<font face=calibri size=3pt color=green>Exam scheme saved.</font><br>";
                            }
                            else
                            {                        
                                $final_result = "<font face=calibri size=3pt color=red>Sorry! Exam scheme not saved.</font><br>";                                
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

    } // end of POST 

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
          		Add Examination Scheme
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
                <td>Maximum Paper Marks</td>
                <td><input type="text" name="TxtMaxPaperMarks" <?php if(array_key_exists("TxtMaxPaperMarks", $_POST)) if(!empty($_POST["TxtMaxPaperMarks"])) print("value='".$_POST["TxtMaxPaperMarks"]."'"); ?>></td>
            </tr>
            <?php
              if(!empty($max_paper_marks_err))
                print("<tr><td></td><td><span>$max_paper_marks_err</span></td></tr>");
            ?>
            <tr>
                <td>Minimum Paper Marks</td>
                <td><input type="text" name="TxtMinPaperMarks" <?php if(array_key_exists("TxtMinPaperMarks", $_POST)) if(!empty($_POST["TxtMinPaperMarks"])) print("value='".$_POST["TxtMinPaperMarks"]."'"); ?>></td>
            </tr>
            <?php
              if(!empty($min_paper_marks_err))
                print("<tr><td></td><td><span>$min_paper_marks_err</span></td></tr>");
            ?>            
            <tr>
                <td>Maximum PA Marks</td>
                <td><input type="text" name="TxtMaxPaMarks" <?php if(array_key_exists("TxtMaxPaMarks", $_POST)) if(!empty($_POST["TxtMaxPaMarks"])) print("value='".$_POST["TxtMaxPaMarks"]."'"); ?>></td>
            </tr>
            <?php
              if(!empty($max_pa_marks_err))
                print("<tr><td></td><td><span>$max_pa_marks_err</span></td></tr>");
            ?>
            <tr>
                <td>Maximum Theory Marks</td>
                <td><input type="text" name="TxtMaxThMarks" <?php if(array_key_exists("TxtMaxThMarks", $_POST)) if(!empty($_POST["TxtMaxThMarks"])) print("value='".$_POST["TxtMaxThMarks"]."'"); ?>></td>
            </tr>
            <?php
              if(!empty($max_th_marks_err))
                print("<tr><td></td><td><span>$max_th_marks_err</span></td></tr>");
            ?>
            <tr>
                <td>Minimum Theory Marks</td>
                <td><input type="text" name="TxtMinThMarks" <?php if(array_key_exists("TxtMinThMarks", $_POST)) if(!empty($_POST["TxtMinThMarks"])) print("value='".$_POST["TxtMinThMarks"]."'"); ?>></td>
            </tr>
            <?php
              if(!empty($min_th_marks_err))
                print("<tr><td></td><td><span>$min_th_marks_err</span></td></tr>");
            ?>
            <tr>
                <td>Maximum Practical Marks</td>
                <td><input type="text" name="TxtMaxPrMarks" <?php if(array_key_exists("TxtMaxPrMarks", $_POST)) if(!empty($_POST["TxtMaxPrMarks"])) print("value='".$_POST["TxtMaxPrMarks"]."'"); ?>></td>
            </tr>
            <?php
              if(!empty($max_pr_marks_err))
                print("<tr><td></td><td><span>$max_pr_marks_err</span></td></tr>");
            ?>
            <tr>
                <td>Minimum Practical Marks</td>
                <td><input type="text" name="TxtMinPrMarks" <?php if(array_key_exists("TxtMinPrMarks", $_POST)) if(!empty($_POST["TxtMinPrMarks"])) print("value='".$_POST["TxtMinPrMarks"]."'"); ?>></td>
            </tr>
            <?php
              if(!empty($min_pr_marks_err))
                print("<tr><td></td><td><span>$min_pr_marks_err</span></td></tr>");
            ?>         
            <tr>
                <td>Maximum TW Marks</td>
                <td><input type="text" name="TxtMaxTwMarks" <?php if(array_key_exists("TxtMaxTwMarks", $_POST)) if(!empty($_POST["TxtMaxTwMarks"])) print("value='".$_POST["TxtMaxTwMarks"]."'"); ?>></td>
            </tr>
            <?php
              if(!empty($max_tw_marks_err))
                print("<tr><td></td><td><span>$max_tw_marks_err</span></td></tr>");
            ?>
            <tr>
                <td>Minimum TW Marks</td>
                <td><input type="text" name="TxtMinTwMarks" <?php if(array_key_exists("TxtMinTwMarks", $_POST)) if(!empty($_POST["TxtMinTwMarks"])) print("value='".$_POST["TxtMinTwMarks"]."'"); ?>></td>
            </tr>
            <?php
              if(!empty($min_tw_marks_err))
                print("<tr><td></td><td><span>$min_tw_marks_err</span></td></tr>");
            ?>
            <tr>
                <td>Maximum Total TH + PR Marks</td>
                <td><input type="text" name="TxtMaxThPrMarks" <?php if(array_key_exists("TxtMaxThPrMarks", $_POST)) if(!empty($_POST["TxtMaxThPrMarks"])) print("value='".$_POST["TxtMaxThPrMarks"]."'"); ?>></td>
            </tr>
            <?php
                if(!empty($max_thpr_marks_err))
                print("<tr><td></td><td><span>$max_thpr_marks_err</span></td></tr>");
            ?>                
            <tr>
                <td></td>
                <td><input type="submit" value="Save" name="BtnSave"></td>
            </tr>
            <?php
              if(!empty($final_result))
                print("<tr><td></td><td>$final_result</td></tr>");
            ?>
          </table>
      </div>
    </div>
    <!--Exam Scheme-->
    <div>
        <a href="select_subject.php">Back</a><br/>
        <?php
            function load_exam_scheme($dept, $sem, $subject, $subject_code)
            {
                try
                {
                    $con = mysqli_connect("127.0.0.1", "root", "super", "gp_cur_db");
                    if($con ==  false)
                    print("Error: ".mysqli_connect_error());
                    else
                    {
                        $sql = "select srno, max_paper_marks, min_paper_marks, max_pa_marks, max_th_marks, min_th_marks, max_pr_marks, min_pr_marks, max_tw_marks, min_tw_marks, max_thpr_marks from exam_scheme where department=? and semester=? and subject=? and subject_code=?";
                        $ps = mysqli_prepare($con, $sql);
                        if($ps != false)                        
                        {
                            mysqli_stmt_bind_param($ps,"ssss", $dept, $sem, $subject, $subject_code);
                            mysqli_stmt_execute($ps);
                            $max_paper_marks = $min_paper_marks = $max_pa_marks = $max_th_marks = $min_th_marks = 0;
                            $max_pr_marks =  $min_pr_marks = $max_tw_marks = $min_tw_marks = $max_thpr_marks = 0;                            
                            mysqli_stmt_bind_result($ps, $srno, $max_paper_marks, $min_paper_marks, $max_pa_marks, $max_th_marks, $min_th_marks, $max_pr_marks, $min_pr_marks, $max_tw_marks, $min_tw_marks, $max_thpr_marks);
                            
                            if(mysqli_stmt_fetch($ps))
                            {
                                print("<table width='100%' cellspacing='0' cellpadding='5' border='1' style='text-align:center;'>");
                                print("<tr><th colspan='5'>THEORY</th><th colspan='3'>PRACTICAL</th><th rowspan='2'>TOTAL</th></tr>");
                                print("<tr><th>PAPER HOURS</th><th colspan='2'>TERM END EXAM MARKS</th><th>PA TEST 1:00HR DURATION</th><th>TOTAL</th><th>PR</th><th>OR</th><th>TW</th></tr>");
                                print("<tr><th rowspan='2'>03</th><th>MAX</th><th>$max_paper_marks</th><th>$max_pa_marks</th><th>$max_th_marks</th><th>$max_pr_marks&#35;</th><th>--</th><th>$max_tw_marks&#64;</th><th>$max_thpr_marks</th></tr>");
                                print("<tr><th>MIN</th><th>$min_paper_marks</th><th>--</th><th>$min_th_marks</th><th>$min_pr_marks</th><th>--</th><th>$min_tw_marks</th><th>--</th></tr>");
                                //print("<tr><td colspan='10'><a href='delete_exam_scheme.php?srno=$srno'>Delete</a></td></tr>");
                                print("</table>");
                            }
                            
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
            } // end load_exam_scheme()

            print("<br/>");
            print("<font face='calibri' size='4pt' color='black'>");
            print("<b>EXAMINATION SCHEME:</b>");
            print("</font>");
            load_exam_scheme($dept, $sem, $subject, $subject_code);      
            print("&#64;: Internal Assessment<br/>");
            print("&#35;: External &#38; Internal Assessment<br/>");
        ?>
    </div>
  </form>
</body>
</html>