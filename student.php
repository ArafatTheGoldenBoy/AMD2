
<?php 
  include "inc/conn.php";
  include "inc/header.php";
?>
    <title>Student</title>
</head>
<body>
<?php include "inc/nav.php"; ?>
<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">place</th>
      <th scope="col">No of student</th>
    </tr>
  </thead>
  <tbody>
  <?php 
  $show_student = pg_query($db, "select * from get_meeting_overview()");
if (!$show_student) {
    echo "An error occurred.\n";
    exit;
  }
  
  while ($row = pg_fetch_row($show_student)) {
    echo "<tr>";
        echo  "<td> $row[0] </td>";
        echo  "<td> $row[1] </td>";
        echo  "<td> $row[6] </td>";
    echo "</tr>";
  }
    ?>
  </tbody>
</table>

<?php include "inc/footer.php"; ?>
