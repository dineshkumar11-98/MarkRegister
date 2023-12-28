<?php
    session_start();
    if(!(isset($_SESSION['user']))){
        header("Location: index.html");
    } else{
        $user = $_SESSION['user'];
        if(isset($_POST['submit'])){
            $exam = $_POST;
            $examExist = false;
            $schoolExist = false;
            $rawData = file_get_contents("database/datas.json");
            $existingData = json_decode($rawData, true);
            if(!(isset($existingData["schoolexams"]))){
                $existingData["schoolexams"] = [];
            }
            $exams = [];
            $examIndex;
            if (count($existingData["schoolexams"]) > 0){
                for ($i = 0; $i < count($existingData["schoolexams"]); $i++) {
                    if($existingData["schoolexams"][$i]['school'] == $exam["schoolid"]){
                        $exams = $existingData["schoolexams"][$i]['exams'];
                        $examIndex = $i;
                        $schoolExist = true;
                        for ($j = 0; $j < count($existingData["schoolexams"][$i]['exams']); $j++) {
                            if($existingData["schoolexams"][$i]['exams'][$j] == $exam['examname']){
                                $examExist = true;
                                break;
                            } else {
                                $examExist = false;
                            }
                        }
                    }
                }
            }
            if($examExist == false) {
                if($schoolExist == true) {
                    array_push($existingData["schoolexams"][$examIndex]['exams'], $exam['examname']);
                } else {
                    array_push($existingData["schoolexams"], array('school' => $exam["schoolid"], 'exams' => [$exam['examname']]));
                }
                $dataFile = fopen("database/datas.json", 'w+');
                fwrite($dataFile, json_encode($existingData));
                fclose($dataFile);
                $success = "Exam add successfully";
            } else {
                $error = "Exam already exist!";
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
    <title>Marke Register - Exams</title>
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
                                <h2 class="title">Create Exams</h2>
                            </div>
                            <!-- /.col-md-6 text-right -->
                        </div>
                        <!-- /.row -->
                        <div class="row breadcrumb-div">
                            <div class="col-md-6">
                                <ul class="breadcrumb">
                                    <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                    <li> Exams</li>
                                    <li class="active">Create Exams</li>
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
                                                    <h5>Create Exams</h5>
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
                                                        <label for="success" class="control-label">Exam Name</label>
                                                        <div class="">
                                                            <input type="text" name="examname" class="form-control" required="required" id="success">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="default" class="control-label">Visible To</label>
                                                        <div class="">
                                                            <select name="schoolid" class="form-control" id="default" required="required">
                                                                <option hidden>Select School</option>
                                                                <?php
                                                                    $rawData2 = file_get_contents("database/datas.json");
                                                                    $existingData2 = json_decode($rawData2, true);
                                                                    if(count($existingData2["schools"]) > 0) {
                                                                        for($i = 0; $i < count($existingData2["schools"]); $i++) {
                                                                            ?>
                                                                            <option value="<?php echo $existingData2["schools"][$i]["schoolid"]; ?>"><?php echo $existingData2["schools"][$i]["schoolname"]; ?></option>
                                                                            <?php
                                                                        }
                                                                    }
                                                                ?>
                                                            </select>
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