
<?php 
  include_once "inc/conn.php";
  include "inc/header.php";
?>
    <title>Create_Meeting</title>
</head>
<body>
<?php include "inc/nav.php"; date_default_timezone_set("Europe/Berlin");?>
<div class="container">
    <h3 class="shadow-sm bg-light my-4">Create Meeting</h3>
    <br>
    <form action="fsr_if_process.php" method="post">
        <div class="row">
            <div class="col-4 shadow p-4">
                <div class="form-group row">
                    <label class="col-4 col-form-label">Location</label>
                    <div class="col">
                    <input type="text" class="form-control" name="inputPlace" placeholder="Meeting Place">
                    </div>
                </div>
                <br>
                <div class="form-group row">
                    <label class="col-4 col-form-label">Starting Time</label>
                    <div class="col">
                    <input type="datetime-local" class="form-control" name="inputStartTime">
                    </div>
                </div>
                <br>
                <div class="form-group row">
                    <label class="col-4 col-form-label">Ending Time</label>
                    <div class="col">
                    <input type="datetime-local" class="form-control" name="inputEndTime">
                    </div>
                </div>
                <br>
                <div class="form-group row">
                    <div class="d-grid gap-2">
                    <button type="submit" name="add_meeting" class="btn btn-success">Create</button>
                    </div>
                </div>
            </div>
            <div class="col">
                
            </div>
            
        </div>
    </form>
</div>

<?php include "inc/footer.php"; ?>