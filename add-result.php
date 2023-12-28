<?php
    session_start();

    function CalculatTotal($markArray) {
        // total
        $total = 0;
        for($i = 0; $i < count($markArray); $i++){
            if($markArray[$i] != 'A'){
                $total = $total + (int) $markArray[$i];
            }
        }
        return $total;
    }

    function CalculatResult($markArray) {
        // result
        $studentResult;
        for($i = 0; $i < count($markArray); $i++) {
            if(!($markArray[$i] > 34) or $markArray[$i] == 'A') {
                $studentResult = 'FAIL';
                break;
            } else {
                $studentResult = 'PASS';
            }
        }
        return $studentResult;
    }

    function CheckAvalibility($array, $element) {
        $elementExist = false;
        for($i = 0; $i < count($array); $i++) {
            if($array[$i] == $element) {
                $elementExist = true;
            }
        }
        return $elementExist;
    }

    function assignRank($exam, $class, $datas) {
        // rank
        $existingData = $datas;
        $studentRank = 1;
        $excludeIndex = [];
        $largestNumber = 0;
        $largestNumberIndex = 0;
        $sameRank = false;
        for($i = 0; $i < count($existingData["results"][$exam][$class]); $i++) {
            for($j = 0; $j < count($existingData["results"][$exam][$class]); $j++) {
                if(count($excludeIndex) > 0) {
                    if(CheckAvalibility($excludeIndex, $j) == false and $existingData["results"][$exam][$class][$j]['result'] == 'PASS') {
                        if($largestNumber <= $existingData["results"][$exam][$class][$j]['total']) {
                            if ($largestNumber == $existingData["results"][$exam][$class][$j]['total']) {
                                $sameRank = true;
                            } else {
                                $sameRank = false;
                            }
                            $largestNumber = $existingData["results"][$exam][$class][$j]['total'];
                            $largestNumberIndex = $j;
                        }
                    }
                } elseif($existingData["results"][$exam][$class][$j]['result'] == 'PASS') {
                    if($largestNumber <= $existingData["results"][$exam][$class][$j]['total']) {
                        if ($largestNumber == $existingData["results"][$exam][$class][$j]['total']) {
                            $sameRank = true;
                        } else {
                            $sameRank = false;
                        }
                        $largestNumber = $existingData["results"][$exam][$class][$j]['total'];
                        $largestNumberIndex = $j;
                    }
                }
            }
            if($existingData["results"][$exam][$class][$i]['result'] == 'PASS' and CheckAvalibility($excludeIndex, $largestNumberIndex) == false) {
                array_push($excludeIndex, $largestNumberIndex);
                $existingData["results"][$exam][$class][$largestNumberIndex]['rank'] = $studentRank;
                if($sameRank == false){$studentRank++;}
                $largestNumber = 0;
            } elseif ($existingData["results"][$exam][$class][$i]['result'] == 'FAIL') {
                $existingData["results"][$exam][$class][$i]['rank'] = 'FAIL';
                $largestNumber = 0;
                array_push($excludeIndex, $i);
            }
        }
        return $existingData;
    }

    if(!(isset($_SESSION['user']))){
        header("Location: index.html");
    } else {
        $user = $_SESSION['user'];
        $userSchoolid = "";
        $rawData = file_get_contents("database/datas.json");
        $existingData = json_decode($rawData, true);
        if(isset($_POST['submit'])){
            $result = $_POST;
            $resultExist = false;
            if(!(isset($existingData))){
                $existingData = array();
            }
            if(!(isset($existingData["results"]))){
                $existingData["results"] = array();
            }
            if(!(isset($existingData["results"][$result["exam"]]))){
                $existingData["results"][$result["exam"]] = array();
            }
            if(!(isset($existingData["results"][$result["exam"]][$result["class"]]))){
                $existingData["results"][$result["exam"]][$result["class"]] = array();
            }
            foreach($existingData["results"][$result["exam"]][$result["class"]] as $studentId => $studentMark) {
                if($studentMark['rollid'] == $result["rollid"]){
                    $resultExist = true;
                    break;
                } else {
                    $resultExist = false;
                }
            }
            if($resultExist == false) {
                $mark = [];
                for($i = 0; $i < count($result["marks"]); $i++) {
                    array_push($mark, $result["marks"][$i] == 'A' ?$result["marks"][$i]:(int)$result["marks"][$i]);
                }
                $markTotal = CalculatTotal($mark);
                $stdResult = CalculatResult($mark);
                array_push($existingData["results"][$result["exam"]][$result["class"]], array('name' => $result['studentid'],'rollid' => $result["rollid"], 'marks' => $mark, 'total' => $markTotal, 'result' => $stdResult));
                $existingData = assignRank($result["exam"], $result["class"], $existingData);
                $dataFile = fopen("database/datas.json", 'w+');
                fwrite($dataFile, json_encode($existingData));
                fclose($dataFile);
                $success = "Result of \"".$result["rollid"]."\" add successfully";
            } else {
                $error = "Result already exist for \"".$result["rollid"]."\" roll number";
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
    <title>Create Class - Results</title>
    <script>
        var existingData = <?php echo json_encode($existingData); ?>;

        function getRollId(className) {
            const allStudents = existingData['students'];
            var subject;
            var school;
            var user = "<?php echo $user; ?>";
            for(i = 0; i < existingData["staffs"].length; i++) {
                if(existingData["staffs"][i]['username'] === user) {
                    school = existingData["staffs"][i]['schoolid']
                }
            }
            for(i = 0; i < existingData["subjectcombs"].length; i++){
                if(existingData["subjectcombs"][i]['class'] == className) {
                    subject = existingData["subjectcombs"][i]['subjects']
                }
            }
            let innerHtml = ""
            let innerHtml2 = ""
            innerHtml = innerHtml + "<option value=\"\" hidden>Select Roll Number</option>"
            document.getElementById("studentid").value = ""
            allStudents.forEach(student => {
                if(student["class"] === className && student['school'] === school){
                    innerHtml = innerHtml + "<option value=\""+ student["rollid"] +"\">"+student["rollid"]+"</option>"
                }
            })
            document.getElementById("rollid").innerHTML = innerHtml
            if(subject !== "undefined") {
                subject.forEach(subject => {
                    innerHtml2 = innerHtml2 + "<p> "+subject+"<input type=\"text\" name=\"marks[]\" class=\"form-control\" required=\"\" autocomplete=\"off\"></p>"
                })
            } else {
                innerHtml2 = ""
            }
            document.getElementById("subject").innerHTML = innerHtml2
        }

        function getStudentData(rollNumber) {
            const allStudents = existingData["students"]
            allStudents.forEach(student => {
                if(student["rollid"] === rollNumber){
                    document.getElementById("studentid").value = student["name"]
                }
            })
        }
    </script>
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
                                <h2 class="title">Results</h2>
                            </div>
                            <!-- /.col-md-6 text-right -->
                        </div>
                        <!-- /.row -->
                        <div class="row breadcrumb-div">
                            <div class="col-md-6">
                                <ul class="breadcrumb">
                                    <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                    <li> Results</li>
                                    <li class="active">Add Results</li>
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
                                                    <h5>Results</h5>
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
                                                <form class="form-horizontal" method="post">
                                                <div class="form-group horizontal">
                                                        <label for="default" class="col-sm-2 control-label">Exam</label>
                                                        <div class="col-sm-10">
                                                            <select name="exam" class="form-control clid" id="default" required="required">
                                                                <option value="" hidden>Select Exam</option>
                                                                <?php
                                                                    $rawData2 = file_get_contents("database/datas.json");
                                                                    $existingData2 = json_decode($rawData2, true);
                                                                    for($ix = 0; $ix < count($existingData2['staffs']); $ix++){
                                                                        if($existingData2['staffs'][$ix]['username'] == $user){
                                                                            $userSchoolid = $existingData2['staffs'][$ix]['schoolid'];
                                                                            for($j = 0; $j < count($existingData2["schoolexams"]); $j++){
                                                                                if($existingData2["schoolexams"][$j]['school'] == $existingData2['staffs'][$ix]['schoolid']) {
                                                                                    for($i = 0; $i < count($existingData2["schoolexams"][$j]['exams']); $i++){
                                                                                        ?>
                                                                                        <option value="<?php echo $existingData2["schoolexams"][$j]['exams'][$i] ?>"><?php echo $existingData2["schoolexams"][$j]['exams'][$i] ?></option>
                                                                                        <?php
                                                                                    }
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group horizontal">
                                                        <label for="classid" class="col-sm-2 control-label">Class</label>
                                                        <div class="col-sm-10">
                                                            <select name="class" class="form-control clid" id="classid" onchange="getRollId(this.value);" required="required">
                                                                <option hidden value="">Select Class</option>
                                                                <?php
                                                                    for($i = 0; $i < count($existingData2['staffclasses']); $i++) {
                                                                        if($existingData2['staffclasses'][$i]['staffname'] == $user) {
                                                                            for($j = 0; $j < count($existingData2['staffclasses'][$i]['classes']); $j++) {
                                                                                ?>
                                                                                <option value="<?php echo $existingData2['staffclasses'][$i]['classes'][$j] ?>"><?php echo $existingData2['staffclasses'][$i]['classes'][$j] ?></option>
                                                                                <?php
                                                                            }
                                                                        }
                                                                    }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group horizontal">
                                                        <label for="rollid" class="col-sm-2 control-label ">Roll Id</label>
                                                        <div class="col-sm-10">
                                                            <select name="rollid" class="form-control stid" id="rollid" required="required" onchange="getStudentData(this.value);"></select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group horizontal">
                                                        <label for="studentid" class="col-sm-2 control-label">Student</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="studentid" class="form-control" id="studentid" required="required" autocomplete="off" readonly="readonly">
                                                        </div>
                                                    </div> 
                                                    <div class="form-group horizontal">
                                                        <span class="col-sm-2 control-label">Subjects</span>
                                                        <div class="col-sm-10">
                                                            <div id="subject"></div>
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
</body>
</html>