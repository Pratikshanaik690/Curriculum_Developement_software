<?php
  $final_result = "";
	$dept_err = $sem_err = $subject_err = $subject_code = $programme_title = $rationale = $objectives = "";
	$dept = $sem = $subject = $subject_code_err = $programme_title_err= $rationale_err = $objectives_err= "";
  //print_r($_POST);
  //print("<br/>");
  //clearstatcache();
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

	if ($_SERVER["REQUEST_METHOD"] == "POST") 
	{		                	
		$c = 0;
    if(array_key_exists("DdlDept", $_POST))
    {
		    if(empty($_POST["DdlDept"]))		
		    {
			     $dept_err = "Department is required";
			     $c++;
		    }
		    else
		    {
			     $dept = $_POST["DdlDept"];
			     $dept_err = "";
			     $_SESSION["dept"] = $dept;
		    }
    }

    if(array_key_exists("DdlSemester", $_POST))
    {
		    if(empty($_POST["DdlSemester"]))		
		    {
			     $sem_err = "Semester is required";
			     $c++;
		    }
		    else
		    {
			     $sem = $_POST["DdlSemester"];
			     $sem_err = "";
			     $_SESSION["sem"] = $sem;
		    }
    }

    if(array_key_exists("TxtProgrammeTitle", $_POST))
    {
        if(empty(trim($_POST["TxtProgrammeTitle"])))
        {
            $programme_title_err = "Programme title is required";
            $c++;
        }
        else
        {
            $programme_title = strtoupper(trim($_POST["TxtProgrammeTitle"]));
            $programme_title_err = "";
            $_SESSION["programme_title"] = $programme_title;
        }
    }

    if(array_key_exists("TxtSubjectCode", $_POST))
    {
        if(empty(trim($_POST["TxtSubjectCode"])))
        {
            $subject_code_err = "Subject code is required";
            $c++;
        }
        else
        {
            $subject_code = strtoupper(trim($_POST["TxtSubjectCode"]));
            $subject_code_err = "";
            $_SESSION["subject_code"] = $subject_code;
        }
    }

    if(array_key_exists("TxtSubject", $_POST))
    {
        if(empty(trim($_POST["TxtSubject"])))
        {
            $subject_err = "Subject is required";
            $c++;
        }
        else
        {
            $subject = strtoupper(trim($_POST["TxtSubject"]));
            $subject_err = "";
            $_SESSION["subject"] = $subject;            
        }
    }

    if(array_key_exists("TxtRationale", $_POST))
    {
        if(empty(trim($_POST["TxtRationale"])))
        {
            $rationale_err = "Rationale is required";
            $c++;
        }
        else
        {
            $rationale = trim($_POST["TxtRationale"]);
            $rationale_err = "";          
        }
    }

    if(array_key_exists("TxtObjectives", $_POST))
    {
        if(empty(trim($_POST["TxtObjectives"])))
        {
            $objectives_err = "Objectives are required";
            $c++;
        }
        else
        {
            $objectives = trim($_POST["TxtObjectives"]);
            $objectives_err = "";          
        }
    }

    if(array_key_exists("b2", $_POST))
    {
      unset($programme_title_err);      
      unset($subject_err);
      unset($subject_code_err);
      unset($rationale_err);
      unset($objectives_err);
      $final_result="";
    }

	  if(array_key_exists("BtnAddSubject", $_POST))	
    {
        if($c == 0)
        {
            if(!empty($_SESSION["dept"]) and !empty($_SESSION["sem"]) and !empty($_SESSION["subject"]) and !empty($_SESSION["subject_code"]) and !empty($programme_title) and !empty($rationale) and !empty($objectives))
            {            
                try
                {
                    $dept = $_SESSION["dept"];
                    $sem = $_SESSION["sem"];
                    $subject = $_SESSION["subject"];
                    $subject_code = $_SESSION["subject_code"];

                    $sql = "select * from subjects where department=? and semester=? and subject=? and subject_code=?";
                    $con = mysqli_connect("127.0.0.1", "root", "super", "gp_cur_db");
                    if($con == false)
                    print("Error: ".mysqli_connect_error());
                    else
                    {
                        $ps = mysqli_prepare($con, $sql);
                        mysqli_stmt_bind_param($ps,"ssss", $dept, $sem, $subject, $subject_code);
                        mysqli_stmt_execute($ps);
                        //mysqli_stmt_bind_result($ps, $dept, $sem, $subject, $subject_code);
                        if(mysqli_stmt_fetch($ps) !== null)
                        {                                     
                            print("This subject is already added<br/>");
                            $final_result = "<font face=calibri size=3pt color=red>This subject is already added</font><br>";
                            mysqli_stmt_close($ps);
                            mysqli_close($con);
                            unset($_SESSION["subject"]);                         
                        }
                        else
                        {
                            mysqli_stmt_close($ps);
                            mysqli_close($con); 
                            $sql = "insert into subjects (department, semester, programme_title, subject, subject_code, rationale, objectives) values(?,?,?,?,?,?,?)";
                            $con = mysqli_connect("127.0.0.1", "root", "super", "gp_cur_db");
                            if($con == false)
                            print("Error: ".mysqli_connect_error());
                            else
                            {
                                $ps = mysqli_prepare($con, $sql);
                                mysqli_stmt_bind_param($ps,"sssssss", $dept, $sem, $programme_title, $subject, $subject_code, $rationale, $objectives);
                                mysqli_stmt_execute($ps);
                                $n = mysqli_stmt_affected_rows($ps);
                                mysqli_stmt_close($ps);
                                mysqli_close($con);
                                if($n == 1)
                                {
                                    print("Subject added successfully<br/>");
                                    $final_result = "<font face=calibri size=3pt color=green>Subject Added successfully.</font><br>";
                                    unset($_SESSION["subject"]);
                                    unset($_SESSION["subject_code"]);                               
                                }
                                else
                                {
                                //print("Something gets wrong. Subject not added<br/>");
                                //$final_result = "<font face=calibri size=3pt color=red>Something gets wrong. Subject not added.</font><br>";                                
                                }
                            }
                        }
                    }       
                }
                catch(Exception $ex)
                {
                    print($ex->getmessage()."<br/>");
                    mysqli_close($con);
                }
            }
            else
            {
              //print("empty..<br/>");
            }
        }
    }// end if BtnAddSubjects


    

	}	
