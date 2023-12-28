<?php
    session_start();
    if(!(isset($_SESSION['user']))){
        header("Location: index.html");
    } else {
        $user = $_SESSION['user'];
        if(isset($_POST['submit'])){
            $student = $_POST;
            $studentExist = false;
            $rawData = file_get_contents("database/datas.json");
            $existingData = json_decode($rawData, true);
            if(!(isset($existingData))){
                $existingData = array();
            }
            if(!(isset($existingData["students"]))){
                $existingData["students"] = [];
            }
            if(count($existingData["students"]) > 0) {
                for ($i = 0; $i < count($existingData["students"]); $i++) {
                    if($existingData["students"][$i]["rollid"] == $student["rollid"] and $existingData["students"][$i]["class"] == $student["class"]) {
                        if ($existingData["students"][$i]["rollid"] == $student["rollid"]) {
                            $error = "Roll Id already exist in ".$student["class"];
                        }
                        $studentExist = true;
                        break;
                    } else {
                        $studentExist = false;
                    }
                }
            }
            if($studentExist == false){
                array_push($existingData["students"], array("name" => $student["fullanme"], "rollid" => $student["rollid"], "gender" => $student["gender"], "class" => $student["class"], "school" => $student["schoolid"]));
                $dataFile = fopen("database/datas.json", 'w+');
                fwrite($dataFile, json_encode($existingData));
                fclose($dataFile);
                $success = "Student add successfully";
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
    <title>Marke Register - Students</title>
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
                                <h2 class="title">Students</h2>
                            </div>
                            <!-- /.col-md-6 text-right -->
                        </div>
                        <!-- /.row -->
                        <div class="row breadcrumb-div">
                            <div class="col-md-6">
                                <ul class="breadcrumb">
                                    <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                    <li> Students</li>
                                    <li class="active">Add Students</li>
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
                                                    <h5>Fill the Student info</h5>
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
                                                        <label for="fullanme" class="col-sm-2 control-label">Full Name</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="fullanme" class="form-control" id="fullanme" required="required" autocomplete="off">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="rollid" class="col-sm-2 control-label">Roll Id</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="rollid" class="form-control" id="rollid" maxlength="5" required="required" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label for="gender" class="col-sm-2 control-label">Gender</label>
                                                        <div class="col-sm-10">
                                                            <select name="gender" class="form-control" id="gender" required="required">
                                                                <option value="Male">Male</option>
                                                                <option value="Female">Female</option>
                                                                <option value="Other">Other</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="class" class="col-sm-2 control-label">Class</label>
                                                        <div class="col-sm-10">
                                                            <select name="class" class="form-control" id="class" required="required">
                                                                <?php
                                                                    $rawData2 = file_get_contents("database/datas.json");
                                                                    $existingData2 = json_decode($rawData2, true);
                                                                    if(count($existingData2["classes"]) > 0) {
                                                                        for($i = 0; $i < count($existingData2["classes"]); $i++) {
                                                                            ?>
                                                                            <option value="<?php echo $existingData2["classes"][$i]["class"]; ?> - <?php echo $existingData2["classes"][$i]["section"]; ?>"><?php echo $existingData2["classes"][$i]["class"]; ?> - <?php echo $existingData2["classes"][$i]["section"]; ?></option>
                                                                            <?php
                                                                        }
                                                                    }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="school" class="col-sm-2 control-label">Class</label>
                                                        <div class="col-sm-10">
                                                            <select name="schoolid" class="form-control" id="school" required="required">
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
                                                        <div class="col-sm-offset-2">
                                                           <button type="submit" name="submit" class="btn btn-success btn-labeled">Add<span class="btn-label btn-label-right"><i class="fa fa-check"></i></span></button>
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