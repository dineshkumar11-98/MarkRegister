<?php
    session_start();
    if(!(isset($_SESSION['user']))){
        header("Location: index.html");
    } else{
        $user = $_SESSION['user'];
        if(isset($_POST['submit'])){
            $classes = $_POST;
            $classExist = false;
            $rawData = file_get_contents("database/datas.json");
            $existingData = json_decode($rawData, true);
            if(!(isset($existingData["classes"]))){
                $existingData["classes"] = [];
            }
            if (count($existingData["classes"]) > 0){
                for ($i = 0; $i < count($existingData["classes"]); $i++) {
                    if($existingData["classes"][$i]["class"] == $classes['classname'] and $existingData["classes"][$i]["section"] == $classes['section']){
                        $classExist = true;
                        break;
                    } else {
                        $classExist = false;
                    }
                }
            }
            if($classExist == false) {
                array_push($existingData["classes"], array("class" => $classes['classname'], "section" => $classes['section']));
                $dataFile = fopen("database/datas.json", 'w+');
                fwrite($dataFile, json_encode($existingData));
                fclose($dataFile);
                $success = "Class Created successfully";
            } else {
                $error = "Class already exist!";
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
    <title>Marke Register - Classes</title>
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
                                <h2 class="title">Create Class</h2>
                            </div>
                            <!-- /.col-md-6 text-right -->
                        </div>
                        <!-- /.row -->
                        <div class="row breadcrumb-div">
                            <div class="col-md-6">
                                <ul class="breadcrumb">
                                    <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                    <li> Classes</li>
                                    <li class="active">Create Class</li>
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
                                                    <h5>Create Class</h5>
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
                                                <form method="post">
                                                    <div class="form-group">
                                                        <label for="classname" class="control-label">Class Name</label>
                                                        <div class="">
                                                            <input type="text" name="classname" class="form-control" required="required" id="classname">
                                                            <span class="help-block">Eg - III, IV, XI etc</span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="section" class="control-label">Section</label>
                                                        <div class="">
                                                            <input type="text" name="section" class="form-control" required="required" id="section">
                                                            <span class="help-block">Eg - A, B, C etc</span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group has-success">
                                                        <div class="">
                                                           <button type="submit" name="submit" class="btn btn-success btn-labeled">Submit<span class="btn-label btn-label-right"><i class="fa fa-check"></i></span></button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.col-md-6 -->             
                                </div>
                                <!-- /.col-md-12 -->
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
    <script>
        
    </script>
</body>
</html>