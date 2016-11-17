<?php
session_start();
// print_r($_SESSION);
$message = "";
// ตรวจสอบว่ามีการสร้างตัวแปร $_SESSION["not_found"] และมีค่าเท่ากับ "YES" หรือไม่ ?
if (isset($_SESSION["not_found"]) && $_SESSION["not_found"] == "YES") {
    $message = "<h5 style='color:red;'>Invalid Username Or Password</h5>";
}

// ลบ session ทั้งหมดในเว็บ
// session_unset();
// session_destroy();
$_SESSION["admin"] = "";
$_SESSION["admin_username"] = "";
$_SESSION["typeOfUser"] = "";
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Admin Access</title>
        <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/mine.css">
        <style>
        html {
            height: 100%;
        }

        body {
            display: table;
            width: 100%;
            height: 100%;
        }

        div.container {
            text-align: center;
            display: table-cell;
            vertical-align: middle;
        }

        img {
            margin: 0 auto;
            /** [top,bottom] [left,right] */
        }

        form {
            width: 30%;
            margin: 0px auto;
        }
        </style>


    </head>

    <body>
        <div class="container">
            <form action="login.php" method="POST" class="form-horizontal">
                <div class="form-group">
                    <h1>Admin Access</h1>
                    <?=$message;?>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <input type="text" pattern="[a-zA-Z0-9_]{2,12}" class="form-control" id="username" name="username" placeholder="Username" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <input type="password" pattern="[a-zA-Z0-9_]{2,12}" class="form-control" id="password" name="password" placeholder="Password" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-default">Sign in</button>
                    </div>
                </div>
            </form>
        </div>
    </body>
    <script src="../js/jquery-1.11.3.min.js"></script>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    </html>
