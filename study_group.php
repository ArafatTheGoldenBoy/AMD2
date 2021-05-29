<?php 
  include_once "inc/conn.php";
  include "inc/header.php";
?>
    <title>Study_Group</title>
</head>
<body>
<?php include "inc/nav.php"; ?>
<div class="container">
        
        <div>
            <p>
            <div class="my-4">
            <button type="button" class="btn btn-success shadow" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                <path d="M8 0a1 1 0 0 1 1 1v6h6a1 1 0 1 1 0 2H9v6a1 1 0 1 1-2 0V9H1a1 1 0 0 1 0-2h6V1a1 1 0 0 1 1-1z"></path>
            </svg>
            Create New Study Group
            </button>
            </div>
            </p>
            <div class="collapse" id="collapseExample">
                <div class="row">
                    <div class="col-4 shadow p-4 bg-light">
                            <form action="student_process.php" method="post">
                                <div class="form-group row">
                                    <label class="col-4 col-form-label">Student ID</label>
                                    <div class="col">
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
                                    <label class="col-4 col-form-label">Meeting ID</label>
                                    <div class="col">
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
                                    <label class="col-4 col-form-label">Group Topic</label>
                                    <div class="col">
                                    <input type="text" class="form-control" name="inputTopic" required>
                                    </div>
                                </div>
                                <br>
                                <div class="form-group row">
                                    <label class="col-4 col-form-label">Description</label>
                                    <div class="col">
                                    <textarea class="form-control" name="inputDescription" required></textarea>
                                    </div>
                                </div>
                                <br>
                                <div class="form-group row">
                                    <label class="col-4 col-form-label">Member Limit</label>
                                    <div class="col">
                                    <input type="text" class="form-control" name="inputStudentLimit" required>
                                    </div>
                                </div>
                                <br>
                                <div class="form-group row">
                                    <div class="d-grid gap-2">
                                    <button type="submit" name="add_study_group" class="btn btn-success">Add</button>
                                    </div>
                                </div>
                            </form>
                    </div>
                    <div class="col">
                        
                    </div>
                </div>
            </div>
            
        </div>
    <div class="row">
        <h3 class="shadow-sm bg-light my-4">Enrolled Study Group Information</h3>
        <div class="col-4">
        
        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
        </symbol>
        <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
        </symbol>
        <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
        </symbol>
        </svg>
        <form action="student_process.php" method="post">
        <?php
            if(isset($_POST['select_meeting']))
            {	 
                $student_id = $_POST['inputStudent_id'];
                echo "<input type='hidden' class='form-control' name='inputStudentId' value='$student_id' readonly>";
                $student = pg_query($db, "select * from student_details_all($student_id)");
                while($row = pg_fetch_row($student)){
                        $student_name = $row[1];
                        $study_group_id = $row[5];
                }
                $results = pg_query($db, "select * from already_joined_group($student_id)");
                $incoming_student_from_db= pg_query($db, "select group_owner($student_id)");
                $owner = 0;
                while ($row = pg_fetch_row($incoming_student_from_db)) {
                    $owner = $row[0];
                }
                if (!$results) {
                    echo "An error occurred.\n";
                    exit;
                }
                
                while ($row = pg_fetch_row($results)) {
                    echo "<div class='card bg-light shadow'>";
                        echo "<div class='card-body'>";
                            echo  "<p class='card-text'>Student ID: $student_id </p>";
                            echo  "<p class='card-text'>Student Name: $student_name </p>";
                            echo  "<p class='card-text'>Study Group Owner ID: $owner </p>";
                            // echo  "<p class='card-text'>Study Group id: $row[0] </p>";
                            echo  "<p class='card-text'>Meeting Location: $row[3] </p>";
                            echo  "<p class='card-text'>Study Group ID: $study_group_id </p>";
                            echo  "<p class='card-text'>Topic: $row[1] </p>";
                            echo  "<p class='card-text'>Description: $row[2] </p>";
                            
                            echo "<div class='row'>";
                                echo '<div class="col-3">';
                                    echo "<button class='btn btn-danger' type= 'submit' name= 'Leave_group' value= '$row[0]' >" . "Leave"  . "</button>";
                                echo  "</div>"; 
                                echo '<div class="col">';   
                                    if( $student_id == $owner ){
                                        echo "<input type='hidden' name= 'owner' value = ". $owner . ">";
                                        echo "<button class='btn btn-secondary' formaction='edit_study_group.php' type= 'submit' name= 'group_id' value= '$row[0]' >" . "Edit"  . "</button>";
                                    }
                                echo  "</div>";
                            echo  "</div>";
                        echo  "</div>";
                    echo  "</div>";
                    if( $student_id == $owner ){
                
                        echo '<div class="alert alert-success d-flex align-items-center" role="alert">';
                        echo '<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>';
                            echo '<div>';
                                echo 'You are the owner';
                            echo '</div>';
                        echo '</div>';
                    }
                    else{
                        
                        echo '<div class="alert alert-warning d-flex align-items-center" role="alert">';
                        echo '<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill"/></svg>';
                            echo '<div>';
                            echo 'You are not the group owner';
                            echo '</div>';
                        echo '</div>';
                    }
                }
            }
            
        ?>
        </form>
        </div>
        <div class="col">

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
<script type="text/javascript">
        function myFunction() {
        window.location = "create_study_group.php";
        }
    </script>
<?php include "inc/footer.php"; ?>