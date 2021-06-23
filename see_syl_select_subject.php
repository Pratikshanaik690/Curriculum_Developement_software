<?php
	//print_r($_GET);
	//print("<br>");
	//print_r($_POST);
	//print("<br/>");
	session_start();
?>
<html>
<head>
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
	<form action="see_content.php" method="POST" name="f1">
		<div class="panel panel-default">
  		<div class="panel-heading">
  			<font face="calibri" size="3pt" color="green">  					
  				Department: 
  				<?php 
  					if(array_key_exists("dept", $_GET))
  					{
  						if(isset($_GET["dept"]))
  						{
  							$dept = $_GET["dept"];
  							echo $dept, "<br/>";
  							$_SESSION["dept"] = $dept;
  						}
  					}
  				?>
  				Semester:
  				<?php
  					if(array_key_exists("sem", $_GET)) 
  					{
  						if(isset($_GET["sem"]))
  						{
  							$sem = $_GET["sem"];
  							echo $sem, "<br/>";
  							$_SESSION["sem"] = $sem;
  						}
  					}
  				?>
  			</font>
  		</div>
  		<!-- <div class="panel-body"> -->
        <div>
          <center>
        	<table style="text-align: left;">
			<tr>
				<td>Subject</td>
				<td>
					<select name="DdlSubjects">
  						<option value="-1">-- Select Subject --</option>
  						<?php
  							if(!empty(trim($_GET["dept"])) and !empty(trim($_GET["sem"])))
  							{
  								try
  								{
  									$dept = strtoupper(trim($_GET["dept"]));
  									$sem = strtoupper(trim($_GET["sem"]));
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
                							print("<option>$subject</option>");                								
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
			<tr>
				<td></td>
				<td>
					<input type="button" value="View Syllabus" name="b1" onclick="checkdata()">
				</td>
			</tr> 	
			</table>
    </center>
        </div>
    </div>
	</form>
</body>
</html>