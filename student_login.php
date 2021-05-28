
<?php 
  include_once "inc/conn.php";
  include "inc/header.php";
?>
    <title>Student Login</title>
</head>
<body>
<?php include "inc/nav.php"; date_default_timezone_set("Europe/Berlin");?>
<div class="container">
    <h1>Student Login</h1>
    <br>
    <form action="fsr_if_process.php" method="post">
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Username</label>
            <div class="col-sm-3">
            <input type="text" class="form-control" name="username" placeholder="username">
            </div>
        </div>
        </br>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Password</label>
            <div class="col-sm-3">
            <input type="text" class="form-control" name="password" placeholder="password">
            </div>
        </div>
        </br>
        <div class="form-group row">
            <div class="col-sm-10">
            <button type="submit" name="login" class="btn btn-primary">Login</button>
            </div>
        </div>
    </form>
</div>

<?php include "inc/footer.php"; ?>