<html>
<head>
<!-- to clear browser cache -->
	<meta http-equiv="cache-control" content="no-cache">
	<link href="styles/subject_table_style.css" rel="stylesheet"/>
	<script type="text/javascript">
	    function print_page()
	    {
		    window.print();
	    }

	    function CloseWindow()
	    {
	        window.close();
	    }
    </script>
</head>
<body style="font-family: Times New Roman">
	<table style="font-family: calibri;font-size: 17px;">
		<tr>
			<td><a href="clear_session.php">Home</a></td>
		</tr>
	</table>
	<center>
		<table>			
			<tr>
				<td><img src="images/gp_logo_1.png" width="100px" height="100px"></td>
				<td style="text-align: center;">
						<font face="Times New Roman" size="5pt">GOVERNMENT POLYTECHNIC, AMRAVATI</font>				
					<br/>
					<font face="Times New Roman" size="3pt">(AN AUTONOMOUS INSTITUTE OF GOVT.OF MATARASHTRA)</font>
					<br/>									
					<font face="Times New Roman" size="3pt">CURRICULUM DEVELOPMENT CELL</font>
					
				</td>
			</tr>
		</table>		
	</center>
<hr size="1px" color="black"/>
<?php
	$dept = $sem = $subject = $programme_title = $subject_code = $rationale = $objectives = "";
	session_start();	
	//print_r($_SESSION);
	//print("<br/>");
	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$c = 0;
		if(array_key_exists("dept", $_SESSION))
  		{
  			if(isset($_SESSION["dept"]))
  			{
  				$dept = $_SESSION["dept"];
  				//echo "Department: ", $dept, "<br/>";  				
  			}
  		}

  		if(array_key_exists("sem", $_SESSION))
  		{
  			if(isset($_SESSION["sem"]))
  			{
  				$sem = $_SESSION["sem"];
  				//echo "Semester: ", $sem, "<br/>";  				
  			}
  		}

  		if(array_key_exists("DdlSubjects", $_POST))
  		{
  			if(isset($_POST["DdlSubjects"]))
  			{
  				$subject = $_POST["DdlSubjects"];
  				//echo "Subject: ", $subject, "<br/>";  				
  			}
  		}

  		if(!empty($dept) && !empty($sem) && !empty($subject))
  		{
  			// Retrieveing Subject Code  			
			try 
			{
				$sql = "select programme_title, subject_code, rationale, objectives from subjects where department=? and semester=? and subject=?";
				$con = mysqli_connect("127.0.0.1", "root", "super", "gp_cur_db");
  				if($con == false)
                print("Error: ".mysqli_connect_error());
                else
                {
                	$ps = mysqli_prepare($con, $sql);
                	mysqli_stmt_bind_param($ps,"sss", $dept, $sem, $subject);
                	mysqli_stmt_execute($ps);                	
                	mysqli_stmt_bind_result($ps, $programme_title, $subject_code, $rationale, $objectives);
                	mysqli_stmt_fetch($ps);
                	mysqli_stmt_close($ps);
                  mysqli_close($con);                    
                }
			} 
			catch (Exception $ex) 
			{
				print($ex->getmessage()."<br/>");
			}	

?>

<font face="Times New Roman" size="4pt" color="black">
	<b>PROGRAMME: <?php print($programme_title); ?></b><br/>
	<b>DEPARTMENT: <?php print($dept); ?></b><br/>
	<b>SEMESTER: <?php print($sem); ?></b><br/>
	<b>COURSE CODE: <?php print($subject_code); ?></b><br/>
	<b>COURSE: <?php print($subject); ?></b><br/>
</font>

<!--Teaching Scheme-->
    <div>
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
        print("<br/>");
        print("<font face='Times New Roman' size='4pt' color='black'><b>TEACHING SCHEME:</b></font><br/>");
        load_teaching_scheme($dept, $sem, $subject, $subject_code);
      ?>
    </div>

<!--Exam Scheme-->
    <div>
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
            print("<font face='Times New Roman' size='4pt' color='black'>");
            print("<b>EXAMINATION SCHEME:</b>");
            print("</font>");
            load_exam_scheme($dept, $sem, $subject, $subject_code);      
            print("<br/>&#64;: Internal Assessment<br/>");
            print("&#35;: External &#38; Internal Assessment<br/>");
        ?>
    </div>

<font face="Times New Roman" size="4pt" color="black">
<br/>
<b>RATIONALE:</b><br/> 
<div style="text-align: justify;width: 100%;">
	<?php print($rationale); ?>	
</div>
<br/>

<b>OBJECTIVES:</b><br/>
<div style="text-align: justify;width: 100%;">
<?php print($objectives); ?>
</div>	
</br>
</font>	

<?php
        function load_course_outcomes($dept, $sem, $subject, $subject_code)
        {
           try
           {
                $con = mysqli_connect("127.0.0.1", "root", "super", "gp_cur_db");
                if($con ==  false)
                print("Error: ".mysqli_connect_error()."<br/>");
                else
                {
                    $sql = "select srno, course_outcome from course_outcomes where department=? and semester=? and subject=? and subject_code=?";
                    $ps = mysqli_prepare($con, $sql);
                    if($ps != false)
                    {
                        mysqli_stmt_bind_param($ps,"ssss", $dept, $sem, $subject, $subject_code);
                        mysqli_stmt_execute($ps);
                        $srno = $index = 0;
                        $course_outcomes = "";
                        mysqli_stmt_bind_result($ps, $srno, $course_outcomes);

                        print("<table>");
                        print("<tr><td colspan='2'><font face='Times New Roman' size='4pt' color='black'><b>COURSE OUTCOMES (COs)</b></font></td></tr>");
                        print("<tr><td colspan='2'>At the end of this course, student will be able to:</td></tr>");
                        while(mysqli_stmt_fetch($ps) != null)
                        {
                            $index++;
                            print("<tr>");
                            print("<td>$index</td>");
                            print("<td>$course_outcomes</td>");
                            print("</tr>");
                        }
                        print("</table>");
                        mysqli_stmt_close($ps);
                        mysqli_close($con); 
                    } 
                    else
                    {
                      mysqli_close($con);
                      print("Function: Prepared Statement is not created..<br/>");
                    }                   
                }
           }
           catch(Exception $ex)
           {
                print($ex->getmessage()."<br/>");
           }
        } // end function load_course_outcomes

        //$dept = $_SESSION["dept"];
        //$sem = $_SESSION["sem"];
       // $subject = $_SESSION["subject"];
       // $subject_code = $_SESSION["subject_code"];
        load_course_outcomes($dept, $sem, $subject, $subject_code);
      ?>
<br/>
<table>
  <tr>
    <td><font face="Times New Roman" size="4pt" color="black"><b>DETAILED CONTENTS:</b></font></td>
  </tr>
</table>

<table cellspacing="0" cellpadding="5px" border="1px" width="100%">
<tr>
	<th>TOPIC NUMBER</th>
	<th>CONTENT</th>	
	<th>HRS</th>
	<th>MARKS</th>
	<th>INSTRUCTIONAL STRATEGIES</th>
</tr>
<?php
			try 
			{				
			  	$con = mysqli_connect("127.0.0.1", "root", "super", "gp_cur_db");
  				if($con == false)
                print("Error: ".mysqli_connect_error());
                else	
                {
                	$sql = "select unit_number, unit_name, unit_contents, hours, marks, strategies from contents where department=? and semester=? and subject=?";
                	$ps = mysqli_prepare($con, $sql);
                	if($ps != false)
                	{
                		//echo $dept , " ", $sem, " ", $subject ,"<br/>";
                		mysqli_stmt_bind_param($ps,"sss", $dept, $sem, $subject);
                		mysqli_stmt_execute($ps);
                		$unit_number = $unit_name = $unit_contents = $hours = $marks = $strategies= "";
                		mysqli_stmt_bind_result($ps, $unit_number, $unit_name, $unit_contents, $hours, $marks, $strategies);
                		while(mysqli_stmt_fetch($ps)) 
                		{
                			//print("Unit Number = $unit_number<br/>");
                			//print("Unit Name = $unit_name<br/>");
                			//print("Unit Contents = $unit_contents<br/>");

                			print("<tr>");
                			print("<td>$unit_number</td>");
                			print("<td><b>$unit_name</b><br/>$unit_contents</td>");                			
                			print("<td>$hours</td>");
                			print("<td>$marks</td>");
                			print("<td>$strategies</td>");
                			print("</tr>");
                		}
                		mysqli_stmt_close($ps);
                    	mysqli_close($con);
                	}
                	else
                	print("Prepared statement not created..<br/>");
                }
			} 
			catch (Exception $ex) 
			{
			  	print($ex->getmessage()."<br/>");
			}  			
  		}
  		//else
  		//print("empty<br/>");
	}
