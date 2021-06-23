<?php
  $server = "localhost"; $username="root"; $password="super"; $database="gp_cur_db";
	$dept = $sem = $subject = $subject_code = "";	
  $course_outcomes = $course_outcomes_err = $final_result = "";
	session_start();

  function my_line_breaks($text) 
  { 
      return strtr($text, array("\r\n" => '<br />', "\r" => '<br />', "\n" => '<br />')); 
  } 

  if($_SERVER["REQUEST_METHOD"] == "POST") 
  {
      $c = 0;
      if(array_key_exists("BtnAddCourseOutcomes", $_POST))  
      {

          if(empty(trim($_POST["txt_course_outcomes"])))
          {
             $c++;
             $course_outcomes_err = "Course Outcomes Rquired";
          }
          else
          {
            $course_outcomes = $_POST["txt_course_outcomes"];
            $course_outcomes_err = "";
          }

          if($c == 0)
          {
              try
              {
                  $con = mysqli_connect($server, $username, $password, $database);
                  if($con == false)
                  print("Error: ".mysqli_connect_error());
                  else
                  {
                      $sql = "insert into course_outcomes (department , semester, subject , subject_code, course_outcome)  values (?, ?, ?, ?, ?)";
                      $ps = mysqli_prepare($con, $sql);
                      if($ps != false)
                      {
                          $dept = $_SESSION["dept"];
                          $sem = $_SESSION["sem"];
                          $subject = $_SESSION["subject"];
                          $subject_code = $_SESSION["subject_code"];

                          mysqli_stmt_bind_param($ps,"sssss", $dept, $sem, $subject, $subject_code, my_line_breaks($course_outcomes));
                          mysqli_stmt_execute($ps);
                          $n = mysqli_stmt_affected_rows($ps);
                          mysqli_stmt_close($ps);
                          mysqli_close($con);
                          if($n == 1)
                          {
                              //print("Course Outcomes Saved.<br/>");
                              $final_result = "<font face=calibri size=3pt color=green>Course Outcomes Saved.</font><br>";
                          }
                          else
                          {                        
                            $final_result = "<font face=calibri size=3pt color=red>Sorry! Course Outcomes Not Saved.</font><br>";                                
                          }
                      }
                      else
                      {  
                          mysqli_close($ps);
                          print("Prepared Statement is not created..<br/>");
                      }//
                  } 
              }
              catch(Exception $ex)
              {
                print($ex->getmessage()."<br/>");
              }
          }

      }// end if BtnAddCourseOutcomes
      elseif(array_key_exists("BtnClear", $_POST))
      {
          $course_outcomes = "";
          $course_outcomes_err = "";
          $final_result = "";
      }// end if BtnClear



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
  	<script>
  		function clear_data()
  		{
  			
  			document.f1.submit();
  		}
  	</script>
</head>
<body>
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" name="f1">
		<div class="panel panel-default">
  		<div class="panel-heading">
  			<font face="calibri" size="5pt" color="green">
  				Add Course Outcomes
  			</font>
  			<br/>
  			<font face="calibri" size="3pt" color="green">  					  				
  				<?php   					
  					if(array_key_exists("dept", $_SESSION))
  					{
  						print("Department:");
  						if(isset($_SESSION["dept"]))
  						{
  							$dept = $_SESSION["dept"];
  							echo $dept, "<br/>";
  						}
  					}
  				
  					if(array_key_exists("sem", $_SESSION)) 
  					{
  						print("Semester:");
  						if(isset($_SESSION["sem"]))
  						{
  							$sem = $_SESSION["sem"];
  							echo $sem, "<br/>";
  						}
  					}

					if(array_key_exists("subject", $_SESSION)) 
  					{
  						print("Subject:");
  						if(isset($_SESSION["subject"]))
  						{
  							$subject = $_SESSION["subject"];
  							echo $subject, "<br/>";
  						}
  					}

  					if(array_key_exists("subject_code", $_SESSION)) 
  					{
  						print("Subject Code:");
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
        <center>
          <table style="text-align: left">
              <tr>
                <td>Course Outcomes</td>                
              <tr>
              <tr>
                <td>
                  <textarea name="txt_course_outcomes" rows="10" cols="90"><?php if(!empty($course_outcomes)) print($course_outcomes);?></textarea>
                </td>                
              <tr>
              <?php
                if(!empty($course_outcomes_err))
                  print("<tr><td><span>$course_outcomes_err</span></td></tr>");
              ?>
              <tr>
                <td>
                  <input type="submit" name="BtnAddCourseOutcomes" value="Add Course Outcomes">
                  &nbsp;
                  <input type="submit" name="BtnClear" value="Clear">
                </td>
              <tr>
              <?php
                if(!empty($final_result))
                  print("<tr><td>$final_result</td></tr>");
              ?>
          </table>
        </center>
      </div>
      <br/>
      <a href="select_subject.php">Back</a><br/>
      <br/>
      
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
                        print("<tr><td colspan='2'><font face='calibri' size='5pt' color='black'>Course Outcomes (COs)</font></td></tr>");
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

        $dept = $_SESSION["dept"];
        $sem = $_SESSION["sem"];
        $subject = $_SESSION["subject"];
        $subject_code = $_SESSION["subject_code"];
        load_course_outcomes($dept, $sem, $subject, $subject_code);
      ?>

</div>
</form>
</body>
</html>  			