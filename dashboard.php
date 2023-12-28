<?php
    session_start();
    if(!(isset($_SESSION['user']))){
        header("Location: index.html");
    } else {
        $user = $_SESSION['user'];
        $classCount = 0;
        $subCount = 0;
        $stuCount = 0;
        $rawData = file_get_contents("database/datas.json");
        $existingData = json_decode($rawData, true);

        function CheckAvalibility($array, $element) {
            $elementExist = false;
            for($i = 0; $i < count($array); $i++) {
                if($array[$i] == $element) {
                    $elementExist = true;
                }
            }
            return $elementExist;
        }

        $userClasses;
        for($i = 0; $i < count($existingData['staffclasses']); $i++) {
            if($existingData['staffclasses'][$i]['staffname'] == $user) {
                $classCount = count($existingData['staffclasses'][$i]['classes']);
                $userClasses = $existingData['staffclasses'][$i]['classes'];
            }
        }
        for($i = 0; $i < count($existingData['subjectcombs']); $i++) {
            if(CheckAvalibility($userClasses, $existingData['subjectcombs'][$i]['class'])) {
                $subCount = $subCount + count($existingData['subjectcombs'][$i]['subjects']);
            }
        }
        for($i = 0; $i < count($existingData['students']); $i++) {
            if(CheckAvalibility($userClasses, $existingData['students'][$i]['class'])) {
                $stuCount++;
            }
        }
        if(isset($existingData[$user])) {
            if(isset($existingData[$user]["students"])){
                $stuCount = count($existingData[$user]["students"]);
            } else {
                $stuCount = 0;
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="./assets/img/logo.png">
    <link rel="stylesheet" href="./css/account.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Marke Register - Dashboard</title>
</head>
<body class="top-navbar-fixed">
    <div class="main-container">
        <?php include('includes/topbar.php');?>
        <div class="content-wrapper">
            <div class="content-container">
                <?php include('includes/leftbar.php');?>
                <div class="main-page">
                    <div class="container-fluid">
                        <div class="row page-title-div">
                            <div class="col-md-6">
                                <h2 class="title">Dashboard</h2>
                            </div>
                            <!-- /.col-md-6 text-right -->
                        </div>
                        <!-- /.row -->
                    </div>
                        <section class="section">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                        <a class="dashboard-stat bg-warning">
                                            <span class="number counter"><?php if(isset($classCount)){echo $classCount;} ?></span>
                                            <span class="name">Classes Listed</span>
                                            <span class="bg-icon"><i class="fa fa-bank"></i></span>
                                        </a>
                                        <!-- /.dashboard-stat -->
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                        <a class="dashboard-stat bg-danger">
                                            <span class="number counter"><?php if(isset($subCount)){echo $subCount;} ?></span>
                                            <span class="name">Subjects Listed</span>
                                            <span class="bg-icon"><i class="fa fa-book"></i></span>
                                        </a>
                                        <!-- /.dashboard-stat -->
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                        <a class="dashboard-stat bg-primary">
                                            <span class="number counter"><?php if(isset($stuCount)){echo $stuCount;} ?></span>
                                            <span class="name">Student Listed</span>
                                            <span class="bg-icon"><i class="fa fa-users"></i></span>
                                        </a>
                                        <!-- /.dashboard-stat -->
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
    <script src="./js/navbars.js"></script>
    <script></script>
</body>
</html>