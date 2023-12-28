<?php
    session_start();
    if(!(isset($_SESSION['user']))){
        header("Location: index.html");
    } else {
        $user = $_SESSION['user'];
        if(isset($_POST['submit'])){
            $staff = $_POST;
            $StaffExist = false;
            $classExist = false;
            $rawData = file_get_contents("database/datas.json");
            $existingData = json_decode($rawData, true);
            if(!(isset($existingData['staffclasses']))){
                $existingData['staffclasses'] = array();
            }
            $classes = [];
            $Index;
            if(count($existingData['staffclasses']) > 0) {
                for ($i = 0; $i < count($existingData['staffclasses']); $i++) {
                    if($existingData['staffclasses'][$i]['staffname'] == $staff["staff"]) {
                        $classes = $existingData['staffclasses'][$i]['classes'];
                        $Index = $i;
                        $classExist = true;
                        for($j = 0; $j < count($existingData['staffclasses'][$i]["classes"]); $j++){
                            if($existingData['staffclasses'][$i]["classes"][$j] == $staff["class"]) {
                                $StaffExist = true;
                                break;
                            } else {
                                $StaffExist = false;
                            }
                        }
                        break;
                    } else {
                        $classExist = false;
                    }
                }
            }
            if($StaffExist == false){
                if($classExist == true) {
                    array_push($existingData['staffclasses'][$Index]['classes'], $staff["class"]);
                } else {
                    array_push($classes, $staff["class"]);
                    array_push($existingData['staffclasses'], array('staffname' => $staff["staff"], "classes" => $classes));
                }
                $dataFile = fopen("database/datas.json", 'w+');
                fwrite($dataFile, json_encode($existingData));
                fclose($dataFile);
                $success = "Class add to staff successfully";
            } else {
                $error = "Class already assing to staff";
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
    <title>Create Class - Staffs</title>
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
                                <h2 class="title">Add Staffs Class</h2>
                            </div>
                            <!-- /.col-md-6 text-right -->
                        </div>
                        <!-- /.row -->
                        <div class="row breadcrumb-div">
                            <div class="col-md-6">
                                <ul class="breadcrumb">
                                    <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                    <li> Staffs</li>
                                    <li class="active">Add Staff Class</li>
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
                                                    <h5>Add Staff Class</h5>
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
                                                        <label for="staff" class="col-sm-2 control-label">Class</label>
                                                        <div class="col-sm-10">
                                                        <select name="staff" class="form-control" id="staff" required="required">
                                                            <option hidden value="">Select Staff</option>
                                                            <?php
                                                                $rawData2 = file_get_contents("database/datas.json");
                                                                $existingData2 = json_decode($rawData2, true);
                                                                if(count($existingData2['staffs']) > 0) {
                                                                    for($i=0;$i<count($existingData2['staffs']); $i++){
                                                                        ?>
                                                                        <option value="<?php echo $existingData2['staffs'][$i]['username']; ?>"><?php echo $existingData2['staffs'][$i]["name"]; ?></option>
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
                                                            <select name="class" class="form-control" id="subject" required="required">
                                                                <option hidden value="">Select Subject</option>
                                                            <?php
                                                                $rawData3 = file_get_contents("database/datas.json");
                                                                $existingData3 = json_decode($rawData3, true);
                                                                if(count($existingData3["classes"]) > 0) {
                                                                    for($i = 0; $i < count($existingData3["classes"]); $i++) {
                                                                        ?>
                                                                        <option value="<?php echo $existingData3["classes"][$i]["class"]; ?> - <?php echo $existingData3["classes"][$i]["section"]; ?>"><?php echo $existingData3["classes"][$i]["class"]; ?> - <?php echo $existingData3["classes"][$i]["section"]; ?></option>
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