<?php
  $server = "localhost"; $user_name = "root"; $password = "super"; $database = "gp_cur_db";
	if(array_key_exists("srno", $_GET))
	{
		if(!empty($_GET["srno"]))
		{
			try
			{				
				$con = mysqli_connect($server, $user_name, $password, $database);
        if($con == false)
        print("Error: ".mysqli_connect_error());
        else
        {
          $srno = intval($_GET["srno"]);
					$sql = "delete from subjects where srno = ?";
					$ps = mysqli_prepare($con, $sql);
					if($ps != false)
          {
            mysqli_stmt_bind_param($ps,"i", $srno);
            mysqli_stmt_execute($ps);
            $n = mysqli_stmt_affected_rows($ps);
            mysqli_stmt_close($ps);
            mysqli_close($con);
            if($n == 1)
            header("location:admin_home.php");
            else
            print("Sorry! subject not deleted..");
          }
          else
          {
          	mysqli_close($con);
          	print("Prepared Satement not created..<br/>");
          }
        }
			}
			catch(Exception $ex)
			{
				print($ex->getmessage()."<br/>");
			}
		}
	}
?>