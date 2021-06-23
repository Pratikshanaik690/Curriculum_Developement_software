<?php
	$dept = $sem = $subject = $subject_code = "";	
	$micro_projects = $micro_projects_err = $final_result = "";
	$server = "localhost"; $username="root"; $password="super"; $database="gp_cur_db";

	session_start();

	function my_line_breaks($text) 
	{ 
   		return strtr($text, array("\r\n" => '<br />', "\r" => '<br />', "\n" => '<br />')); 
	} 

	//BtnAddMicroProjects

	if($_SERVER["REQUEST_METHOD"] == "POST") 
	{
		$c = 0;
      	if(array_key_exists("BtnAddMicroProjects", $_POST))
      	{
      		if(empty(trim($_POST["txt_micro_projects"])))
          	{
             	$c++;
             	$micro_projects_err = "Suggested Micro Projects Rquired";
          	}
          	else
          	{
            	$micro_projects = $_POST["txt_micro_projects"];
            	$micro_projects_err = "";
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
                  		$sql = "insert into micro_projects (department , semester, subject , subject_code, micro_projects)  values (?, ?, ?, ?, ?)";
                  		$ps = mysqli_prepare($con, $sql);
                      	if($ps != false)
                      	{
                      		$dept = $_SESSION["dept"];
                          	$sem = $_SESSION["sem"];
                          	$subject = $_SESSION["subject"];
                          	$subject_code = $_SESSION["subject_code"];
                          	$new_micro_projects = my_line_breaks($micro_projects);
                          	mysqli_stmt_bind_param($ps,"sssss", $dept, $sem, $subject, $subject_code, $new_micro_projects);
                          	mysqli_stmt_execute($ps);
                          	$n = mysqli_stmt_affected_rows($ps);
                         	mysqli_stmt_close($ps);
                          	mysqli_close($con);
                          	if($n == 1)
                          	{                              	
                              	$final_result = "<font face=calibri size=3pt color=green>Micro Projects Saved.</font><br>";
                          	}
                          	else
                          	{                        
                            	$final_result = "<font face=calibri size=3pt color=red>Sorry! Micro Projects Not Saved.</font><br>";                                
                          	}
                      	}
                      	else
                      	{
                      		mysqli_close($ps);
                          	print("Prepared Statement is not created..<br/>");
                      	}
                  	}
          		}
          		catch(Exception $ex)
          		{
          			print($ex->getmessage()."<br/>");
          		}
          	}
      	}  
      	elseif(array_key_exists("BtnClear", $_POST))
      	{
          $micro_projects = "";
          $micro_projects_err = "";
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
  				Add Suggested Micro Projects
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
                <td>Suggested Micro Projects</td>                
              <tr>
              <tr>
                <td>
                  <textarea name="txt_micro_projects" rows="10" cols="90"><?php if(!empty($micro_projects)) print($micro_projects);?></textarea>
                </td>                
              <tr>
              <?php
                if(!empty($micro_projects_err))
                  print("<tr><td><span>$micro_projects_err</span></td></tr>");
              ?>
              <tr>
                <td>
                  <input type="submit" name="BtnAddMicroProjects" value="Add Suggested Micro Projects">
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
  	

  	<div>
      <br/>
  		<a href="select_subject.php">Back</a><br/>
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

        $dept = $_SESSION["dept"];
        $sem = $_SESSION["sem"];
        $subject = $_SESSION["subject"];
        $subject_code = $_SESSION["subject_code"];
        load_micro_projects($dept, $sem, $subject, $subject_code);
      ?>
  </div>
</div>
</form>
</body>
</html>  			