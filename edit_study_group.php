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
        <h3 class="shadow-sm bg-light my-4">Edit Study Group </h3>
            <div class="col-4 shadow p-4">
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

                                echo "<div class='form-floating mb-3'>";
                                    echo "<input type='text' class='form-control' id='floatingInput' name='place' placeholder='Group Topic' value=" . $row[2] . "><br>";
                                    echo "<label for='floatingInput'>Group Topic</label>";
                                echo '</div>';
                                echo "<div class='form-floating mb-3'>";
                                    echo "<textarea class='form-control' id='floatingInput' name='details' style='height: 100px' placeholder='Description' value=" . $row[3] . ">$row[3]</textarea><br>";
                                    echo "<label>Description</label>";
                                echo '</div>';
                                echo "<div class='form-floating mb-3'>";
                                    echo "<input type='text' class='form-control' id='floatingInput' name='limit' placeholder='Set Student Limit' value=" . $row[4] . "><br>";
                                    echo "<label for='floatingInput'>Set Student Limit</label>";
                                echo '</div>';
                                
                                // echo "<p>Description: <input type='textarea' name='details' value=" . $row[3] . "></p><br>";
                                // echo "<p>Set Student Limit: <input type='text' name='limit' value=" . $row[4] . "></p><br>";
                        }
                    }
                ?>
                <div class="d-grid gap-2">
                    <input type="submit" class="btn btn-success shadow" name="update_study_group" value="Update">
                </div>
                </form>
            </div>
        </div>
    </div>
<?php include "inc/footer.php"; ?>