<html> 
<head>
<title>Result of Database Query</title>
</head>
<body> 
<h1>Result of Database Query</h1>
<?php
  $dbconn = pg_connect("host=tr01")
    or die('Could not connect: ' . pg_last_error());

    //********************************************** PART II  **********************************************/

    // Prepare a query for execution with $1 as a placeholder
    $result = pg_prepare($dbconn, "my_query",
        'SELECT DISTINCT m.dname FROM major m WHERE m.sid IN (SELECT s.sid FROM student s WHERE s.age < $1)')
        or die('Query preparation failed: ' . pg_last_error());

    // Execute the prepared query with the value from the form as the actual argument 
    $result = pg_execute($dbconn, "my_query", array($_POST['maximumage'])) 
        or die('Query execution failed: ' . pg_last_error());

    $nrows = pg_numrows($result);
    if($nrows != 0)
      {
    print "<p>Data for maximum age: " . $_POST['maximumage'];
    print "<table border=2><tr>Name\n";
    for($j=0;$j<$nrows;$j++)
        {
            $row = pg_fetch_array($result);
            print "<tr><td>" . $row["sname"];
            print "\n";
        }
        print "</table>\n";
    }
    else	print "<p>No Entry for " . $_POST['maximumage'];

    //********************************************** PART II  **********************************************/

	pg_close($dbconn);
?>
</p>
</body>
</html>