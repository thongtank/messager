<?php
session_start();
// print_r($_SESSION['profile_detail']);
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>ระบบแจ้งข้อมูลข่าวสารวิทยาลัยเทคนิคอุบลราชธานี</title>
        <link rel="stylesheet" href="js/jquery-ui-1.11.4.custom/jquery-ui.min.css">
        <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="css/mine.css">
        <style>
        div.menu {
            /* height: 200px; */
            padding-top: 20px;
            padding-bottom: 20px;
        }
        </style>
    </head>

    <body>
        <?php include "header.php";?>
        <article class="container-fluid">
            <section class="container">
                <div class="col-md-12 menu text-center">
                    <form action="php/login.php" method="POST" class="form-horizontal">
                        <div class="form-group">
                            <h1 class="text-center"><i class="fa fa-user fa-5x"></i></h1>
                            <h1 class="text-center">Teacher Login</h1>
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
                                <button type="submit" class="btn btn-default">เข้าสู่ระบบ</button>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </article>
        <?php include 'footer.php';?>
        <script src="js/jquery-1.11.3.min.js"></script>
        <script src="js/jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>
        <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    </body>

    </html>
