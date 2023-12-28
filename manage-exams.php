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
    <title>Marke Register - Exams</title>
    <script src="./js/table.js"></script>
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
                                <h2 class="title">Manage Exams</h2>
                            </div>
                            
                            <!-- /.col-md-6 text-right -->
                        </div>
                        <!-- /.row -->
                        <div class="row breadcrumb-div">
                            <div class="col-md-6">
                                <ul class="breadcrumb">
                                    <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                    <li> Exams</li>
                                    <li class="active">Manage Exams</li>
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
                                                <h5>View Exams Info</h5>
                                            </div>
                                        </div>
                                        <div class="panel-body p-20">
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
                                                        <th colName="class">School Id</th>
                                                        <th colName="section">Exams</th>
                                                        <th colName="action">Action</th>
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
        getTableDataArray(<?php echo json_encode($existingData["schoolexams"]); ?>, true, <?php echo json_encode($existingData); ?>, "schoolexams", true, [false, false])
        // function onValueChange(oldValue, newValue) {
        //     console.log(oldValue, newValue)
        //     fetch("saveUpdatedDataToAll.php", {
        //         method: 'POST',
        //         headers: {
        //             'Content-Type' : 'application/json; charset=utf-8'
        //         },
        //         body: JSON.stringify({"oldSub":oldValue, 'newSub':newValue})
        //     })
        // }
    </script>
</body>
</html>