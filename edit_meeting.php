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
            <h3 class="shadow-sm bg-light my-4">Edit Selected Meeting</h3>
            <div class="col-4 shadow p-4">
                <form action="fsr_if_process.php" method="post">
                <?php  
                    if(isset($_POST['edit_meeting']))
                    {	
                        $meeting_id = $_POST['edit_meeting'];
                        $sql = pg_query($db, "select * from edit_meeting($meeting_id);");
                        while($row = pg_fetch_row($sql)) {
                                //echo "<p>Meeting ID <input type='text' class='form-control' name='meeting_id' value = ". $row[0] . " readonly></p>";
                                echo '<div class="form-group row">';
                                    echo '<label class="col-sm-3 col-form-label">Meeting ID</label>';
                                    echo '<div class="col">';
                                    echo "<p><input type='text' class='form-control' name='meeting_id' value = ". $row[0] . " readonly></p>";
                                    echo '</div>';
                                echo '</div>';
                                echo "<div class='form-floating mb-3'>";
                                    echo "<input type='text' class='form-control' name='inputPlace' placeholder='Location: ' value=" . $row[1] . ">";
                                    echo "<label>Location: </label>";
                                echo '</div>';
                                // echo "<p>Location: <input type='text' name='inputPlace' value=" . $row[1] . "></p>";
                                $stime = date('Y-m-d\TH:i', strtotime($row[2]));
                                $etime = date('Y-m-d\TH:i', strtotime($row[3]));
                                echo "<p>Start Time: <input type='datetime-local' class='form-control' name='inputStart' value=" . $stime ."></p>";
                                echo "<p>End Time: <input type='datetime-local' class='form-control' name='inputEnd' value=" . $etime . "></p>";
                                echo "Status: <input type='radio' name='in_status' value='t' checked = 'true'>Show ";
                                echo "<input type='radio' name='in_status' value='f'>Hide</p>";
                        }
                    }
                ?>
                <div class="d-grid gap-2">
                    <input type="submit" class="btn btn-success shadow" name="update_change_meeting" value="Update">
                </div>
                </form>
            </div>
        </div>
    </div>
<?php include "inc/footer.php"; ?>