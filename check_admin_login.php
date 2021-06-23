<?php	

	$userid = $upassword = "";
	$userid_err = $upassword_err = "";
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") 
	{		
		$c = 0;
		//print_r($_POST);
		//print("<br/>");

		if(empty($_POST["TxtUserId"]))
		{
			$userid_err = "Userid is required";
			$c++;
		}
		else
		{			
			$userid = $_POST["TxtUserId"];
			$userid_err = "";
		}

		if(empty($_POST["TxtPassword"]))
		{
			$upassword_err = "Password is required";
			$c++;
		}
		else
		{			
			$upassword = $_POST["TxtPassword"];
			$upassword_err = "";
		}

		if($c == 0)
		{
			//print("$c<br/>");			
			$sql = "select admin_password from admin_master where userid=?";
			$con = mysqli_connect("127.0.0.1", "root", "super", "gp_cur_db");
          	if($con ==  false)
          		print("Error: ".mysqli_connect_error());
          	else
          	{                                     
                $ps = mysqli_prepare($con, $sql);
                mysqli_stmt_bind_param($ps, "s", $userid);
                mysqli_stmt_execute($ps);
                mysqli_stmt_bind_result($ps, $actual_pass);
                if(mysqli_stmt_fetch($ps) != null)
                {
                	mysqli_stmt_close($ps);
                	mysqli_close($con);                	
                	//print("actual_pass = $actual_pass<br/>");
                	if(strcmp($upassword, $actual_pass) == 0)
                	{
                		print("Valid Password..<br/>");
                		session_start();
                		$_SESSION["userid"] = $userid;
                        header("location:admin_panel.php");
                	}
                	else
                	{
                		print("<font face='calibri' size='4' color='red'>");
                		print("Invalid Password..<br/>");
                		print("</font><br/>");
                	}
                }
                else
                {
                	mysqli_stmt_close($ps);
                	mysqli_close($con);
                	print("<font face='calibri' size='4' color='red'>");
                	print("Invalid userid..<br/>");
                	print("</font><br/>");
            	}                
			}
		}
		else
		{
			//print("$c<br/>");
			print("<font face='calibri' size='4' color='red'>");
			print("$userid_err<br/>");
			print("$upassword_err<br/>");
			print("</font><br/>");
		}
	}

?>