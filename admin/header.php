<link rel="stylesheet" href="../js/jquery-ui-1.11.4.custom/jquery-ui.min.css">
<link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="../css/mine.css">
<link rel="stylesheet" href="../css/font-awesome.min.css">
<section style="padding-bottom: 60px;">
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-mainmenu" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="main.php"><i class="fa fa-adn"></i>dmin</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-mainmenu">
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="list-msg.php"><i class="fa fa-comments-o"></i> ข้อความ</a>
                    </li>
                </ul>
                <!--
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-medkit"></i> ยา <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="create-medicine.php"><i class="fa fa-plus"></i> เพิ่มข้อมูลยา</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="list-medicine.php"><i class="fa fa-medkit"></i> รายการยาทั้งหมด</a></li>
                        </ul>
                    </li>
                </ul>

                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="list-profile.php"><i class="fa fa-users"></i> สมาชิก</a>
                    </li>
                </ul>
                -->
                <ul class="nav navbar-right">
                    <li>
                        <p class="navbar-text">Signed in as
                            <?=$_SESSION['typeOfUser'];?> | <a href="logout.php" class="navbar-link" title="ออกจากระบบ" onclick="return confirm('ยืนยันการออกจากระบบ ?');"><i class="fa fa-sign-out"></i> Sign out</a></p>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>
</section>
