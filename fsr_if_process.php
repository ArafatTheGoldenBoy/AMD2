<?php
include_once 'inc/conn.php';
if(isset($_POST['add_meeting']))
{	 
    $place = $_POST['inputPlace'];
    $start_time = $_POST['inputStartTime'];
    $end_time = $_POST['inputEndTime'];
    $sql = "select add_meeting('$place', '$start_time', '$end_time', '0')";
    $result = pg_query($db, $sql);
    if ($result) {
        /* echo '<form id="notify" action="list_of_Meeting.php" method="post">';
        
         $notify = pg_fetch_result($result, 1, 0);
         echo $notify;
         echo    '<input type="text" value=<?php $notify ?>" name="inputNotify">';
         echo    '<input type="submit" value="notification">';
         echo '</form>';
         */
        while ($row = pg_fetch_row($result)) {
            echo "$row[0]\n";
        }
        header("Location: list_of_Meeting.php");
        exit();
    }
}
if(isset($_POST['delete_meeting']))
{	 
    $meeting_id = $_POST['delete_meeting'];
    $sql = "select remove_meeting('$meeting_id')";
    $result = pg_query($db, $sql);
    if ($result) {
        header("Location: Remove_Meeting.php");
        exit();
    }
}
?>

<!-- <script type="text/javascript">
    document.getElementById('notify').submit(); // SUBMIT FORM
</script> -->