<?php 
include 'inc/conn.php';
$sql = 'select * from get_meeting_overview()';
$result = pg_query($db, $sql);
echo $result;
$row = pg_fetch_array($result);
echo $row;
while ($row = pg_fetch_array($result)) {
        echo  "$row[0]<br>";
        echo  "$row[1]<br>";
        echo  "$row[2]<br>";
        echo  "$row[3]<br>";
}
$date = date('d-m-y h:i:s');
echo $date;
?>
<script>console.log(Date.now())
console.log(new Date().getTime())

</script>