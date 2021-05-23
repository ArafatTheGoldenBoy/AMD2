<?php 
  include_once "inc/conn.php";
  include "inc/header.php";
?>
    <title>List Of Meeting</title>
</head>
<body>
<?php include "inc/nav.php"; ?>
<div class="container">
    <h3>
    <?php 
        // if(isset($_POST['notification'])){
        //     echo "$_POST['inputNotify']"; 
        // }    
    ?>
    </h3>
    <form action="create_study_group.php" method="post">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">place</th>
                <th scope="col">start_time</th>
                <th scope="col">End_time</th>
                <th> Stduent Id </th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
        <?php 
        $results = pg_query($db, "select * from only_visible_meeting_list()");
        if(isset($_POST['select_student']))
            {	 
                $student_id = $_POST['select_student'];
                echo "<input type='text' class='form-control' name='inputStudent_id' value='$student_id' readonly>";
            }
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
            echo "<td><button class='btn btn-danger' type= 'submit' name= 'select_meeting' value= '$row[0]' >" . "Select"  . "</button></td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
    </form>   
</div>
<div class="container">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Topic</th>
                <th scope="col">Student Limit</th>
                <th scope="col">Description</th>
                <th scope="col">No of Students</th>
                <th scope="col">Joint Students</th>
            </tr>
        </thead>
        <tbody>
        <?php 
            if(isset($_POST['select_meeting']))
            {	 
                $meeting_id = $_POST['select_meeting'];
                // echo $meeting_id;
                $sql = "select get_meeting_details($meeting_id)";
                $result = pg_query($db, $sql);
                while ($row = pg_fetch_row($results)) {
                    echo "<tr>";
                    echo  "<td> $row[0] </td>";
                    echo  "<td> $row[1] </td>";
                    echo  "<td> $row[2] </td>";
                    echo  "<td> $row[3] </td>";
                    echo  "<td> $row[4] </td>";
                    echo  "<td> $row[5] </td>";
                    echo "<td><button class='btn btn-danger' type= 'submit' name= 'select_meeting' value= '$row[0]' >" . "Select"  . "</button></td>";
                    echo "</tr>";
                }
            }
        ?>
        </tbody>
    </table>

</div>
<?php include "inc/footer.php"; ?>