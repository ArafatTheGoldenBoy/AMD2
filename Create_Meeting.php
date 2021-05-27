
<?php 
  include_once "inc/conn.php";
  include "inc/header.php";
?>
    <title>Create_Meeting</title>
</head>
<body>
<?php include "inc/nav.php"; date_default_timezone_set("Europe/Berlin");?>
<div class="container">
    <h1>Create Meeting</h1>
    <br>
    <form action="fsr_if_process.php" method="post">
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Location</label>
            <div class="col-sm-3">
            <input type="text" class="form-control" name="inputPlace" placeholder="Meeting Place">
            </div>
        </div>
        <br>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Start Time With Date</label>
            <div class="col-sm-3">
            <input type="datetime-local" class="form-control" name="inputStartTime">
            </div>
        </div>
        <br>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">End Time With Date</label>
            <div class="col-sm-3">
            <input type="datetime-local" class="form-control" name="inputEndTime">
            </div>
        </div>
        <br>
        <div class="form-group row">
            <div class="col-sm-10">
            <button type="submit" name="add_meeting" class="btn btn-primary">Add</button>
            </div>
        </div>
    </form>
</div>

<?php include "inc/footer.php"; ?>