?>
</table>

<div>
<br/>
<table>
	<tr>
		<td><font face="Times New Roman" size="4pt" color="black"><b>PRACTICALS:</b></font></td>
	</tr>
</table>


<?php
function load_practicals($dept, $sem, $subject, $subject_code)
    {
      try
      {
          $con = mysqli_connect("127.0.0.1", "root", "super", "gp_cur_db");
          if($con == false)
          print("Error: ".mysqli_connect_error());
          else
          {
              $sql = "select srno, practical_name, instructional_strategy from practicals where department=? and semester=? and subject=? and subject_code=?";
              $ps = mysqli_prepare($con, $sql);
              if($ps != false)
              {
                  mysqli_stmt_bind_param($ps,"ssss", $dept, $sem, $subject, $subject_code);
                  mysqli_stmt_execute($ps);
                  $srno = 0;
                  $pname = $istrategry = "";
                  mysqli_stmt_bind_result($ps, $srno, $pname, $istrategy);
                  $index = 0;
                  print("<table cellspacing='0' cellpadding='5' width='100%' border='1'>");
                  //print("<tr><th>Sr. No.</th><th>Practical Name</th><th>Instructional Strategy</th><th>Delete</th></tr>");
                  print("<tr><th>SR.NO.</th><th>LIST OF PRACTICALS</th><th>INSTRUCTIONAL STRATEGIES</th></tr>");
                  while(mysqli_stmt_fetch($ps)) 
                  {    
                      $index++;
                      print("<tr>");
                      print("<td>$index</td>");
                      print("<td>$pname</td>");
                      print("<td>$istrategy</td>");
                      //print("<td><a href='delete_practical.php?srno=$srno'>Delete</a></td>");
                      print("</tr>");            
                  }
                  print("</table>");
                  mysqli_stmt_close($ps);
                  mysqli_close($con);
              } 
              else
              {
                  mysqli_close($con);
                  print("load_practicals, prepared statement not created..<br/>");
              }             
          }
      }
      catch(Exception $ex)
      {
          print($ex->getmessage()."<br/>");
      }
    }

    //print("Department = $dept<br/>");
    //print("Semester = $sem<br/>");
    //print("Subject = $subject<br/>");
    //print("Subject Code = $subject_code<br/>");
    load_practicals($dept, $sem, $subject, $subject_code);
