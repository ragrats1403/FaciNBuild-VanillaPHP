<?php
require_once('../../authentication/anti_pagetrans.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Minor Job Request List</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" href="../../../dependencies/bootstrap/css/bootstrap.min.css?<?= time() ?>" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../../../dependencies/datatables/datatables.min.css?<?= time() ?>" />
    <link rel="stylesheet" type="text/css" href="../../../../css/sidebar.css?<?= time() ?>">
    <link rel="stylesheet" type="text/css" href="../../../../css/header.css?<?= time() ?>">
    <link rel="stylesheet" type="text/css" href="../../../../css/body.css?<?= time() ?>">
    <link rel="stylesheet" type="text/css" href="../../../../css/admin/adminaccount.css?<?= time() ?>" />
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
                    <a href="../../../../php/pco/pcocalendar.php">
                        <i class='bx bx-calendar'></i>
                        <span class="link_name">Calendar of Activities</span>
                    </a>
                </li>
                <li>
                    <div class="dropdown">
                        <i class='bx bx-clipboard' style="margin-left:17px;"></i>
                        <button class="btn dropdown-toggle" style="box-shadow: none;"type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            Manage Request
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="/../../../php/pco/major/majorjobreqlist.php">Major Job Request</a>
                        </ul>
                    </div>
                    <div class="dropdown">
                        <i class='bx bx-notepad' style="margin-left:17px;"></i>
                        <button class="btn dropdown-toggle" style="box-shadow: none;"type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            View/Create Request
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="../../../php/pco/minor/minorjobreqlist.php">Minor Job Request</a>
                            <a class="dropdown-item" href="../../../php/pco/majoruser/majorjobreqlist.php">Major Job Request</a>
                            <a class="dropdown-item" href="../../../php/pco/reservation/pcoreservation.php">Reservation</a>
                        </ul>
                    </div>
                </li>
            </ul>
            <div class="profile_content">
                <div class="profile">
                    <div class="profile_details">
                        <img src="../../../../images/ico/profileicon.png" alt="" style="height: 45px; width:45px; object-fit:cover; border-radius:12px;" />
                        <div class="name_role">
                            <div class="name"><?php echo mb_strimwidth($_SESSION['department'], 0, 20, '…'); ?></div>
                            <div class="role">PCO Department</div>
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
                        <div class="col-sm-12 shadow" style="width: 100%; background-color: #FFF; padding-top: 100px; padding-left:50px; padding-right:50px; padding-bottom:50px; ">
                            <!-- padding-left:50px; padding-right:50px; padding-bottom:50px;-->
                            <table id="datatable" class="table">
                                <thead>
                                    <th>ID</th>
                                    <th>Department</th>
                                    <th>Date</th>
                                    <th>Section</th>
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
    <!-- Script Process Start-->
    <script src="../../../dependencies/jquery/jquery-3.6.4.min.js"></script>
    <script type="text/javascript" src="../../../dependencies/datatables/datatables.min.js"></script>
    <script src="../../../dependencies/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        var dpt = "<?php echo $_SESSION['department']; ?>";
$('#datatable').DataTable({
    'serverSide': true,
    'processing': true,
    'paging': true,
    'order': [],
    'responsive': true,
    'ajax': {
        'url': 'functions/fetch_data.php',
        'type': 'post',
        'data': {
            'dpt': dpt,
        },
    },
    'fnCreatedRow': function(nRow, aData, iDataIndex) {
        $(nRow).attr('id', aData[0]);
        if (aData[4] === 'Approved') {
            $(nRow).css('background-color', '#a7d9ae');
        }
        if (aData[4] === 'Declined') {
            $(nRow).css('background-color', '#e09b8d');
        }
        if (aData[4] === 'Pending') {
            $(nRow).css('background-color', '#d9d2a7');
        }
    },
    'columnDefs': [{
        'target': [0, 4],
        'orderable': false,
    }],
    scrollY: 670,
    'scrollCollapse': true,
    'paging': false,
});
    </script>
    <script type="text/javascript">
        
        //add button control
        $(document).on('submit', '#saveUserForm', function(event) {
            document.getElementById("savechange").disabled = true;
            var department = $('#department').val();
            var date = $('#datemajorjr').val();
            var quantity = $('#_quantity_').val();
            var description = $('#_itemdesc_').val();
            var purpose = $('#_purpose_').val();
            var renderedby = $('#renderedby').val();
            var daterendered = $('#daterendered').val();
            var confirmedby = $('#confirmedby').val();
            var dateconfirmed = $('#dateconfirmed').val();
            var requestedby = $('#requestedby').val();
            if (department != '' && date != '' && quantity != '' && requestedby != '' && description != '' && purpose != '' && renderedby != '' && daterendered != '' && confirmedby != '' && dateconfirmed != '') {
                $.ajax({
                    url: "functions/add_data.php",
                    data: {
                        department: department,
                        date: date,
                        quantity: quantity,
                        requestedby: requestedby,
                        description: description,
                        purpose: purpose,
                        renderedby: renderedby,
                        daterendered: daterendered,
                        confirmedby: confirmedby,
                        dateconfirmed: dateconfirmed,

                    },
                    type: 'POST',
                    success: function(data) {
                        var json = JSON.parse(data);
                        status = json.status;
                        if (status = 'success') {
                            table = $('#datatable').DataTable();
                            table.draw();
                            $('#_quantity_').val('');
                            $('#_item_').val('');
                            $('#_itemdesc_').val('');
                            $('#_purpose_').val('');
                            $('#renderedby').val('');
                            $('#daterendered').val('');
                            $('#confirmedby').val('');
                            $('#dateconfirmed').val('');   
                            $('#requestedby').val('');
                            myFunctionPrompt("alert1");
                            var loopnum = $('#numForms').val();
                            if(loopnum > 1)
                            {
                                for(var i = 1; i<loopnum; i++)
                                {
                                    var iterate = i+1
                                    var quantityid = "_quantity_" + iterate;
                                    var itemdescid = "_itemdesc_" + iterate;
                                    var exquantity = document.getElementById(quantityid).value;
                                    var exitemdesc = document.getElementById(itemdescid).value;
                                    console.log(quantityid);
                                    console.log(itemdescid);
                                    $.ajax({
                                            url: "functions/addmultidata.php",
                                            data: {
                                                department: department,
                                                date: date,
                                                quantity: exquantity,
                                                requestedby: requestedby,
                                                description: exitemdesc,
                                                purpose: purpose,
                                                multinum: iterate,

                                            },
                                            type: 'POST',
                                            success: function(data) {
                                                $('#_quantity_2').val('');
                                                $('#_itemdesc_2').val('');
                                                $('#_quantity_3').val('');
                                                $('#_itemdesc_3').val('');
                                                $('#_quantity_4').val('');
                                                $('#_itemdesc_4').val('');
                                                $('#_quantity_5').val('');
                                                $('#_itemdesc_5').val('');
                                            }
                                        });
                            }
                            
                            document.getElementById("savechange").disabled = false;
                            
                        }
                        $('#addUserModal').scrollTop(0);
                    }
                    }
                });
            } else {
                $('#alert2').css('display', 'block');
                $('#strongId1').html('Please fill all the Required fields');
                document.getElementById("savechange").disabled = false;
            }
        });
        //edit button control 
        $(document).on('click', '.editBtn', function(event) {
            var id = $(this).data('id');
            var trid = $(this).closest('tr').attr('minorjobid');
            for(var a = 2; a<=5; a++)
            {
                var divid = "_"+a
                allhide(divid);
            }
            document.getElementById("_renderedby").disabled = true;
            document.getElementById("_daterendered").disabled = true;
            document.getElementById("_purpose").disabled = true;
            document.getElementById("_itemdesc").disabled = true;
            document.getElementById("_daterendered").disabled = true;
            document.getElementById("_dateconfirmed").disabled = true;
            document.getElementById("_step1").disabled = true;
            document.getElementById("_sect").disabled = true;
            document.getElementById("_inputFeedback").disabled = true;
            document.getElementById("_requestedby").disabled = true;
            $.ajax({
                url: "functions/get_request_details.php",
                data: {
                    id: id
                },
                type: 'POST',
                success: function(data) {
                    var json = JSON.parse(data);
                    //var itemwdesc = json.item + json.item_desc;
                    
                    $('#minorjobid').val(json.minorjobid);
                    $('#trid').val(trid);
                    $('#_ID').val(id);
                    $('#_status').val(json.status);
                    $('#_datemajorjr').val(json.datesubmitted);
                    $('#_department').val(json.department);
                    $('#_quantity').val(json.quantity);
                    $('#_itemdesc').val(json.item_desc);
                    $('#_requestedby').val(json.requestedby);
                    $('#_purpose').val(json.purpose);
                    $('#_step1').val(json.bdstatus);
                    $('#_renderedby').val(json.renderedby);
                    $('#_confirmedby').val(json.confirmedby);
                    $('#_daterendered').val(json.daterendered);
                    $('#_dateconfirmed').val(json.dateconfirmed);
                    $('#_inputFeedback').val(json.feedback);
                    $('#_notedby').val(json.notedby);
                    $('#_bdapprovedby').val(json.approvedby);
                    var e = document.getElementById("_sect");
                    var section = e.options[e.selectedIndex].text;

                    e.options[e.selectedIndex].text = json.section;
                    var dep = json.department;
                    var rqby = json.requestedby;
                    var datesub = json.datesubmitted;
                    var purp = json.purpose;
                    $.ajax({
                        url: "functions/multicount.php",
                        type: 'POST',
                        data: {
                            department: dep,
                            requestedby: rqby,
                            datesubmitted: datesub,
                            purpose: purp,
                        },
                        success: function(data) {
                            var mjson = JSON.parse(data);
                            var storecount = mjson.count;
                            var newiter = storecount;

                            var nia = parseInt(newiter) + 1;
                            if(mjson.count>=1)
                            {
                                for(var i = 2; i<=nia; i++)
                                {
                                    var divid = "_"+i
                                    console.log(i);
                                    myFunctionPrompt(divid);
                                    iteratemultival(dep, rqby, datesub, purp, i);
                                }
                            }
                        }
                    });
                    
                    $('#editMinorjreqmodal').modal('show');
                    //$('#_datemajorjr').val(json.datesubmitted);
                    $('').val();
                    $('').val();
                    $('').val();
                    $('').val();
                    $('').val();
                    /*$('#_inputName').val(json.name)
                    $('#_inputUsername').val(json.username);
                    $('#_inputPassword').val(json.password);
                    $('#_inputRoleLevel').val(json.rolelevel);
                    $('#_inputRoleID').val(json.roleid);*/

                }
            });



        });




        function iteratemultival(dep, rqby, datesub, purp, i)
        {
            $.ajax({
                    url: "functions/getmultivalues.php",
                    type: 'POST',
                    data: {
                        department: dep,
                        requestedby: rqby,
                        datesubmitted: datesub,
                        purpose: purp,
                        multinum: i,
                        },
                        success: function(data) {
                        var njson = JSON.parse(data);
                        console.log(i);
                        var qua = document.getElementById("quantity_"+i);
                        var des = document.getElementById("itemdesc_"+i);
                        console.log(njson.item_desc, njson.quantity);
                        var newqid = "quantity_" + i;
                        var newdesid= "itemdesc_" + i;
                        console.log(newqid);
                        console.log(newdesid);
                        $('#'+newqid).val("test");
                        $('#'+newdesid).val("test");
                        document.getElementById("quantity_"+i).value = njson.quantity;
                        document.getElementById("itemdesc_"+i).value = njson.item_desc;     
                        }
            });          

        }
        

    </script>

    <!-- Script Process End-->
    <!-- add user modal-->
    <!-- Modal Popup -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="max-width:1100px;">
            <div class="modal-content">
                <div class="modal-header justify-content-center" style="max-width:1100px;">
                    <div class="col-md-2" style="width:30%;">
                        <h5 class="modal-title text-uppercase fw-bold" id="exampleModalLabel">Minor Job Request</h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="col-md-12">
                        <div class="alert1" id="alert1" style = "display:none;">
                            <span class="cbtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                            <strong id = "strongId">Success! </strong> Successfully Submitted Job Request!
                            <style>
                                .alert1 {
                                padding: 20px;
                                background-color: green;
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
                            <script>
                                //add ons click
                                    function myFunctionPrompt(divID) {
                                    var x = document.getElementById(divID);
                                    if (x.style.display === "block") {
                                        x.style.display = "none";
                                    } else {
                                        x.style.display = "block";
                                    }
                                    }
                                    function allhide(divId)
                                    {
                                        var x = document.getElementById(divId);
                                        if(x.style.display === "block")
                                        {
                                            x.style.display = "none";
                                        }
                                        
                                    }
                            </script>
                        </div>

                    </div>
                <div class="modal-body ">
                    <form id="saveUserForm" action="javascript:void();" method="POST">
                        <div class="modal-body">
                            <!-- Form Controls-->
                            <div class="row justify-content-center" style="padding-bottom:13px;">
                                <div class="col-md-6 ">
                                    <label class="fw-bold" for="date">Department:</label>
                                    <input type="name" class="form-control input-sm col-xs-1" id="department" placeholder="Department" value="<?php echo $_SESSION['department']; ?>" disabled>
                                </div>
                                <div class="col-md-6 ">
                                    <label class="fw-bold" for="date">Date:</label>
                                    <input type="datetime-local" class="form-control input-sm col-xs-1" id="datemajorjr" placeholder="Date" disabled>

                                </div>
                            </div>
                            <div class="justify-content-left">
                                <h5 class="text-uppercase fw-bold">Requisition(To be filled up by the requesting party)</h5>
                            </div>


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
                        <div class="col-md-12">
                                        <div class="alert2" id="alert2" style = "display:none; width: 100%;">
                                            <span class="cbtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                                            <strong id = "strongId1">Please fill in all required fields</strong>
                                        </div>
                                    </div>
                                        <style>
                                            .alert2 {
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
                            <button type="button" class="btn btn-secondary col-md-2" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary col-md-2" id ="savechange">Save Changes</button>
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
                        <h5 class="modal-title text-uppercase fw-bold" id="exampleModalLabel">Job Request</h5>
                    </div>
                    <div class="col-md-2" style="width:15%">
                        <label class="" for="inputName">Status:</label>
                        <input type="text" style="width:50%" class="col-sm-2" name="_ID" class="form-control" id="_status" disabled>
                    </div>
                    <div class="col-md-2" style="width:30%">
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
                                    <input type="name" class="form-control input-sm col-xs-1" id="_quantity" disabled>
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
                                <div class="col-md-12">
                                    <label class="fw-bold" for="date">Purpose:</label>
                                    <textarea class="form-control" rows="2" id="_purpose" placeholder="Purpose"></textarea>
                                </div>
                            </div>
                            <div class="justify-content-center">
                                <div class="col-md-12">
                                    <label class="fw-bold" for="date">Requested by:</label>
                                    <textarea class="form-control" rows="2" id="_requestedby" placeholder="Requested by"></textarea>
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
                            </div>
                            <div class="row" style="padding-top:6px;">
                                <div class="col-md-1" style="margin-top:5px;">
                                    <label class="fw-bold" for="inputName">Noted By:</label>
                                </div>
                                <div class="col-md-4" style="margin-top:5px;">
                                    <input class="form-control" type="text" style="width:100%; height:80%;" name="" id="_notedby" disabled>
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
                            <div class="justify-content-center">
                                <div class="col-md-12">
                                    <label class="fw-bold" for="date">Feedback:</label>
                                    <textarea class="form-control" rows="2" id="_inputFeedback" placeholder="Feedback"></textarea>
                                </div>
                            </div>
                            <!-- Form Controls End-->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        //date auto fill
        var now = new Date();
        now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
        var formattedDate = now.toISOString().slice(0, 19);
        document.getElementById('datemajorjr').value = formattedDate;
        //date end
    </script>
</body>

</html>