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
            <h3>Edit Selected Student </h3>
            <form action="student_process.php" method="post">
            <?php  
                if(isset($_POST['edit_student']))
                {	
                    $student_id = $_POST['edit_student'];
                    //echo "<input type='text' name= 'owner' value = ". $student_id . ">";
                    $sql = pg_query($db, "select * from edit_student($student_id);");
                    while($row = pg_fetch_row($sql)) {
                            echo "<input type='hidden' name= 'student_id' value = ". $row[0] . ">";
                            echo "<p>Student Name: <input type='text' name='student_name' value=" . $row[1] . "></p>";
                            // echo "<p>Region Province: <input type='text' name='in_region' value=" . $row[2] . "></p><br>";
                            // echo "<p>Price: <input type='text' name='in_price' value=" . $row[3]. "></p><br>";
                            // echo "<p>Quantity: <input type='text' name='in_stock' value=" . $row[4] . "></p><br>";
                            // echo "Status: <input type='radio' name='in_status' value='t'>Show ";
                            // echo "<input type='radio' name='in_status' value='f'>Hide</p>";
                            // echo "<input type='hidden' name='su_id' value=" . $row[6] . ">";
                    }
                }
            ?>
            <input type="submit" name="update_change_name" value="Update">
            </form>
        </div>
    </div>
<?php include "inc/footer.php"; ?>