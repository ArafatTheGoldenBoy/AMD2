<?php 
  include_once "inc/conn.php";
  include "inc/header.php";
?>
    <title>List Of Meeting</title>
</head>
<body>
<?php include "inc/nav.php"; ?>
<div class="container">
    <!-- card layout -->
    <form action="create_study_group.php" method="post">
    <?php 
        $results = pg_query($db, "select * from only_visible_meeting_list()");
        if(isset($_POST['select_student']))
            {	 
                $student_id = $_POST['student_id'];
                echo "<input type='text' class='form-control' name='inputStudent_id' value='$student_id' readonly>";
            }
            if(isset($_POST['login']))
            {	 
                $name = $_POST['username'];
                $pass = $_POST['password'];
                $sql = "select student_login('$name','$pass')";
                $result = pg_query($db, $sql);
                while($row = pg_fetch_row($result)){
                    $id = $row[0];
                }
                if ($id != null) {
                    $_SESSION['student_id'] = $id;
                    header("Location: select_meeting.php");
                    exit();
                }
                else echo"abc";
            }
        if (!$results) {
            echo "An error occurred.\n";
            exit;
        }
        echo '<div class="row row-cols-1 row-cols-md-3 g-4">';
        while ($row = pg_fetch_row($results)) {
            echo "<div class='col'>";
                echo '<div class="card h-100">';
                    echo "<div class='card-header'>$row[1]</div>";
                    echo '<div class="card-body">';
                        //echo "<h5 class='card-title bg-light'>  </h5>";
                        echo "<p class='card-text'>Meeting Id:  $row[0] </p>";
                        echo "<p class='card-text'>Start Time:  $row[2] </p>";
                        echo "<p class='card-text'>End Time: $row[3] </p>";
                        echo "<button class='btn btn-success' type= 'submit' name= 'select_meeting' value= '$row[0]' >" . "Select"  . "</button>";
                    echo '</div>';
                echo '</div>';
            echo '</div>';
        }
        echo '</div>';
    ?>
    </form>  
    <!-- end card layout -->
</div>
<div class="container">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Topic</th>
                <th scope="col">Student Limit</th>
                <th scope="col">Description</th>
                <th scope="col">No of Students</th>
                <th scope="col">Joint Students</th>
            </tr>
        </thead>
        <tbody>
        <?php 
            if(isset($_POST['select_meeting']))
            {	 
                $meeting_id = $_POST['select_meeting'];
                // echo $meeting_id;
                $sql = "select get_meeting_details($meeting_id)";
                $result = pg_query($db, $sql);
                while ($row = pg_fetch_row($results)) {
                    echo "<tr>";
                    echo  "<td> $row[0] </td>";
                    echo  "<td> $row[1] </td>";
                    echo  "<td> $row[2] </td>";
                    echo  "<td> $row[3] </td>";
                    echo  "<td> $row[4] </td>";
                    echo  "<td> $row[5] </td>";
                    echo "<td><button class='btn btn-danger' type= 'submit' name= 'select_meeting' value= '$row[0]' >" . "Select"  . "</button></td>";
                    echo "</tr>";
                }
            }
        ?>
        </tbody>
    </table>

</div>
<?php include "inc/footer.php"; ?>