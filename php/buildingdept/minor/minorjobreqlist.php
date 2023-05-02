<?php
require_once('../../authentication/anti_pagetrans.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Minor Job Request List</title>
    <!--dependencies-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">-->
    <link type="text/css" href="../../../../dependencies/bootstrap/css/bootstrap.min.css?<?= time() ?>" rel="stylesheet">
    <!--<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.1/datatables.min.css" />-->
    <link rel="stylesheet" type="text/css" href="../../../../dependencies/datatables/datatables.min.css?<?= time() ?>" />
    <link rel="stylesheet" type="text/css" href="../../../../css/sidebar.css?<?= time() ?>">
    <link rel="stylesheet" type="text/css" href="../../../../css/header.css?<?= time() ?>">
    <link rel="stylesheet" type="text/css" href="../../../../css/body.css?<?= time() ?>">
    <link rel="stylesheet" type="text/css" href="../../../../css/admin/adminaccount.css?<?= time() ?>" />
    <!--<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>-->
    <link href='../../../../dependencies/boxicons/css/boxicons.min.css?<?= time() ?>' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="../../../../css/print.css?<?= time() ?>">
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
                <img src="../../../images/Brown_logo_faci.png" />
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
                        <button class="btn dropdown-toggle" style="box-shadow: none;"type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
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
                        <button class="btn dropdown-toggle" style="box-shadow: none;"type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
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
    <div class="table1">
        <div class="container-fluid">
            <div class="row">
                <div class="container">
                    <div class="row">
                        <div class="col-md-2" style="width: 15%;"></div>
                        <div class="col-sm-12 shadow" style="width: 100%; background-color: #FFF; padding-top: 100px; padding-left:50px; padding-right:50px; padding-bottom:50px; ">
                            <!-- padding-left:50px; padding-right:50px; padding-bottom:50px;-->
                            <table id="datatable" class="table">
                                <thead>
                                    <th>ID</th>
                                    <th>Department</th>
                                    <th>Section</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Options</th>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Optional JavaScript; choose one of the two! -->
    <!-- Optional JavaScript; choose one of the two! -->
    
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <!-- Script Process Start-- DO NOT MOVE THIS Script tags!!-->
    
    <!--<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>-->
    <script src="../../../../dependencies/jquery/jquery-3.6.4.min.js"></script>
    <!--<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.1/datatables.min.js"></script>-->
    <script type="text/javascript" src="../../../../dependencies/datatables/datatables.min.js"></script>
    <!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>-->
    <script src="../../../../dependencies/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="functions/js/process.js?random=<?php echo uniqid(); ?>"></script>
    <!-- Script Process End-->
    <!-- edit user modal-->
    <!-- Modal -->
    <div class="modal fade" id="editMinorjreqmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog " style="max-width:1100px;">
            <div class="modal-content ">
                <div class="modal-header justify-content-center" style="max-width:1100px;">
                    <div class="col-md-2" style="width:17%;">
                        <h5 class="modal-title text-uppercase fw-bold" id="exampleModalLabel">Job Request</h5>
                    </div>
                    <div class="col-md-12" style="width:15%">
                        <label class="" for="inputName">Status:</label>
                        <input type="text" style="width:60%" class="col-sm-1" name="_ID" class="form-control" id="_statustext" disabled>
                    </div>
                    <div class="col-md-1" style="width:10%">
                        <label class="" for="inputName">ID:</label>
                        <input type="text" style="width:21%" class="col-sm-1" name="_ID" class="form-control" id="_ID" disabled>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="updateUserForm" action="javascript:void();" method="POST">
                        <div class="modal-body">
                            <input type="hidden" id="id" name="id" value="">
                            <input type="hidden" id="trid" name="trid" value="">
                            <!-- Form Controls-->

                            <div class="row justify-content-center" style="padding-bottom:13px;">
                                <div class="col-md-6 ">
                                    <label class="fw-bold" for="date">Department:</label>
                                    <input type="name" class="form-control input-sm col-xs-1" id="_department" disabled>
                                </div>
                                <div class="col-md-6 ">
                                    <label class="fw-bold" for="date">Date:</label>
                                    <input type="name" class="form-control input-sm col-xs-1" id="_datemajorjr" disabled>
                                </div>
                            </div>
                            <div class="justify-content-center">
                                <h5 class="text-uppercase fw-bold">A. Requisition(To be filled up by the requesting party)</h5>
                                <div class="col-md-2" style="padding-bottom:10px">
                                    <label class="fw-bold" for="date">Quantity:</label>
                                    <input type="name" class="form-control input-sm col-xs-1" id="_quantity" placeholder="Quantity" disabled>
                                </div>
                            </div>
                            <div class="justify-content-center">
                                <div class="col-md-12">
                                    <label class="fw-bold" for="date">Item with Complete Description:</label>
                                    <textarea class="form-control" rows="2" id="_itemdesc" placeholder="Description"></textarea>
                                </div>
                            </div>
                            <div class="justify-content-center">
                                <div class="col-md-12">
                                    <label class="fw-bold" for="date">Purpose:</label>
                                    <textarea class="form-control" rows="2" id="_purpose" placeholder="Purpose" disabled></textarea>
                                </div>
                            </div>
                            <div class="justify-content-center">
                                <div class="col-md-12">
                                    <label class="fw-bold" for="date">Requested by:</label>
                                    <textarea class="form-control" rows="2" id="requestedby" placeholder="Requested by" disabled></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="fw-bold" style="padding-top:20px;" for="date">Section:</label>
                                    <select class="" style="width: 150px; Border: 5px;" name="sections" id="_sect">
                                        <option value="P" selected hidden>Select</option>
                                        <option value="C">CARPENTRY</option>
                                        <option value="P">PLUMBING</option>
                                        <option value="A">AIRCON</option>
                                        <option value="E">ELECTRICAL</option>
                                        <option value="H">HOUSEKEEPING</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row" style="padding-top:6px;">
                                <div class="col-md-4" style="margin-top:5px;">
                                    <label class="fw-bold" for="inputName">Building Department Approval Status:</label>
                                </div>
                                <div class="col-md-2">
                                    <input class="form-control" type="text" style = "margin-left:-50px;"name="" id="_step1" disabled>
                                </div>
                                <div class="col-md-2">
                                    <label class="fw-bold" for="date">Approved By</label>
                                </div>
                                <div class="col-md-4 "> 
                                    <input type="name" style = "margin-left:-50px;"class="form-control input-sm col-xs-1" id="_bdapprovedby" disabled>
                                </div>
                            </div>
                            <div class="row" style="padding-top:6px;">
                                <div class="col-md-2" style="margin-top:5px;">
                                    <label class="fw-bold" for="inputName">Noted By:</label>
                                </div>
                                <div class="col-md-4" style="margin-top:5px;">
                                    <input class="form-control" type="text" style="width:100%; height:80%; margin-left:-50px;" name="" id="_notedby">
                                </div>
                            </div>
                            <div class="row justify-content-center" style="padding-bottom:10px;">
                                <div class="col-md-6">
                                    <label class="fw-bold" for="renderedby">Rendered by:</label>
                                    <input type="name" class="form-control input-sm col-xs-1" id="_renderedby" disabled>
                                </div>
                                <div class="col-md-6">
                                    <label class="fw-bold" for="date">Date:</label>
                                    <input type="date" class="form-control input-sm col-xs-1" id="_daterendered" disabled>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-md-right">
                                <button onclick="enableFields()" type="button" class="btn btn-primary col-md-1" id="editbutton1">Edit</button>
                                <button type="button" class="btn btn-success col-md-1 renderUpdate" id="endediting1" hidden>Update</button>
                            </div>
                            <div class="row justify-content-center" style="padding-bottom:10px;">
                                <div class="col-md-6">
                                    <label class="fw-bold" for="renderedby">Confirmed by:</label>
                                    <input type="name" class="form-control input-sm col-xs-1" id="_confirmedby" disabled>
                                </div>
                                <div class="col-md-6">
                                    <label class="fw-bold" for="date">Date:</label>
                                    <input type="date" class="form-control input-sm col-xs-1" id="_dateconfirmed" disabled>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-md-right">
                                <button onclick="enableFields2()" type="button" class="btn btn-primary col-md-1" id="editbutton2">Edit</button>
                                <button type="button" class="btn btn-success col-md-1 confirmUpdate" id="endediting2" hidden>Update</button>
                            </div>
                            <div class="justify-content-center">
                                <div class="col-md-12">
                                    <label class="fw-bold" for="date">Feedback:</label>
                                    <textarea class="form-control" rows="2" id="_inputFeedback" placeholder="Feedback"></textarea>
                                </div>
                            </div>
                            <div>
                                <div class="modal-footer justify-content-md-center">
                                    <div class="col-md-12">
                                        <div class="alert1" id="alert1" style = "display:none; width: 100%;">
                                            <span class="cbtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                                            <strong id = "strongId">Success!</strong>
                                        </div>
                                    </div>
                                        <style>
                                            .alert1 {
                                            padding: 20px;
                                            background-color: red;
                                            color: white;
                                            }

                                            .cbtn {
                                            margin-left: 15px;
                                            color: white;
                                            font-weight: bold;
                                            float: right;
                                            font-size: 22px;
                                            line-height: 20px;
                                            cursor: pointer;
                                            transition: 0.3s;
                                            }

                                            .cbtn:hover {
                                            color: black;
                                            }
                                        </style>
                                    <a href="javascript:void();" class="btn btn-primary step1approveBtn" id= "step1a">Approve</a>
                                    <a href="javascript:void();" class="btn btn-danger step1declineBtn"id= "step1d">Decline</a>
                                    <!--<button type="" class="btn btn-primary approveBtn">Approve</button>
                                    <button type="button" class="btn btn-danger">Decline</button>
                                    <button type="submit" class="btn btn-info text-white">Update</button>-->
                                </div>
                            </div>
                            <!-- Form Controls End-->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="print-area">
        <div class="modal fade" id="printmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog " style="max-width:1100px;">
                <div class="modal-content" style="border: none; border-color: transparent;">
                    <div class="modal-header" style="max-width:1100px;">
                        <div class="col-md-5">
                            <h5 class="modal-title text-uppercase fw-bold" id="exampleModalLabel">MINOR JOB REQUEST</h5>
                        </div>
                        <div class="no-print-area">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                    </div>
                    <div class="modal-body">
                        <form id="saveUserForm" action="javascript:void();" method="POST">
                            <div class="modal-body">
                                <input type="hidden" id="id" name="id" value="">
                                <input type="hidden" id="trid" name="trid" value="">
                                <!-- Form Controls-->
                                <div id="print-section" *ngIf="propertyLedger">
                                    <div class="logo">
                                        <img src="../../../../images/uclogo.png" alt="" width="75" height="50" />
                                    </div>
                                    <table class="table borderless">
                                        <tr>
                                            <th class="col-md-3">ID:</th>
                                            <td><input style="border: none; border-color: transparent;" type="text" id="_idnum" disabled></td>
                                        </tr>
                                        <tr>
                                            <th class="col-md-3">Department:</th>
                                            <td><input style="border: none; border-color: transparent;" type="text" id="_department1" disabled></td>
                                        </tr>
                                        <tr>
                                            <th class="col-md-2" style="text-align: left;">Date</th>
                                            <td><input style="border: none; border-color: transparent;" type="text" id="_datemajorjr1" disabled></td>
                                        </tr>
                                        <tr>
                                            <th class="col-md-2" style="text-align: left;">Section</th>
                                            <td><input style="border: none; border-color: transparent;" type="text" id="_section" disabled></td>
                                        </tr>
                                    </table>
                                    <hr>
                                    <table class="table borderless">
                                        <tr>
                                            <th>QUANTITY</th>
                                            <th colspan="3">ITEMS WITH COMPLETE DESCRIPTION</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                        <tr>
                                            <td><textarea style="border: none; border-color: transparent;" class="form-control" rows="2" id="_quantity1" disabled></textarea></td>
                                            <td colspan="3"><textarea style="border: none; border-color: transparent;" class="form-control col-md-3" rows="2" id="_itemdesc1" disabled></textarea></td>
                                        </tr>
                                        <tr>
                                            <th class="col-md-2" style="text-align: left;">PURPOSE:</th>
                                            <td colspan="3"><textarea style="border: none; border-color: transparent;" class="form-control" rows="2" id="_purpose1" disabled></textarea></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr style="border: 0px; border: none">
                                            <th style="border: 0px; border: none">Requested by:</th>
                                            <td colspan="2" style="border: 0px; border: none "><input style="border: none; border-color: transparent;" type="text" id="_requestedby1" disabled></td>
                                            <td style="border: 0px; border: none "></td>
                                            <td style="border: 0px; border: none "></td>
                                        </tr>
                                        <tr>
                                            <th style="border: 0px; border: none">Noted By:</th>
                                            <td colspan="2" style="border: 0px; border: none "><input style="border: none; border-color: transparent;" type="text" id="_notedby1" disabled></td>
                                            <td style="border: 0px; border: none "></td>
                                            <td style="border: 0px; border: none "></td>
                                        </tr>
                                        <tr>
                                            <th colspan="4" style="border: 0px; border: none">B. ACCOMPLISHMENT REPORT (to be filled up by the MAINTENANCE representative) PROECT / SERVICE RENDERED AND ATTESTED BY:</th>
                                            <td style="border: 0px; border: none "></td>
                                            <td style="border: 0px; border: none "></td>
                                            <td style="border: 0px; border: none "></td>
                                        </tr>
                                        <tr>
                                            <th style="border: 0px; border: none">Rendered by:</th>
                                            <td style="border: 0px; border: none"><input style="border: none; border-color: transparent;" type="text" id="_renderedby1" disabled></td>
                                            <th style="border: 0px; border: none ">Date:</th>
                                            <td style="border: 0px; border: none"><input style="border: none; border-color: transparent;" type="text" id="_daterendered1" disabled></td>
                                        </tr>
                                        <tr>
                                            <th style="border: 0px; border: none">Confirmed By:</th>
                                            <td style="border: 0px; border: none"><input style="border: none; border-color: transparent;" type="text" id="_confirmedby1" disabled></td>
                                            <th style="border: 0px; border: none ">Date:</th>
                                            <td style="border: 0px; border: none"><input style="border: none; border-color: transparent;" type="text" id="_dateconfirmed1" disabled></td>
                                        </tr>
                                        
                                    </table>
                                    <div class="no-print-area">
                                        <div class="modal-footer justify-content-md-center">
                                            <a href="#" class="btn btn-secondary printbtn" onclick="printContent()">Print</a>

                                        </div>
                                    </div>
                                    <script>
                                        function printContent() {
                                            var printReport = document.getElementsByClassName("print-area");

                                            $('body').append('<div id="print" class="printBc"></div>');
                                            $(printReport).clone().appendTo('#print');

                                            $('body').css('background-color', 'white');
                                            $('body > :not(#print)').addClass('no-print-area');
                                            window.print();

                                            $('#print').remove();
                                            $('body').css('background-color', '');
                                            $('body > :not(#print)').removeClass('no-print-area');
                                        };
                                    </script>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deletemodal">
        <div class="modal-dialog ">
            <div class="modal-content ">
                <div class="modal-header" >
                    <h5 class="modal-title" id="exampleModalLabel">Success</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Successfully approve form</p>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="declinemodal">
        <div class="modal-dialog ">
            <div class="modal-content ">
                <div class="modal-header" >
                    <h5 class="modal-title" id="exampleModalLabel">Success</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Successfully declined form</p>
                </div>
            </div>
        </div>
    </div>
    <script>
        //datetime auto fill up
        var now = new Date();
        now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
        document.getElementById('datemajorjr').value = now.toISOString().slice(0, 16);
        //Requesting department auto fill up

        /*  var deptname;
        document.getElementById('inputRoleID').value = deptname;*/

        /*toggle edit and update buttons*/
        const paragraph = document.getElementById(""); //NOT DONE YET!
        const edit_button = document.getElementById("edit-button");
        const end_button = document.getElementById("end-editing");

        edit_button.addEventListener("click", function() {
            paragraph.contentEditable = true;
        });

        end_button.addEventListener("click", function() {
            paragraph.contentEditable = false;
        })
        //Onclick event for enabling button
        function autofilldate(filldate) {

            //document.getElementById("_daterendered").valueAsDate = today;
            //document.getElementById('_daterendered').value = new Date().toISOString();
            /*var now = new Date();
            now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
            document.getElementById('_daterendered').value = now.toISOString().substring(0, 10);
            
            */
            var now = new Date();
            now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
            document.getElementById(filldate).value = now.toISOString().substring(0, 10);

        }

        function enableFields() {
            document.getElementById("_renderedby").disabled = false;
            document.getElementById("_daterendered").disabled = false;
            document.getElementById("endediting1").hidden = false;
            document.getElementById("editbutton1").hidden = true;
            autofilldate("_daterendered");

        }

        function enableFields2() {
            document.getElementById("_confirmedby").disabled = false;
            document.getElementById("_dateconfirmed").disabled = false;
            document.getElementById("endediting2").hidden = false;
            document.getElementById("editbutton2").hidden = true;
            autofilldate("_dateconfirmed");
        }
    </script>
    <!-- edit user modalPopup end-->
</body>

</html>