?>
</div>

<div>
      <br/>
      <?php
        function load_stucent_activities($dept, $sem, $subject, $subject_code)
        {
           try
           {
                $con = mysqli_connect("127.0.0.1", "root", "super", "gp_cur_db");
                if($con ==  false)
                print("Error: ".mysqli_connect_error()."<br/>");
                else
                {
                    $sql = "select srno, student_activities from student_activities where department=? and semester=? and subject=? and subject_code=?";
                    $ps = mysqli_prepare($con, $sql);
                    if($ps != false)
                    {
                        mysqli_stmt_bind_param($ps,"ssss", $dept, $sem, $subject, $subject_code);
                        mysqli_stmt_execute($ps);
                        $srno = 0;
                        $activities = "";
                        mysqli_stmt_bind_result($ps, $srno, $activities);

                        print("<br/>");
                        print("<font face='Times New Roman' face='4pt' color='black'><b>SUGGESTED STUDENT ACTIVITIES:</b></font></br>");
                        print("<table>");
                                                
                        while(mysqli_stmt_fetch($ps) != null)
                        {                            
                            print("<tr>");                            
                            print("<td>$activities</td>");
                            print("</tr>");
                        }
                        print("</table>");
                        mysqli_stmt_close($ps);
                        mysqli_close($con); 
                    } 
                    else
                    {
                      mysqli_close($con);
                      print("Function: Prepared Statement is not created..<br/>");
                    }                   
                }
           }
           catch(Exception $ex)
           {
                print($ex->getmessage()."<br/>");
           }
        } // end function load_course_outcomes

        //$dept = $_SESSION["dept"];
        //$sem = $_SESSION["sem"];
        //$subject = $_SESSION["subject"];
        //$subject_code = $_SESSION["subject_code"];
        load_stucent_activities($dept, $sem, $subject, $subject_code);
      ?>
  </div>

    <div>
      <br/>
      <?php
        function load_micro_projects($dept, $sem, $subject, $subject_code)
        {
           try
           {
                $con = mysqli_connect("127.0.0.1", "root", "super", "gp_cur_db");
                if($con ==  false)
                print("Error: ".mysqli_connect_error()."<br/>");
                else
                {
                    $sql = "select srno, micro_projects from micro_projects where department=? and semester=? and subject=? and subject_code=?";
                    $ps = mysqli_prepare($con, $sql);
                    if($ps != false)
                    {
                        mysqli_stmt_bind_param($ps,"ssss", $dept, $sem, $subject, $subject_code);
                        mysqli_stmt_execute($ps);
                        $srno = 0;
                        $micro_projects = "";
                        mysqli_stmt_bind_result($ps, $srno, $micro_projects);

                        print("<br/>");
                        print("<font face='Times New Roman' face='4pt' color='black'><b>SUGGESTED MICRO-PROJECTS:</b></font></br>");
                        print("<table>");
                                                
                        while(mysqli_stmt_fetch($ps) != null)
                        {                            
                            print("<tr>");                            
                            print("<td>$micro_projects</td>");
                            print("</tr>");
                        }
                        print("</table>");
                        mysqli_stmt_close($ps);
                        mysqli_close($con); 
                    } 
                    else
                    {
                      mysqli_close($con);
                      print("Function: Prepared Statement is not created..<br/>");
                    }                   
                }
           }
           catch(Exception $ex)
           {
                print($ex->getmessage()."<br/>");
           }
        } // end function load_course_outcomes

        //$dept = $_SESSION["dept"];
        //$sem = $_SESSION["sem"];
        //$subject = $_SESSION["subject"];
        //$subject_code = $_SESSION["subject_code"];
        load_micro_projects($dept, $sem, $subject, $subject_code);
      ?>
  </div>



