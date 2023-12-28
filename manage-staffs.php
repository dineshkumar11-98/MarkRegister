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
    <title>Marke Register - Staffs</title>
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
                                <h2 class="title">Manage Staffs</h2>
                            </div>
                            
                            <!-- /.col-md-6 text-right -->
                        </div>
                        <!-- /.row -->
                        <div class="row breadcrumb-div">
                            <div class="col-md-6">
                                <ul class="breadcrumb">
                                    <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                    <li> Staffs</li>
                                    <li class="active">Manage Staffs</li>
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
                                                <h5>View Staffs Info</h5>
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
                                                        <th colName="name">Name</th>
                                                        <th colName="username">UserName</th>
                                                        <th colName="password">Password</th>
                                                        <th colName="permission">Permission</th>
                                                        <th colName="schoolid">School Id</th>
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
        getTableDataArray(<?php echo json_encode($existingData["staffs"]); ?>, true, <?php echo json_encode($existingData); ?>, "staffs", true, [true,true,true,false,false])
        function onValueChange(oldValue, newValue, index, column) {
            console.log(oldValue, newValue)
            fetch("saveUpdatedDataToAll.php", {
                method: 'POST',
                headers: {
                    'Content-Type' : 'application/json; charset=utf-8'
                },
                body: JSON.stringify({"oldStaffData":oldValue, 'newStaffData':newValue, 'array_index': index, 'column': column})
            })
        }
    </script>
</body>
</html>