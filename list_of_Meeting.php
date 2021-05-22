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
    <table class="table">
        <thead>
            <tr>
            <th scope="col">#</th>
            <th scope="col">place</th>
            <th scope="col">No of student</th>
            </tr>
        </thead>
        <tbody>
        <?php 
        $show_student = pg_query($db, "select * from get_meeting_overview()");
        if (!$show_student) {
            echo "An error occurred.\n";
            exit;
        }
        
        while ($row = pg_fetch_row($show_student)) {
            echo "<tr>";
                echo  "<td> $row[0] </td>";
                echo  "<td> $row[1] </td>";
                echo  "<td> $row[6] </td>";
            echo "</tr>";
        }
            ?>
        </tbody>
    </table>   
    </div>
<?php include "inc/footer.php"; ?>