<?php
    session_start();
    if(!(isset($_SESSION['user']))){
        header("Location: index.html");
    } else {
        $user = $_SESSION['user'];
        if(isset($_POST['submit'])){
            $subject = $_POST;
            $subjectExist = false;
            $rawData = file_get_contents("database/datas.json");
            $existingData = json_decode($rawData, true);
            if(!(isset($existingData["subjects"]))){
                $existingData["subjects"] = [];
            }
            if(count($existingData["subjects"]) > 0){
                for ($i = 0; $i < count($existingData["subjects"]); $i++) {
                    if($existingData["subjects"][$i]["subject"] == $subject["subjectname"]){
                        $subjectExist = true;
                        break;
                    } else {
                        $subjectExist = false;
                    }
                }
            }
            if($subjectExist == false) {
                array_push($existingData["subjects"], array("subject" => $subject['subjectname'], "code" => $subject['subjectcode']));
                $dataFile = fopen("database/datas.json", 'w+');
                fwrite($dataFile, json_encode($existingData));
                fclose($dataFile);
                $success = "Subject Created successfully";
            } else {
                $error = "Subject already exist!";
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
    <title>Create Class - Subjects</title>
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
                                <h2 class="title">Subject Creation</h2>
                            </div>
                            <!-- /.col-md-6 text-right -->
                        </div>
                        <!-- /.row -->
                        <div class="row breadcrumb-div">
                            <div class="col-md-6">
                                <ul class="breadcrumb">
                                    <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                    <li> Classes</li>
                                    <li class="active">Subject Creation</li>
                                </ul>
                            </div>
                        </div>
                        <!-- /.row -->
                    </div>
                        <section class="section">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-8 col-md-offset-2">
                                        <div class="panel">
                                            <div class="panel-heading">
                                                <div class="panel-title">
                                                    <h5>Subject Creation</h5>
                                                </div>
                                            </div>
                                            <?php if(isset($success)){ ?>
                                                    <div class="alert alert-success left-icon-alert" role="alert">
                                                        <strong>Well done! </strong><?php echo htmlentities($success); ?>
                                                    </div>
                                            <?php } 
                                                else if(isset($error)){?>
                                                    <div class="alert alert-danger left-icon-alert" role="alert">
                                                        <strong>Oh snap! </strong> <?php echo htmlentities($error); ?>
                                                    </div>
                                            <?php } ?>
                                            <div class="panel-body">
                                                <form class="" method="post">
                                                    <div class="form-group">
                                                        <label for="subjectname" class="col-sm-2 control-label">Subject Name</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="subjectname" class="form-control" id="subjectname" required="required">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="subjectcode" class="col-sm-2 control-label">Subject Code</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="subjectcode" class="form-control" id="subjectcode" required="required">
                                                        </div>
                                                    </div>
                                                    <div class="form-group has-success">
                                                        <div class="col-sm-2">
                                                            <button type="submit" name="submit" class="btn btn-success btn-labeled">Submit<span class="btn-label btn-label-right"><i class="fa fa-check"></i></span></button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                        <!-- /.col-md-12 -->
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