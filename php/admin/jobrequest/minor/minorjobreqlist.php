<?php
require_once('../../../authentication/anti_pagetrans.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Minor Job Request List</title>
     <!--dependencies-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" href="../../../../dependencies/bootstrap/css/bootstrap.min.css?<?= time() ?>" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../../../../dependencies/datatables/datatables.min.css?<?= time() ?>" />
    <link rel="stylesheet" type="text/css" href="../../../../css/sidebar.css?<?=time()?>">
    <link rel="stylesheet" type="text/css" href="../../../../css/header.css?<?=time()?>">
    <link rel="stylesheet" type="text/css" href="../../../../css/body.css?<?=time()?>">
    <link rel="stylesheet" type="text/css" href="../../../../css/admin/adminaccount.css?<?=time()?>" />
    <link rel="stylesheet" type="text/css" href="../../../../css/print.css?<?= time() ?>">
    <link href='../../../../dependencies/boxicons/css/boxicons.min.css?<?= time() ?>' rel='stylesheet'> 
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
                    url: "../../reservations/functions/notification.php",
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
                    url: "../../reservations/functions/update_notification.php",
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
        <p>Hello, <?php echo $_SESSION['department'];?></p>
        </div>
        <nav class="gnav">
        </nav>
    </div>
</header>

<body onload="autofilldate('datemajorjr');">

<div class="sidebar">
        <div class="logo_content">
            <div class="logo">
                <img src="../../../../images/Black_logo.png" />
            </div>
        </div>
        <div class="navdiv">
            <ul class="nav_list">
                <li>
                    <a href="../../../../php/admin/reservations/admincalendar.php">
                        <i class='bx bx-calendar'></i>
                        <span class="link_name">Calendar of Activities</span>
                    </a>
                </li>
                <li>
                    <a href="../../../../php/admin/accounts/admin_account.php">
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
                            <a class="dropdown-item" href="../../../../php/admin/jobrequest/minor/minorjobreqlist.php">Minor Job Request</a>
                            <a class="dropdown-item" href="../../../../php/admin/jobrequest/major/majorjobreqlist.php">Major Job Request</a>
                            <a class="dropdown-item" href="../../../../php/admin/reservations/adminreservations.php">Reservations</a>  
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="../../../../php/admin/equipments/adminequipment.php">
                        <i class='bx bx-wrench'></i>
                        <span class="link_name">Facilities Equipment</span>
                    </a>
                </li>
                <li>
                        <a href="../../../../php/admin/generatereports/generatereports.php">
                            <i class='bx bx-food-menu'></i>
                            <span class="link_name">Generate Report</span>
                        </a>
                    </li>
            </ul>

        <div class="profile_content">
                <div class="profile">
                    <div class="profile_details">
                    <img src="../../../../images/ico/profileicon.png" alt="" style = "height: 45px; width:45px; object-fit:cover; border-radius:12px;" />
                        <div class="name_role">
                        <div class="name"><?php echo mb_strimwidth($_SESSION['department'], 0, 20, '…');?></div>
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
    
   <div class="table1">
        <div class="container-fluid">
            <div class="row">
                <div class="container">
                    <div class="row">
                        <div class="col-md-2" style="width: 15%;"></div>
                        <div class="col-sm-12 shadow" style="width: 100%; background-color: #FFF; padding-top: 100px; padding-left:50px; padding-right:50px; padding-bottom:50px; ">
                            <!-- padding-left:50px; padding-right:50px; padding-bottom:50px;-->
                            <table id="datatable" class="table" >
                                <thead>
                                    <th>ID</th>
                                    <th>Department</th>
                                    <th>Section</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Options</th>
                                </thead>
                            </table>
                            <div class="col-sm-12 d-flex justify-content-end">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">Create Minor Job Request</button>
                            </div>
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
    <script src="../../../../dependencies/jquery/jquery-3.6.4.min.js"></script>
    <script type="text/javascript" src="../../../../dependencies/datatables/datatables.min.js"></script>
    <script type="text/javascript" src="functions/js/process.js?random=<?php echo uniqid(); ?>"></script>
    <script src="../../../../dependencies/bootstrap/js/bootstrap.bundle.min.js"></script>
    
                        
    <!-- Script Process End-->
    <!-- add user modal-->
    <!-- Modal Popup -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="max-width:1100px;">
            <div class="modal-content">
                <div class="modal-header justify-content-center" style="max-width:1100px;">
                    <div class="col-md-2" style="width:17%;">
                        <h5 class="modal-title text-uppercase fw-bold" id="exampleModalLabel">Job Request</h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="col-md-12">
                                        <div class="alert1" id="alert1" style = "display:none; width: 100%;">
                                            <span class="cbtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                                            <strong id = "strongId1">Please fill in required fields</strong>
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
                <div class="modal-body ">
                    <form id="saveUserForm" action="javascript:void();" method="POST">
                        <div class="modal-body">
                            <!-- Form Controls-->
                            <div class="row justify-content-center" style="padding-bottom:13px;">
                                <div class="col-md-6 ">
                                    <label class="fw-bold" for="date">Department:</label>
                                    <input type="name" class="form-control input-sm col-xs-1" id="department" placeholder="Department" value="<?php echo mb_strimwidth($_SESSION['department'], 0, 30, '…'); ?>" disabled>
                                </div>
                                <div class="col-md-6 ">
                                    <label class="fw-bold" for="date">Date:</label>
                                    <input type="datetime-local" class="form-control input-sm col-xs-1" id="datemajorjr" placeholder="Date" disabled>

                                </div>
                            </div>
                            <div class="justify-content-center">
                                <h5 class="text-uppercase fw-bold">Requisition(To be filled up by the requesting party)</h5>
                                <div class = "row">
                                    <div class="col-md-1" >
                                        <input type="name" class="form-control input-sm col-xs-1" id="numForms" style="width:60%; text-align:left;" value = "1" disabled>
                                    </div>
                                    <div class="col-md-1" style="margin-left: -4.5%;">
                                        <button type="button" class="btn btn-light" id="subForm" onclick= "subtract();"><b>-</b></button>
                                    </div>
                                    
                                    <div class="col-md-1" style="margin-left: -5%;">
                                        <button type="button" class="btn btn-light" id="addForm" onclick = "add();"><b>+</b></button>
                                    </div>
                                </div>
                                <script>
                                    function subtract()
                                    {
                                        var num = document.getElementById("numForms").value;

                                        if(num <= 5 && num >= 2)
                                        {
                                            var divid = num+"_";
                                            myFunctionPrompt(divid);
                                            var newnum = num - 1;
                                            $('#numForms').val(newnum);
                                        }
                                        else
                                        {
                                            
                                            return null;
                                        }
                                    }

                                    function add()
                                    {
                                        var num = document.getElementById("numForms").value;

                                        if(num < 5 && num >= 1)
                                        {
                                            var newnum = parseInt(num) + 1;
                                            $('#numForms').val(newnum);
                                            var divid = newnum+"_";
                                            myFunctionPrompt(divid);
                                            table = $('#datatable').DataTable();
                                            table.draw();
                                        }
                                        else
                                        {
                                            return null;
                                        }
                                    }
                                    function myFunctionPrompt(divID) {
                                        var x = document.getElementById(divID);
                                        if (x.style.display === "block") {
                                            x.style.display = "none";
                                        } else {
                                            x.style.display = "block";
                                        }   
                                        }

                                        
                                </script>
                                <style>
                                    hr.solid {
                                    border-top: 3px solid #bbb;
                                    }
                                </style>
                                <div class="col-md-2" style="padding-bottom:10px">
                                    <label class="fw-bold" for="date">Quantity:</label>
                                    <input type="name" class="form-control input-sm col-xs-1" id="_quantity_" placeholder="Quantity">
                                </div>
                            </div>
                            <div class="justify-content-center">
                                <div class="col-md-12">
                                    <label class="fw-bold" for="date">Item with Complete Description:</label>
                                    <textarea class="form-control" rows="2" id="_itemdesc_" placeholder="Description"></textarea>
                                </div>
                            </div>

                            <div class = "2" style= "display:none;" id="2_">
                            <hr class="solid">
                                    <div class="justify-content-center">                                 
                                        <div class="col-md-2" style="padding-bottom:10px">
                                            <label class="fw-bold" for="date">Quantity:</label>
                                            <input type="name" class="form-control input-sm col-xs-1" id="_quantity_2" placeholder="Quantity">
                                            
                                        </div>
                                    </div>
                                    <div class="justify-content-center">
                                        <div class="col-md-12">
                                            <label class="fw-bold" for="date">Item with Complete Description:</label>
                                            <textarea class="form-control" rows="2" id="_itemdesc_2" placeholder="Description"></textarea>
                                        </div>
                                    </div>
                            <hr class="solid">
                            </div>
                            <div class = "3" style= "display:none;" id="3_">
                                    <div class="justify-content-center">                                 
                                        <div class="col-md-2" style="padding-bottom:10px">
                                            <label class="fw-bold" for="date">Quantity:</label>
                                            <input type="name" class="form-control input-sm col-xs-1" id="_quantity_3" placeholder="Quantity">
                                        </div>
                                    </div>
                                    <div class="justify-content-center">
                                        <div class="col-md-12">
                                            <label class="fw-bold" for="date">Item with Complete Description:</label>
                                            <textarea class="form-control" rows="2" id="_itemdesc_3" placeholder="Description"></textarea>
                                    </div>
                                </div>
                                <hr class="solid">
                            </div>
                            <div class = "4" style= "display:none;" id="4_">
                                    <div class="justify-content-center">                                 
                                        <div class="col-md-2" style="padding-bottom:10px">
                                            <label class="fw-bold" for="date">Quantity:</label>
                                            <input type="name" class="form-control input-sm col-xs-1" id="_quantity_4" placeholder="Quantity">
                                        </div>
                                    </div>
                                    <div class="justify-content-center">
                                        <div class="col-md-12">
                                            <label class="fw-bold" for="date">Item with Complete Description:</label>
                                            <textarea class="form-control" rows="2" id="_itemdesc_4" placeholder="Description"></textarea>
                                    </div>
                                </div>
                                <hr class="solid">
                            </div>
                            <div class = "5" style= "display:none;" id="5_">
                                    <div class="justify-content-center">                                 
                                        <div class="col-md-2" style="padding-bottom:10px">
                                            <label class="fw-bold" for="date">Quantity:</label>
                                            <input type="name" class="form-control input-sm col-xs-1" id="_quantity_5" placeholder="Quantity">
                                        </div>
                                    </div>
                                    <div class="justify-content-center">
                                        <div class="col-md-12">
                                            <label class="fw-bold" for="date">Item with Complete Description:</label>
                                            <textarea class="form-control" rows="2" id="_itemdesc_5" placeholder="Description"></textarea>
                                    </div>
                                </div>
                                <hr class="solid">
                            </div>

                            <div class="justify-content-center">
                                <div class="col-md-12">
                                    <label class="fw-bold" for="date">Purpose:</label>
                                    <textarea class="form-control" rows="2" id="_purpose_" placeholder="Purpose"></textarea>
                                </div>
                            </div>
                            <div class="justify-content-center">
                                <div class="col-md-12">
                                    <label class="fw-bold" for="date">Requested by:</label>
                                    <textarea class="form-control" rows="2" id="requestedby" placeholder="Requested by"></textarea>
                                </div>
                            </div>

                            <!-- Form Controls End-->
                        </div>
                        <div class="modal-footer justify-content-md-center">
                            <button type="button" class="btn btn-secondary col-md-2" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary col-md-2">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- add user modal end-->
    <!-- edit user modal-->
    <!-- Modal -->

    
    <div class="modal fade" id="editMinorjreqmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog " style="max-width:1100px;">
            <div class="modal-content ">
                <div class="modal-header justify-content-center" style="max-width:1100px;">
                    <div class="col-md-2" style="width:17%;">
                        <h5 class="modal-title text-uppercase fw-bold" id="exampleModalLabel" >Job Request</h5>
                    </div>
                    <div class="col-md-12" style="width:15%">
                        <label class=""  for="inputName">Status:</label>
                        <input type="text" style="width:60%" class="col-sm-1" name="_ID" class="form-control" id= "_statustext" disabled> 
                    </div>
                    <div class="col-md-1" style="width:10%">
                        <label class=""  for="inputName">ID:</label>
                        <input type="text" style="width:21%" class="col-sm-1" name="_ID" class="form-control" id="_ID" disabled>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="col-md-12">
                                        <div class="alert2" id="alert2" style = "display:none; width: 100%;">
                                            <span class="cbtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                                            <strong id = "strongId2"></strong>
                                        </div>
                                        <div class="alert3" id="alert3" style = "display:none; width: 100%;">
                                            <span class="cbtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                                            <strong id = "strongId3"></strong>
                                        </div>
                                    </div>
                                        <style>
                                            .alert2 {
                                            padding: 20px;
                                            background-color: red;
                                            color: white;
                                            }
                                            .alert3 {
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
                                <h5 class="text-uppercase fw-bold" >A. Requisition(To be filled up by the requesting party)</h5>
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

                            <!--multiple start-->
                            <div class = "2" style= "display:none;" id="_2">
                            <hr class="solid">
                                    <div class="justify-content-center">                                 
                                        <div class="col-md-2" style="padding-bottom:10px">
                                            <label class="fw-bold" for="date">Quantity:</label>
                                            <input type="name" class="form-control input-sm col-xs-1" id="quantity_2" placeholder="Quantity" disabled>
                                            
                                        </div>
                                    </div>
                                    <div class="justify-content-center">
                                        <div class="col-md-12">
                                            <label class="fw-bold" for="date">Item with Complete Description:</label>
                                            <textarea class="form-control" rows="2" id="itemdesc_2" placeholder="Description" disabled></textarea>
                                        </div>
                                    </div>
                            <hr class="solid">
                            </div>
                            <div class = "3" style= "display:none;" id="_3">
                                    <div class="justify-content-center">                                 
                                        <div class="col-md-2" style="padding-bottom:10px">
                                            <label class="fw-bold" for="date">Quantity:</label>
                                            <input type="name" class="form-control input-sm col-xs-1" id="quantity_3" placeholder="Quantity" disabled>
                                        </div>
                                    </div>
                                    <div class="justify-content-center">
                                        <div class="col-md-12">
                                            <label class="fw-bold" for="date">Item with Complete Description:</label>
                                            <textarea class="form-control" rows="2" id="itemdesc_3" placeholder="Description" disabled></textarea>
                                    </div>
                                </div>
                                <hr class="solid">
                            </div>
                            <div class = "4" style= "display:none;" id="_4">
                                    <div class="justify-content-center">                                 
                                        <div class="col-md-2" style="padding-bottom:10px">
                                            <label class="fw-bold" for="date">Quantity:</label>
                                            <input type="name" class="form-control input-sm col-xs-1" id="quantity_4" placeholder="Quantity" disabled>
                                        </div>
                                    </div>
                                    <div class="justify-content-center">
                                        <div class="col-md-12">
                                            <label class="fw-bold" for="date">Item with Complete Description:</label>
                                            <textarea class="form-control" rows="2" id="itemdesc_4" placeholder="Description" disabled></textarea>
                                    </div>
                                </div>
                                <hr class="solid">
                            </div>
                            <div class = "5" style= "display:none;" id="_5">
                                    <div class="justify-content-center">                                 
                                        <div class="col-md-2" style="padding-bottom:10px">
                                            <label class="fw-bold" for="date">Quantity:</label>
                                            <input type="name" class="form-control input-sm col-xs-1" id="quantity_5" placeholder="Quantity" disabled>
                                        </div>
                                    </div>
                                    <div class="justify-content-center">
                                        <div class="col-md-12">
                                            <label class="fw-bold" for="date">Item with Complete Description:</label>
                                            <textarea class="form-control" rows="2" id="itemdesc_5" placeholder="Description" disabled></textarea>
                                    </div>
                                </div>
                                <hr class="solid">
                            </div>
                            <!--multiple end-->

                            <div class="justify-content-center">
                                <div class="col-md-12" >
                                    <label class="fw-bold" for="date">Purpose:</label>
                                    <textarea class="form-control" rows="2" id="_purpose" placeholder="Purpose" disabled></textarea>
                                </div>
                            </div>
                            <div class="justify-content-center">
                                <div class="col-md-12">
                                    <label class="fw-bold" for="date">Requested by:</label>
                                    <textarea class="form-control" rows="2" id="_requestedby" placeholder="Requested by" disabled></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="fw-bold" style="padding-top:20px;" for="date">Section:</label>
                                    <select class="" style="width: 150px; Border: 5px;" name="sections" id="_sect">
                                    <option disabled selected value hidden></option>
                                        <option value="C">CARPENTRY</option>
                                        <option value="P">PLUMBING</option>
                                        <option value="A">AIRCON</option>
                                        <option value="E">ELECTRICAL</option>
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
                                <div class="col-md-1" style="margin-top:5px;">
                                    <label class="fw-bold" for="inputName">Noted By:</label>
                                </div>
                                <div class="col-md-4" style="margin-top:5px;">
                                    <input class="form-control" type="text" style="width:100%; height:80%;" name="" id="_notedby">
                                </div>
                                <div class="col-md-1" style="margin-top:5px; margin-left:30px;">
                                    <a href= "javascript:void();" class ="btn btn-success step1approveBtn" id = "step1a">Approve</a>
                                </div>
                                <div class="col-md-1"style="margin-top:5px;">
                                    <a href= "javascript:void();" class ="btn btn-danger step1declineBtn" id = "step1d">Decline</a>
                                </div>
                            </div>
                            <div class="row justify-content-center" style="padding-bottom:10px;">
                                <div class="col-md-6">
                                    <label class="fw-bold" for="renderedby">Rendered by:</label>
                                    <input type="name" class="form-control input-sm col-xs-1" id="_renderedby" onKeyPress = "enableFields();" disabled>
                                </div>
                                <div class="col-md-6">
                                    <label class="fw-bold" for="date">Date:</label>
                                    <input type="date" class="form-control input-sm col-xs-1" id="_daterendered" disabled>
                                </div>
                            </div>

                            <div class="row justify-content-center" style="padding-bottom:10px;">
                                <div class="col-md-6">
                                    <label class="fw-bold" for="renderedby">Confirmed by:</label>
                                    <input type="name" class="form-control input-sm col-xs-1" id="_confirmedby"  onKeyPress = "enableFields2();"disabled>
                                </div>
                                <div class="col-md-6">
                                    <label class="fw-bold" for="date">Date:</label>
                                    <input type="date" class="form-control input-sm col-xs-1" id="_dateconfirmed" disabled>
                                </div>
                            </div>
                        <div class="justify-content-center">
                                <div class="col-md-12" >
                                    <label class="fw-bold" for="date">Feedback:</label>
                                    <textarea class="form-control" rows="2" id="_inputFeedback" placeholder="Feedback"></textarea>
                                </div>
                            </div>
                        <div>
                        <div class="modal-footer justify-content-md-center">
                            <a href="javascript:void();" class="btn btn-info text-white updateBtn" id="updbtn" hidden>Update</a>
                            <a href="javascript:void();" class="btn btn-secondary editfieldBtn">Edit</a>
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
                                            <td><textarea style="border: none; border-color: transparent;" class="form-control" rows="2" id="quantity2" disabled></textarea></td>
                                            <td colspan="3"><textarea style="border: none; border-color: transparent;" class="form-control col-md-3" rows="2" id="itemdesc2" disabled></textarea></td>
                                        </tr>
                                        <tr>
                                            <td><textarea style="border: none; border-color: transparent;" class="form-control" rows="2" id="quantity3" disabled></textarea></td>
                                            <td colspan="3"><textarea style="border: none; border-color: transparent;" class="form-control col-md-3" rows="2" id="itemdesc3" disabled></textarea></td>
                                        </tr>
                                        <tr>
                                            <td><textarea style="border: none; border-color: transparent;" class="form-control" rows="2" id="quantity4" disabled></textarea></td>
                                            <td colspan="3"><textarea style="border: none; border-color: transparent;" class="form-control col-md-3" rows="2" id="itemdesc4" disabled></textarea></td>
                                        </tr>
                                        <tr>
                                            <td><textarea style="border: none; border-color: transparent;" class="form-control" rows="2" id="quantity5" disabled></textarea></td>
                                            <td colspan="3"><textarea style="border: none; border-color: transparent;" class="form-control col-md-3" rows="2" id="itemdesc5" disabled></textarea></td>
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
    <script>
        $('#printmodal').on('hidden.bs.modal', function () {
        $('textarea').val(''); // clear all textareas
        });
    </script>
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
    <div class="modal fade" id="deletemodal">
        <div class="modal-dialog ">
            <div class="modal-content ">
                <div class="modal-header" >
                    <h5 class="modal-title" id="exampleModalLabel">Warning!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="close-modal">No</button>
                    <button type="button" class="btn btn-danger">Yes</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="createdmodal">
        <div class="modal-dialog ">
            <div class="modal-content ">
                <div class="modal-header" >
                    <h5 class="modal-title" id="exampleModalLabel">Success</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Successfully Created Minor Job request</p>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="approvedmodal">
        <div class="modal-dialog ">
            <div class="modal-content ">
                <div class="modal-header" >
                    <h5 class="modal-title" id="exampleModalLabel">Success</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Successfully approved Minor Job request</p>
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
                    <p>Successfully declined Minor Job request</p>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="updateform">
        <div class="modal-dialog ">
            <div class="modal-content ">
                <div class="modal-header" >
                    <h5 class="modal-title" id="exampleModalLabel">Success</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Successfully updated Minor Job request</p>
                </div>
            </div>
        </div>
    </div>
    <script>
        //datetime auto fill up
        var now = new Date();
        now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
        var formattedDate = now.toISOString().slice(0, 19);
        document.getElementById('datemajorjr').value = formattedDate;
        //Requesting department auto fill up
        
        /*  var deptname;
        document.getElementById('inputRoleID').value = deptname;*/

        /*toggle edit and update buttons*/
        const paragraph = document.getElementById("");          //NOT DONE YET!
        const edit_button = document.getElementById("edit-button");
        const end_button = document.getElementById("end-editing");

        edit_button.addEventListener("click", function() {
        paragraph.contentEditable = true;
        } );

        end_button.addEventListener("click", function() {
        paragraph.contentEditable = false;
        } )
        //Onclick event for enabling button
    function autofilldate(filldate) {

    var now = new Date();
    now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
    var formattedDate = now.toISOString().slice(0, 10);
    document.getElementById(filldate).value = formattedDate;

    }
    function enableFields() {


    autofilldate("_daterendered");

    }
    function enableFields2() {

    autofilldate("_dateconfirmed");
    }
            
    </script>
    <!-- edit user modalPopup end-->
</body>
</html>