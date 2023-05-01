<?php
require_once('../../authentication/anti_pagetrans.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Generate Reports</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" href="../../../dependencies/bootstrap/css/bootstrap.min.css?<?= time() ?>" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../../../dependencies/datatables/datatables.min.css?<?= time() ?>" />
    <link rel="stylesheet" type="text/css" href="../../../css/sidebar.css?<?= time() ?>">
    <link rel="stylesheet" type="text/css" href="../../../css/header.css?<?= time() ?>">
    <link rel="stylesheet" type="text/css" href="../../../css/body.css?<?= time() ?>">
    <link rel="stylesheet" type="text/css" href="../../../css/print.css?<?= time() ?>">
    <link rel="stylesheet" type="text/css" href="../../../css/admin/adminaccount.css?<?= time() ?>" />
    <link href='../../../dependencies/boxicons/css/boxicons.min.css?<?= time() ?>' rel='stylesheet'>
</head>

<header class="shadow">
    <div class="imgctrl">
    </div>
    <div class="navplace">
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="notification-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color: transparent; border: none;">
                <i class='bx bxs-bell' style='color:#ffffff'></i>
                <span class="icon-button__badge"></span>
            </button>
            <div class="dropdown-menu" aria-labelledby="notification-dropdown">
                <div class="dropdown-header">Notifications</div>
                <div class="dropdown-divider"></div>
                <div class="notification-list"></div>
                <a class="dropdown-item py-1 px-2 text-center mark-as-read" href="#">Mark all as read</a>
            </div>
        </div>

        <script>
            // Get the notification dropdown button and badge
            const notificationDropdown = document.getElementById("notification-dropdown");
            const notificationBadge = notificationDropdown.querySelector(".icon-button__badge");

            // Get the notification list element
            const notificationList = document.querySelector(".notification-list");
            notificationList.style.height = "300px"; // Set a fixed height for the notification
            notificationList.style.overflowY = "auto"; // Enable vertical scrolling
            notificationList.style.width = "500px";
            notificationList.style.position = "relative";

            // Fetch the notifications and update the badge and list
            function fetchNotifications() {
                // Make an AJAX request to fetch the notifications
                var department = "<?php echo $_SESSION['department']; ?>";
                $.ajax({
                    url: "../reservations/functions/notification.php",
                    data: {
                        department: department,
                    },
                    type: 'POST',
                    success: function(data) {
                        var notifications = JSON.parse(data);
                        var len = notifications.length;
                        // Update the badge count
                        notificationBadge.innerText = notifications.length;

                        // Clear the existing list
                        notificationList.innerHTML = "";

                        // Add each notification to the list
                        for (let i = 0; i < notifications.length; i++) {
                            const notification = notifications[i];
                            const notificationItem = document.createElement("div");
                            notificationItem.classList.add("dropdown-item");
                            if (!notification.is_read) {
                                notificationItem.classList.add("unread"); // Add "unread" class if the notification is unread
                            }
                            notificationItem.innerHTML = `
            <div class="d-flex align-items-center">
            <div class="flex-grow-1 notification-message">${notification.message}</div>
            <div class="text-muted notification-date">${new Date(notification.created_at).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' })} ${new Date(notification.created_at).toLocaleTimeString('en-US', { hour: 'numeric', minute: 'numeric', hour12: true })}</div>
            </div>
        `;
                            notificationList.appendChild(notificationItem);
                            if (i < notifications.length - 1) {
                                // Add a divider after each item except the last one
                                const divider = document.createElement("div");
                                divider.classList.add("dropdown-divider");
                                notificationList.appendChild(divider);
                            }
                        }

                        // Add event listeners to the notification items
                        const notificationItems = notificationList.querySelectorAll(".dropdown-item");
                        notificationItems.forEach(item => {
                            item.addEventListener("click", function() {
                                // Remove the "unread" class when the notification is clicked
                                item.classList.remove("unread");
                            });
                        });
                    }
                });
            }

            document.addEventListener("DOMContentLoaded", function() {
                fetchNotifications();
                setInterval(fetchNotifications, 5000);
            });

            const markAsReadButton = document.querySelector(".mark-as-read");

            markAsReadButton.addEventListener("click", function(event) {
                var department = "<?php echo $_SESSION['department']; ?>";
                $.ajax({
                    url: "../reservations/functions/update_notification.php",
                    type: 'POST',
                    data: {
                        department: department,
                    },
                    success: function(data) {
                        var json = JSON.parse(data);
                        var len = json.length;
                        const notificationItems = notificationList.querySelectorAll(".dropdown-item");
                        notificationItems.forEach(item => {
                            item.classList.remove("unread"); // Remove the "unread" class when the notifications are marked as read
                            item.classList.add("read"); // Add the "read" class to mark the notification as read
                        });
                        notificationBadge.innerText = "0";
                    },
                    error: function() {
                        console.log("Error marking notifications as read");
                    }
                });
            });
        </script>
        <p>Hello, <?php echo $_SESSION['department']; ?></p>
    </div>
    <nav class="gnav">
    </nav>
    </div>
</header>

<body onload="fetchNotifications();">
<div class="sidebar">
        <div class="logo_content">
            <div class="logo">
                <img src="../../../images/Black_logo.png" />
            </div>
        </div>
        <div class ="navdiv">
        <ul class="nav_list">
                <li>
                    <a href="../../../php/admin/reservations/admincalendar.php">
                        <i class='bx bx-calendar'></i>
                        <span class="link_name">Calendar of Activities</span>
                    </a>
                </li>
                <li>
                    <a href="../../../php/admin/accounts/admin_account.php">
                        <i class='bx bx-user'></i>
                        <span class="link_name">Account</span>
                    </a>
                </li>
                <li>
                    <div class="dropdown">
                        <i class='bx bx-clipboard' style="margin-left:17px;"></i>
                        <button class="btn dropdown-toggle" style="box-shadow: none;"type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            Create/Manage Request
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="../../../php/admin/jobrequest/minor/minorjobreqlist.php">Minor Job Request</a>
                            <a class="dropdown-item" href="../../../php/admin/jobrequest/major/majorjobreqlist.php">Major Job Request</a>
                            <a class="dropdown-item" href="../../../php/admin/reservations/adminreservations.php">Reservations</a>  
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="../../../php/admin/equipments/adminequipment.php">
                        <i class='bx bx-wrench'></i>
                        <span class="link_name">Facilities Equipment</span>
                    </a>
                </li>
                <li>
                        <a href="../../../php/admin/generatereports/generatereports.php">
                            <i class='bx bx-food-menu'></i>
                            <span class="link_name">Generate Report</span>
                        </a>
                    </li>
            </ul>
            <div class="profile_content">
                <div class="profile">
                    <div class="profile_details">
                        <img src="../../../../images/ico/profileicon.png" alt="" style="height: 45px; width:45px; object-fit:cover; border-radius:12px;" />
                        <div class="name_role">
                            <div class="name"><?php echo mb_strimwidth($_SESSION['department'], 0, 20, '…'); ?></div>
                            <div class="role">System Administrator</div>
                        </div>
                    </div>
                    <a href="../../../../logout.php">
                        <i class='bx bx-log-out' id="log_out"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div id="loading-overlay"></div>
    <style>
        #loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background-color: rgba(255, 255, 255, 0.8);
        /* add additional styles here as needed */
        }
    </style>
    <script>
        window.addEventListener("load", function() {
        var loadingOverlay = document.getElementById("loading-overlay");
        loadingOverlay.style.display = "none";
        });
    </script>
    <!--<script>
        let btn = document.querySelector("#btn");
        let sidebar = document.querySelector(".sidebar");

        btn.onclick = function() {
            sidebar.classList.toggle("active");
        }
    </script>-->
    <!-- Data Table Start-->
    <!--<h1 class="text-center">Faci N Build Test table control</h1>-->
    <div class="table1">
        <div class="container-fluid">
            <div class="row">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 shadow" style="width: 100%; background-color: #FFF; padding-top: 100px; padding-left:50px; padding-right:50px; padding-bottom:50px; overflow-y: scroll; height: 960px;">
                            <div class="row col-md-12 mb-3">
                                <div class="col-md-4 d-flex align-items-center" style="margin-left:10px">
                                    <p class="fw-bold" style="font-size: 2rem;">Generate Reports</p>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-3" onMouseDown="return false;" onSelectStart="return false;">
                                    <input class="form-check-input" type="checkbox" id="minorDivCheckdefault" onclick="myFunction('minorDiv', 'minortable', 'minorfetch.php', 'minordatestart', 'minordateend','selectminordept', 'selectminorsect', 'minorfiltersectionCheck', 'minorfilterdeptCheck')" onchange = "onchangeval('minorDiv', 'minordatestart', 'minordateend', 'minorfiltersectionCheck', 'minorfilterdeptCheck', 'selectminorsect','selectminordept');">
                                    <label class="form-check-label"> Minor Job Request </label>

                                    <br>
                                        <label class="fw-bold" for="date">Date Start:</label>
                                        <input type="date" class="form-control input-sm col-xs-1" id="minordatestart" placeholder="Date Filed" onchange="myFunction('minorDiv', 'minortable', 'minorfetchdate.php','minordatestart','minordateend', 'selectminordept', 'selectminorsect', 'minorfiltersectionCheck', 'minorfilterdeptCheck')" disabled>
                                    
                                    
                                        <label class="fw-bold" for="date">Date End:</label>
                                        <input type="date" class="form-control input-sm col-xs-1" id="minordateend" placeholder="Date Filed" onchange="myFunction('minorDiv', 'minortable', 'minorfetchdate.php','minordatestart','minordateend', 'selectminordept', 'selectminorsect', 'minorfiltersectionCheck', 'minorfilterdeptCheck')" disabled>
                                    
                                </div>
                                <div class="col-md-3">
                                <br>
                                    <input class="form-check-input" type="checkbox" id="minorfiltersectionCheck" onclick="" onchange = "onsectioncheck('minorDiv');"disabled>
                                    <label class="form-check-label" >Filter By Section</label>
                                    
                                    <br>
                                        <select class="form-control input-sm col-xs-1" name="sections" id="selectminorsect" onchange="filterbysection('minorDiv','minortable');" disabled>
                                            <option selected value="" hidden>--Select Section--</option>
                                            <option value="C">CARPENTRY</option>
                                            <option value="P">PLUMBING</option>
                                            <option value="A">AIRCON</option>
                                            <option value="E">ELECTRICAL</option>
                                            <option value="H">HOUSEKEEPING</option>
                                        </select>

                                        <input class="form-check-input" type="checkbox" id="minorfilterdeptCheck" onclick="" onchange = "ondeptcheck('minorDiv');" disabled>
                                        <label class="form-check-label" >Filter By Department</label>

                                    <br>
                                        <select class="form-control input-sm col-xs-1" name="sections" id="selectminordept" onchange="filterbydept('minorDiv','minortable');"disabled>
                                            <option selected value hidden>--Select Department--</option>
                                            <?php include('../../connection/connection.php');
                                                $sql = "SELECT department FROM users WHERE department != 'Administrator'";
                                                $query = mysqli_query($con, $sql);
                                                $i = 1;
                                                while ($row = mysqli_fetch_assoc($query)) {
                                                    echo "<option value=$i>" . $row["department"] . "</option>";
                                                    $i++;
                                                }
                                                ?>
                                        </select>
                                    
                                </div>
                                <div class="col-md-3" onMouseDown="return false;" onSelectStart="return false;">
                                    
                                    
                                </div>
                                <div class="col-md-3" onMouseDown="return false;" onSelectStart="return false;" style="margin-left: -25%;">
                                    <input class="form-check-input" type="checkbox" value="" id="majorDivCheckDefault" onclick="myFunction('majorDiv', 'majortable', 'majorfetch.php', 'majordatestart', 'majordateend','selectmajordept', 'selectmajorsect', 'majorfiltersectionCheck', 'majorfilterdeptCheck')" onchange = "onchangeval('majorDiv', 'majordatestart', 'majordateend', 'majorfiltersectionCheck', 'majorfilterdeptCheck', 'selectmajorsect','selectmajordept');">
                                    <label class="form-check-label" for="majorDivCheckDefault"> Major Job Request </label>
                                    <br>
                                        <label class="fw-bold" for="date">Date Start:</label>
                                        <input type="date" class="form-control input-sm col-xs-1" id="majordatestart" placeholder="Date Filed" onchange="myFunction('majorDiv', 'majortable', 'majorfetchdate.php', 'majordatestart', 'majordateend','selectmajordept', 'selectmajorsect', 'majorfiltersectionCheck', 'majorfilterdeptCheck')" disabled>
                                        <label class="fw-bold" for="date">Date End:</label>
                                        <input type="date" class="form-control input-sm col-xs-1" id="majordateend" placeholder="Date Filed" onchange="myFunction('majorDiv', 'majortable', 'majorfetchdate.php', 'majordatestart', 'majordateend','selectmajordept', 'selectmajorsect', 'majorfiltersectionCheck', 'majorfilterdeptCheck')" disabled>
                                </div>
                                <div class="col-md-3">
                                <br>
                                    <input class="form-check-input" type="checkbox" id="majorfiltersectionCheck" onclick="" onchange = "monsectioncheck('majorDiv');" disabled > 
                                    <label class="form-check-label" for="majorfiltersectionCheck">Filter By Section</label>
                                    
                                    <br>
                                        <select class="form-control input-sm col-xs-1" name="sections" id="selectmajorsect" onchange="mfilterbysection('majorDiv','majortable');" disabled>
                                            <option selected value="" hidden>--Select Section--</option>
                                            <option value="C">CARPENTRY</option>
                                            <option value="P">PLUMBING</option>
                                            <option value="A">AIRCON</option>
                                            <option value="E">ELECTRICAL</option>
                                            <option value="H">HOUSEKEEPING</option>
                                        </select>

                                        <input class="form-check-input" type="checkbox" id="majorfilterdeptCheck" onclick="" onchange = "mondeptcheck('majorDiv');" disabled>
                                        <label class="form-check-label" for="majorfilterdeptCheck">Filter By Department</label>

                                    <br>
                                        <select class="form-control input-sm col-xs-1" name="sections" id="selectmajordept"  onchange="mfilterbydept('majorDiv','majortable');" disabled>
                                            <option selected value hidden>--Select Department--</option>
                                            <?php include('../../connection/connection.php');
                                                $sql = "SELECT department FROM users WHERE department != 'Administrator'";
                                                $query = mysqli_query($con, $sql);
                                                $i = 1;
                                                while ($row = mysqli_fetch_assoc($query)) {
                                                    echo "<option value=$i>" . $row["department"] . "</option>";
                                                    $i++;
                                                }
                                                ?>
                                        </select>
                                    
                                </div>
                            </div>
                            
                            <br>
                            <div class="col-md-2">
                                <button class="btn btn-info" onclick="printDiv()">Print</button>
                            </div>

                            <div class="row" id="headerDiv" style="display: none;">
                                <div class="col-md-1 float-start">
                                    <img style="position: relative; left:" src='../../../../images/uclogo.png' alt='' width='75' height='50' />
                                </div>   
                                <div class="col-md-3">
                                    <h1 class="fw-bold form-check-label" style="padding-left: 100px; position: relative; left:">Generate Reports </h1>
                                </div>     
                            </div>
                            <div id="catch" style="display: none;">
                                <label class="fw-bold">ㅤ</label>
                            </div>
                            <div class="row" id="minorDiv" style=" position:relative; display: none;">
                            <table id="minortable" class="table" width="100%">
                                <thead>
                                <tr>
                                    <th colspan="9">
                                    <label class="fw-bold">Minor Job Request</label>
                                    </th>
                                </tr>
                                <tr>
                                    <th>ID</th>
                                    <th>Department</th>
                                    <th>Section</th>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Purpose</th>
                                    <th>Date Rendered</th>
                                    <th>Date Confirmed</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                            </table>
                            </div>

                            <div id="majorDiv" style="display: none;">
                            <table id="majortable" class="table" width="100%">
                                <thead>
                                <tr>
                                    <th colspan="10">
                                    <label class="fw-bold">Major Job Request</label>
                                    </th>
                                </tr>
                                <tr>
                                    <th>Job Request no.</th>
                                    <th>Requisition no.</th>
                                    <th>Department</th>
                                    <th>Quantity</th>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Section</th>
                                    <th>Purpose</th>
                                    <th>Outsource</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                            </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function printDiv() {
            var minorChecked = document.getElementById("minorDivCheckdefault").checked;
            var majorChecked = document.getElementById("majorDivCheckDefault").checked;
            var header = document.getElementById("headerDiv").checked;
            var catcher = document.getElementById("catch").checked;

            if (minorChecked || majorChecked) {
                var printContents = "";
                var header = "";

                if (majorChecked && !minorChecked) {
                    header = document.getElementById("headerDiv").innerHTML;
                    printContents += "<div style='position: relative; left: -200px; margin-bottom: 50px;'>" + header + document.getElementById("catch").innerHTML + document.getElementById("majorDiv").innerHTML + "</div>";
                } else if (minorChecked && !majorChecked) {
                    header = document.getElementById("headerDiv").innerHTML;
                    printContents += "<div style='position: relative; left: -200px; margin-bottom: 50px;'>" + header + document.getElementById("catch").innerHTML + document.getElementById("minorDiv").innerHTML + "</div>";
                } else if (minorChecked && majorChecked) {
                    header = document.getElementById("headerDiv").innerHTML;
                    printContents += "<div style='position: relative; left: -200px; margin-bottom: 50px;'>" + header + document.getElementById("catch").innerHTML + document.getElementById("minorDiv").innerHTML + document.getElementById("majorDiv").innerHTML + "</div>";
                }

                var originalContents = document.body.innerHTML;
                document.body.innerHTML = printContents;
                window.print();
                document.body.innerHTML = originalContents;
                window.location.reload();
            } else {
                alert("Please select at least one checkbox before printing.");
            }
        }
    </script>
    <!-- Data Table End-->

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <!-- Script Process Start-->
    <script src="../../../dependencies/jquery/jquery-3.6.4.min.js"></script>
    <script type="text/javascript" src="../../../dependencies/datatables/datatables.min.js"></script>
    <script src="../../../dependencies/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>

        // minor functions start
        function onchangeval(divID, datestart, dateend, minorsectchk, minordeptchk, minorsectsel, minordeptsel)
        {   
           
            var dates = document.getElementById(datestart);
            var datee = document.getElementById(dateend);
            var sectchkbox = document.getElementById(minorsectchk);
            var deptchkbox = document.getElementById(minordeptchk);
            var f = document.getElementById(minorsectsel);
            var e = document.getElementById(minordeptsel);
            dates.value = null;
            datee.value = null;
            
            var x = document.getElementById(divID);
            if(divID == 'minorDiv' || divID == 'majorDiv')
            {
                
                if (x.style.display === "block") {
                    x.style.display = "none";
                    dates.disabled = true;
                    datee.disabled = true;
                    sectchkbox.disabled = true;
                    deptchkbox.disabled = true;
                    sectchkbox.checked = false;
                    deptchkbox.checked = false;
                    dates.value = null;
                    datee.value = null;
                    f.disabled = true;
                    e.disabled = true;
                    
                } else {
                    x.style.display = "block";
                    dates.disabled = false;
                    datee.disabled = false;
                    sectchkbox.disabled = false;
                    deptchkbox.disabled = false;
                    sectchkbox.checked = false;
                    deptchkbox.checked = false;
                

                }
            }


            
        }
        function filterbydept(divID, tableid)
        {
                var e = document.getElementById("selectminordept");
                var filterdeptval = e.options[e.selectedIndex].text;
                var f = document.getElementById("selectminorsect");
                var filtersectval = f.options[f.selectedIndex].text;
                var sectselchk = document.getElementById("minorfiltersectionCheck");
                var deptselchk = document.getElementById("minorfilterdeptCheck");
                var tid = tableid;

                if(filtersectval == '--Select Section--')
                {
                    if(divID == "minorDiv")
                    {
                        
                        var dates = document.getElementById("minordatestart").value;
                        var datee = document.getElementById("minordateend").value;
                        console.log(dates);
                        console.log(datee);
                        if(dates == '' || datee == '' || dates == null || datee == null)
                        {
                            console.log("line executed");
                            $('#' + tid).DataTable().clear().destroy();
                            $('#' + tid).DataTable({
                            'searching': false,
                            'serverSide': true,
                            'processing': true,
                            'autoWidth': true,
                            'paging': false,
                            'info': false,
                            'order': [],
                            'ajax': {
                                'url': 'filterdeptfetch.php',
                                'type': 'post',
                                'data':{
                                    department:filterdeptval,
                                },
                            },
                            'fnCreatedRow': function(nRow, aData, iDataIndex) {
                                $(nRow).attr('id', aData[0]);
                            },
                            'columnDefs': [{
                                    'target': [0, 4],
                                    'orderable': false,
                                },
                                {
                                    'width': '5%',
                                    'targets': 0
                                }, // set 30% width for first column
                                {
                                    'width': '5%',
                                    'targets': 2
                                },
                                {
                                    'width': '7%',
                                    'targets': 3
                                },
                                {
                                    'width': '5%',
                                    'targets': 6
                                },
                                {
                                    'width': '5%',
                                    'targets': 7
                                },
                            ],
                            scrollCollapse: false,
                            paging: false
                        });
                        }
                        else
                        {
                            console.log("line2 executed");
                            $('#' + tid).DataTable().clear().destroy();
                            $('#' + tid).DataTable({
                            'searching': false,
                            'serverSide': true,
                            'processing': true,
                            'autoWidth': true,
                            'paging': false,
                            'info': false,
                            'order': [],
                            'ajax': {
                                'url': 'filterdeptwdate.php',
                                'type': 'post',
                                'data':{
                                    department:filterdeptval,
                                    datestart:dates,
                                    dateend:datee,

                                },
                            },
                            'fnCreatedRow': function(nRow, aData, iDataIndex) {
                                $(nRow).attr('id', aData[0]);
                            },
                            'columnDefs': [{
                                    'target': [0, 4],
                                    'orderable': false,
                                },
                                {
                                    'width': '5%',
                                    'targets': 0
                                }, // set 30% width for first column
                                {
                                    'width': '5%',
                                    'targets': 2
                                },
                                {
                                    'width': '7%',
                                    'targets': 3
                                },
                                {
                                    'width': '5%',
                                    'targets': 6
                                },
                                {
                                    'width': '5%',
                                    'targets': 7
                                },
                            ],
                            scrollCollapse: false,
                            paging: false
                        });
                        }
                    }
                }
                else
                {
                    if(divID == "minorDiv")
                        {       
                        var dates = document.getElementById("minordatestart").value;
                        var datee = document.getElementById("minordateend").value;
                        console.log(dates);
                        console.log(datee);
                        if(dates == '' || datee == '' || dates == null || datee == null)
                        {
                            console.log("line executed");
                            $('#' + tid).DataTable().clear().destroy();
                            $('#' + tid).DataTable({
                            'searching': false,
                            'serverSide': true,
                            'processing': true,
                            'autoWidth': true,
                            'paging': false,
                            'info': false,
                            'order': [],
                            'ajax': {
                                'url': 'filtersectdeptfetch.php',
                                'type': 'post',
                                'data':{
                                    section:filtersectval,
                                    department: filterdeptval,
                                },
                            },
                            'fnCreatedRow': function(nRow, aData, iDataIndex) {
                                $(nRow).attr('id', aData[0]);
                            },
                            'columnDefs': [{
                                    'target': [0, 4],
                                    'orderable': false,
                                },
                                {
                                    'width': '5%',
                                    'targets': 0
                                }, // set 30% width for first column
                                {
                                    'width': '5%',
                                    'targets': 2
                                },
                                {
                                    'width': '7%',
                                    'targets': 3
                                },
                                {
                                    'width': '5%',
                                    'targets': 6
                                },
                                {
                                    'width': '5%',
                                    'targets': 7
                                },
                            ],
                            scrollCollapse: false,
                            paging: false
                        });
                        }
                        else
                        {
                            console.log("line2 executed");
                            $('#' + tid).DataTable().clear().destroy();
                            $('#' + tid).DataTable({
                            'searching': false,
                            'serverSide': true,
                            'processing': true,
                            'autoWidth': true,
                            'paging': false,
                            'info': false,
                            'order': [],
                            'ajax': {
                                'url': 'filtersectwdeptdate.php',
                                'type': 'post',
                                'data':{
                                    section:filtersectval,
                                    department: filterdeptval,
                                    datestart:dates,
                                    dateend:datee,

                                },
                            },
                            'fnCreatedRow': function(nRow, aData, iDataIndex) {
                                $(nRow).attr('id', aData[0]);
                            },
                            'columnDefs': [{
                                    'target': [0, 4],
                                    'orderable': false,
                                },
                                {
                                    'width': '5%',
                                    'targets': 0
                                }, // set 30% width for first column
                                {
                                    'width': '5%',
                                    'targets': 2
                                },
                                {
                                    'width': '7%',
                                    'targets': 3
                                },
                                {
                                    'width': '5%',
                                    'targets': 6
                                },
                                {
                                    'width': '5%',
                                    'targets': 7
                                },
                            ],
                            scrollCollapse: false,
                            paging: false
                        });
                        }
                       
                    }
                }
                if ((dates !== undefined && dates !== null && dates !== '') ||
                        (datee !== undefined && datee !== null && datee !== '')) 
                        {

                            if (sectselchk.checked && deptselchk.checked) {
                                console.log("line2 executed");
                                    $('#' + tid).DataTable().clear().destroy();
                                    $('#' + tid).DataTable({
                                    'searching': false,
                                    'serverSide': true,
                                    'processing': true,
                                    'autoWidth': true,
                                    'paging': false,
                                    'info': false,
                                    'order': [],
                                    'ajax': {
                                        'url': 'filtersectwdeptdate.php',
                                        'type': 'post',
                                        'data':{
                                            section:filtersectval,
                                            department: filterdeptval,
                                            datestart:dates,
                                            dateend:datee,

                                        },
                                    },
                                    'fnCreatedRow': function(nRow, aData, iDataIndex) {
                                        $(nRow).attr('id', aData[0]);
                                    },
                                    'columnDefs': [{
                                            'target': [0, 4],
                                            'orderable': false,
                                        },
                                        {
                                            'width': '5%',
                                            'targets': 0
                                        }, // set 30% width for first column
                                        {
                                            'width': '5%',
                                            'targets': 2
                                        },
                                        {
                                            'width': '7%',
                                            'targets': 3
                                        },
                                        {
                                            'width': '5%',
                                            'targets': 6
                                        },
                                        {
                                            'width': '5%',
                                            'targets': 7
                                        },
                                    ],
                                    scrollCollapse: false,
                                    paging: false
                                });
                            }

                                if (!sectselchk.checked && deptselchk.checked) {
                                    $('#' + tid).DataTable().clear().destroy();
                                        $('#' + tid).DataTable({
                                        'searching': false,
                                        'serverSide': true,
                                        'processing': true,
                                        'autoWidth': true,
                                        'paging': false,
                                        'info': false,
                                        'order': [],
                                        'ajax': {
                                            'url': 'filterdeptwdate.php',
                                            'type': 'post',
                                            'data':{
                                                department:filterdeptval,
                                                datestart:dates,
                                                dateend:datee,

                                            },
                                        },
                                        'fnCreatedRow': function(nRow, aData, iDataIndex) {
                                            $(nRow).attr('id', aData[0]);
                                        },
                                        'columnDefs': [{
                                                'target': [0, 4],
                                                'orderable': false,
                                            },
                                            {
                                                'width': '5%',
                                                'targets': 0
                                            }, // set 30% width for first column
                                            {
                                                'width': '5%',
                                                'targets': 2
                                            },
                                            {
                                                'width': '7%',
                                                'targets': 3
                                            },
                                            {
                                                'width': '5%',
                                                'targets': 6
                                            },
                                            {
                                                'width': '5%',
                                                'targets': 7
                                            },
                                        ],
                                        scrollCollapse: false,
                                        paging: false
                                    }); 
                                }
                                if (sectselchk.checked && !deptselchk.checked) {
                                    $('#' + tid).DataTable().clear().destroy();
                                        $('#minortable').DataTable({
                                        'searching': false,
                                        'serverSide': true,
                                        'processing': true,
                                        'autoWidth': true,
                                        'paging': false,
                                        'info': false,
                                        'order': [],
                                        'ajax': {
                                            'url': 'filtersectwdate.php',
                                            'type': 'post',
                                            'data':{
                                                section:filtersectval,
                                                datestart:dates,
                                                dateend:datee,

                                            },
                                        },
                                        'fnCreatedRow': function(nRow, aData, iDataIndex) {
                                            $(nRow).attr('id', aData[0]);
                                        },
                                        'columnDefs': [{
                                                'target': [0, 4],
                                                'orderable': false,
                                            },
                                            {
                                                'width': '5%',
                                                'targets': 0
                                            }, // set 30% width for first column
                                            {
                                                'width': '5%',
                                                'targets': 2
                                            },
                                            {
                                                'width': '7%',
                                                'targets': 3
                                            },
                                            {
                                                'width': '5%',
                                                'targets': 6
                                            },
                                            {
                                                'width': '5%',
                                                'targets': 7
                                            },
                                        ],
                                        scrollCollapse: false,
                                        paging: false
                                    });
                                }
                        }
                        if ((dates == undefined && dates == null && dates == '') ||
                            (datee == undefined && datee == null && datee == '')) {
                            if(sectselchk.checked && deptselchk.checked) {
                                $('#' + tid).DataTable().clear().destroy();
                                    $('#' + tid).DataTable({
                                    'searching': false,
                                    'serverSide': true,
                                    'processing': true,
                                    'autoWidth': true,
                                    'paging': false,
                                    'info': false,
                                    'order': [],
                                    'ajax': {
                                        'url': 'filtersectdeptfetch.php',
                                        'type': 'post',
                                        'data':{
                                            section:filtersectval,
                                            department: filterdeptval,
                                        },
                                    },
                                    'fnCreatedRow': function(nRow, aData, iDataIndex) {
                                        $(nRow).attr('id', aData[0]);
                                    },
                                    'columnDefs': [{
                                            'target': [0, 4],
                                            'orderable': false,
                                        },
                                        {
                                            'width': '5%',
                                            'targets': 0
                                        }, // set 30% width for first column
                                        {
                                            'width': '5%',
                                            'targets': 2
                                        },
                                        {
                                            'width': '7%',
                                            'targets': 3
                                        },
                                        {
                                            'width': '5%',
                                            'targets': 6
                                        },
                                        {
                                            'width': '5%',
                                            'targets': 7
                                        },
                                    ],
                                    scrollCollapse: false,
                                    paging: false
                                });
                            }
                            if(!sectselchk.checked && deptselchk.checked){
                                $('#' + tid).DataTable().clear().destroy();
                                    $('#' + tid).DataTable({
                                    'searching': false,
                                    'serverSide': true,
                                    'processing': true,
                                    'autoWidth': true,
                                    'paging': false,
                                    'info': false,
                                    'order': [],
                                    'ajax': {
                                        'url': 'filterdeptfetch.php',
                                        'type': 'post',
                                        'data':{
                                            department:filterdeptval,
                                        },
                                    },
                                    'fnCreatedRow': function(nRow, aData, iDataIndex) {
                                        $(nRow).attr('id', aData[0]);
                                    },
                                    'columnDefs': [{
                                            'target': [0, 4],
                                            'orderable': false,
                                        },
                                        {
                                            'width': '5%',
                                            'targets': 0
                                        }, // set 30% width for first column
                                        {
                                            'width': '5%',
                                            'targets': 2
                                        },
                                        {
                                            'width': '7%',
                                            'targets': 3
                                        },
                                        {
                                            'width': '5%',
                                            'targets': 6
                                        },
                                        {
                                            'width': '5%',
                                            'targets': 7
                                        },
                                    ],
                                    scrollCollapse: false,
                                    paging: false
                                });
                            }
                            if(sectselchk.checked && !deptselchk.checked)
                            {
                                $('#' + tid).DataTable().clear().destroy();
                                    $('#' + tid).DataTable({
                                    'searching': false,
                                    'serverSide': true,
                                    'processing': true,
                                    'autoWidth': true,
                                    'paging': false,
                                    'info': false,
                                    'order': [],
                                    'ajax': {
                                        'url': 'filtersectfetch.php',
                                        'type': 'post',
                                        'data':{
                                            section:filtersectval,
                                        },
                                    },
                                    'fnCreatedRow': function(nRow, aData, iDataIndex) {
                                        $(nRow).attr('id', aData[0]);
                                    },
                                    'columnDefs': [{
                                            'target': [0, 4],
                                            'orderable': false,
                                        },
                                        {
                                            'width': '5%',
                                            'targets': 0
                                        }, // set 30% width for first column
                                        {
                                            'width': '5%',
                                            'targets': 2
                                        },
                                        {
                                            'width': '7%',
                                            'targets': 3
                                        },
                                        {
                                            'width': '5%',
                                            'targets': 6
                                        },
                                        {
                                            'width': '5%',
                                            'targets': 7
                                        },
                                    ],
                                    scrollCollapse: false,
                                    paging: false
                                });
                            }

                        }     
        }
            
        function filterbysection(divID, tableid)
        {
                var e = document.getElementById("selectminordept");
                var filterdeptval = e.options[e.selectedIndex].text;
                var f = document.getElementById("selectminorsect");
                var filtersectval = f.options[f.selectedIndex].text;
                var sectselchk = document.getElementById("minorfiltersectionCheck");
                var deptselchk = document.getElementById("minorfilterdeptCheck");
                var tid = tableid;

                if(filterdeptval == '--Select Department--')
                {
                    if(divID == "minorDiv")
                    {       
                    var dates = document.getElementById("minordatestart").value;
                    var datee = document.getElementById("minordateend").value;
                    console.log(dates);
                    console.log(datee);
                    if(dates == '' || datee == '' || dates == null || datee == null)
                    {
                        console.log("line executed");
                        $('#' + tid).DataTable().clear().destroy();
                        $('#' + tid).DataTable({
                        'searching': false,
                        'serverSide': true,
                        'processing': true,
                        'autoWidth': true,
                        'paging': false,
                        'info': false,
                        'order': [],
                        'ajax': {
                            'url': 'filtersectfetch.php',
                            'type': 'post',
                            'data':{
                                section:filtersectval,
                            },
                        },
                        'fnCreatedRow': function(nRow, aData, iDataIndex) {
                            $(nRow).attr('id', aData[0]);
                        },
                        'columnDefs': [{
                                'target': [0, 4],
                                'orderable': false,
                            },
                            {
                                'width': '5%',
                                'targets': 0
                            }, // set 30% width for first column
                            {
                                'width': '5%',
                                'targets': 2
                            },
                            {
                                'width': '7%',
                                'targets': 3
                            },
                            {
                                'width': '5%',
                                'targets': 6
                            },
                            {
                                'width': '5%',
                                'targets': 7
                            },
                        ],
                        scrollCollapse: false,
                        paging: false
                    });
                    }
                    else
                    {
                        console.log("line2 executed");
                        $('#' + tid).DataTable().clear().destroy();
                        $('#' + tid).DataTable({
                        'searching': false,
                        'serverSide': true,
                        'processing': true,
                        'autoWidth': true,
                        'paging': false,
                        'info': false,
                        'order': [],
                        'ajax': {
                            'url': 'filtersectwdate.php',
                            'type': 'post',
                            'data':{
                                section:filtersectval,
                                datestart:dates,
                                dateend:datee,

                            },
                        },
                        'fnCreatedRow': function(nRow, aData, iDataIndex) {
                            $(nRow).attr('id', aData[0]);
                        },
                        'columnDefs': [{
                                'target': [0, 4],
                                'orderable': false,
                            },
                            {
                                'width': '5%',
                                'targets': 0
                            }, // set 30% width for first column
                            {
                                'width': '5%',
                                'targets': 2
                            },
                            {
                                'width': '7%',
                                'targets': 3
                            },
                            {
                                'width': '5%',
                                'targets': 6
                            },
                            {
                                'width': '5%',
                                'targets': 7
                            },
                        ],
                        scrollCollapse: false,
                        paging: false
                    });
                    }
                    
                    }
                }
                else{
                        if(divID == "minorDiv")
                        {       
                        var dates = document.getElementById("minordatestart").value;
                        var datee = document.getElementById("minordateend").value;
                        console.log(dates);
                        console.log(datee);
                        if(dates == '' || datee == '' || dates == null || datee == null)
                        {
                            console.log("line executed");
                            $('#' + tid).DataTable().clear().destroy();
                            $('#' + tid).DataTable({
                            'searching': false,
                            'serverSide': true,
                            'processing': true,
                            'autoWidth': true,
                            'paging': false,
                            'info': false,
                            'order': [],
                            'ajax': {
                                'url': 'filtersectdeptfetch.php',
                                'type': 'post',
                                'data':{
                                    section:filtersectval,
                                    department: filterdeptval,
                                },
                            },
                            'fnCreatedRow': function(nRow, aData, iDataIndex) {
                                $(nRow).attr('id', aData[0]);
                            },
                            'columnDefs': [{
                                    'target': [0, 4],
                                    'orderable': false,
                                },
                                {
                                    'width': '5%',
                                    'targets': 0
                                }, // set 30% width for first column
                                {
                                    'width': '5%',
                                    'targets': 2
                                },
                                {
                                    'width': '7%',
                                    'targets': 3
                                },
                                {
                                    'width': '5%',
                                    'targets': 6
                                },
                                {
                                    'width': '5%',
                                    'targets': 7
                                },
                            ],
                            scrollCollapse: false,
                            paging: false
                        });
                        }
                        else
                        {
                            console.log("line2 executed");
                            $('#' + tid).DataTable().clear().destroy();
                            $('#' + tid).DataTable({
                            'searching': false,
                            'serverSide': true,
                            'processing': true,
                            'autoWidth': true,
                            'paging': false,
                            'info': false,
                            'order': [],
                            'ajax': {
                                'url': 'filtersectwdeptdate.php',
                                'type': 'post',
                                'data':{
                                    section:filtersectval,
                                    department: filterdeptval,
                                    datestart:dates,
                                    dateend:datee,

                                },
                            },
                            'fnCreatedRow': function(nRow, aData, iDataIndex) {
                                $(nRow).attr('id', aData[0]);
                            },
                            'columnDefs': [{
                                    'target': [0, 4],
                                    'orderable': false,
                                },
                                {
                                    'width': '5%',
                                    'targets': 0
                                }, // set 30% width for first column
                                {
                                    'width': '5%',
                                    'targets': 2
                                },
                                {
                                    'width': '7%',
                                    'targets': 3
                                },
                                {
                                    'width': '5%',
                                    'targets': 6
                                },
                                {
                                    'width': '5%',
                                    'targets': 7
                                },
                            ],
                            scrollCollapse: false,
                            paging: false
                        });
                        }
                       
                    }

                }

                if ((dates !== undefined && dates !== null && dates !== '') ||
                        (datee !== undefined && datee !== null && datee !== '')) 
                    {

                        if (sectselchk.checked && deptselchk.checked) {
                            console.log("line2 executed");
                                $('#' + tid).DataTable().clear().destroy();
                                $('#' + tid).DataTable({
                                'searching': false,
                                'serverSide': true,
                                'processing': true,
                                'autoWidth': true,
                                'paging': false,
                                'info': false,
                                'order': [],
                                'ajax': {
                                    'url': 'filtersectwdeptdate.php',
                                    'type': 'post',
                                    'data':{
                                        section:filtersectval,
                                        department: filterdeptval,
                                        datestart:dates,
                                        dateend:datee,

                                    },
                                },
                                'fnCreatedRow': function(nRow, aData, iDataIndex) {
                                    $(nRow).attr('id', aData[0]);
                                },
                                'columnDefs': [{
                                        'target': [0, 4],
                                        'orderable': false,
                                    },
                                    {
                                        'width': '5%',
                                        'targets': 0
                                    }, // set 30% width for first column
                                    {
                                        'width': '5%',
                                        'targets': 2
                                    },
                                    {
                                        'width': '7%',
                                        'targets': 3
                                    },
                                    {
                                        'width': '5%',
                                        'targets': 6
                                    },
                                    {
                                        'width': '5%',
                                        'targets': 7
                                    },
                                ],
                                scrollCollapse: false,
                                paging: false
                            });
                        }

                            if (!sectselchk.checked && deptselchk.checked) {
                                $('#' + tid).DataTable().clear().destroy();
                                    $('#' + tid).DataTable({
                                    'searching': false,
                                    'serverSide': true,
                                    'processing': true,
                                    'autoWidth': true,
                                    'paging': false,
                                    'info': false,
                                    'order': [],
                                    'ajax': {
                                        'url': 'filterdeptwdate.php',
                                        'type': 'post',
                                        'data':{
                                            department:filterdeptval,
                                            datestart:dates,
                                            dateend:datee,

                                        },
                                    },
                                    'fnCreatedRow': function(nRow, aData, iDataIndex) {
                                        $(nRow).attr('id', aData[0]);
                                    },
                                    'columnDefs': [{
                                            'target': [0, 4],
                                            'orderable': false,
                                        },
                                        {
                                            'width': '5%',
                                            'targets': 0
                                        }, // set 30% width for first column
                                        {
                                            'width': '5%',
                                            'targets': 2
                                        },
                                        {
                                            'width': '7%',
                                            'targets': 3
                                        },
                                        {
                                            'width': '5%',
                                            'targets': 6
                                        },
                                        {
                                            'width': '5%',
                                            'targets': 7
                                        },
                                    ],
                                    scrollCollapse: false,
                                    paging: false
                                }); 
                            }
                            if (sectselchk.checked && !deptselchk.checked) {
                                $('#' + tid).DataTable().clear().destroy();
                                    $('#minortable').DataTable({
                                    'searching': false,
                                    'serverSide': true,
                                    'processing': true,
                                    'autoWidth': true,
                                    'paging': false,
                                    'info': false,
                                    'order': [],
                                    'ajax': {
                                        'url': 'filtersectwdate.php',
                                        'type': 'post',
                                        'data':{
                                            section:filtersectval,
                                            datestart:dates,
                                            dateend:datee,

                                        },
                                    },
                                    'fnCreatedRow': function(nRow, aData, iDataIndex) {
                                        $(nRow).attr('id', aData[0]);
                                    },
                                    'columnDefs': [{
                                            'target': [0, 4],
                                            'orderable': false,
                                        },
                                        {
                                            'width': '5%',
                                            'targets': 0
                                        }, // set 30% width for first column
                                        {
                                            'width': '5%',
                                            'targets': 2
                                        },
                                        {
                                            'width': '7%',
                                            'targets': 3
                                        },
                                        {
                                            'width': '5%',
                                            'targets': 6
                                        },
                                        {
                                            'width': '5%',
                                            'targets': 7
                                        },
                                    ],
                                    scrollCollapse: false,
                                    paging: false
                                });
                            }
                    }
                    if ((dates == undefined && dates == null && dates == '') ||
                        (datee == undefined && datee == null && datee == '')) {
                        if(sectselchk.checked && deptselchk.checked) {
                            $('#' + tid).DataTable().clear().destroy();
                                $('#' + tid).DataTable({
                                'searching': false,
                                'serverSide': true,
                                'processing': true,
                                'autoWidth': true,
                                'paging': false,
                                'info': false,
                                'order': [],
                                'ajax': {
                                    'url': 'filtersectdeptfetch.php',
                                    'type': 'post',
                                    'data':{
                                        section:filtersectval,
                                        department: filterdeptval,
                                    },
                                },
                                'fnCreatedRow': function(nRow, aData, iDataIndex) {
                                    $(nRow).attr('id', aData[0]);
                                },
                                'columnDefs': [{
                                        'target': [0, 4],
                                        'orderable': false,
                                    },
                                    {
                                        'width': '5%',
                                        'targets': 0
                                    }, // set 30% width for first column
                                    {
                                        'width': '5%',
                                        'targets': 2
                                    },
                                    {
                                        'width': '7%',
                                        'targets': 3
                                    },
                                    {
                                        'width': '5%',
                                        'targets': 6
                                    },
                                    {
                                        'width': '5%',
                                        'targets': 7
                                    },
                                ],
                                scrollCollapse: false,
                                paging: false
                            });
                        }
                        if(!sectselchk.checked && deptselchk.checked){
                            $('#' + tid).DataTable().clear().destroy();
                                $('#' + tid).DataTable({
                                'searching': false,
                                'serverSide': true,
                                'processing': true,
                                'autoWidth': true,
                                'paging': false,
                                'info': false,
                                'order': [],
                                'ajax': {
                                    'url': 'filterdeptfetch.php',
                                    'type': 'post',
                                    'data':{
                                        department:filterdeptval,
                                    },
                                },
                                'fnCreatedRow': function(nRow, aData, iDataIndex) {
                                    $(nRow).attr('id', aData[0]);
                                },
                                'columnDefs': [{
                                        'target': [0, 4],
                                        'orderable': false,
                                    },
                                    {
                                        'width': '5%',
                                        'targets': 0
                                    }, // set 30% width for first column
                                    {
                                        'width': '5%',
                                        'targets': 2
                                    },
                                    {
                                        'width': '7%',
                                        'targets': 3
                                    },
                                    {
                                        'width': '5%',
                                        'targets': 6
                                    },
                                    {
                                        'width': '5%',
                                        'targets': 7
                                    },
                                ],
                                scrollCollapse: false,
                                paging: false
                            });
                        }
                        if(sectselchk.checked && !deptselchk.checked)
                        {
                            $('#' + tid).DataTable().clear().destroy();
                                $('#' + tid).DataTable({
                                'searching': false,
                                'serverSide': true,
                                'processing': true,
                                'autoWidth': true,
                                'paging': false,
                                'info': false,
                                'order': [],
                                'ajax': {
                                    'url': 'filtersectfetch.php',
                                    'type': 'post',
                                    'data':{
                                        section:filtersectval,
                                    },
                                },
                                'fnCreatedRow': function(nRow, aData, iDataIndex) {
                                    $(nRow).attr('id', aData[0]);
                                },
                                'columnDefs': [{
                                        'target': [0, 4],
                                        'orderable': false,
                                    },
                                    {
                                        'width': '5%',
                                        'targets': 0
                                    }, // set 30% width for first column
                                    {
                                        'width': '5%',
                                        'targets': 2
                                    },
                                    {
                                        'width': '7%',
                                        'targets': 3
                                    },
                                    {
                                        'width': '5%',
                                        'targets': 6
                                    },
                                    {
                                        'width': '5%',
                                        'targets': 7
                                    },
                                ],
                                scrollCollapse: false,
                                paging: false
                            });
                        }

                    }

                
        }
        function onsectioncheck(divID)
        {
                var e = document.getElementById("selectminorsect");
                var filtersectval = e.options[e.selectedIndex].text;
                var sectselchk = document.getElementById("minorfiltersectionCheck");
                var sectsel = document.getElementById("selectminorsect");
                var dates = document.getElementById("minordatestart").value;
                var datee = document.getElementById("minordateend").value;
                var e = document.getElementById("selectminordept");
                var filterdeptval = e.options[e.selectedIndex].text;
                var option = document.createElement("option");
                option.text = '--Select Section--';
                option.hidden = true;
                option.disabled = true;
                option.selected = true;
                sectsel.add(option);
                if (!sectselchk.checked) {
                    sectsel.disabled = true;
                    console.log("else executed");
                    if(filterdeptval == '--Select Department--' && filtersectval == '--Select Section--')
                    {                   
                        if(dates == '' || datee == '' || dates == null || datee == null)
                        {
                            $('#minortable').DataTable().clear().destroy();
                            $('#minortable').DataTable({
                            'searching': false,
                            'serverSide': true,
                            'processing': true,
                            'autoWidth': true,
                            'paging': false,
                            'info': false,
                            'order': [],
                            'ajax': {
                                'url': 'minorfetch.php',
                                'type': 'post',
                            },
                            'fnCreatedRow': function(nRow, aData, iDataIndex) {
                                $(nRow).attr('id', aData[0]);
                            },
                            'columnDefs': [{
                                    'target': [0, 4],
                                    'orderable': false,
                                },
                                {
                                    'width': '5%',
                                    'targets': 0
                                }, // set 30% width for first column
                                {
                                    'width': '5%',
                                    'targets': 2
                                },
                                {
                                    'width': '7%',
                                    'targets': 3
                                },
                                {
                                    'width': '5%',
                                    'targets': 6
                                },
                                {
                                    'width': '5%',
                                    'targets': 7
                                },
                            ],
                            scrollCollapse: false,
                            paging: false
                        });
                        }   
                    }

                    if(filtersectval != '--Select Section--' &&  filterdeptval == '--Select Department--')
                {
                        $('#minortable').DataTable().clear().destroy();
                        $('#minortable').DataTable({
                        'searching': false,
                        'serverSide': true,
                        'processing': true,
                        'autoWidth': true,
                        'paging': false,
                        'info': false,
                        'order': [],
                        'ajax': {
                            'url': 'filtersectwdate.php',
                            'type': 'post',
                            'data':{
                                section:filtersectval,
                                datestart:dates,
                                dateend:datee,

                            },
                        },
                        'fnCreatedRow': function(nRow, aData, iDataIndex) {
                            $(nRow).attr('id', aData[0]);
                        },
                        'columnDefs': [{
                                'target': [0, 4],
                                'orderable': false,
                            },
                            {
                                'width': '5%',
                                'targets': 0
                            }, // set 30% width for first column
                            {
                                'width': '5%',
                                'targets': 2
                            },
                            {
                                'width': '7%',
                                'targets': 3
                            },
                            {
                                'width': '5%',
                                'targets': 6
                            },
                            {
                                'width': '5%',
                                'targets': 7
                            },
                        ],
                        scrollCollapse: false,
                        paging: false
                    });
                }
                if(!sectselchk.checked &&  filterdeptval != '--Select Department--')
                {
                        $('#minortable').DataTable().clear().destroy();
                        $('#minortable').DataTable({
                        'searching': false,
                        'serverSide': true,
                        'processing': true,
                        'autoWidth': true,
                        'paging': false,
                        'info': false,
                        'order': [],
                        'ajax': {
                            'url': 'filterdeptwdate.php',
                            'type': 'post',
                            'data':{
                                department:filterdeptval,
                                datestart:dates,
                                dateend:datee,

                            },
                        },
                        'fnCreatedRow': function(nRow, aData, iDataIndex) {
                            $(nRow).attr('id', aData[0]);
                        },
                        'columnDefs': [{
                                'target': [0, 4],
                                'orderable': false,
                            },
                            {
                                'width': '5%',
                                'targets': 0
                            }, // set 30% width for first column
                            {
                                'width': '5%',
                                'targets': 2
                            },
                            {
                                'width': '7%',
                                'targets': 3
                            },
                            {
                                'width': '5%',
                                'targets': 6
                            },
                            {
                                'width': '5%',
                                'targets': 7
                            },
                        ],
                        scrollCollapse: false,
                        paging: false
                    });
                }
                } 
                else{
                    sectsel.disabled = false;

                    if(dates == '' || datee == '' || dates == null || datee == null)
                        {
                            if(divID == "minorDiv")

                            {
                                console.log("line executed");
                                    $('#minortable').DataTable().clear().destroy();
                                    $('#minortable').DataTable({
                                    'searching': false,
                                    'serverSide': true,
                                    'processing': true,
                                    'autoWidth': true,
                                    'paging': false,
                                    'info': false,
                                    'order': [],
                                    'ajax': {
                                        'url': 'filtersectfetch.php',
                                        'type': 'post',
                                        'data':{
                                            section:filtersectval,
                                        },
                                    },
                                    'fnCreatedRow': function(nRow, aData, iDataIndex) {
                                        $(nRow).attr('id', aData[0]);
                                    },
                                    'columnDefs': [{
                                            'target': [0, 4],
                                            'orderable': false,
                                        },
                                        {
                                            'width': '5%',
                                            'targets': 0
                                        }, // set 30% width for first column
                                        {
                                            'width': '5%',
                                            'targets': 2
                                        },
                                        {
                                            'width': '7%',
                                            'targets': 3
                                        },
                                        {
                                            'width': '5%',
                                            'targets': 6
                                        },
                                        {
                                            'width': '5%',
                                            'targets': 7
                                        },
                                    ],
                                    scrollCollapse: false,
                                    paging: false
                                });
                            }
                            
                        }
                        else
                        {
                            if(divID == "minorDiv")

                            {
                                console.log("line2 executed");
                                $('#minortable').DataTable().clear().destroy();
                                $('#minortable').DataTable({
                                'searching': false,
                                'serverSide': true,
                                'processing': true,
                                'autoWidth': true,
                                'paging': false,
                                'info': false,
                                'order': [],
                                'ajax': {
                                    'url': 'filtersectwdate.php',
                                    'type': 'post',
                                    'data':{
                                        section:filtersectval,
                                        datestart:dates,
                                        dateend:datee,

                                    },
                                },
                                'fnCreatedRow': function(nRow, aData, iDataIndex) {
                                    $(nRow).attr('id', aData[0]);
                                },
                                'columnDefs': [{
                                        'target': [0, 4],
                                        'orderable': false,
                                    },
                                    {
                                        'width': '5%',
                                        'targets': 0
                                    }, // set 30% width for first column
                                    {
                                        'width': '5%',
                                        'targets': 2
                                    },
                                    {
                                        'width': '7%',
                                        'targets': 3
                                    },
                                    {
                                        'width': '5%',
                                        'targets': 6
                                    },
                                    {
                                        'width': '5%',
                                        'targets': 7
                                    },
                                ],
                                scrollCollapse: false,
                                paging: false
                            });
                            }
                            
                        }
                }

        }
        function ondeptcheck(divID)
        {
                var deptselchk = document.getElementById("minorfilterdeptCheck");
                var deptsel = document.getElementById("selectminordept");
                var dates = document.getElementById("minordatestart").value;
                var datee = document.getElementById("minordateend").value;
                var option = document.createElement("option");
                option.text = '--Select Department--';
                option.hidden = true;
                option.disabled = true;
                option.selected = true;
                deptsel.add(option);
                if(deptselchk.checked == true)
                {
                    deptsel.disabled = false;
                }
                else{
                    deptsel.disabled = true;
                    if(dates == null || datee == null || dates == '' || datee == '')
                    {
                        if (divID == "minorDiv") {
                        $('#minortable').DataTable().clear().destroy();
                        $('#minortable').DataTable({
                            'searching': false,
                            'serverSide': true,
                            'processing': true,
                            'autoWidth': true,
                            'paging': false,
                            'info': false,
                            'order': [],
                            'ajax': {
                                'url': 'minorfetch.php',
                                'type': 'post',
                            },
                            'fnCreatedRow': function(nRow, aData, iDataIndex) {
                                $(nRow).attr('id', aData[0]);
                            },
                            'columnDefs': [{
                                    'target': [0, 4],
                                    'orderable': false,
                                },
                                {
                                    'width': '5%',
                                    'targets': 0
                                }, // set 30% width for first column
                                {
                                    'width': '5%',
                                    'targets': 2
                                },
                                {
                                    'width': '7%',
                                    'targets': 3
                                },
                                {
                                    'width': '5%',
                                    'targets': 6
                                },
                                {
                                    'width': '5%',
                                    'targets': 7
                                },
                            ],
                            scrollCollapse: false,
                            paging: false
                        });


                        }
                    }
                    else
                    {

                        if (divID == "minorDiv") {
                            $('#minortable').DataTable().clear().destroy();
                            $('#minortable').DataTable({
                                'searching': false,
                                'serverSide': true,
                                'processing': true,
                                'autoWidth': true,
                                'paging': false,
                                'info': false,
                                'order': [],
                                'ajax': {
                                    'url': 'minorfetchdate.php',
                                    'type': 'post',
                                        'data': {
                                        datestart: dates,
                                        dateend: datee,
                                    },
                                },
                                'fnCreatedRow': function(nRow, aData, iDataIndex) {
                                    $(nRow).attr('id', aData[0]);
                                },
                                'columnDefs': [{
                                        'target': [0, 4],
                                        'orderable': false,
                                    },
                                    {
                                        'width': '5%',
                                        'targets': 0
                                    }, // set 30% width for first column
                                    {
                                        'width': '5%',
                                        'targets': 2
                                    },
                                    {
                                        'width': '7%',
                                        'targets': 3
                                    },
                                    {
                                        'width': '5%',
                                        'targets': 6
                                    },
                                    {
                                        'width': '5%',
                                        'targets': 7
                                    },
                                ],
                                scrollCollapse: false,
                                paging: false
                            });
                        }
                    }
                }
        }

        function myFunction(divID, tableid, fetchdataid, datestart, dateend, selectdept, selectsect, sectionchk, deptchk) {
            var x = document.getElementById(divID);
            var tid = tableid;
            var fdid = fetchdataid;
            var dates = document.getElementById(datestart).value;
            var datee = document.getElementById(dateend).value;
            var ndates = document.getElementById("majordatestart").value;
            var ndatee = document.getElementById("majordateend").value;
            var e = document.getElementById(selectdept);
            var filterdeptval = e.options[e.selectedIndex].text;
            var f = document.getElementById(selectsect);
            var filtersectval = f.options[f.selectedIndex].text;
            var sectselchk = document.getElementById(sectionchk);
            var deptselchk = document.getElementById(deptchk);
            //console.log(filterdeptval, filtersectval, dates, datee);
            if(dates == null || datee == null || dates == '' || datee == '' && filterdeptval == '--Select Department--' && filtersectval == '--Select Section--')
            {
                //alert("executed");
                if (divID == "minorDiv") {
                    $('#' + tid).DataTable().clear().destroy();
                    $('#' + tid).DataTable({
                        'searching': false,
                        'serverSide': true,
                        'processing': true,
                        'autoWidth': true,
                        'paging': false,
                        'info': false,
                        'order': [],
                        'ajax': {
                            'url': fdid,
                            'type': 'post',
                        },
                        'fnCreatedRow': function(nRow, aData, iDataIndex) {
                            $(nRow).attr('id', aData[0]);
                        },
                        'columnDefs': [{
                                'target': [0, 4],
                                'orderable': false,
                            },
                            {
                                'width': '5%',
                                'targets': 0
                            }, // set 30% width for first column
                            {
                                'width': '5%',
                                'targets': 2
                            },
                            {
                                'width': '7%',
                                'targets': 3
                            },
                            {
                                'width': '5%',
                                'targets': 6
                            },
                            {
                                'width': '5%',
                                'targets': 7
                            },
                        ],
                        scrollCollapse: false,
                        paging: false
                    });


                }
                if (divID == "majorDiv") {
                    $('#' + tid).DataTable().clear().destroy();
                    $('#' + tid).DataTable({
                        'searching': false,
                        'serverSide': true,
                        'processing': true,
                        'autoWidth': true,
                        'paging': false,
                        'info': false,
                        'order': [],
                        'ajax': {
                            'url': fdid,
                            'type': 'post',
                        },
                        'fnCreatedRow': function(nRow, aData, iDataIndex) {
                            $(nRow).attr('id', aData[0]);
                        },
                        'columnDefs': [{
                                'target': [0, 4],
                                'orderable': false,
                            },
                            {
                                'width': '5%',
                                'targets': 0
                            }, // set 30% width for first column
                            {
                                'width': '5%',
                                'targets': 1
                            },
                            {
                                'width': '7%',
                                'targets': 3
                            },
                            {
                                'width': '7%',
                                'targets': 4
                            },
                        ],
                        paging: false,
                        scrollCollapse: false
                    });

                }
 
            }
            try{
                if ((dates && datee) || (dates !== '' || datee !== '') && (dates !== null || datee !== null))
                {
                    
                    if (divID == "minorDiv" || divID == "majorDiv") {
                        $('#' + tid).DataTable().clear().destroy();
                        $('#' + tid).DataTable({
                            'searching': false,
                            'serverSide': true,
                            'processing': true,
                            'autoWidth': true,
                            'paging': false,
                            'info': false,
                            'order': [],
                            'ajax': {
                                'url': fdid,
                                'type': 'post',
                                    'data': {
                                    datestart: dates,
                                    dateend: datee,
                                },
                            },
                            'fnCreatedRow': function(nRow, aData, iDataIndex) {
                                $(nRow).attr('id', aData[0]);
                            },
                            'columnDefs': [{
                                    'target': [0, 4],
                                    'orderable': false,
                                },
                                {
                                    'width': '5%',
                                    'targets': 0
                                }, // set 30% width for first column
                                {
                                    'width': '5%',
                                    'targets': 2
                                },
                                {
                                    'width': '7%',
                                    'targets': 3
                                },
                                {
                                    'width': '5%',
                                    'targets': 6
                                },
                                {
                                    'width': '5%',
                                    'targets': 7
                                },
                            ],
                            scrollCollapse: false,
                            paging: false
                        });
                    }
                }

            }
            catch (e)
            {
                console.error('Datatables Error:', e);
            }
            
                    
           
            

            if(filterdeptval != '--Select Department--')
            {
                if(dates != null || datee != null || dates != '' || datee != '')
                {
                    if (divID == "minorDiv")
                    {
                        filterbydept('minorDiv','minortable');
                    }
                    
                    if(divID == "majorDiv")
                    {
                        mfilterbydept('majorDiv','majortable');
                    }
                    
                }
                
            }

            if(filtersectval != '--Select Section--')
            {
                if(dates != null || datee != null || dates != '' || datee != '')
                {

                    if (divID == "minorDiv")
                    {
                        filterbysection('minorDiv','minortable')
                    }
                    
                    if(divID == "majorDiv")
                    {
                        mfilterbysection('majorDiv','majortable')
                    }

                    
                    
                }
                
            }
            if ((dates !== undefined && dates !== null && dates !== '') ||
                (datee !== undefined && datee !== null && datee !== '')) {
                    if (divID == "minorDiv")
                    {
                        if (sectselchk.checked && deptselchk.checked) {

                        $('#' + tid).DataTable().clear().destroy();
                        $('#' + tid).DataTable({
                        'searching': false,
                        'serverSide': true,
                        'processing': true,
                        'autoWidth': true,
                        'paging': false,
                        'info': false,
                        'order': [],
                        'ajax': {
                            'url': 'filtersectwdeptdate.php',
                            'type': 'post',
                            'data':{
                                section:filtersectval,
                                department: filterdeptval,
                                datestart:dates,
                                dateend:datee,

                            },
                        },
                        'fnCreatedRow': function(nRow, aData, iDataIndex) {
                            $(nRow).attr('id', aData[0]);
                        },
                        'columnDefs': [{
                                'target': [0, 4],
                                'orderable': false,
                            },
                            {
                                'width': '5%',
                                'targets': 0
                            }, // set 30% width for first column
                            {
                                'width': '5%',
                                'targets': 2
                            },
                            {
                                'width': '7%',
                                'targets': 3
                            },
                            {
                                'width': '5%',
                                'targets': 6
                            },
                            {
                                'width': '5%',
                                'targets': 7
                            },
                        ],
                        scrollCollapse: false,
                        paging: false
                        });
                        }

                        if (!sectselchk.checked && deptselchk.checked) {
                        $('#' + tid).DataTable().clear().destroy();
                        $('#' + tid).DataTable({
                        'searching': false,
                        'serverSide': true,
                        'processing': true,
                        'autoWidth': true,
                        'paging': false,
                        'info': false,
                        'order': [],
                        'ajax': {
                        'url': 'filterdeptwdate.php',
                        'type': 'post',
                        'data':{
                            department:filterdeptval,
                            datestart:dates,
                            dateend:datee,

                        },
                        },
                        'fnCreatedRow': function(nRow, aData, iDataIndex) {
                        $(nRow).attr('id', aData[0]);
                        },
                        'columnDefs': [{
                            'target': [0, 4],
                            'orderable': false,
                        },
                        {
                            'width': '5%',
                            'targets': 0
                        }, // set 30% width for first column
                        {
                            'width': '5%',
                            'targets': 2
                        },
                        {
                            'width': '7%',
                            'targets': 3
                        },
                        {
                            'width': '5%',
                            'targets': 6
                        },
                        {
                            'width': '5%',
                            'targets': 7
                        },
                        ],
                        scrollCollapse: false,
                        paging: false
                        }); 
                        }
                        if (sectselchk.checked && !deptselchk.checked) {
                        $('#' + tid).DataTable().clear().destroy();
                        $('#minortable').DataTable({
                        'searching': false,
                        'serverSide': true,
                        'processing': true,
                        'autoWidth': true,
                        'paging': false,
                        'info': false,
                        'order': [],
                        'ajax': {
                        'url': 'filtersectwdate.php',
                        'type': 'post',
                        'data':{
                            section:filtersectval,
                            datestart:dates,
                            dateend:datee,

                        },
                        },
                        'fnCreatedRow': function(nRow, aData, iDataIndex) {
                        $(nRow).attr('id', aData[0]);
                        },
                        'columnDefs': [{
                            'target': [0, 4],
                            'orderable': false,
                        },
                        {
                            'width': '5%',
                            'targets': 0
                        }, // set 30% width for first column
                        {
                            'width': '5%',
                            'targets': 2
                        },
                        {
                            'width': '7%',
                            'targets': 3
                        },
                        {
                            'width': '5%',
                            'targets': 6
                        },
                        {
                            'width': '5%',
                            'targets': 7
                        },
                        ],
                        scrollCollapse: false,
                        paging: false
                        });
                        }
                    }
                    
                    if(divID == "majorDiv")
                    {
                        if (sectselchk.checked && deptselchk.checked) {

                        $('#' + tid).DataTable().clear().destroy();
                        $('#' + tid).DataTable({
                        'searching': false,
                        'serverSide': true,
                        'processing': true,
                        'autoWidth': true,
                        'paging': false,
                        'info': false,
                        'order': [],
                        'ajax': {
                            'url': 'mfiltersectwdeptdate.php',
                            'type': 'post',
                            'data':{
                                section:filtersectval,
                                department: filterdeptval,
                                datestart:dates,
                                dateend:datee,

                            },
                        },
                        'fnCreatedRow': function(nRow, aData, iDataIndex) {
                            $(nRow).attr('id', aData[0]);
                        },
                        'columnDefs': [{
                                'target': [0, 4],
                                'orderable': false,
                            },
                            {
                                'width': '5%',
                                'targets': 0
                            }, // set 30% width for first column
                            {
                                'width': '5%',
                                'targets': 2
                            },
                            {
                                'width': '7%',
                                'targets': 3
                            },
                            {
                                'width': '5%',
                                'targets': 6
                            },
                            {
                                'width': '5%',
                                'targets': 7
                            },
                        ],
                        scrollCollapse: false,
                        paging: false
                        });
                        }

                        if (!sectselchk.checked && deptselchk.checked) {
                        $('#' + tid).DataTable().clear().destroy();
                        $('#' + tid).DataTable({
                        'searching': false,
                        'serverSide': true,
                        'processing': true,
                        'autoWidth': true,
                        'paging': false,
                        'info': false,
                        'order': [],
                        'ajax': {
                        'url': 'mfilterdeptwdate.php',
                        'type': 'post',
                        'data':{
                            department:filterdeptval,
                            datestart:dates,
                            dateend:datee,

                        },
                        },
                        'fnCreatedRow': function(nRow, aData, iDataIndex) {
                        $(nRow).attr('id', aData[0]);
                        },
                        'columnDefs': [{
                            'target': [0, 4],
                            'orderable': false,
                        },
                        {
                            'width': '5%',
                            'targets': 0
                        }, // set 30% width for first column
                        {
                            'width': '5%',
                            'targets': 2
                        },
                        {
                            'width': '7%',
                            'targets': 3
                        },
                        {
                            'width': '5%',
                            'targets': 6
                        },
                        {
                            'width': '5%',
                            'targets': 7
                        },
                        ],
                        scrollCollapse: false,
                        paging: false
                        }); 
                        }
                        if (sectselchk.checked && !deptselchk.checked) {
                        $('#' + tid).DataTable().clear().destroy();
                        $('#minortable').DataTable({
                        'searching': false,
                        'serverSide': true,
                        'processing': true,
                        'autoWidth': true,
                        'paging': false,
                        'info': false,
                        'order': [],
                        'ajax': {
                        'url': 'mfiltersectwdate.php',
                        'type': 'post',
                        'data':{
                            section:filtersectval,
                            datestart:dates,
                            dateend:datee,

                        },
                        },
                        'fnCreatedRow': function(nRow, aData, iDataIndex) {
                        $(nRow).attr('id', aData[0]);
                        },
                        'columnDefs': [{
                            'target': [0, 4],
                            'orderable': false,
                        },
                        {
                            'width': '5%',
                            'targets': 0
                        }, // set 30% width for first column
                        {
                            'width': '5%',
                            'targets': 2
                        },
                        {
                            'width': '7%',
                            'targets': 3
                        },
                        {
                            'width': '5%',
                            'targets': 6
                        },
                        {
                            'width': '5%',
                            'targets': 7
                        },
                        ],
                        scrollCollapse: false,
                        paging: false
                        });
                        }
                    }

                }
            
        }

        //minor function end


        //major functions start
        function mondeptcheck(divID)
        {
                var deptselchk = document.getElementById("majorfilterdeptCheck");
                var deptsel = document.getElementById("selectmajordept");
                var dates = document.getElementById("majordatestart").value;
                var datee = document.getElementById("majordateend").value;
                var option = document.createElement("option");
                option.text = '--Select Department--';
                option.hidden = true;
                option.disabled = true;
                option.selected = true;
                deptsel.add(option);
                if(deptselchk.checked == true)
                {
                    deptsel.disabled = false;
                }
                else{
                    deptsel.disabled = true;
                    if(dates == null || datee == null || dates == '' || datee == '')
                    {
                        if (divID == "majorDiv") {
                        $('#majortable').DataTable().clear().destroy();
                        $('#majortable').DataTable({
                            'searching': false,
                            'serverSide': true,
                            'processing': true,
                            'autoWidth': true,
                            'paging': false,
                            'info': false,
                            'order': [],
                            'ajax': {
                                'url': 'majorfetch.php',
                                'type': 'post',
                            },
                            'fnCreatedRow': function(nRow, aData, iDataIndex) {
                                $(nRow).attr('id', aData[0]);
                            },
                            'columnDefs': [{
                                    'target': [0, 4],
                                    'orderable': false,
                                },
                                {
                                    'width': '5%',
                                    'targets': 0
                                }, // set 30% width for first column
                                {
                                    'width': '5%',
                                    'targets': 2
                                },
                                {
                                    'width': '7%',
                                    'targets': 3
                                },
                                {
                                    'width': '5%',
                                    'targets': 6
                                },
                                {
                                    'width': '5%',
                                    'targets': 7
                                },
                            ],
                            scrollCollapse: false,
                            paging: false
                        });


                        }
                    }
                    else
                    {

                        if (divID == "majorDiv") {
                            $('#majortable').DataTable().clear().destroy();
                            $('#majortable').DataTable({
                                'searching': false,
                                'serverSide': true,
                                'processing': true,
                                'autoWidth': true,
                                'paging': false,
                                'info': false,
                                'order': [],
                                'ajax': {
                                    'url': 'majorfetchdate.php',
                                    'type': 'post',
                                        'data': {
                                        datestart: dates,
                                        dateend: datee,
                                    },
                                },
                                'fnCreatedRow': function(nRow, aData, iDataIndex) {
                                    $(nRow).attr('id', aData[0]);
                                },
                                'columnDefs': [{
                                        'target': [0, 4],
                                        'orderable': false,
                                    },
                                    {
                                        'width': '5%',
                                        'targets': 0
                                    }, // set 30% width for first column
                                    {
                                        'width': '5%',
                                        'targets': 2
                                    },
                                    {
                                        'width': '7%',
                                        'targets': 3
                                    },
                                    {
                                        'width': '5%',
                                        'targets': 6
                                    },
                                    {
                                        'width': '5%',
                                        'targets': 7
                                    },
                                ],
                                scrollCollapse: false,
                                paging: false
                            });
                        }
                    }
                }
        }

        function monsectioncheck(divID)
        {
                var e = document.getElementById("selectmajorsect");
                var filtersectval = e.options[e.selectedIndex].text;
                var sectselchk = document.getElementById("majorfiltersectionCheck");
                var sectsel = document.getElementById("selectmajorsect");
                var dates = document.getElementById("majordatestart").value;
                var datee = document.getElementById("majordateend").value;
                var e = document.getElementById("selectmajordept");
                var filterdeptval = e.options[e.selectedIndex].text;
                var option = document.createElement("option");
                option.text = '--Select Section--';
                option.hidden = true;
                option.disabled = true;
                option.selected = true;
                sectsel.add(option);
                if (!sectselchk.checked) {
                    sectsel.disabled = true;
                    console.log("else executed");
                    if(filterdeptval == '--Select Department--' && filtersectval == '--Select Section--')
                    {                   
                        if(dates == '' || datee == '' || dates == null || datee == null)
                        {
                            $('#majortable').DataTable().clear().destroy();
                            $('#majortable').DataTable({
                            'searching': false,
                            'serverSide': true,
                            'processing': true,
                            'autoWidth': true,
                            'paging': false,
                            'info': false,
                            'order': [],
                            'ajax': {
                                'url': 'majorfetch.php',
                                'type': 'post',
                            },
                            'fnCreatedRow': function(nRow, aData, iDataIndex) {
                                $(nRow).attr('id', aData[0]);
                            },
                            'columnDefs': [{
                                    'target': [0, 4],
                                    'orderable': false,
                                },
                                {
                                    'width': '5%',
                                    'targets': 0
                                }, // set 30% width for first column
                                {
                                    'width': '5%',
                                    'targets': 2
                                },
                                {
                                    'width': '7%',
                                    'targets': 3
                                },
                                {
                                    'width': '5%',
                                    'targets': 6
                                },
                                {
                                    'width': '5%',
                                    'targets': 7
                                },
                            ],
                            scrollCollapse: false,
                            paging: false
                        });
                        }   
                    }

                    if(filtersectval != '--Select Section--' &&  filterdeptval == '--Select Department--')
                {
                        $('#majortable').DataTable().clear().destroy();
                        $('#majortable').DataTable({
                        'searching': false,
                        'serverSide': true,
                        'processing': true,
                        'autoWidth': true,
                        'paging': false,
                        'info': false,
                        'order': [],
                        'ajax': {
                            'url': 'mfiltersectwdate.php',
                            'type': 'post',
                            'data':{
                                section:filtersectval,
                                datestart:dates,
                                dateend:datee,

                            },
                        },
                        'fnCreatedRow': function(nRow, aData, iDataIndex) {
                            $(nRow).attr('id', aData[0]);
                        },
                        'columnDefs': [{
                                'target': [0, 4],
                                'orderable': false,
                            },
                            {
                                'width': '5%',
                                'targets': 0
                            }, // set 30% width for first column
                            {
                                'width': '5%',
                                'targets': 2
                            },
                            {
                                'width': '7%',
                                'targets': 3
                            },
                            {
                                'width': '5%',
                                'targets': 6
                            },
                            {
                                'width': '5%',
                                'targets': 7
                            },
                        ],
                        scrollCollapse: false,
                        paging: false
                    });
                }
                if(!sectselchk.checked &&  filterdeptval != '--Select Department--')
                {
                        $('#majortable').DataTable().clear().destroy();
                        $('#majortable').DataTable({
                        'searching': false,
                        'serverSide': true,
                        'processing': true,
                        'autoWidth': true,
                        'paging': false,
                        'info': false,
                        'order': [],
                        'ajax': {
                            'url': 'mfilterdeptwdate.php',
                            'type': 'post',
                            'data':{
                                department:filterdeptval,
                                datestart:dates,
                                dateend:datee,

                            },
                        },
                        'fnCreatedRow': function(nRow, aData, iDataIndex) {
                            $(nRow).attr('id', aData[0]);
                        },
                        'columnDefs': [{
                                'target': [0, 4],
                                'orderable': false,
                            },
                            {
                                'width': '5%',
                                'targets': 0
                            }, // set 30% width for first column
                            {
                                'width': '5%',
                                'targets': 2
                            },
                            {
                                'width': '7%',
                                'targets': 3
                            },
                            {
                                'width': '5%',
                                'targets': 6
                            },
                            {
                                'width': '5%',
                                'targets': 7
                            },
                        ],
                        scrollCollapse: false,
                        paging: false
                    });
                }
                } 
                else{
                    sectsel.disabled = false;

                    if(dates == '' || datee == '' || dates == null || datee == null)
                        {
                            if(divID == "majorDiv")

                            {
                                console.log("line executed");
                                    $('#majortable').DataTable().clear().destroy();
                                    $('#majortable').DataTable({
                                    'searching': false,
                                    'serverSide': true,
                                    'processing': true,
                                    'autoWidth': true,
                                    'paging': false,
                                    'info': false,
                                    'order': [],
                                    'ajax': {
                                        'url': 'mfiltersectfetch.php',
                                        'type': 'post',
                                        'data':{
                                            section:filtersectval,
                                        },
                                    },
                                    'fnCreatedRow': function(nRow, aData, iDataIndex) {
                                        $(nRow).attr('id', aData[0]);
                                    },
                                    'columnDefs': [{
                                            'target': [0, 4],
                                            'orderable': false,
                                        },
                                        {
                                            'width': '5%',
                                            'targets': 0
                                        }, // set 30% width for first column
                                        {
                                            'width': '5%',
                                            'targets': 2
                                        },
                                        {
                                            'width': '7%',
                                            'targets': 3
                                        },
                                        {
                                            'width': '5%',
                                            'targets': 6
                                        },
                                        {
                                            'width': '5%',
                                            'targets': 7
                                        },
                                    ],
                                    scrollCollapse: false,
                                    paging: false
                                });
                            }
                            
                        }
                        else
                        {
                            if(divID == "majorDiv")

                            {
                                console.log("line2 executed");
                                $('#majortable').DataTable().clear().destroy();
                                $('#majortable').DataTable({
                                'searching': false,
                                'serverSide': true,
                                'processing': true,
                                'autoWidth': true,
                                'paging': false,
                                'info': false,
                                'order': [],
                                'ajax': {
                                    'url': 'mfiltersectwdate.php',
                                    'type': 'post',
                                    'data':{
                                        section:filtersectval,
                                        datestart:dates,
                                        dateend:datee,

                                    },
                                },
                                'fnCreatedRow': function(nRow, aData, iDataIndex) {
                                    $(nRow).attr('id', aData[0]);
                                },
                                'columnDefs': [{
                                        'target': [0, 4],
                                        'orderable': false,
                                    },
                                    {
                                        'width': '5%',
                                        'targets': 0
                                    }, // set 30% width for first column
                                    {
                                        'width': '5%',
                                        'targets': 2
                                    },
                                    {
                                        'width': '7%',
                                        'targets': 3
                                    },
                                    {
                                        'width': '5%',
                                        'targets': 6
                                    },
                                    {
                                        'width': '5%',
                                        'targets': 7
                                    },
                                ],
                                scrollCollapse: false,
                                paging: false
                            });
                            }
                            
                        }
                }

        }

        function mfilterbysection(divID, tableid)
        {
                var e = document.getElementById("selectmajordept");
                var filterdeptval = e.options[e.selectedIndex].text;
                var f = document.getElementById("selectmajorsect");
                var filtersectval = f.options[f.selectedIndex].text;
                var sectselchk = document.getElementById("majorfiltersectionCheck");
                var deptselchk = document.getElementById("majorfilterdeptCheck");
                var tid = tableid;

                if(filterdeptval == '--Select Department--')
                {
                    if(divID == "majorDiv")
                    {       
                    var dates = document.getElementById("majordatestart").value;
                    var datee = document.getElementById("majordateend").value;
                    console.log(dates);
                    console.log(datee);
                    if(dates == '' || datee == '' || dates == null || datee == null)
                    {
                        console.log("line executed");
                        $('#' + tid).DataTable().clear().destroy();
                        $('#' + tid).DataTable({
                        'searching': false,
                        'serverSide': true,
                        'processing': true,
                        'autoWidth': true,
                        'paging': false,
                        'info': false,
                        'order': [],
                        'ajax': {
                            'url': 'mfiltersectfetch.php',
                            'type': 'post',
                            'data':{
                                section:filtersectval,
                            },
                        },
                        'fnCreatedRow': function(nRow, aData, iDataIndex) {
                            $(nRow).attr('id', aData[0]);
                        },
                        'columnDefs': [{
                                'target': [0, 4],
                                'orderable': false,
                            },
                            {
                                'width': '5%',
                                'targets': 0
                            }, // set 30% width for first column
                            {
                                'width': '5%',
                                'targets': 2
                            },
                            {
                                'width': '7%',
                                'targets': 3
                            },
                            {
                                'width': '5%',
                                'targets': 6
                            },
                            {
                                'width': '5%',
                                'targets': 7
                            },
                        ],
                        scrollCollapse: false,
                        paging: false
                    });
                    }
                    else
                    {
                        console.log("line2 executed");
                        $('#' + tid).DataTable().clear().destroy();
                        $('#' + tid).DataTable({
                        'searching': false,
                        'serverSide': true,
                        'processing': true,
                        'autoWidth': true,
                        'paging': false,
                        'info': false,
                        'order': [],
                        'ajax': {
                            'url': 'mfiltersectwdate.php',
                            'type': 'post',
                            'data':{
                                section:filtersectval,
                                datestart:dates,
                                dateend:datee,

                            },
                        },
                        'fnCreatedRow': function(nRow, aData, iDataIndex) {
                            $(nRow).attr('id', aData[0]);
                        },
                        'columnDefs': [{
                                'target': [0, 4],
                                'orderable': false,
                            },
                            {
                                'width': '5%',
                                'targets': 0
                            }, // set 30% width for first column
                            {
                                'width': '5%',
                                'targets': 2
                            },
                            {
                                'width': '7%',
                                'targets': 3
                            },
                            {
                                'width': '5%',
                                'targets': 6
                            },
                            {
                                'width': '5%',
                                'targets': 7
                            },
                        ],
                        scrollCollapse: false,
                        paging: false
                    });
                    }
                    
                    }
                }
                else{
                        if(divID == "majorDiv")
                        {       
                        var dates = document.getElementById("majordatestart").value;
                        var datee = document.getElementById("majordateend").value;
                        console.log(dates);
                        console.log(datee);
                        if(dates == '' || datee == '' || dates == null || datee == null)
                        {
                            console.log("line executed");
                            $('#' + tid).DataTable().clear().destroy();
                            $('#' + tid).DataTable({
                            'searching': false,
                            'serverSide': true,
                            'processing': true,
                            'autoWidth': true,
                            'paging': false,
                            'info': false,
                            'order': [],
                            'ajax': {
                                'url': 'mfiltersectdeptfetch.php',
                                'type': 'post',
                                'data':{
                                    section:filtersectval,
                                    department: filterdeptval,
                                },
                            },
                            'fnCreatedRow': function(nRow, aData, iDataIndex) {
                                $(nRow).attr('id', aData[0]);
                            },
                            'columnDefs': [{
                                    'target': [0, 4],
                                    'orderable': false,
                                },
                                {
                                    'width': '5%',
                                    'targets': 0
                                }, // set 30% width for first column
                                {
                                    'width': '5%',
                                    'targets': 2
                                },
                                {
                                    'width': '7%',
                                    'targets': 3
                                },
                                {
                                    'width': '5%',
                                    'targets': 6
                                },
                                {
                                    'width': '5%',
                                    'targets': 7
                                },
                            ],
                            scrollCollapse: false,
                            paging: false
                        });
                        }
                        else
                        {
                            console.log("line2 executed");
                            $('#' + tid).DataTable().clear().destroy();
                            $('#' + tid).DataTable({
                            'searching': false,
                            'serverSide': true,
                            'processing': true,
                            'autoWidth': true,
                            'paging': false,
                            'info': false,
                            'order': [],
                            'ajax': {
                                'url': 'mfiltersectwdeptdate.php',
                                'type': 'post',
                                'data':{
                                    section:filtersectval,
                                    department: filterdeptval,
                                    datestart:dates,
                                    dateend:datee,

                                },
                            },
                            'fnCreatedRow': function(nRow, aData, iDataIndex) {
                                $(nRow).attr('id', aData[0]);
                            },
                            'columnDefs': [{
                                    'target': [0, 4],
                                    'orderable': false,
                                },
                                {
                                    'width': '5%',
                                    'targets': 0
                                }, // set 30% width for first column
                                {
                                    'width': '5%',
                                    'targets': 2
                                },
                                {
                                    'width': '7%',
                                    'targets': 3
                                },
                                {
                                    'width': '5%',
                                    'targets': 6
                                },
                                {
                                    'width': '5%',
                                    'targets': 7
                                },
                            ],
                            scrollCollapse: false,
                            paging: false
                        });
                        }
                       
                    }

                }

                if ((dates !== undefined && dates !== null && dates !== '') ||
                        (datee !== undefined && datee !== null && datee !== '')) 
                    {

                        if (sectselchk.checked && deptselchk.checked) {
                            console.log("line2 executed");
                                $('#' + tid).DataTable().clear().destroy();
                                $('#' + tid).DataTable({
                                'searching': false,
                                'serverSide': true,
                                'processing': true,
                                'autoWidth': true,
                                'paging': false,
                                'info': false,
                                'order': [],
                                'ajax': {
                                    'url': 'mfiltersectwdeptdate.php',
                                    'type': 'post',
                                    'data':{
                                        section:filtersectval,
                                        department: filterdeptval,
                                        datestart:dates,
                                        dateend:datee,

                                    },
                                },
                                'fnCreatedRow': function(nRow, aData, iDataIndex) {
                                    $(nRow).attr('id', aData[0]);
                                },
                                'columnDefs': [{
                                        'target': [0, 4],
                                        'orderable': false,
                                    },
                                    {
                                        'width': '5%',
                                        'targets': 0
                                    }, // set 30% width for first column
                                    {
                                        'width': '5%',
                                        'targets': 2
                                    },
                                    {
                                        'width': '7%',
                                        'targets': 3
                                    },
                                    {
                                        'width': '5%',
                                        'targets': 6
                                    },
                                    {
                                        'width': '5%',
                                        'targets': 7
                                    },
                                ],
                                scrollCollapse: false,
                                paging: false
                            });
                        }

                            if (!sectselchk.checked && deptselchk.checked) {
                                $('#' + tid).DataTable().clear().destroy();
                                    $('#' + tid).DataTable({
                                    'searching': false,
                                    'serverSide': true,
                                    'processing': true,
                                    'autoWidth': true,
                                    'paging': false,
                                    'info': false,
                                    'order': [],
                                    'ajax': {
                                        'url': 'mfilterdeptwdate.php',
                                        'type': 'post',
                                        'data':{
                                            department:filterdeptval,
                                            datestart:dates,
                                            dateend:datee,

                                        },
                                    },
                                    'fnCreatedRow': function(nRow, aData, iDataIndex) {
                                        $(nRow).attr('id', aData[0]);
                                    },
                                    'columnDefs': [{
                                            'target': [0, 4],
                                            'orderable': false,
                                        },
                                        {
                                            'width': '5%',
                                            'targets': 0
                                        }, // set 30% width for first column
                                        {
                                            'width': '5%',
                                            'targets': 2
                                        },
                                        {
                                            'width': '7%',
                                            'targets': 3
                                        },
                                        {
                                            'width': '5%',
                                            'targets': 6
                                        },
                                        {
                                            'width': '5%',
                                            'targets': 7
                                        },
                                    ],
                                    scrollCollapse: false,
                                    paging: false
                                }); 
                            }
                            if (sectselchk.checked && !deptselchk.checked) {
                                $('#' + tid).DataTable().clear().destroy();
                                    $('#' + tid).DataTable({
                                    'searching': false,
                                    'serverSide': true,
                                    'processing': true,
                                    'autoWidth': true,
                                    'paging': false,
                                    'info': false,
                                    'order': [],
                                    'ajax': {
                                        'url': 'mfiltersectwdate.php',
                                        'type': 'post',
                                        'data':{
                                            section:filtersectval,
                                            datestart:dates,
                                            dateend:datee,

                                        },
                                    },
                                    'fnCreatedRow': function(nRow, aData, iDataIndex) {
                                        $(nRow).attr('id', aData[0]);
                                    },
                                    'columnDefs': [{
                                            'target': [0, 4],
                                            'orderable': false,
                                        },
                                        {
                                            'width': '5%',
                                            'targets': 0
                                        }, // set 30% width for first column
                                        {
                                            'width': '5%',
                                            'targets': 2
                                        },
                                        {
                                            'width': '7%',
                                            'targets': 3
                                        },
                                        {
                                            'width': '5%',
                                            'targets': 6
                                        },
                                        {
                                            'width': '5%',
                                            'targets': 7
                                        },
                                    ],
                                    scrollCollapse: false,
                                    paging: false
                                });
                            }
                    }
                    if ((dates == undefined && dates == null && dates == '') ||
                        (datee == undefined && datee == null && datee == '')) {
                        if(sectselchk.checked && deptselchk.checked) {
                            $('#' + tid).DataTable().clear().destroy();
                                $('#' + tid).DataTable({
                                'searching': false,
                                'serverSide': true,
                                'processing': true,
                                'autoWidth': true,
                                'paging': false,
                                'info': false,
                                'order': [],
                                'ajax': {
                                    'url': 'mfiltersectdeptfetch.php',
                                    'type': 'post',
                                    'data':{
                                        section:filtersectval,
                                        department: filterdeptval,
                                    },
                                },
                                'fnCreatedRow': function(nRow, aData, iDataIndex) {
                                    $(nRow).attr('id', aData[0]);
                                },
                                'columnDefs': [{
                                        'target': [0, 4],
                                        'orderable': false,
                                    },
                                    {
                                        'width': '5%',
                                        'targets': 0
                                    }, // set 30% width for first column
                                    {
                                        'width': '5%',
                                        'targets': 2
                                    },
                                    {
                                        'width': '7%',
                                        'targets': 3
                                    },
                                    {
                                        'width': '5%',
                                        'targets': 6
                                    },
                                    {
                                        'width': '5%',
                                        'targets': 7
                                    },
                                ],
                                scrollCollapse: false,
                                paging: false
                            });
                        }
                        if(!sectselchk.checked && deptselchk.checked){
                            $('#' + tid).DataTable().clear().destroy();
                                $('#' + tid).DataTable({
                                'searching': false,
                                'serverSide': true,
                                'processing': true,
                                'autoWidth': true,
                                'paging': false,
                                'info': false,
                                'order': [],
                                'ajax': {
                                    'url': 'mfilterdeptfetch.php',
                                    'type': 'post',
                                    'data':{
                                        department:filterdeptval,
                                    },
                                },
                                'fnCreatedRow': function(nRow, aData, iDataIndex) {
                                    $(nRow).attr('id', aData[0]);
                                },
                                'columnDefs': [{
                                        'target': [0, 4],
                                        'orderable': false,
                                    },
                                    {
                                        'width': '5%',
                                        'targets': 0
                                    }, // set 30% width for first column
                                    {
                                        'width': '5%',
                                        'targets': 2
                                    },
                                    {
                                        'width': '7%',
                                        'targets': 3
                                    },
                                    {
                                        'width': '5%',
                                        'targets': 6
                                    },
                                    {
                                        'width': '5%',
                                        'targets': 7
                                    },
                                ],
                                scrollCollapse: false,
                                paging: false
                            });
                        }
                        if(sectselchk.checked && !deptselchk.checked)
                        {
                            $('#' + tid).DataTable().clear().destroy();
                                $('#' + tid).DataTable({
                                'searching': false,
                                'serverSide': true,
                                'processing': true,
                                'autoWidth': true,
                                'paging': false,
                                'info': false,
                                'order': [],
                                'ajax': {
                                    'url': 'mfiltersectfetch.php',
                                    'type': 'post',
                                    'data':{
                                        section:filtersectval,
                                    },
                                },
                                'fnCreatedRow': function(nRow, aData, iDataIndex) {
                                    $(nRow).attr('id', aData[0]);
                                },
                                'columnDefs': [{
                                        'target': [0, 4],
                                        'orderable': false,
                                    },
                                    {
                                        'width': '5%',
                                        'targets': 0
                                    }, // set 30% width for first column
                                    {
                                        'width': '5%',
                                        'targets': 2
                                    },
                                    {
                                        'width': '7%',
                                        'targets': 3
                                    },
                                    {
                                        'width': '5%',
                                        'targets': 6
                                    },
                                    {
                                        'width': '5%',
                                        'targets': 7
                                    },
                                ],
                                scrollCollapse: false,
                                paging: false
                            });
                        }

                    }

                
        }
        
        function mfilterbydept(divID, tableid)
        {
                var e = document.getElementById("selectmajordept");
                var filterdeptval = e.options[e.selectedIndex].text;
                var f = document.getElementById("selectmajorsect");
                var filtersectval = f.options[f.selectedIndex].text;
                var sectselchk = document.getElementById("majorfiltersectionCheck");
                var deptselchk = document.getElementById("majorfilterdeptCheck");
                var tid = tableid;

                if(filtersectval == '--Select Section--')
                {
                    if(divID == "majorDiv")
                    {
                        
                        var dates = document.getElementById("majordatestart").value;
                        var datee = document.getElementById("majordateend").value;
                        console.log(dates);
                        console.log(datee);
                        if(dates == '' || datee == '' || dates == null || datee == null)
                        {
                            console.log("line executed");
                            $('#' + tid).DataTable().clear().destroy();
                            $('#' + tid).DataTable({
                            'searching': false,
                            'serverSide': true,
                            'processing': true,
                            'autoWidth': true,
                            'paging': false,
                            'info': false,
                            'order': [],
                            'ajax': {
                                'url': 'mfilterdeptfetch.php',
                                'type': 'post',
                                'data':{
                                    department:filterdeptval,
                                },
                            },
                            'fnCreatedRow': function(nRow, aData, iDataIndex) {
                                $(nRow).attr('id', aData[0]);
                            },
                            'columnDefs': [{
                                    'target': [0, 4],
                                    'orderable': false,
                                },
                                {
                                    'width': '5%',
                                    'targets': 0
                                }, // set 30% width for first column
                                {
                                    'width': '5%',
                                    'targets': 2
                                },
                                {
                                    'width': '7%',
                                    'targets': 3
                                },
                                {
                                    'width': '5%',
                                    'targets': 6
                                },
                                {
                                    'width': '5%',
                                    'targets': 7
                                },
                            ],
                            scrollCollapse: false,
                            paging: false
                        });
                        }
                        else
                        {
                            console.log("line2 executed");
                            $('#' + tid).DataTable().clear().destroy();
                            $('#' + tid).DataTable({
                            'searching': false,
                            'serverSide': true,
                            'processing': true,
                            'autoWidth': true,
                            'paging': false,
                            'info': false,
                            'order': [],
                            'ajax': {
                                'url': 'mfilterdeptwdate.php',
                                'type': 'post',
                                'data':{
                                    department:filterdeptval,
                                    datestart:dates,
                                    dateend:datee,

                                },
                            },
                            'fnCreatedRow': function(nRow, aData, iDataIndex) {
                                $(nRow).attr('id', aData[0]);
                            },
                            'columnDefs': [{
                                    'target': [0, 4],
                                    'orderable': false,
                                },
                                {
                                    'width': '5%',
                                    'targets': 0
                                }, // set 30% width for first column
                                {
                                    'width': '5%',
                                    'targets': 2
                                },
                                {
                                    'width': '7%',
                                    'targets': 3
                                },
                                {
                                    'width': '5%',
                                    'targets': 6
                                },
                                {
                                    'width': '5%',
                                    'targets': 7
                                },
                            ],
                            scrollCollapse: false,
                            paging: false
                        });
                        }
                    }
                }
                else
                {
                    if(divID == "majorDiv")
                        {       
                        var dates = document.getElementById("majordatestart").value;
                        var datee = document.getElementById("majordateend").value;
                        console.log(dates);
                        console.log(datee);
                        if(dates == '' || datee == '' || dates == null || datee == null)
                        {
                            console.log("line executed");
                            $('#' + tid).DataTable().clear().destroy();
                            $('#' + tid).DataTable({
                            'searching': false,
                            'serverSide': true,
                            'processing': true,
                            'autoWidth': true,
                            'paging': false,
                            'info': false,
                            'order': [],
                            'ajax': {
                                'url': 'mfiltersectdeptfetch.php',
                                'type': 'post',
                                'data':{
                                    section:filtersectval,
                                    department: filterdeptval,
                                },
                            },
                            'fnCreatedRow': function(nRow, aData, iDataIndex) {
                                $(nRow).attr('id', aData[0]);
                            },
                            'columnDefs': [{
                                    'target': [0, 4],
                                    'orderable': false,
                                },
                                {
                                    'width': '5%',
                                    'targets': 0
                                }, // set 30% width for first column
                                {
                                    'width': '5%',
                                    'targets': 2
                                },
                                {
                                    'width': '7%',
                                    'targets': 3
                                },
                                {
                                    'width': '5%',
                                    'targets': 6
                                },
                                {
                                    'width': '5%',
                                    'targets': 7
                                },
                            ],
                            scrollCollapse: false,
                            paging: false
                        });
                        }
                        else
                        {
                            console.log("line2 executed");
                            $('#' + tid).DataTable().clear().destroy();
                            $('#' + tid).DataTable({
                            'searching': false,
                            'serverSide': true,
                            'processing': true,
                            'autoWidth': true,
                            'paging': false,
                            'info': false,
                            'order': [],
                            'ajax': {
                                'url': 'mfiltersectwdeptdate.php',
                                'type': 'post',
                                'data':{
                                    section:filtersectval,
                                    department: filterdeptval,
                                    datestart:dates,
                                    dateend:datee,

                                },
                            },
                            'fnCreatedRow': function(nRow, aData, iDataIndex) {
                                $(nRow).attr('id', aData[0]);
                            },
                            'columnDefs': [{
                                    'target': [0, 4],
                                    'orderable': false,
                                },
                                {
                                    'width': '5%',
                                    'targets': 0
                                }, // set 30% width for first column
                                {
                                    'width': '5%',
                                    'targets': 2
                                },
                                {
                                    'width': '7%',
                                    'targets': 3
                                },
                                {
                                    'width': '5%',
                                    'targets': 6
                                },
                                {
                                    'width': '5%',
                                    'targets': 7
                                },
                            ],
                            scrollCollapse: false,
                            paging: false
                        });
                        }
                       
                    }
                }
                if ((dates !== undefined && dates !== null && dates !== '') ||
                        (datee !== undefined && datee !== null && datee !== '')) 
                        {

                            if (sectselchk.checked && deptselchk.checked) {
                                console.log("line2 executed");
                                    $('#' + tid).DataTable().clear().destroy();
                                    $('#' + tid).DataTable({
                                    'searching': false,
                                    'serverSide': true,
                                    'processing': true,
                                    'autoWidth': true,
                                    'paging': false,
                                    'info': false,
                                    'order': [],
                                    'ajax': {
                                        'url': 'mfiltersectwdeptdate.php',
                                        'type': 'post',
                                        'data':{
                                            section:filtersectval,
                                            department: filterdeptval,
                                            datestart:dates,
                                            dateend:datee,

                                        },
                                    },
                                    'fnCreatedRow': function(nRow, aData, iDataIndex) {
                                        $(nRow).attr('id', aData[0]);
                                    },
                                    'columnDefs': [{
                                            'target': [0, 4],
                                            'orderable': false,
                                        },
                                        {
                                            'width': '5%',
                                            'targets': 0
                                        }, // set 30% width for first column
                                        {
                                            'width': '5%',
                                            'targets': 2
                                        },
                                        {
                                            'width': '7%',
                                            'targets': 3
                                        },
                                        {
                                            'width': '5%',
                                            'targets': 6
                                        },
                                        {
                                            'width': '5%',
                                            'targets': 7
                                        },
                                    ],
                                    scrollCollapse: false,
                                    paging: false
                                });
                            }

                                if (!sectselchk.checked && deptselchk.checked) {
                                    $('#' + tid).DataTable().clear().destroy();
                                        $('#' + tid).DataTable({
                                        'searching': false,
                                        'serverSide': true,
                                        'processing': true,
                                        'autoWidth': true,
                                        'paging': false,
                                        'info': false,
                                        'order': [],
                                        'ajax': {
                                            'url': 'mfilterdeptwdate.php',
                                            'type': 'post',
                                            'data':{
                                                department:filterdeptval,
                                                datestart:dates,
                                                dateend:datee,

                                            },
                                        },
                                        'fnCreatedRow': function(nRow, aData, iDataIndex) {
                                            $(nRow).attr('id', aData[0]);
                                        },
                                        'columnDefs': [{
                                                'target': [0, 4],
                                                'orderable': false,
                                            },
                                            {
                                                'width': '5%',
                                                'targets': 0
                                            }, // set 30% width for first column
                                            {
                                                'width': '5%',
                                                'targets': 2
                                            },
                                            {
                                                'width': '7%',
                                                'targets': 3
                                            },
                                            {
                                                'width': '5%',
                                                'targets': 6
                                            },
                                            {
                                                'width': '5%',
                                                'targets': 7
                                            },
                                        ],
                                        scrollCollapse: false,
                                        paging: false
                                    }); 
                                }
                                if (sectselchk.checked && !deptselchk.checked) {
                                    $('#' + tid).DataTable().clear().destroy();
                                        $('#minortable').DataTable({
                                        'searching': false,
                                        'serverSide': true,
                                        'processing': true,
                                        'autoWidth': true,
                                        'paging': false,
                                        'info': false,
                                        'order': [],
                                        'ajax': {
                                            'url': 'mfiltersectwdate.php',
                                            'type': 'post',
                                            'data':{
                                                section:filtersectval,
                                                datestart:dates,
                                                dateend:datee,

                                            },
                                        },
                                        'fnCreatedRow': function(nRow, aData, iDataIndex) {
                                            $(nRow).attr('id', aData[0]);
                                        },
                                        'columnDefs': [{
                                                'target': [0, 4],
                                                'orderable': false,
                                            },
                                            {
                                                'width': '5%',
                                                'targets': 0
                                            }, // set 30% width for first column
                                            {
                                                'width': '5%',
                                                'targets': 2
                                            },
                                            {
                                                'width': '7%',
                                                'targets': 3
                                            },
                                            {
                                                'width': '5%',
                                                'targets': 6
                                            },
                                            {
                                                'width': '5%',
                                                'targets': 7
                                            },
                                        ],
                                        scrollCollapse: false,
                                        paging: false
                                    });
                                }
                        }
                        if ((dates == undefined && dates == null && dates == '') ||
                            (datee == undefined && datee == null && datee == '')) {
                            if(sectselchk.checked && deptselchk.checked) {
                                $('#' + tid).DataTable().clear().destroy();
                                    $('#' + tid).DataTable({
                                    'searching': false,
                                    'serverSide': true,
                                    'processing': true,
                                    'autoWidth': true,
                                    'paging': false,
                                    'info': false,
                                    'order': [],
                                    'ajax': {
                                        'url': 'mfiltersectdeptfetch.php',
                                        'type': 'post',
                                        'data':{
                                            section:filtersectval,
                                            department: filterdeptval,
                                        },
                                    },
                                    'fnCreatedRow': function(nRow, aData, iDataIndex) {
                                        $(nRow).attr('id', aData[0]);
                                    },
                                    'columnDefs': [{
                                            'target': [0, 4],
                                            'orderable': false,
                                        },
                                        {
                                            'width': '5%',
                                            'targets': 0
                                        }, // set 30% width for first column
                                        {
                                            'width': '5%',
                                            'targets': 2
                                        },
                                        {
                                            'width': '7%',
                                            'targets': 3
                                        },
                                        {
                                            'width': '5%',
                                            'targets': 6
                                        },
                                        {
                                            'width': '5%',
                                            'targets': 7
                                        },
                                    ],
                                    scrollCollapse: false,
                                    paging: false
                                });
                            }
                            if(!sectselchk.checked && deptselchk.checked){
                                $('#' + tid).DataTable().clear().destroy();
                                    $('#' + tid).DataTable({
                                    'searching': false,
                                    'serverSide': true,
                                    'processing': true,
                                    'autoWidth': true,
                                    'paging': false,
                                    'info': false,
                                    'order': [],
                                    'ajax': {
                                        'url': 'mfilterdeptfetch.php',
                                        'type': 'post',
                                        'data':{
                                            department:filterdeptval,
                                        },
                                    },
                                    'fnCreatedRow': function(nRow, aData, iDataIndex) {
                                        $(nRow).attr('id', aData[0]);
                                    },
                                    'columnDefs': [{
                                            'target': [0, 4],
                                            'orderable': false,
                                        },
                                        {
                                            'width': '5%',
                                            'targets': 0
                                        }, // set 30% width for first column
                                        {
                                            'width': '5%',
                                            'targets': 2
                                        },
                                        {
                                            'width': '7%',
                                            'targets': 3
                                        },
                                        {
                                            'width': '5%',
                                            'targets': 6
                                        },
                                        {
                                            'width': '5%',
                                            'targets': 7
                                        },
                                    ],
                                    scrollCollapse: false,
                                    paging: false
                                });
                            }
                            if(sectselchk.checked && !deptselchk.checked)
                            {
                                $('#' + tid).DataTable().clear().destroy();
                                    $('#' + tid).DataTable({
                                    'searching': false,
                                    'serverSide': true,
                                    'processing': true,
                                    'autoWidth': true,
                                    'paging': false,
                                    'info': false,
                                    'order': [],
                                    'ajax': {
                                        'url': 'mfiltersectfetch.php',
                                        'type': 'post',
                                        'data':{
                                            section:filtersectval,
                                        },
                                    },
                                    'fnCreatedRow': function(nRow, aData, iDataIndex) {
                                        $(nRow).attr('id', aData[0]);
                                    },
                                    'columnDefs': [{
                                            'target': [0, 4],
                                            'orderable': false,
                                        },
                                        {
                                            'width': '5%',
                                            'targets': 0
                                        }, // set 30% width for first column
                                        {
                                            'width': '5%',
                                            'targets': 2
                                        },
                                        {
                                            'width': '7%',
                                            'targets': 3
                                        },
                                        {
                                            'width': '5%',
                                            'targets': 6
                                        },
                                        {
                                            'width': '5%',
                                            'targets': 7
                                        },
                                    ],
                                    scrollCollapse: false,
                                    paging: false
                                });
                            }

                        }     
        }
        //major functions end



            

         

    </script>
</body>

</html>