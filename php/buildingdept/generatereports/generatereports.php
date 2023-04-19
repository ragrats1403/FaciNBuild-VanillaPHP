<?php
require_once('../../authentication/anti_pagetrans.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Generate Reports</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.1/datatables.min.css" />
    <link rel="stylesheet" type="text/css" href="../../../css/sidebar.css?<?= time() ?>">
    <link rel="stylesheet" type="text/css" href="../../../css/header.css?<?= time() ?>">
    <link rel="stylesheet" type="text/css" href="../../../css/body.css?<?= time() ?>">
    <link rel="stylesheet" type="text/css" href="../../../css/print.css?<?= time() ?>">
    <link rel="stylesheet" type="text/css" href="../../../css/admin/adminaccount.css?<?= time() ?>" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>


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
                    url: "../reservation/functions/notification.php",
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
                    url: "../reservation/functions/update_notification.php",
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
                <img src="../../../../images/Brown_logo_faci.png" />
            </div>
        </div>
        <div class="navdiv">
            <ul class="nav_list">
                <li>
                    <a href="../../../php/buildingdept/buildingcalendar.php">
                        <i class='bx bx-calendar'></i>
                        <span class="link_name">Calendar of Activities</span>
                    </a>
                </li>
                <li>
                    <div class="dropdown">
                        <i class='bx bx-notepad' style="margin-left:17px;"></i>
                        <button class="btn dropdown-toggle" style="box-shadow: none;" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            Manage Request
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="../../../php/buildingdept/minor/minorjobreqlist.php">Minor Job Request</a>
                            <a class="dropdown-item" href="../../../php/buildingdept/major/majorjobreqlist.php">Major Job Request</a>
                        </ul>
                    </div>
                </li>
                <li>
                    <div class="dropdown">
                        <i class='bx bx-clipboard' style="margin-left:17px;"></i>
                        <button class="btn dropdown-toggle" style="box-shadow: none;" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            View/Create Request
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="../../../php/buildingdept/minoruser/minorjobreqlist.php">Minor Job Request</a>
                            <a class="dropdown-item" href="../../../php/buildingdept/majoruser/majorjobreqlist.php">Major Job Request</a>
                            <a class="dropdown-item" href="../../../php/buildingdept/reservation/buildingdeptreservation.php">Reservation</a>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="../../../php/buildingdept/generatereports/generatereports.php">
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
                            <div class="role">Building Department</div>
                        </div>
                    </div>
                    <a href="../../../../logout.php">
                        <i class='bx bx-log-out' id="log_out"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
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
                                    <input class="form-check-input" type="checkbox" id="minorDivCheckdefault" onclick="myFunction('minorDiv', 'minortable', 'minorfetch.php')" onchange = "onchangeval('minorDiv', 'minordatestart', 'minordateend');">
                                    <label class="form-check-label" for="minorDivCheckdefault"> Minor Job Request </label>

                                    <br>
                                        <label class="fw-bold" for="date">Date Start:</label>
                                        <input type="date" class="form-control input-sm col-xs-1" id="minordatestart" placeholder="Date Filed" onchange="myFunction('minorDiv', 'minortable', 'minorfetchdate.php')" disabled>
                                    
                                    
                                        <label class="fw-bold" for="date">Date End:</label>
                                        <input type="date" class="form-control input-sm col-xs-1" id="minordateend" placeholder="Date Filed" onchange="myFunction('minorDiv', 'minortable', 'minorfetchdate.php')" disabled>
                                    
                                </div>
                                <div class="col-md-3" onMouseDown="return false;" onSelectStart="return false;">
                                    <input class="form-check-input" type="checkbox" value="" id="majorDivCheckDefault" onclick="myFunction('majorDiv', 'majortable', 'majorfetch.php')" onchange = "onchangeval('majorDiv', 'majordatestart', 'majordateend');">
                                    <label class="form-check-label" for="majorDivCheckDefault"> Major Job Request </label>
                                    <br>
                                        <label class="fw-bold" for="date">Date Start:</label>
                                        <input type="date" class="form-control input-sm col-xs-1" id="majordatestart" placeholder="Date Filed" onchange="myFunction('majorDiv', 'majortable', 'majorfetchdate.php')" disabled>
                                        <label class="fw-bold" for="date">Date End:</label>
                                        <input type="date" class="form-control input-sm col-xs-1" id="majordateend" placeholder="Date Filed" onchange="myFunction('majorDiv', 'majortable', 'majorfetchdate.php')" disabled>
                                </div>
                            </div>
                            <br>
                            <div class="col-md-2">
                                <button class="btn btn-info" onclick="printDiv()">Print</button>
                            </div>
                            <div id="minorDiv" style="display: none;">
                                <table id="minortable" class="table">
                                    <thead>
                                        <h5 class="fw-bold"> Minor Job Request </h5>
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
                                <table id="majortable" class="table">
                                    <thead>
                                        <h5 class="fw-bold"> Major Job Request </h5>
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
  if (document.getElementById("minorDivCheckdefault").checked || document.getElementById("majorDivCheckDefault").checked) {
    var printContents = "";
    if (document.getElementById("minorDivCheckdefault").checked) {
      printContents += "<div style='position: relative; left: -200px; margin-bottom: 50px;'>" + document.getElementById("minorDiv").innerHTML + "</div>";
    }
    if (document.getElementById("majorDivCheckDefault").checked) {
      printContents += "<div style='position: relative; left: -200px; margin-bottom: 50px;'>" + document.getElementById("majorDiv").innerHTML + "</div>";
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
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.1/datatables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
        function onchangeval(divID, datestart, dateend)
        {   
            var dates = document.getElementById(datestart);
            var datee = document.getElementById(dateend);
            var x = document.getElementById(divID);
            if (x.style.display === "block") {
                    x.style.display = "none";
                    dates.disabled = true;
                    datee.disabled = true;
                    dates.value = null;
                    datee.value = null;
                } else {
                    x.style.display = "block";
                    dates.disabled = false;
                    datee.disabled = false;
                  
                    
            }
        }

        function myFunction(divID, tableid, fetchdataid) {
            var x = document.getElementById(divID);
            var tid = tableid;
            var fdid = fetchdataid;
            var dates = document.getElementById("minordatestart").value;
            var datee = document.getElementById("minordateend").value;
            var ndates = document.getElementById("majordatestart").value;
            var ndatee = document.getElementById("majordateend").value;


            if(dates == null || datee == null)
            {
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
            else
            {

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
                                'data': {
                                    datestart: ndates,
                                    dateend: ndatee,
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
            }


         

    </script>
</body>

</html>