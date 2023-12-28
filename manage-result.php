<?php
    session_start();
    if(!(isset($_SESSION['user']))){
        header("Location: index.html");
    } else {
        $user = $_SESSION['user'];
        $rawData = file_get_contents("database/datas.json");
        $existingData = json_decode($rawData, true);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/account.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Marke Register - Results</title>
    <script src="./js/table.js"></script>
    <script>
        function TableHeader() {
            var subjects = <?php echo json_encode($existingData['subjectcombs']) ?>;
            var headers = "";
            for(i = 0; i < subjects.length; i++) {
                if(subjects[i]['class'] == document.getElementById("class").value) {
                    for(j = 0; j < subjects[i]['subjects'].length; j++) {
                        headers = headers + "<th>" +subjects[i]['subjects'][j]+ "</th>";
                    }
                }
            }
            document.getElementById("subjectHeader").innerHTML = headers;
        }

        function elementInArray(array, element) {
            for(i = 0; i < array.length; i++) {
                if(array[i] === element) {
                    return true
                }
            }
            return false 
        }

        function GetClasses(exam) {
            var existingData = <?php echo json_encode($existingData); ?>;
            var allClasses = existingData['results'][exam];
            var classSelect = document.getElementById("class");
            var classOptions = '';
            var firstClass;
            var user = "<?php echo $user ?>";
            var keys = Object.keys(existingData['results'][exam])
            for(i =0; i < existingData['staffclasses'].length; i++) {
                if(existingData['staffclasses'][i]['staffname'] === user) {
                    var classKeys = Object.keys(existingData['results'][exam])
                    for(j = 0; j < classKeys.length; j++) {
                        if(elementInArray(existingData['staffclasses'][i]['classes'], classKeys[j])){
                            if(j === 0) {
                                firstClass = classKeys[j];
                            }
                            classOptions = classOptions + "<option value=\""+ classKeys[j] +"\">"+ classKeys[j] + "</option>"
                        }
                    }
                    break;
                }
            }
            classSelect.innerHTML = classOptions;
            GetMarkData(exam, firstClass)
        }

        function GetMarkData(exam, examClass, fullData) {
            TableHeader();
            var existingData = fullData ? fullData : <?php echo json_encode($existingData); ?>;
            let path = "results"+"."+exam+"."+examClass
            getTableDataArray(existingData['results'][exam][examClass], true, existingData, path, true, [false,false,true,false,false,false])
            try {
                RefreshTable()
            } catch {
                console.log("function not found")
            }
        }
        document.addEventListener("DOMContentLoaded", () => {
            GetClasses(document.getElementById("exam").value)
        })
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
                                <h2 class="title">Manage Results</h2>
                            </div>
                            
                            <!-- /.col-md-6 text-right -->
                        </div>
                        <!-- /.row -->
                        <div class="row breadcrumb-div">
                            <div class="col-md-6">
                                <ul class="breadcrumb">
                                    <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                    <li> Results</li>
                                    <li class="active">Manage Results</li>
                                </ul>
                            </div>
                         
                        </div>
                        <!-- /.row -->
                    </div>
                    <section class="section">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel">
                                        <div class="panel-heading">
                                            <div class="panel-title">
                                                <h5>View Results Info</h5>
                                            </div>
                                        </div>
                                        <div class="panel-body p-20">
                                            <div class="same-row">
                                                <div class="form-group horizontal">
                                                    <label for="exam" class="col-sm-2 control-label">Exam</label>
                                                    <div class="col-sm-10">
                                                        <select name="exam" class="form-control clid" id="exam" required="required" onchange="GetClasses(this.value)">
                                                            <?php
                                                                $rawData2 = file_get_contents("database/datas.json");
                                                                $existingData2 = json_decode($rawData2, true);
                                                                for($ix = 0; $ix < count($existingData2['staffs']); $ix++){
                                                                    if($existingData2['staffs'][$ix]['username'] == $user){
                                                                        $userSchoolid = $existingData2['staffs'][$ix]['schoolid'];
                                                                        for($j = 0; $j < count($existingData2["schoolexams"]); $j++){
                                                                            if($existingData2["schoolexams"][$j]['school'] == $existingData2['staffs'][$ix]['schoolid']) {
                                                                                for($i = 0; $i < count($existingData2["schoolexams"][$j]['exams']); $i++){
                                                                                    if(isset($existingData2['results'][$existingData2["schoolexams"][$j]['exams'][$i]])) {
                                                                                        ?>
                                                                                        <option value="<?php echo $existingData2["schoolexams"][$j]['exams'][$i] ?>"><?php echo $existingData2["schoolexams"][$j]['exams'][$i] ?></option>
                                                                                        <?php
                                                                                    }
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
                                                    <label for="class" class="col-sm-2 control-label">Class</label>
                                                    <div class="col-sm-10">
                                                        <select name="class" class="form-control clid" id="class" onchange="GetMarkData(document.getElementById('exam').value, this.value);" required="required"></select>
                                                    </div>
                                                </div>
                                            </div> 
                                            <div class="table-container">
                                                <div class="tab_head_container">
                                                    <div class="page_limit">
                                                        <span>Number of Rows:</span>
                                                        <select name="" id="rows_per_tab" onchange="DeclarRowPerTab(parseInt(this.value))">
                                                            <option value="10">10</option>
                                                            <option value="25">25</option>
                                                            <option value="50">50</option>
                                                            <option value="100">100</option>
                                                            <option value="250">250</option>
                                                        </select>
                                                    </div>
                                                    <div class="table_row_filter">
                                                        <span>Search:</span>
                                                        <input type="text" name="" id="table_row_filter_key">
                                                    </div>
                                                </div>
                                                <table class="table" editable=true id="data-table">
                                                    <thead>
                                                        <th colName="sno">S.No</th>
                                                        <th colName="name">Name</th>
                                                        <th colName="rollid">Roll No</th>
                                                        <th colName="marks" style="padding:0">Marks
                                                            <table class="nested-table" >
                                                                <thead id="subjectHeader"></thead>
                                                            </table>
                                                        </th>
                                                        <th colName="total">Total</th>
                                                        <th colName="result">Result</th>
                                                        <th colName="rank">Rank</th>
                                                        <th colName="acion">Action</th>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                                <div class="table-footer">
                                                    <span></span>
                                                    <div class="pages_container"></div>
                                                </div>
                                            </div>
                                            <!-- /.col-md-12 -->
                                        </div>
                                    </div>
                                </div>                     
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
    <script src="./js/navbars.js"></script>
    <script>
        getTableDataArray(<?php echo json_encode($existingData["results"]["Test1"]["X - A"]); ?>, true, <?php echo json_encode($existingData); ?>, 'results.Test1.X - A', true, [false,true,true,false,false,false])

        function onValueChange(oldValue, newValue, index, column, childIndex, arrayKey) {
            let arrayKeys = arrayKey.split(".")
            fetch("saveUpdatedDataToAll.php", {
                method: 'POST',
                headers: {
                    'Content-Type' : 'application/json; charset=utf-8'
                },
                body: JSON.stringify({'resultExam':arrayKeys[1], 'resultClass': arrayKeys[2],'array_index': index, 'column': column, "childIndex": childIndex})
            }).then(
                response => response.json()
            ).then(respArray => {
                if(respArray['Status']) {
                    try {
                        GetMarkData(arrayKeys[1], arrayKeys[2], respArray['Status'])
                    } catch {
                        console.log("RefreshTable() function not found")
                    }
                }
            })
        }
    </script>
</body>
</html>