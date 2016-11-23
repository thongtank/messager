<header>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">ระบบแจ้งข้อมูลข่าวสารวิทยาลัยเทคนิคอุบลราชธานี</a>
            </div>
            <div>
                <ul class="nav navbar-nav pull-right">
                    <li class="">
                        <a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a>
                    </li>
                    <?php
if (isset($_SESSION['teacher'])) {
	?>
                    <li class="">
                        <a href="signout.php" onclick="return confirm('ยืนยันการออกจากระบบ ?');" title="ออกจากระบบ">
                            <i class="fa fa-sign-out"></i> ออกจากระบบ
                        </a>
                    </li>
                    <?php }?>
                    <!--
                    <li class="">
                        <a href="research.php"><i class="fa fa-line-chart"></i> ประเมินการรักษา</a>
                    </li>
                    <li class="">
                        <a href="search.php"><i class="fa fa-search"></i> ค้นหา รพ.</a>
                    </li>
                    -->
                </ul>
            </div>
        </div>
    </nav>
</header>
