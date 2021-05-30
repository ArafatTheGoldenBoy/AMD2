<?php 
  include "inc/conn.php";
  include "inc/header.php";
?>
    <title>Edit Student</title>
</head>
<body>
<?php include "inc/nav.php"; ?>
    <div class="container">
        <div class="row">
            <h3 class="shadow-sm bg-light my-4">Edit Selected Student </h3>
            <div class="col-4 shadow p-4">
                <form action="student_process.php" method="post">
                <?php  
                    if(isset($_POST['edit_student']))
                    {	
                        $student_id = $_POST['edit_student'];
                        //echo "<input type='text' name= 'owner' value = ". $student_id . ">";
                        $sql = pg_query($db, "select * from edit_student($student_id);");
                        while($row = pg_fetch_row($sql)) {
                                echo "<input type='hidden' name= 'student_id' value = ". $row[0] . ">";
                                // echo "<p>Student Name: <input type='text' name='student_name' value=" . $row[1] . "></p>";
                                echo "<div class='form-floating mb-3'>";
                                echo "<input type='text' class='form-control' name='student_name' placeholder='Student Name:' value=" . $row[1] . ">";
                                    echo "<label>Student Name: </label>";
                                echo '</div>';
                        }
                    }
                ?>
                <div class="d-grid gap-2">
                    <input type="submit" class="btn btn-success shadow" name="update_change_name" value="Update">
                </div>
                </form>
            </div>
        </div>
    </div>
<?php include "inc/footer.php"; ?>