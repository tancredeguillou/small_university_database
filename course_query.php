<html> 
<head>
<title>Result of Database Query</title>
</head>
<body> 
<h1>Result of Database Query</h1>
<?php
  $dbconn = pg_connect("host=tr01")
    or die('Could not connect: ' . pg_last_error());

    //********************************************** PART I  **********************************************/

    // Prepare a query for execution with $1 as a placeholder
    $result = pg_prepare($dbconn, "my_query",
        'SELECT s.sname, e.grade FROM student s, enroll e WHERE e.cno = $1 AND s.sid = e.sid')
        or die('Query preparation failed: ' . pg_last_error());

    // Execute the prepared query with the value from the form as the actual argument 
    $result = pg_execute($dbconn, "my_query", array($_POST['courseno'])) 
        or die('Query execution failed: ' . pg_last_error());

    $nrows = pg_numrows($result);
    if($nrows != 0)
      {
    print "<p>Data for course number: " . $_POST['courseno'];
    print "<table border=2><tr><th>Name<th>Grade\n";
    for($j=0;$j<$nrows;$j++)
        {
            $row = pg_fetch_array($result);
            print "<tr><td>" . $row["sname"];
            print "<td>" . $row["grade"];
            print "\n";
        }
        print "</table>\n";
    }
    else	print "<p>No Entry for " . $_POST['courseno'];

    //********************************************** PART I  **********************************************/

  // Prepare a query for execution with $1 as a placeholder
  $result = pg_prepare($dbconn, "my_query", 'SELECT * FROM student WHERE sid = $1')
    or die('Query preparation failed: ' . pg_last_error());

  // Execute the prepared query with the value from the form as the actual argument 
  $result = pg_execute($dbconn, "my_query", array($_POST['studentid'])) 
    or die('Query execution failed: ' . pg_last_error());

  $nrows = pg_numrows($result);
    if($nrows != 0)
      {
	print "<p>Data for student id: " . $_POST['studentid'];
	print "<table border=2><tr><th>Name<th>Age<th>Sex<th>Year<th>GPA\n";
	for($j=0;$j<$nrows;$j++)
		{
			$row = pg_fetch_array($result);
			print "<tr><td>" . $row["sname"];
			print "<td>" . $row["age"];
			print "<td>" . $row["sex"];
			print "<td>" . $row["year"];
			print "<td>" . $row["gpa"];
			print "\n";
		}
		print "</table>\n";
	}
    else	print "<p>No Entry for " . $_POST['studentid'];
    
	pg_close($dbconn);
?>
</p>
</body>
</html>