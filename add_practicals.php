<?php
    session_start();
    $practical_name = $instructional_strategy = "";
    $practical_name_err = $instructional_strategy_err = $final_result = "";
    $c = 0;

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
                  print("<tr><th>Sr. No.</th><th>Practical Name</th><th>Instructional Strategy</th><th>Delete</th></tr>");
                  while(mysqli_stmt_fetch($ps)) 
                  {    
                      $index++;
                      print("<tr>");
                      print("<td>$index</td>");
                      print("<td>$pname</td>");
                      print("<td>$istrategy</td>");
                      print("<td><a href='delete_practical.php?srno=$srno'>Delete</a></td>");
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

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {      
        if(array_key_exists("TxtPracticalName", $_POST))
        {
            if(empty(trim($_POST["TxtPracticalName"])))
            {
                $practical_name_err = "Practical name is required";
                $c++;
            }
            else
            {
                $practical_name = strtoupper(trim($_POST["TxtPracticalName"]));
                $practical_name_err = "";
            }
        }

        if(array_key_exists("TxtStrategy", $_POST))
        {
            if(empty(trim($_POST["TxtStrategy"])))
            {
                $instructional_strategy_err = "Instructional strategy is required";
                $c++;
            }
            else
            {
                $instructional_strategy = strtoupper(trim($_POST["TxtStrategy"]));
                $instructional_strategy_err = "";
            }
        }

        if(array_key_exists("BtnClear", $_POST))
        {
            unset($practical_name_err);
            unset($instructional_strategy_err);
            unset($final_result);
            unset($practical_name);
            unset($inctructional_strategy);
        }

        if(array_key_exists("BtnAddPractical", $_POST))
        {
            if(!empty($_SESSION["dept"]) and !empty($_SESSION["sem"]) and !empty($_SESSION["subject_code"]) and !empty($_SESSION["subject"]) and !empty($practical_name) and !empty($instructional_strategy) and $c == 0)
            {
                $dept = $_SESSION["dept"];
                $sem = $_SESSION["sem"];
                $subject = $_SESSION["subject"];
                $subject_code = $_SESSION["subject_code"];

                try
                {
                    $con = mysqli_connect("127.0.0.1", "root", "super", "gp_cur_db");
                    if($con == false)
                    print("Error: ".mysqli_connect_error());
                    else
                    {
                        $sql = "insert into practicals (department, semester, subject, subject_code, practical_name, instructional_strategy) values (?, ?, ?, ?, ?, ?)";
                        $ps = mysqli_prepare($con, $sql);
                        if($ps !== false)
                        {
                            mysqli_stmt_bind_param($ps,"ssssss", $dept, $sem, $subject, $subject_code, $practical_name, $instructional_strategy);
                            mysqli_stmt_execute($ps);
                            $n = mysqli_stmt_affected_rows($ps);
                            mysqli_stmt_close($ps);
                            mysqli_close($con);
                            if($n == 1)
                            {
                                print("Practical added successfully<br/>");
                                $final_result = "<font face=calibri size=3pt color=green>Practical Added successfully.</font><br>";
                                unset($practical_name);
                                unset($instructional_strategy);                               
                            }
                            else
                            {
                                print("Sorry! Practical not added<br/>");
                                $final_result = "<font face=calibri size=3pt color=red>Sorry! Practical Not Added.</font><br>";
                                unset($practical_name);
                                unset($instructional_strategy);
                            }
                        }
                        else
                        {
                            mysqli_close($con);
                            print("Prepared statement not created..<br/>");
                        }
                    }
                } 
                catch(Exception $ex)
                {
                    print($ex->getmessage()."<br/>");
                }
            } 
        } // end if BtnAddPractical

    }
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
           document.f1.TxtPracticalName.value = "";
           document.f1.TxtStrategy.value = "";
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
                  <td>Practical Name</td>
                  <td><input type="text" name="TxtPracticalName" <?php if(array_key_exists("TxtPracticalName", $_POST)) if(!empty(trim($_POST["TxtPracticalName"]))) print("value='".$_POST["TxtPracticalName"]."'"); ?>></td>
                </tr>
                <?php
                    if(!empty($practical_name_err))
                    {
                      print("<tr><td></td><td><span>$practical_name_err</span></td></tr>");
                    }
                ?>
                <tr>
                  <td>Instractional Strategy</td>
                  <td><input type="text" name="TxtStrategy" <?php if(array_key_exists("TxtStrategy", $_POST)) if(!empty(trim($_POST["TxtStrategy"]))) print("value='".$_POST["TxtStrategy"]."'"); ?>></td>
                </tr>
                <?php
                    if(!empty($instructional_strategy_err))
                    {
                      print("<tr><td></td><td><span>$instructional_strategy_err</span></td></tr>");
                    }
                ?>
                <tr>                  
                  <td colspan="2" style="text-align: right;">
                    <input type="submit" value="Add Practical" name="BtnAddPractical">
                    <input type="submit" value="Clear" name="BtnClear" onclick="clear_data()">
                  </td>
                </tr>
                <?php
                    if(!empty($final_result))
                    {
                      print("<tr><td></td><td><span>$final_result</span></td></tr>");
                    }
                ?>
             </table>
        </div>
    </div>
  <a href="select_subject.php">Back</a><br/>
  <!-- Practical List-->
  <div>
    <?php
    if(!empty($_SESSION["dept"]) and !empty($_SESSION["sem"]) and !empty($_SESSION["subject"]) and !empty($_SESSION["subject_code"]))
    {
        $dept = $_SESSION["dept"];
        $sem = $_SESSION["sem"];
        $subject = $_SESSION["subject"];
        $subject_code = $_SESSION["subject_code"];
        load_practicals($dept, $sem, $subject, $subject_code);        
    }
    ?>      
  </div>
</form>  	
</body>
</html>