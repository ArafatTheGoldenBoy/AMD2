<?php 
  include "inc/conn.php";
  include "inc/header.php";
?>
    <title>Edit Study Group</title>
</head>
<body>
<?php include "inc/nav.php"; ?>
    <div class="container">
        <div class="row">
            <h3>Edit Study Group </h3>
            <form action="student_process.php" method="post">
            <?php  
                if(isset($_POST['group_id']))
                {	 
                    $group_id = $_POST['group_id'];
                    $student_id = $_POST['owner'];;
                    echo "<input type='hidden' name= 'owner' value = ". $student_id . ">";
                    $sql = pg_query($db, "select * from edit_group($group_id);");
                    while($row = pg_fetch_row($sql)) {
                            echo "<input type='hidden' name= 'group_id' value = ". $row[0] . ">";
                            echo "<p>Location: <input type='text' name='place' value=" . $row[2] . "></p><br>";
                            echo "<p>Description: <input type='textarea' name='details' value=" . $row[3] . "></p><br>";
                            echo "<p>Set Student Limit: <input type='text' name='limit' value=" . $row[4] . "></p><br>";
                            // echo "<p>Region Province: <input type='text' name='in_region' value=" . $row[2] . "></p><br>";
                            // echo "<p>Price: <input type='text' name='in_price' value=" . $row[3]. "></p><br>";
                            // echo "<p>Quantity: <input type='text' name='in_stock' value=" . $row[4] . "></p><br>";
                            // echo "Status: <input type='radio' name='in_status' value='t'>Show ";
                            // echo "<input type='radio' name='in_status' value='f'>Hide</p>";
                            // echo "<input type='hidden' name='su_id' value=" . $row[6] . ">";
                    }
                }
            ?>
            <input type="submit" name="update_study_group" value="Update">
            </form>
        </div>
    </div>
<?php include "inc/footer.php"; ?>