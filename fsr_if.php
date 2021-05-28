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
    <!-- card layout -->
    <form action="details_meeting.php" method="post">
    <?php 
        $results = pg_query($db, "select * from get_meeting_overview();");
        if (!$results) {
            echo "An error occurred.\n";
            exit;
        }
        echo '<div class="row row-cols-1 row-cols-md-3 g-4">';
        while ($row = pg_fetch_row($results)) {
            echo "<div class='col'>";
                echo '<div class="card h-100">';
                    echo "<div class='card-header'>$row[1]</div>";
                    echo '<div class="card-body">';
                        //echo "<h5 class='card-title bg-light'>  </h5>";
                        echo "<p class='card-text'>Meeting Id:  $row[0] </p>";
                        echo "<p class='card-text'>Start Time:  $row[2] </p>";
                        echo "<p class='card-text'>End Time: $row[3] </p>";
                        echo "<div class='row'>";
                            echo '<div class="col-3">';
                                echo "<button class='btn btn-info' type= 'submit' name= 'details_meeting' value= '$row[0]' >" . "Details"  . "</button>";
                            echo '</div>';
                            echo '<div class="col">';
                                echo "<button class='btn btn-success' formaction='edit_meeting.php' type= 'submit' name= 'edit_meeting' value= '$row[0]' >" . "Modify"  . "</button>";
                            echo '</div>';
                        echo "</div>";
                    echo '</div>';
                echo '</div>';
            echo '</div>';
        }
        echo '</div>';
    ?>
    </form>  
    <!-- end card layout -->
    </div>
    <div class="container">
    <h3>Hidden Meetings</h3>
    <!-- card layout -->
    <form action="fsr_if_process.php" method="post">
    <?php 
        $results = pg_query($db, "select * from only_hidden_meeting_list();");
        if (!$results) {
            echo "An error occurred.\n";
            exit;
        }
        echo '<div class="row row-cols-1 row-cols-md-3 g-4">';
        while ($row = pg_fetch_row($results)) {
            echo "<div class='col'>";
                echo '<div class="card h-100">';
                    echo "<div class='card-header'>$row[1]</div>";
                    echo '<div class="card-body">';
                        //echo "<h5 class='card-title bg-light'>  </h5>";
                        echo "<p class='card-text'>Meeting Id:  $row[0] </p>";
                        echo "<p class='card-text'>Start Time:  $row[2] </p>";
                        echo "<p class='card-text'>End Time: $row[3] </p>";
                        echo "<div class='row'>";
                            echo '<div class="col-3">';
                                echo "<button class='btn btn-danger' type= 'submit' name= 'delete_meeting' value= '$row[0]' >" . "Delete"  . "</button>";
                            echo '</div>';
                            echo '<div class="col">';
                                echo "<button class='btn btn-success' type= 'submit' name= 'visible' value= '$row[0]' >" . "Publish"  . "</button>";
                            echo '</div>';
                        echo "</div>";
                    echo '</div>';
                echo '</div>';
            echo '</div>';
        }
        echo '</div>';
    ?>
    </form>  
    <!-- end card layout -->
    </div>
<?php include "inc/footer.php"; ?>