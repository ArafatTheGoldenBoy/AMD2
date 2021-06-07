
<?php 
  include "inc/conn.php";
  include "inc/header.php";
?>
    <title>Index</title>
</head>
<body>
<?php include "inc/nav.php"; date_default_timezone_set("Europe/Berlin");?>
<div class="container">
    <h3 class="shadow-sm my-4 text-center display-3">Work-Together Meeting Management System</h3>
    <div class="row gx-5 p-5 mx-5">
        <div class="col-6">
            
            <form action="fsr_if_process.php" method="post">
            <h3 class="shadow-sm bg-light my-4 text-center">FSR:IF Login</h3>
                        <div class="shadow p-4">
                            
                            <div class="form-group row">
                                <div class='form-floating mb-3'>
                                <input type='text' class='form-control' name='fsr_username' placeholder='Username'>
                                    <label>Username</label>
                                </div>
                            </div>
                            </br>
                            <div class="form-group row">
                                <div class='form-floating mb-3'>
                                <input type="password" class='form-control' name="password" placeholder='password'>
                                    <label>Password</label>
                                </div>
                            </div>
                            </br>
                            <div class="form-group row">
                                <div class="d-grid gap-2">
                                <button type="submit" name="login_fsr" class="btn btn-primary">Login</button>
                                </div>
                            </div>
                        </div>
            </form>
        </div>                
        <div class="col-6">
            
            <form action="select_meeting.php" method="post">
            <h3 class="shadow-sm bg-light my-4 text-center">Student Login</h3>
                        <div class="shadow p-4">
                            
                            <div class="form-group row">
                                <div class='form-floating mb-3'>
                                <input type='text' class='form-control' name='username' placeholder='Username'>
                                    <label>Username</label>
                                </div>
                            </div>
                            </br>
                            <div class="form-group row">
                                <div class='form-floating mb-3'>
                                <input type="password" class='form-control' name="password" placeholder='password'>
                                    <label>Password</label>
                                </div>
                            </div>
                            </br>
                            <div class="form-group row">
                                <div class="d-grid gap-2">
                                <button type="submit" name="login" class="btn btn-primary">Login</button>
                                </div>
                            </div>
                        </div>
            </form>
        </div>
    </div>
</div>

<?php include "inc/footer.php"; ?>