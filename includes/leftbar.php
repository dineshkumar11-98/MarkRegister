<?php 
    $rawDataPerm = file_get_contents("database/datas.json");
    $existingDataPerm = json_decode($rawDataPerm, true);
    for($i = 0; $i < count($existingDataPerm['staffs']); $i++) {
        if($existingDataPerm['staffs'][$i]['username'] == $user) {
            $loginUser = array();
            $loginUser[$user] = $existingDataPerm['staffs'][$i];
        }
    }
?>
<div class="left-sidebar bg-black-300 ">
    <div class="sidebar-content">
        <div class="user-info closed">
            <img src="http://placehold.it/90/c2c2c2?text=User" alt="John Doe" class="img-circle profile-img">
            <h6 class="title">John Doe</h6>
            <small class="info">PHP Developer</small>
        </div>
        <!-- /.user-info -->

        <div class="sidebar-nav">
            <ul class="side-nav color-gray">
                <li class="nav-header">
                    <span class="">Main Category</span>
                </li>
                <li>
                    <a href="dashboard.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span> </a>
                    
                </li>

                <li class="nav-header">
                    <span class="">Appearance</span>
                </li>
                <li class="has-children" style = "display:<?php if($loginUser[$user]["permission"] == "superadmin"){echo "block";} else {echo "none";} ?>;">
                    <a ><i class="fa fa-file-text"></i> <span>Schools</span> <i class="fa fa-angle-right arrow"></i></a>
                    <ul class="child-nav" style="display: none;">
                        <li><a href="add-school.php"><i class="fa fa-bars"></i> <span>Add School</span></a></li>
                        <li><a href="manage-school.php"><i class="fa fa fa-server"></i> <span>Manage School</span></a></li>
                    </ul>
                </li>
                <li class="has-children" style = "display:<?php if($loginUser[$user]["permission"] == "superadmin"){echo "block";} else {echo "none";} ?>;">
                    <a><i class="fa fa-file-text"></i> <span>Classes</span> <i class="fa fa-angle-right arrow"></i></a>
                    <ul class="child-nav" style="display: none;">
                        <li><a href="create-class.php"><i class="fa fa-bars"></i> <span>Create Class</span></a></li>
                        <li><a href="manage-classes.php"><i class="fa fa fa-server"></i> <span>Manage Classes</span></a></li>
                    </ul>
                </li>
                <li class="has-children" style = "display:<?php if($loginUser[$user]["permission"] == "superadmin"){echo "block";} else {echo "none";} ?>;">
                    <a><i class="fa fa-file-text"></i> <span>Subjects</span> <i class="fa fa-angle-right arrow"></i></a>
                    <ul class="child-nav" style="display: none;">
                        <li><a href="create-subject.php"><i class="fa fa-bars"></i> <span>Create Subject</span></a></li>
                        <li><a href="manage-subject.php"><i class="fa fa fa-server"></i> <span>Manage Subjects</span></a></li>
                        <li><a href="add-subjectcombination.php"><i class="fa fa-newspaper"></i> <span>Add Subject Combination</span></a></li>
                        <li><a href="manage-subjectcombination.php"><i class="fa fa-newspaper"></i> <span>Manage Subject Combination</span></a></li>
                    </ul>
                </li>
                <li class="has-children" style = "display:<?php if($loginUser[$user]["permission"] == "superadmin" or $loginUser[$user]["permission"] == "admin"){echo "block";} else {echo "none";} ?>;">
                    <a><i class="fa fa-user"></i> <span>Staffs</span> <i class="fa fa-angle-right arrow"></i></a>
                    <ul class="child-nav" style="display: none;">
                        <li style = "display:<?php if($loginUser[$user]["permission"] == "superadmin"){echo "block";} else {echo "none";} ?>;"><a href="add-staff.php"><i class="fa fa-bars"></i> <span>Add Staff</span></a></li>
                        <li style = "display:<?php if($loginUser[$user]["permission"] == "superadmin"){echo "block";} else {echo "none";} ?>;"><a href="manage-staffs.php"><i class="fa fa fa-server"></i> <span>Manage Staff</span></a></li>
                        <li style = "display:<?php if($loginUser[$user]["permission"] == "superadmin" or $loginUser[$user]["permission"] == "admin"){echo "block";} else {echo "none";} ?>;"><a href="addclasstostaff.php"><i class="fa fa-newspaper"></i> <span>Assign Class for Staff</span></a></li>
                        <li style = "display:<?php if($loginUser[$user]["permission"] == "superadmin" or $loginUser[$user]["permission"] == "admin"){echo "block";} else {echo "none";} ?>;"><a href="manage-assignedclass.php"><i class="fa fa-newspaper"></i> <span>Manage Assigned Class for Staff</span></a></li>
                    </ul>
                </li>
                <li class="has-children" style = "display:<?php if($loginUser[$user]["permission"] == "superadmin" or $loginUser[$user]["permission"] == "admin"){echo "block";} else {echo "none";} ?>;">
                    <a><i class="fa fa-user"></i> <span>Exams</span> <i class="fa fa-angle-right arrow"></i></a>
                    <ul class="child-nav" style="display: none;">
                        <li><a href="add-exam.php"><i class="fa fa-bars"></i> <span>Add Exam</span></a></li>
                        <li><a href="manage-exams.php"><i class="fa fa fa-server"></i> <span>Manage Exam</span></a></li>
                    </ul>
                </li>
                <li class="has-children" style = "display:<?php if($loginUser[$user]["permission"] == "superadmin"){echo "block";} else {echo "none";} ?>;">
                    <a><i class="fa fa-users"></i> <span>Students</span> <i class="fa fa-angle-right arrow"></i></a>
                    <ul class="child-nav" style="display: none;">
                        <li><a href="add-students.php"><i class="fa fa-bars"></i> <span>Add Students</span></a></li>
                        <li><a href="manage-student.php"><i class="fa fa fa-server"></i> <span>Manage Students</span></a></li>
                    </ul>
                </li>
                <li class="has-children">
                    <a><i class="fa fa-info-circle"></i> <span>Result</span> <i class="fa fa-angle-right arrow"></i></a>
                    <ul class="child-nav" style="display: none;">
                        <li><a href="add-result.php"><i class="fa fa-bars"></i> <span>Add Result</span></a></li>
                        <li><a href="manage-result.php"><i class="fa fa fa-server"></i> <span>Manage Result</span></a></li>
                        
                    </ul>
                <!-- </li><li><a href="#"><i class="fa fa fa-server"></i> <span> Change Password</span></a></li> -->
            </ul>
        </div>
        <!-- /.sidebar-nav -->
    </div>
</div>