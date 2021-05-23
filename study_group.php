<?php 
  include_once "inc/conn.php";
  include "inc/header.php";
?>
    <title>Study_Group</title>
</head>
<body>
<?php include "inc/nav.php"; ?>
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
        $results = pg_query($db, "select * from get_all_study_groups()");
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
                echo "<td><button class='btn btn-danger' type= 'submit' name= 'Join_group' value= '$row[0]' >" . "Join"  . "</button></td>";
            echo "</tr>";
        }
            ?>
        </tbody>
    </table> 
    </form>  
</div>
<?php include "inc/footer.php"; ?>