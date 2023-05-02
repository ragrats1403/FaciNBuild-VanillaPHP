<?php
require_once('../../authentication/anti_pagetrans.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Major Job Request List</title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" href="../../../dependencies/bootstrap/css/bootstrap.min.css?<?= time() ?>" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../../../dependencies/datatables/datatables.min.css?<?= time() ?>" />
    <link rel="stylesheet" type="text/css" href="../../../../css/sidebar.css?<?=time()?>">
    <link rel="stylesheet" type="text/css" href="../../../../css/header.css?<?=time()?>">
    <link rel="stylesheet" type="text/css" href="../../../../css/body.css?<?=time()?>">
    <link rel="stylesheet" type="text/css" href="../../../../css/admin/adminaccount.css?<?=time()?>" />
    <link href='../../../dependencies/boxicons/css/boxicons.min.css?<?= time() ?>' rel='stylesheet'>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js?<?= time() ?>"></script>
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
        <p>Hello, <?php echo $_SESSION['department'];?></p>
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
                <ul class="nav_list">
                    <li>
                        <a href="../../../php/sao/reservation/saocalendar.php">
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
                                <a class="dropdown-item" href="../../../php/sao/managereserve/managereservation.php">Reservation</a>
                            </ul>
                        </div>
                        <div class="dropdown">
                            <i class='bx bx-clipboard' style="margin-left:17px;"></i>
                            <button class="btn dropdown-toggle" style="box-shadow: none;"type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                View/Create Request
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="../../../php/sao/majoruser/majorjobreqlist.php">Major Job Request</a>
                                <a class="dropdown-item" href="../../../php/sao/minor/minorjobreqlist.php">Minor Job Request</a>
                                <a class="dropdown-item" href="../../../php/sao/reservation/saoreservation.php">Reservation</a>
                            </ul>
                        </div>
                    </li>
                </ul>
        <div class="profile_content">
                <div class="profile">
                    <div class="profile_details">
                    <img src="../../../../images/ico/profileicon.png" alt="" style = "height: 45px; width:45px; object-fit:cover; border-radius:12px;" />
                        <div class="name_role">
                            <div class="name"><?php echo mb_strimwidth($_SESSION['department'], 0, 20, '…');?></div>
                            <div class="role">SAO</div>
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
                            <table id="datatable" class="table" >
                                <thead>
                                    <th>Job Request no.</th>
                                    <th>Requisition no.</th>
                                    <th>Department</th>
                                    <th>Date</th>
                                    <th>Quantity</th>
                                    <th>Status</th>
                                    <th>Options</th>
                                </thead>
                            </table>
                            <div class="col-sm-12 d-flex justify-content-end">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">Create Major Job Request</button>
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
        var dpt = "<?php echo $_SESSION['department'];?>";
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
        if (aData[5] === 'Approved') {
            $(nRow).css('background-color', '#a7d9ae');
        }
        if (aData[5] === 'Declined') {
            $(nRow).css('background-color', '#e09b8d');
        }
        if (aData[5] === 'Pending') {
            $(nRow).css('background-color', '#d9d2a7');
        }
    },
    'columnDefs': [{
        'targets': [0, 4],
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
            event.preventDefault();
            document.getElementById("savechange").disabled = true;
            var requino = $('#requi').val();
            var department = $('#depart').val();
            var date = $('#deeto').val();
            var quantity = $('#quan').val();
            var description = $('#desc').val();
            var purpose = $('#purp').val();
            var requestby = $('#req').val();
            var departmenthead = $('#dephead').val();


            if (department != '' && date != '' && quantity != '' && requestby != '' && description != '' && purpose != '' && departmenthead != '') {
                $.ajax({
                    url: "functions/add_data.php",
                    data: {
                        requino: requino,
                        department: department,
                        date: date,
                        quantity: quantity,
                        description: description,
                        purpose: purpose,
                        requestby: requestby,
                        departmenthead: departmenthead,
                    },
                    type: 'POST',
                    success: function(data) {
                        var json = JSON.parse(data);
                        status = json.status;
                        if (status = 'success') {
                            table = $('#datatable').DataTable();
                            table.draw();
                            myFunctionPrompt("alert1");
                            $('#requi').val('');
                            $('#quan').val('');
                            $('#desc').val('');
                            $('#purp').val('');
                            $('#req').val('');
                            $('#dephead').val('');
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
                                                requestedby: requestby,
                                                description: exitemdesc,
                                                purpose: purpose,
                                                multinum: iterate,
                                                departmenthead: departmenthead,
                                    
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
                            document.getElementById("savechange").disabled = false;

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
            var trid = $(this).closest('trid').attr('majoreq');
            for(var a = 2; a<=5; a++)
            {
                var divid = "_"+a
                allhide(divid);
            }
            document.getElementById("_inputFeedback").disabled = true;
            $.ajax({
                url: "functions/get_single_user.php",
                data: {
                    id: id
                },
                type: 'POST',
                success: function(data) {
                    var json = JSON.parse(data);
                    $('#id').val(json.id);
                    $('#trid').val(trid);
                    $('#jobrequestno').val(json.jobreqno);
                    $('#requino').val(json.requino);
                    $('#department').val(json.department);
                    $('#date').val(json.date);
                    var e = document.getElementById("sections");
                    var section = e.options[e.selectedIndex].text;
                    e.options[e.selectedIndex].text = json.section;
                    /*$('#sections').val(json.section);*/
                    $('#quantity').val(json.quantity);
                    $('#_req').val(json.requestedby);
                    $('#_dephead').val(json.departmenthead);
                    $('#description').val(json.description);
                    $('#purpose').val(json.purpose);
                    var e = document.getElementById("remark");
                    var outsource = e.options[e.selectedIndex].text;
                    e.options[e.selectedIndex].text = json.outsource;

                    $('#_statustext').val(json.status);
                    $('#_step1').val(json.bdstatus);
                    $('#_step2').val(json.pcostatus);
                    $('#_step3').val(json.cadstatus);
                    $('#_bdapprovedby').val(json.bdapprovedby);
                    $('#_pcoapprovedby').val(json.pcoapprovedby);
                    $('#_cadapprovedby').val(json.cadapprovedby);
                    $('#_inputFeedback').val(json.feedback);
                    
                    var dep = json.department;
                    var rqby = json.requestedby;
                    var datesub = json.date;
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

                    $('#editUserModal').modal('show');
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
        <div class="modal-dialog" style="max-width:1000px;">
            <div class="modal-content">
                <div class="modal-header justify-content-center" style="max-width:1100px;">
                    <div class="col-md-3" style="width:27%;">
                        <h5 class="modal-title text-uppercase fw-bold" id="exampleModalLabel" >Major Job Request</h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="col-md-12">
                        <div class="alert1" id="alert1" style = "display:none; width: 100%;">
                            <span class="cbtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                            <strong id = "strongId">Success! </strong> Successfully submitted Major Job request!
                        </div>
                    </div>
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

                                    $("#addUserModal").on("hidden.bs.modal", function () {
                                            var x = document.getElementById("alert1");
                                            x.style.display = "none";    
                                            var a = document.getElementById("alert2");
                                            a.style.display = "none";                                   
                                        });
                            </script>
                    <div class="modal-body ">
                    <form id="saveUserForm" action="javascript:void();" method="POST">
                            <div class="row justify-content-center" style="padding-bottom:13px;">
                                <div class="col-md-6 ">
                                    <label class="fw-bold" for="date">Department</label>
                                    <input type="name" class="form-control input-sm col-xs-1" id="depart" placeholder="Department" value = "<?php echo $_SESSION['department'];?>" disabled>
                                </div>
                                <div class="col-md-6 ">
                                    <label class="fw-bold" for="date">Date</label>
                                    <input type="datetime-local" class="form-control input-sm col-xs-1" id="deeto" placeholder="Date" disabled>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <h5 class="text-uppercase fw-bold">A. Requisition(To be filled up by the requesting party)</h5>
                                </div>
                                <div class="col-md-1" >
                                        <input type="name" class="form-control input-sm col-xs-1" id="numForms" style="width:60%; text-align:left;" value = "1" disabled>
                                    </div>
                                    <div class="col-md-1" style="margin-left: -4.5%;">
                                        <button type="button" class="btn btn-light" id="subForm" onclick= "subtract();"><b>-</b></button>
                                    </div>
                                    
                                    <div class="col-md-1" style="margin-left: -5%;">
                                        <button type="button" class="btn btn-light" id="addForm" onclick = "add();"><b>+</b></button>
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
                            </div>
                            <div>
                                <div class="col-md-2" style="padding-bottom:10px; width:20%">
                                    <label class="fw-bold" for="date">Quantity:</label>
                                    <input type="form-control" class="form-control input-sm col-xs-1" id="quan" placeholder="Quantity">
                                </div>
                            </div>
                            <div class="justify-content-center" style="padding-bottom:10px;">
                                <div class="col-md-12">
                                    <label class="fw-bold" for="date">Item with Complete Description:</label>
                                    <textarea placeholder="Description" class="form-control" rows="2" id="desc"></textarea>
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
                            <div class="justify-content-center" style="padding-bottom:10px;">
                                <div class="col-md-12">
                                    <label class="fw-bold" for="date">Purpose:</label>
                                    <textarea placeholder="Purpose" class="form-control" rows="2" id="purp"></textarea>
                                </div>
                            </div>
                            <div class="justify-content-center" style="padding-bottom:10px;">
                                <div class="col-md-12">
                                    <label class="fw-bold" for="date">Requested by:</label>
                                    <textarea placeholder="Description" class="form-control" rows="2" id="req"></textarea>
                                </div>
                            </div>
                            <div class="justify-content-center" style="padding-bottom:10px;">
                                <div class="col-md-12">
                                    <label class="fw-bold" for="date">Department Head:</label>
                                    <textarea placeholder="Department Head" class="form-control" rows="2" id="dephead"></textarea>
                                </div>
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
                                <button type="submit" class="btn btn-primary col-md-2" id = "savechange">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <!-- add user modal end-->
    <!-- edit user modal-->
    <!-- Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog " style="max-width:1100px;">
            <div class="modal-content">
                <div class="modal-header justify-content-center" style="max-width:1100px;">
                    <div class="col-md-2" style="width:17%;">
                        <h5 class="modal-title text-uppercase fw-bold" id="exampleModalLabel">Job Request</h5>
                    </div>
                    <div class="col-md-12" style="width:15%">
                        <label class="" for="inputName">Status:</label>
                        <input type="text" style="width:60%" class="col-sm-1" name="id" class="form-control" id="_statustext" disabled>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="saveUserForm" action="javascript:void();" method="POST">
                        <div class="modal-body">
                            <!-- Form Controls-->
                            <input type="hidden" id="id" name="id" value="">
                            <input type="hidden" id="trid" name="trid" value="">
                            <div class="row justify-content-center" style="padding-bottom:10px;">
                                <div class="col-md-6 ">
                                    <label class="fw-bold" for="date">Job Request no.</label>
                                    <input type="name" class="form-control input-sm col-xs-1" id="jobrequestno" placeholder="Job request no." disabled>
                                </div>
                                <div class="col-md-6 ">
                                    <label class="fw-bold" for="date">Requisition no.</label>
                                    <input type="name" class="form-control input-sm col-xs-1" id="requino" placeholder="Requisition no." disabled>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-md-6 ">
                                    <label class="fw-bold" for="date">Department</label>
                                    <input type="name" class="form-control input-sm col-xs-1" id="department" placeholder="Department" disabled>
                                </div>
                                <div class="col-md-6 ">
                                    <label class="fw-bold" for="date">Date</label>
                                    <input type="name" class="form-control input-sm col-xs-1" id="date" placeholder="Date" disabled>
                                </div>
                                <h5 class="text-uppercase fw-bold " style="padding-top:13px;">A. Requisition(To be filled up by the requesting party)</h5>
                            </div>
                            <div class="row">
                                <div class="col-md-2" style="width:22%">
                                    <label class="fw-bold" for="date">Quantity:</label>
                                    <input type="form-control" class="form-control input-sm col-xs-1" id="quantity" placeholder="Quantity" disabled>
                                </div>
                            </div>
                            <div class="justify-content-center" style="padding-bottom:10px;">
                                <div class="col-md-12">
                                    <label class="fw-bold" for="date">Item with Complete Description:</label>
                                    <textarea placeholder="Description" class="form-control" rows="2" id="description" disabled></textarea>
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
                            <div class="justify-content-center" style="padding-bottom:10px;">
                                <div class="col-md-12">
                                    <label class="fw-bold" for="date">Purpose:</label>
                                    <textarea placeholder="Purpose" class="form-control" rows="2" id="purpose" disabled></textarea>
                                </div>
                            </div>
                            <div class="justify-content-center" style="padding-bottom:10px;">
                                <div class="col-md-12">
                                    <label class="fw-bold" for="date">Requested by:</label>
                                    <textarea placeholder="Description" class="form-control" rows="2" id="_req" disabled></textarea>
                                </div>
                            </div>
                            <div class="justify-content-center" style="padding-bottom:10px;">
                                <div class="col-md-12">
                                    <label class="fw-bold" for="date">Department Head:</label>
                                    <textarea placeholder="Department Head" class="form-control" rows="2" id="_dephead" disabled></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="fw-bold" for="date">Section:</label>
                                    <select class="" style="width: 150px; Border: 5px;" name="sections" id="sections" disabled>
                                        <option value="CARPENTRY">CARPENTRY</option>
                                        <option value="PLUMBING">PLUMBING</option>
                                        <option value="AIRCON">AIRCON</option>
                                        <option value="ELECTRICAL">ELECTRICAL</option>
                                    </select>
                                </div>
                            </div>
                            <!--step 1-->
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
                            <!--step 2-->
                            <div class="row" style="padding-top:6px;">
                                <div class="col-md-4" style="margin-top:5px;">
                                    <label class="fw-bold" for="inputName">Property Custodian Approval Status:</label>
                                </div>
                                <div class="col-md-2">
                                    <input class="form-control" type="text" style = "margin-left:-50px;"name="" id="_step2" disabled>
                                </div>
                                <div class="col-md-2">
                                    <label class="fw-bold" for="date">Approved By</label>
                                </div>
                                <div class="col-md-4 "> 
                                    <input type="name" style = "margin-left:-50px;"class="form-control input-sm col-xs-1" id="_pcoapprovedby" disabled>
                                </div>
                            </div>
                            <!--step 3-->
                            <div class="row" style="padding-top:6px;">
                                <div class="col-md-4" style="margin-top:5px;">
                                    <label class="fw-bold" for="inputName">Campus Academic Director Approval Status:</label>
                                </div>
                                <div class="col-md-2">
                                    <input class="form-control" type="text" style = "margin-left:-50px;"name="" id="_step3" disabled>
                                </div>
                                <div class="col-md-2">
                                    <label class="fw-bold" for="date">Approved By</label>
                                </div>
                                <div class="col-md-4 "> 
                                    <input type="name" style = "margin-left:-50px;"class="form-control input-sm col-xs-1" id="_cadapprovedby" disabled>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="fw-bold" style="padding-bottom:5px;" for="date">Remarks:</label>
                                    <select class="" style="width: 150px; Border: none;" id="remark" disabled>
                                        <option value="1">Select</option>
                                        <option value="Outsource">Outsource</option>
                                        <option value="Bill of materials">Bill of materials</option>
                                    </select>
                                </div>
                            </div>
                            <div class="justify-content-center">
                                <div class="col-md-12">
                                    <label class="fw-bold" for="date">Feedback:</label>
                                    <textarea class="form-control" rows="2" id="_inputFeedback" placeholder="Feedback" disabled></textarea>
                                </div>
                            </div>
                            <div>
                                <div class="modal-footer justify-content-md-center">
                                    <!--<a href="javascript:void();" class="btn btn-primary approveBtn">Approve All</a>
                                    <a href="javascript:void();" class="btn btn-danger declineBtn">Decline All</a>
                                    <a href="javascript:void();" class="btn btn-info text-white updateBtn">Update</a>
                                   <button type="" class="btn btn-primary approveBtn">Approve</button>
                                <button type="button" class="btn btn-danger">Decline</button>
                                <button type="submit" class="btn btn-info text-white">Update</button>-->
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- edit user modalPopup end-->
    <script>
        //date auto fill
        // Get the current datetime in Asia/Manila timezone
        var now = new Date();
        now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
        var formattedDate = now.toISOString().slice(0, 19);
        document.getElementById('deeto').value = formattedDate;
        //date end
    </script>
</body>

</html>