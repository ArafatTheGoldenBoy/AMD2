<?php 
  include_once "inc/conn.php";
  include "inc/header.php";
?>
    <title>List Of Meeting</title>
</head>
<body>
<?php include "inc/nav.php"; ?>
<div class="container">
    <h3 class="shadow-sm bg-light my-4">Available Meetings</h3>
    <!-- card layout -->
    <form action="study_group.php" method="post">
    <?php 
    if(isset($_POST['login'])){
        $results = pg_query($db, "select * from only_visible_meeting_list()");
        // if(isset($_POST['select_student']))
        //     {	 
        //         $student_id = $_POST['student_id'];
        //         echo "<input type='text' class='form-control' name='inputStudent_id' value='$student_id' readonly>";
        //     }
        $name = $_POST['username'];
        $pass = $_POST['password'];
        $sql = "select student_login('$name','$pass')";
        $result = pg_query($db, $sql);
        while($row = pg_fetch_row($result)){
                $student_id = $row[0];
            }
            echo "<input type='hidden' class='form-control' name='inputStudent_id' value='$student_id' readonly>";
            if ($student_id != null) {
                if (!$results) {
                     echo "An error occurred.\n";
                    exit;
                }
                echo '<div class="row row-cols-1 row-cols-md-3 g-4">';
                while ($row = pg_fetch_row($results)) {
                    echo "<div class='col'>";
                        echo '<div class="card h-100 shadow">';
                            echo "<div class='card-header'>$row[1]</div>";
                            echo '<div class="card-body">';
                                //echo "<h5 class='card-title bg-light'>  </h5>";
                                echo "<p class='card-text'>Meeting Id:  $row[0] </p>";
                                echo "<p class='card-text'>Start Time:  $row[2] </p>";
                                echo "<p class='card-text'>End Time: $row[3] </p>";
                                echo "<button class='btn btn-success shadow' type= 'submit' name= 'select_meeting' value= '$row[0]' >" . "Select"  . "</button>";
                            echo '</div>';
                        echo '</div>';
                    echo '</div>';
                    }
                echo '</div>';
            }
            else echo"abc";
    }
    ?>
    </form>  
    <!-- end card layout -->
</div>
<?php include "inc/footer.php"; ?>