?>

<html>
<head>
	<meta charset="utf-8">
      <style>
      span
      {
        font-family: calibri;
        font-size: 17px;
        color: red;
      }
      </style>
  		<meta name="viewport" content="width=device-width, initial-scale=1">  		
      <link href="styles/subject_table_style.css" rel="stylesheet"/>
  		<link rel="stylesheet" href="bootstrap/bootstrap.min.css">      
  		<script src="bootstrap/jquery.min.js"></script>
  		<script src="bootstrap/bootstrap.min.js"></script>
  		<link href="styles/add_subjects.css" rel="stylesheet"/>
  		<script lang="javascript">
  			function checkdata()
  			{
  				var msg = "";
           if(document.f1.TxtProgrammeTitle.value.trim().length == 0)
            msg = msg + "Programme Title is required\n";

          if(document.f1.TxtSubjectCode.value.trim().length == 0)
            msg = msg + "Subject Code is required\n"

  				if(document.f1.TxtSubject.value.trim().length == 0)
  					msg = msg + "Subject is required\n"

          if(document.f1.TxtRationale.value.trim().length == 0)
            msg = msg + "Rationale is required\n";

          if(document.f1.TxtObjectives.value.trim().length == 0)
            msg = msg + "Objectives are required\n";

  				if(msg != "")
  				{
  					alert(msg);
  					return;
  				}
  				else
  					document.f1.submit();
  			}

        function clear_click()
        { 
            document.f1.TxtProgrammeTitle.value="";         
            document.f1.TxtSubjectCode.value="";
            document.f1.TxtSubject.value="";
            document.f1.TxtRationale.value="";
            document.f1.TxtObjectives.value="";
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
  							if(isset($_SESSION["dept"]))
  							{
  								$dept = $_SESSION["dept"];
  								echo $dept, "<br/>";
  							}
  						?>
  						Semester:
  						<?php 
  							if(isset($_SESSION["sem"]))
  							{
  								$sem = $_SESSION["sem"];
  								echo $sem, "<br/>";
  							}
  						?>
  					</font>
  				</div>
  				<!-- <div class="panel-body"> -->
          <div>
  					<table>
              <tr>
                <td>Programme Title</td>
                <td><input type="text" name="TxtProgrammeTitle" <?php if(empty($_POST['TxtProgrammeTitle'])===false) echo "value='".$_POST['TxtProgrammeTitle']."'"; ?>></td>
              </tr>  
              <?php if(!empty($programme_title_err)) print("<tr><td></td><td><span>$programme_title_err</span></td></tr>"); ?>
              <tr>
                <td>Subject Code</td>              
                <td><input type="text" name="TxtSubjectCode" <?php if(empty($_POST['TxtSubjectCode'])===false) echo "value=".$_POST['TxtSubjectCode']; ?>></td>
              </tr>
              <?php if(!empty($subject_code_err)) print("<tr><td></td><td><span>$subject_code_err</span></td></tr>"); ?>
  						<tr>
  							<td>Subject Name</td>  						
  							<td><input type="text" name="TxtSubject" <?php if(empty($_POST['TxtSubject'])===false) echo "value='".$_POST['TxtSubject']."'"; ?>></td>
  						</tr>
              <?php if(!empty($subject_err)) print("<tr><td></td><td><span>$subject_err</span></td></tr>"); ?>
              <tr>
                <td colspan="2">Rationale</td>
              </tr>
              <tr>
                <td colspan="2">
                  <textarea name="TxtRationale" cols="80" rows="7"><?php if(empty($_POST['TxtRationale'])===false) echo $_POST['TxtRationale']; ?></textarea>
                </td>
              </tr>
              <?php if(!empty($rationale_err)) print("<tr><td></td><td><span>$rationale_err</span></td></tr>"); ?>
              <tr>
                <td colspan="2">Objectives</td>
              </tr>
              <tr>
                <td colspan="2">
                  <textarea name="TxtObjectives" cols="80" rows="7"><?php if(empty($_POST['TxtObjectives'])===false) echo $_POST['TxtObjectives']; ?></textarea>
                </td>
              </tr>
              <?php if(!empty($objectives_err)) print("<tr><td></td><td><span>$objectives_err</span></td></tr>"); ?>
  						<tr>
  							<td colspan="2" style="text-align: right;">
                  <!-- <input type="submit" name="BtnAddSubject" value="Add Subject" onclick="checkdata()"/> -->
                  <input type="submit" name="BtnAddSubject" value="Add Subject"/>  								
  								<input type="submit" value="Clear" name="b2" onclick="clear_click()"/>
  							</td>
  						</tr>
              <tr>
                <td colspan="2">
                    <?php
                        print("<font face=calibri size=3pt color=red>");
                        print($final_result);
                        print("</font>");
                    ?>
                </td>
              </tr>
  					</table>
  				</div>
  			</div>

        <!-- List of Subjects -->
        <div>
          <a href="add_subjects.php">Back</a><br/>
          <!--class="mystyle" -->
          <!-- style="width:100%;font-family:calibri;font-size: 17px;" -->
        <table class="mystyle">
            <tr>
              <th>DEPARTMENT</th>
              <th>SEMESTER</th>
              <th>PROGRAMME TITLE</th>
              <th>SUBJECT</th>
              <th>SUBJECT CODE</th>
              <th>RATIONALE</th>
              <th>OBJECTIVES</th>
              <th>DELETE</th>
            </tr>
            <?php
                if(!empty($_SESSION["dept"]) && !empty($_SESSION["sem"]))
                {
                    $dept = $_SESSION["dept"];
                    $sem = $_SESSION["sem"];
                    $sql = "select srno, programme_title, subject, subject_code, rationale, objectives from subjects where department=? and semester=? order by srno desc";
                    $con = mysqli_connect("127.0.0.1", "root", "super", "gp_cur_db");
                    if($con ==  false)
                    print("Error: ".mysqli_connect_error());
                    else
                    {
                        $ps = mysqli_prepare($con, $sql);
                        mysqli_stmt_bind_param($ps,"ss", $dept, $sem);
                        mysqli_stmt_execute($ps);
                        mysqli_stmt_bind_result($ps, $srno,$programme_title, $subject, $subject_code, $rationale, $objectives);
                        while(mysqli_stmt_fetch($ps)) // while(mysqli_stmt_fetch($ps) != null)
                        {
                              //global $dept; global $sem; global $job; global $sal;
                              print("<tr>");
                              print("<td>$dept</td>");
                              print("<td>$sem</td>");
                              print("<td>$programme_title</td>");
                              print("<td>$subject</td>");
                              print("<td>$subject_code</td>");
                              print("<td>$rationale</td>");
                              print("<td>$objectives</td>");
                              print("<td><a href=delete_sub.php?srno=$srno>Delete</a></td>");
                              print("</tr>");
                        }
                        mysqli_stmt_close($ps);
                        mysqli_close($con);
                    }
                }
            ?>
        </table>
      </div>
        <!-- End of list of subject -->
		</form>
	</body>
</html>
<?php
  $_POST = array();
?>