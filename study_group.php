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
                <div class="row my-4">
                    <div class="col-3">
                        <button type="button" class="btn btn-success shadow" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                            <path d="M8 0a1 1 0 0 1 1 1v6h6a1 1 0 1 1 0 2H9v6a1 1 0 1 1-2 0V9H1a1 1 0 0 1 0-2h6V1a1 1 0 0 1 1-1z"></path>
                        </svg>
                        Create New Study Group
                        </button>
                    </div>
                    <div class="col-3">
                    <form action="edit_student.php" method="post">
                    <?php 
                        if(isset($_POST['select_meeting']))
                        {	 
                            $student_id = $_POST['inputStudent_id'];
                            echo '<button class="btn btn-success shadow" name="edit_student" value="'.$student_id.'"><i class="bi bi-pen"> Edit Student Name</i></button>';
                        }
                        ?>
                    </form>
                    </div>
                </div>
            </p>
            
            <div class="collapse" id="collapseExample">
                <div class="row">
                <h3 class="shadow-sm bg-light my-4">Create Study Group</h3>
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
                                        $_SESSION["meeting_id"] = $meeting_id ;
                                        $meet_id = $_SESSION["meeting_id"];
                                        echo "<input type='text' class='form-control' name='inputMeetingId' value='$meet_id' readonly>";
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
        <form action="student_process.php" method="post">
        <?php
            if(isset($_POST['select_meeting']))
            {	 
                $student_id = $_POST['inputStudent_id'];
                $_SESSION["student_id"] = $student_id ;
                $sid = $_SESSION["student_id"];
                echo "<input type='hidden' class='form-control' name='inputStudentId' value='$sid' readonly>";
                $student = pg_query($db, "select * from student_details_all($sid)");
                while($row = pg_fetch_row($student)){
                        $student_name = $row[1];
                        $study_group_id = $row[5];
                }
                $results = pg_query($db, "select * from already_joined_group($sid)");
                $incoming_student_from_db= pg_query($db, "select group_owner($sid)");
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
                            echo  "<p class='card-text'>Student ID: $sid </p>";
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
                                echo 'You are the owner of this group';
                            echo '</div>';
                        echo '</div>';
                    }
                    else{
                        
                        echo '<div class="alert alert-warning d-flex align-items-center" role="alert">';
                        echo '<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill"/></svg>';
                            echo '<div>';
                            echo 'You are not the owner of this group ';
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
    <h3 class="shadow-sm bg-light my-4">List of Study Group</h3>
    <form action="student_process.php" method="post">
        <div class="form-group row">
            <!-- <label class="col-sm-2 col-form-label">Student ID</label> -->
            <div class="col-sm-3">
            <?php
            if(isset($_POST['select_meeting']))
            {	 
                $student_id = $_POST['inputStudent_id'];
                $_SESSION["student_id"] = $student_id ;
                $sid = $_SESSION["student_id"];
                echo "<input type='hidden' class='form-control' name='inputStudentId' value='$sid' readonly>";
            }
            ?>
            </div>
        </div>
        <?php 
        $results = pg_query($db, "select * from get_all_study_groups($meet_id)");
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
                        echo "<p class='card-text'>Study group id:  $row[0] </p>";
                        echo "<p class='card-text'>Description:  $row[2] </p>";
                        echo "<p class='card-text'>Student limit: $row[3] </p>";
                        echo "<p class='card-text'>Meeting Place:  $row[4] </p>";
                        echo "<p class='card-text'>Start Time:  $row[5] </p>";
                        echo "<p class='card-text'>End Time: $row[6] </p>";
                        echo "<button class='btn btn-success' type= 'submit' name= 'Join_group' value= '$row[0]' >" . "Join"  . "</button>";
                    echo '</div>';
                echo '</div>';
            echo '</div>';
        }
        echo '</div>';
    ?>
    
    </form>  
</div>
<script type="text/javascript">
        function myFunction() {
        window.location = "create_study_group.php";
        }
(function()
{
  if( window.localStorage )
  {
    if( !localStorage.getItem('firstLoad') )
    {
      localStorage['firstLoad'] = true;
      window.location.reload();
    }  
    else
      localStorage.removeItem('firstLoad');
  }
})();
</script>
    <!-- <script>  setTimeout(function(){ location.reload(); }, 2000); </script> -->
<?php include "inc/footer.php"; ?>