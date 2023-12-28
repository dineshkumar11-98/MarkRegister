<?php
    session_start();
    if(!(isset($_SESSION['user']))){
        header("Location: index.html");
    } else {
        $user = $_SESSION['user'];
        if(isset($_POST['submit'])){
            $staff = $_POST;
            $StaffExist = false;
            $rawData = file_get_contents("database/datas.json");
            $existingData = json_decode($rawData, true);
            if(!isset($existingData['staffs'])) {
                $existingData['staffs'] = [];
            }
            if(count($existingData['staffs']) > 0) {
                for($i = 0; $i < count($existingData['staffs']); $i++) {
                    if($existingData['staffs'][$i]['username'] ==  $staff["staffusername"]) {
                        $StaffExist = true;
                        break;
                    } else {
                        $StaffExist = false;
                    }
                }
            }
            if($StaffExist == false) {
                array_push($existingData['staffs'], array(
                    "name" => $staff["staffname"],
                    "username" => $staff["staffusername"], 
                    "password" => $staff["staffpassword"],
                    "permission" => $staff["permission"],
                    "schoolid" => $staff["schoolid"])
                );
                $dataFile = fopen("database/datas.json", 'w+');
                fwrite($dataFile, json_encode($existingData));
                fclose($dataFile);
                $success = "Staff Add successfully";
            } else {
                $error = "Staff already exist!";
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
                                <h2 class="title">Add Staffs</h2>
                            </div>
                            <!-- /.col-md-6 text-right -->
                        </div>
                        <!-- /.row -->
                        <div class="row breadcrumb-div">
                            <div class="col-md-6">
                                <ul class="breadcrumb">
                                    <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                    <li> Staffs</li>
                                    <li class="active">Add Staff</li>
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
                                                    <h5>Add Staff</h5>
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
                                                        <label for="staffname" class="col-sm-2 control-label">Staff Name</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="staffname" class="form-control" id="staffname" required="required">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="permission" class="col-sm-2 control-label">Staff Account Permission</label>
                                                        <div class="col-sm-10">
                                                            <select name="permission" class="form-control" id="permission" required="required">
                                                                <option value="staff">Staff</option>
                                                                <option value="admin">Admin</option>
                                                                <option value="superadmin">Super Admin</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="school" class="col-sm-2 control-label">Staff School</label>
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
                                                    <div class="form-group">
                                                        <label for="staffusername" class="col-sm-2 control-label">Staff User Name</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="staffusername" class="form-control" id="staffusername" required="required">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="pass" class="col-sm-2 control-label">Staff Password</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="staffpassword" class="form-control" id="pass" required="required">
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