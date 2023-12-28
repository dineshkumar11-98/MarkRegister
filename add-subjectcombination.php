<?php
    session_start();
    if(!(isset($_SESSION['user']))){
        header("Location: index.html");
    } else {
        $user = $_SESSION['user'];
        if(isset($_POST['submit'])){
            $subjectCombs = $_POST;
            $subjectCombExist = false;
            $classExist = false;
            $rawData = file_get_contents("database/datas.json");
            $existingData = json_decode($rawData, true);
            if(!(isset($existingData["subjectcombs"]))){
                $existingData["subjectcombs"] = array();
            }
            $subjects = [];
            $classIndex;
            if(count($existingData["subjectcombs"]) > 0){
                for ($i = 0; $i < count($existingData["subjectcombs"]); $i++) {
                    if($existingData["subjectcombs"][$i]["class"] == $subjectCombs["class"]) {
                        $subjects = $existingData["subjectcombs"][$i]["subjects"];
                        $classIndex = $i;
                        $classExist = true;
                        for($j = 0; $j < count($existingData["subjectcombs"][$i]["subjects"]); $j++) {
                            if($existingData["subjectcombs"][$i]["subjects"][$j] == $subjectCombs["subject"]){
                                $subjectCombExist = true;
                                break;
                            } else {
                                $subjectCombExist = false;
                            }
                        }
                        break;
                    } else {
                        $classExist = false;
                    }
                }
            }
            if($subjectCombExist == false) {
                if($classExist == true) {
                    array_push($existingData["subjectcombs"][$classIndex]["subjects"], $subjectCombs["subject"]);
                } else {
                    array_push($subjects, $subjectCombs["subject"]);
                    array_push($existingData["subjectcombs"], array("class" => $subjectCombs["class"], "subjects" => $subjects));
                }
                $dataFile = fopen("database/datas.json", 'w+');
                fwrite($dataFile, json_encode($existingData));
                fclose($dataFile);
                $success = "Subject add to ".$subjectCombs["class"]." successfully";
            } else {
                $error = "Subject already exist ".$subjectCombs["class"];
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
                                <h2 class="title">Subject Combination Creation</h2>
                            </div>
                            <!-- /.col-md-6 text-right -->
                        </div>
                        <!-- /.row -->
                        <div class="row breadcrumb-div">
                            <div class="col-md-6">
                                <ul class="breadcrumb">
                                    <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                    <li> Classes</li>
                                    <li class="active">Add Subject Combination</li>
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
                                                    <h5>Subject Combination</h5>
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
                                                        <label for="class" class="col-sm-2 control-label">Class</label>
                                                        <div class="col-sm-10">
                                                        <select name="class" class="form-control" id="class" required="required">
                                                            <option value="" hidden>Select Class</option>
                                                            <?php
                                                                $rawData2 = file_get_contents("database/datas.json");
                                                                $existingData2 = json_decode($rawData2, true);
                                                                if(count($existingData2["classes"]) > 0) {
                                                                    for($k = 0; $k < count($existingData2["classes"]); $k++) {
                                                                        ?>
                                                                        <option value="<?php echo $existingData2["classes"][$k]["class"]; ?> - <?php echo $existingData2["classes"][$k]["section"]; ?>"><?php echo $existingData2["classes"][$k]["class"]; ?> - <?php echo $existingData2["classes"][$k]["section"]; ?></option>
                                                                        <?php
                                                                    }
                                                                }
                                                            ?>
                                                        </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="subject" class="col-sm-2 control-label">Subject</label>
                                                        <div class="col-sm-10">
                                                            <select name="subject" class="form-control" id="subject" required="required">
                                                                <option value="" hidden>Select Subject</option>
                                                            <?php
                                                                if(count($existingData2["subjects"])) {
                                                                    for($i = 0; $i < count($existingData2["subjects"]); $i++) {
                                                                        ?>
                                                                        <option value="<?php echo $existingData2["subjects"][$i]["subject"]; ?>"><?php echo $existingData2["subjects"][$i]["subject"]; ?></option>
                                                                        <?php
                                                                    }
                                                                }
                                                            ?>
                                                            </select>
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