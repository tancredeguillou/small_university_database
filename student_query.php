<html> 
<head>
<title>Result of Database Query</title>
</head>
<body> 
<h1>Result of Database Query</h1>
<?php
  $dbconn = pg_connect("host=tr01")
    or die('Could not connect: ' . pg_last_error());

    //********************************************** PART III  **********************************************/

    // Prepare a query for execution with $1 as a placeholder
    $result = pg_prepare($dbconn, "my_query",
        'SELECT s.cno, s.sectno FROM section s WHERE (SELECT count(e.sid) FROM enroll e WHERE e.sectno = s.sectno AND e.cno = s.cno AND e.dname = s.dname) < $1)')
        or die('Query preparation failed: ' . pg_last_error());

    // Execute the prepared query with the value from the form as the actual argument 
    $result = pg_execute($dbconn, "my_query", array($_POST['studentno'])) 
        or die('Query execution failed: ' . pg_last_error());

    $nrows = pg_numrows($result);
    if($nrows != 0)
      {
    print "<p>Data for maximum number of students: " . $_POST['studentno'];
    print "<table border=2><tr>Name\n";
    for($j=0;$j<$nrows;$j++)
        {
            $row = pg_fetch_array($result);
            print "<tr>" . $row["cno"];
            print "<td>" . $row["sectno"];
            print "\n";
        }
        print "</table>\n";
    }
    else	print "<p>No Entry for " . $_POST['studentno'];

    //********************************************** PART III  **********************************************/

	pg_close($dbconn);
?>
</p>
</body>
</html>