<?php
	$dept = $sem = $subject = $subject_code = "";
	$book_title = $author = $publication = "";
	$book_title_err = $author_err = $publication_err = $final_result = "";

	session_start();

	if($_SERVER["REQUEST_METHOD"] == "POST") 
	{

		if(array_key_exists("BtnAddBook", $_POST))
		{
			$c = 0;

			if(array_key_exists("TxtBookTitle", $_POST))
			{
				if(empty(trim($_POST["TxtBookTitle"])))
				{
					$book_title_err = "Book title is required";
					$c++;
				}
				else
				{
					$book_title = strtoupper(trim($_POST["TxtBookTitle"]));
					$book_title_err = "";
				}
			}

			if(array_key_exists("TxtAuthor", $_POST))
			{
				if(empty(trim($_POST["TxtAuthor"])))
				{
					$author_err = "Author is required";
					$c++;
				}
				else
				{
					$author = strtoupper(trim($_POST["TxtAuthor"]));
					$author_err = "";
				}
			}

			if(array_key_exists("TxtPublication", $_POST))
			{
				if(empty(trim($_POST["TxtPublication"])))
				{
					$publication_err = "Publication is required";
					$c++;
				}
				else
				{
					$publication = strtoupper(trim($_POST["TxtPublication"]));
					$publication_err = "";
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
                		$sql = "insert into books (department, semester, subject, subject_code, book_title, author, publication) values(?, ?, ?, ?, ?, ?, ?)";
                		$ps = mysqli_prepare($con, $sql);
                		if($ps != false)
                		{
                			$dept = $_SESSION["dept"];
                			$sem = $_SESSION["sem"];
                			$subject = $_SESSION["subject"];
                			$subject_code = $_SESSION["subject_code"];
                		
                			mysqli_stmt_bind_param($ps,"sssssss", $dept, $sem, $subject, $subject_code, $book_title, $author, $publication);
                        	mysqli_stmt_execute($ps);
                        	$n = mysqli_stmt_affected_rows($ps);
                        	mysqli_stmt_close($ps);
                        	mysqli_close($con);
                        	if($n == 1)
                        	{
                            	print("Book details saved.<br/>");
                            	$final_result = "<font face=calibri size=3pt color=green>Book details saved.</font><br>";
							            }
                        	else
                        	{                        
                        		$final_result = "<font face=calibri size=3pt color=red>Sorry! Book details not saved.</font><br>";                                
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

		}	// end if BtnAddBook
		elseif(array_key_exists("BtnClear", $_POST))
		{
			$book_title_err = "";
			$author_err = "";
			$publication_err = "";
			$final_result = "";
		}	// end if BtnClear

	}	// end if POST
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
  			document.f1.TxtBookTitle.value = "";
  			document.f1.TxtAuthor.value = "";
  			document.f1.TxtPublication.value = "";
  			document.f1.submit();
  		}
  	</script>
</head>
<body>
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" name="f1">
		<div class="panel panel-default">
  		<div class="panel-heading">
  			<font face="calibri" size="5pt" color="green">
  				Add Books
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
      		<table>
      			<tr>
      				<td>Title</td>
      				<td><input type="text" name="TxtBookTitle" <?php if(array_key_exists("TxtBookTitle", $_POST)) if(!empty($_POST["TxtBookTitle"])) print("value='".$_POST["TxtBookTitle"]."'"); ?>></td>
      			</tr>
      			<?php
      				if(!empty($book_title_err))
      					print("<tr><td></td><td><span>$book_title_err</span></td></tr>");
      			?>
      			<tr>
      				<td>Author</td>
      				<td><input type="text" name="TxtAuthor" <?php if(array_key_exists("TxtAuthor", $_POST)) if(!empty($_POST["TxtAuthor"])) print("value='".$_POST["TxtAuthor"]."'"); ?>></td>
      			</tr>
      			<?php
      				if(!empty($author_err))
      					print("<tr><td></td><td><span>$author_err</span></td></tr>");
      			?>
      			<tr>
      				<td>Publication</td>
      				<td><input type="text" name="TxtPublication" <?php if(array_key_exists("TxtPublication", $_POST)) if(!empty($_POST["TxtPublication"])) print("value='".$_POST["TxtPublication"]."'"); ?>></td>
      			</tr>
      			<?php
      				if(!empty($publication_err))
      					print("<tr><td></td><td><span>$publication_err</span></td></tr>");
      			?>
      			<tr>
      				<td></td>
      				<td>
      					<input type="submit" value="Add Book" name="BtnAddBook">
      					&nbsp;
      					<input type="submit" value="Clear" name="BtnClear" onclick="clear_data()">
      				</td>
      			</tr>
      			<?php
      				if(!empty($final_result))
      					print("<tr><td></td><td>$final_result</td></tr>");
      			?>
      		</table>
        </div>
    </div>

    <!-- Book List -->
    <div>
      <a href="select_subject.php">Back</a><br/>
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
                        	print("<tr><th>Sr. No.</th><th>Book Name</th><th>Author</th><th>Publication</th><th>Delete</th></tr>");
                        	mysqli_stmt_bind_result($ps, $srno, $book_title, $author, $publication);
							while(mysqli_stmt_fetch($ps)) // while(mysqli_stmt_fetch($ps) != null)
                        	{
                        		$index++;
                        		print("<tr>");
                        		print("<td>$index</td>");
                        		print("<td>$book_title</td>");
                        		print("<td>$author</td>");
                        		print("<td>$publication</td>");
                        		print("<td><a href='delete_book.php?srno=$srno'>Delete</a></td>");
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

    		$dept = $_SESSION["dept"];
    		$sem = $_SESSION["sem"];
    		$subject = $_SESSION["subject"];
    		$subject_code = $_SESSION["subject_code"];

    		//print("Department = $dept<br/>");
    		//print("Semester = $sem<br/>");
    		//print("Subject = $subject<br/>");
    		//print("Subject Code = $subject_code<br/>");
    		load_books($dept, $sem, $subject, $subject_code);
    	?>
    </div>
	</form>
</body>	
</html>