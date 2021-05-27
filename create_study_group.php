<?php 
  include_once "inc/conn.php";
  include "inc/header.php";
?>
    <title>Add Study Group</title>
</head>
<body>
<?php include "inc/nav.php"; ?>
<div class="container">
    <div class="row">
        <div class="col-6">
        <h1>Add Study Group</h1>
        <br>
        <form action="student_process.php" method="post">
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Student ID</label>
                <div class="col-sm-3">
                <?php
                if(isset($_POST['select_meeting']))
                {	 
                    $student_id = $_POST['inputStudent_id'];
                    echo "<input type='text' class='form-control' name='inputStudentId' value='$student_id' readonly>";
                }
                ?>
                </div>
            </div>
            <br>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Meeting ID</label>
                <div class="col-sm-3">
                <?php
                if(isset($_POST['select_meeting']))
                {	 
                    $meeting_id = $_POST['select_meeting'];
                    echo "<input type='text' class='form-control' name='inputMeetingId' value='$meeting_id' readonly>";
                }
                ?>
                </div>
            </div>
            <br>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Topic</label>
                <div class="col-sm-3">
                <input type="text" class="form-control" name="inputTopic" required>
                </div>
            </div>
            <br>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Description</label>
                <div class="col-sm-3">
                <input type="text" class="form-control" name="inputDescription" required>
                </div>
            </div>
            <br>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Student Limit</label>
                <div class="col-sm-3">
                <input type="text" class="form-control" name="inputStudentLimit" required>
                </div>
            </div>
            <br>
            <div class="form-group row">
                <div class="col-sm-10">
                <button type="submit" name="add_study_group" class="btn btn-primary">Add</button>
                </div>
            </div>
        </form>
        </div>
        <div class="col-6">
        <h1>Group Activity</h1>
        <form action="student_process.php" method="post">
        <table class="table">
            <thead>
                <tr>
                <th scope="col">study group id</th>
                <th scope="col">Topic</th>
                <th scope="col">Description</th>
                <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
        <?php
            if(isset($_POST['select_meeting']))
            {	 
                $student_id = $_POST['inputStudent_id'];
                echo "<input type='text' class='form-control' name='inputStudentId' value='$student_id' readonly>";
                $results = pg_query($db, "select * from already_joined_group($student_id)");
                $incoming_student_from_db= pg_query($db, "select group_owner($student_id)");
                $owner = 0;
                while ($row = pg_fetch_row($incoming_student_from_db)) {
                    $owner = $row[0];
                }
                echo "Owner of this group are = $owner";
                if (!$results) {
                    echo "An error occurred.\n";
                    exit;
                }
                
                while ($row = pg_fetch_row($results)) {
                    echo "<tr>";
                        echo  "<td> $row[0] </td>";
                        echo  "<td> $row[1] </td>";
                        echo  "<td> $row[2] </td>";
                        echo "<td><button class='btn btn-danger' type= 'submit' name= 'Leave_group' value= '$row[0]' >" . "Leave"  . "</button></td>";
                        if( $student_id == $owner ){
                            echo "<input type='hidden' name= 'owner' value = ". $owner . ">";
                            echo "<td><button class='btn btn-secondary' formaction='edit_study_group.php' type= 'submit' name= 'group_id' value= '$row[0]' >" . "Edit"  . "</button></td>";
                        }
                        
                    echo "</tr>";
                }
            }
        ?>
            </tbody>
        </table> 
        </form>
        </div>
        
    </div>
</div>
<div class="container">
    <h3>List of Study Group</h3>
    <form action="student_process.php" method="post">
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Student ID</label>
            <div class="col-sm-3">
            <?php
            if(isset($_POST['select_meeting']))
            {	 
                $student_id = $_POST['inputStudent_id'];
                echo "<input type='text' class='form-control' name='inputStudentId' value='$student_id' readonly>";
            }
            ?>
            </div>
        </div>
    <table class="table">
        <thead>
            <tr>
            <th scope="col">study group id</th>
            <th scope="col">meeting id</th>
            <th scope="col">topic</th>
            <th scope="col">description</th>
            <th scope="col">student limit</th>
            <th scope="col">crated_on</th>
            <th scope="col">status</th>
            <th scope="col">action</th>
            </tr>
        </thead>
        <tbody>
        <?php 
            if(isset($_POST['select_meeting']))
            {	 
                $meeting_id = $_POST['select_meeting'];
                $results = pg_query($db, "select * from get_all_study_groups($meeting_id)");
                if (!$results) {
                    echo "An error occurred.\n";
                    exit;
                }
                
                while ($row = pg_fetch_row($results)) {
                    echo "<tr>";
                        echo  "<td> $row[0] </td>";
                        echo  "<td> $row[1] </td>";
                        echo  "<td> $row[2] </td>";
                        echo  "<td> $row[3] </td>";
                        echo  "<td> $row[4] </td>";
                        echo  "<td> $row[5] </td>";
                        echo  "<td> $row[6] </td>";
                        echo "<td><button class='btn btn-success' type= 'submit' name= 'Join_group' value= '$row[0]' >" . "Join"  . "</button></td>";
                    echo "</tr>";
                }
            }
        
            ?>
        </tbody>
    </table> 
    </form>  
</div>
<?php include "inc/footer.php"; ?>