<div>
<br/>
<table>
  <tr>
    <td><font face="Times New Roman" size="4pt" color="black"><b>REFERENCES:</b></font></td>
  </tr>
</table>
<?php
    function load_books($dept, $sem, $subject, $subject_code)
    {
        try
        {
            $con = mysqli_connect("127.0.0.1", "root", "super", "gp_cur_db");
            if($con ==  false)
            print("Error: ".mysqli_connect_error());
            else
            {
                $sql = "select srno, book_title, author, publication from books where department=? and semester=? and subject=? and subject_code=?";
                $ps = mysqli_prepare($con, $sql);
                if($ps != false)
                {
                    mysqli_stmt_bind_param($ps,"ssss", $dept, $sem, $subject, $subject_code);
                    mysqli_stmt_execute($ps);
                    $srno = $index = 0;
                    $book_title = $author = $publication = "";
                    print("<table width='100%' cellspacing='0' cellpadding='5' border='1'>");
                    //print("<tr><th>Sr. No.</th><th>Book Name</th><th>Author</th><th>Publication</th><th>Delete</th></tr>");
                    print("<tr><th>Sr. No.</th><th>Title</th><th>Author</th><th>Publication</th></tr>");
                    mysqli_stmt_bind_result($ps, $srno, $book_title, $author, $publication);
                    while(mysqli_stmt_fetch($ps)) // while(mysqli_stmt_fetch($ps) != null)
                    {
                        $index++;
                        print("<tr>");
                        print("<td>$index</td>");
                        print("<td>$book_title</td>");
                        print("<td>$author</td>");
                        print("<td>$publication</td>");
                        //print("<td><a href='delete_book.php?srno=$srno'>Delete</a></td>");
                        print("</tr>");
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
    }// end of function load_books

    //$dept = $_SESSION["dept"];
    //$sem = $_SESSION["sem"];
    //$subject = $_SESSION["subject"];
    //$subject_code = $_SESSION["subject_code"];

    //print("Department = $dept<br/>");
    //print("Semester = $sem<br/>");
    //print("Subject = $subject<br/>");
    //print("Subject Code = $subject_code<br/>");
    load_books($dept, $sem, $subject, $subject_code);
?>
</div>

<!--Specification Table-->
    <div>
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
            print("<font face='Times New Roman' size='4pt' color='black'>");
            print("<b>SPECIFICATION TABLE:</b><br/>");
            print("</font>");            
            print("<b>Note:</b> All paper setter are instructed to use following specification table for paper setting<br/>");
            load_specification_table($dept, $sem, $subject, $subject_code);
            print("<b>Note:</b> 15% questions should be of application level.<br/>");
            print("The Government Board of Dtudies has approved the above course curriculum.<br/>");
        ?>
    </div>

<div>
<br/>
<br/>
<table width="100%">
<tr>
	<td style="text-align: right;font-weight: bold;">
		<img src="images/chairman.jpg"/>
	</td>
</tr>
<tr>
	<td>
		<input type="button" value="Print" onclick="print_page()"/>
		<!-- <input type="button" value="Close" onclick="CloseWindow()"/> -->
	</td>
</tr>
</table>
</div>
</center>
</body>
</html>