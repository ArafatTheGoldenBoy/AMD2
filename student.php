
<?php 
  include "inc/conn.php";
  include "inc/header.php";
?>
    <title>Student</title>
</head>
<body>

<?php include "inc/nav.php"; ?>
<form action="select_meeting.php" method="post">
<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">UserName</th>
      <th scope="col">Password</th>
      <th scope="col">Created time</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
  <?php 
  $show_student = pg_query($db, "select * from students");
if (!$show_student) {
    echo "An error occurred.\n";
    exit;
  }
  
  while ($row = pg_fetch_row($show_student)) {
    echo "<tr>";
        echo  "<td> $row[0] </td>";
        echo  "<td> $row[1] </td>";
        echo  "<td> $row[2] </td>";
        echo  "<td> $row[3] </td>";
        echo  "<td> $row[4] </td>";
        echo "<td><button class='btn btn-danger' type= 'submit' name= 'login' value= '$row[0]' >" . "Select"  . "</button></td>";
        echo "<td><button class='btn btn-info' formaction='edit_student.php' type= 'submit' name= 'edit_student' value= '$row[0]' >" . "Edit"  . "</button></td>";
    echo "</tr>";
  }
    ?>
  </tbody>
</table>
</form>
<?php include "inc/footer.php"; ?>
