<?php 
  include_once "inc/conn.php";
  include "inc/header.php";
?>
    <title>List Of Meeting</title>
</head>
<body>
<?php include "inc/nav.php"; ?>

    <div class="container">
    <h3>Published Meetings</h3>
    <form action="details_meeting.php" method="post">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Meeting ID</th>
                <th scope="col">Place</th>
                <th scope="col">Start Time</th>
                <th scope="col">End Time</th>
                <th scope="col">Details</th>
                <th scope="col">Modify</th>

            </tr>
        </thead>
        <tbody>
        <?php 
        $result = pg_query($db, "select * from get_meeting_overview();");
        if (!$result) {
            echo "An error occurred.\n";
            exit;
        }
        
        while ($row = pg_fetch_row($result)) {
            echo "<tr>";
                echo  "<td> $row[0] </td>";
                echo  "<td> $row[1] </td>";
                echo  "<td> $row[2] </td>";
                echo  "<td> $row[3] </td>";
                echo "<td><button class='btn btn-info' type= 'submit' name= 'details_meeting' value= '$row[0]' >" . "Details"  . "</button></td>";
                echo "<td><button class='btn btn-success' formaction='edit_meeting.php' type= 'submit' name= 'edit_meeting' value= '$row[0]' >" . "Modify"  . "</button></td>";
            echo "</tr>";
        }
            ?>
        </tbody>
    </table>
    </form>   
    </div>

    <div class="container">
    <h3>Hidden Meetings</h3>
    <form action="fsr_if_process.php" method="post">
    <table class="table">
        <thead>
            <tr>
            <th scope="col">Meeting ID</th>
                <th scope="col">Place</th>
                <th scope="col">Start Time</th>
                <th scope="col">End Time</th>
                <th scope="col">Delete</th>
                <th scope="col">Publish</th>
            </tr>
        </thead>
        <tbody>
        <?php 
        $result = pg_query($db, "select * from only_hidden_meeting_list();");
        if (!$result) {
            echo "An error occurred.\n";
            exit;
        }
        
        while ($row = pg_fetch_row($result)) {
            echo "<tr>";
                echo  "<td> $row[0] </td>";
                echo  "<td> $row[1] </td>";
                echo  "<td> $row[2] </td>";
                echo  "<td> $row[3] </td>";
                echo "<td><button class='btn btn-danger' type= 'submit' name= 'delete_meeting' value= '$row[0]' >" . "Delete"  . "</button></td>";
                echo "<td><button class='btn btn-success' type= 'submit' name= 'visible' value= '$row[0]' >" . "Publish"  . "</button></td>";
                echo "</tr>";
        }
            ?>
        </tbody>
    </table>
    </form>   
    </div>
<?php include "inc/footer.php"; ?>