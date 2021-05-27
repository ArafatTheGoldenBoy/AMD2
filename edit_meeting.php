<?php 
  include "inc/conn.php";
  include "inc/header.php";
?>
    <title>Edit Meeting</title>
</head>
<body>
<?php include "inc/nav.php"; ?>
    <div class="container">
        <div class="row">
            <h3>Edit Selected Meeting </h3>
            <form action="fsr_if_process.php" method="post">
            <?php  
                if(isset($_POST['edit_meeting']))
                {	
                    $meeting_id = $_POST['edit_meeting'];
                    $sql = pg_query($db, "select * from edit_meeting($meeting_id);");
                    while($row = pg_fetch_row($sql)) {
                            echo "<input type='text' name='meeting_id' value = ". $row[0] . " readonly>";
                            echo "<p>Location: <input type='text' name='inputPlace' value=" . $row[1] . "></p>";
                            $stime = date('Y-m-d\TH:i', strtotime($row[2]));
                            $etime = date('Y-m-d\TH:i', strtotime($row[3]));
                            echo "<p>Start Time: <input type='datetime-local' name='inputStart' value=" . $stime ."></p>";
                            echo "<p>End Time: <input type='datetime-local' name='inputEnd' value=" . $etime . "></p>";
                            echo "Status: <input type='radio' name='in_status' value='t' checked = 'true'>Show ";
                            echo "<input type='radio' name='in_status' value='f'>Hide</p>";
                            // echo "<p>Region Province: <input type='text' name='in_region' value=" . $row[2] . "></p><br>";
                            // echo "<p>Price: <input type='text' name='in_price' value=" . $row[3]. "></p><br>";
                            // echo "<p>Quantity: <input type='text' name='in_stock' value=" . $row[4] . "></p><br>";
                            // echo "Status: <input type='radio' name='in_status' value='t'>Show ";
                            // echo "<input type='radio' name='in_status' value='f'>Hide</p>";
                            // echo "<input type='hidden' name='su_id' value=" . $row[6] . ">";
                    }
                }
            ?>
            <input type="submit" name="update_change_meeting" value="Update">
            </form>
        </div>
    </div>
<?php include "inc/footer.php"; ?>