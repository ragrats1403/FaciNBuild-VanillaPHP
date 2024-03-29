<?php
require_once('../../../authentication/anti_pagetrans.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Major Job Request List</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" href="../../../../dependencies/bootstrap/css/bootstrap.min.css?<?= time() ?>" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../../../../dependencies/datatables/datatables.min.css?<?= time() ?>" />
    <link rel="stylesheet" type="text/css" href="../../../../css/sidebar.css?<?= time() ?>">
    <link rel="stylesheet" type="text/css" href="../../../../css/header.css?<?= time() ?>">
    <link rel="stylesheet" type="text/css" href="../../../../css/body.css?<?= time() ?>">
    <link rel="stylesheet" type="text/css" href="../../../../css/modal.css?<?= time() ?>" />
    <link rel="stylesheet" type="text/css" href="../../../../css/admin/adminaccount.css?<?= time() ?>" />
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
        <p>Hello, <?php echo $_SESSION['department']; ?></p>
    </div>
    <nav class="gnav">
    </nav>
    </div>
</header>
<body>
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
    <div class="table1">

        <div class="container-fluid">
            <div class="row">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 shadow" style="width: 100%; background-color: #FFF; padding-top: 100px; padding-left:50px; padding-right:50px; padding-bottom:50px; ">
                            <!-- padding-left:50px; padding-right:50px; padding-bottom:50px;-->
                            <table id="datatable" class="table">
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
        <script src="../../../../dependencies/jquery/jquery-3.6.4.min.js"></script>
        <script type="text/javascript" src="../../../../dependencies/datatables/datatables.min.js"></script>
        <script src="../../../../dependencies/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script>
        var dpt = "<?php echo $_SESSION['department'];?>";
            $('#datatable').DataTable({
            'serverSide': true,
            'processing': true,
            'paging': true,
            'responsive': true,
            'order': [],
            'ajax': {
            'url': 'fetch_data.php',
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
                    url: "add_data.php",
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
                            $('#createmajorrequest').modal('show');
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
                                            url: "addmultidata.php",
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
                            
                           
                            
                        }
                            $('#addUserModal').scrollTop(0);
                            $('#addUserModal').modal('hide');
                        
                        }
                    }
                });
            } else {
                $('#alert1').css('display', 'block');
                $('#strongId1').html('Please fill all the Required fields');
                
            }
        });
        //delete user button control
        $(document).on("click", ".btnDelete", function (event) {
            event.preventDefault();
            var id = $(this).data("id");
            $('#deletemodal').modal('show');
            
            $('#deletemodal').on('click', '.btn-danger', function() {
                $.ajax({
                url: "delete_user.php",
                data: {
                    id: id,
                },
                type: "POST",
                success: function (data) {
                    var json = JSON.parse(data);
                    var status = json.status;
                    if (status == "success") {
                    $("#" + id).closest("tr").remove();
                    } else {
                    alert("failed");
                    return;
                    }
                },
                });
                $('#deletemodal').modal('hide');
            });
            
            $('#deletemodal').on('click', '#close-modal', function() {
                $('#deletemodal').modal('hide');
            });
        });

   
        //edit button control 
        $(document).on('click', '.editBtn', function(event) {
            var id = $(this).data('id');
            var trid = $(this).closest('trid').attr('majoreq');
            document.getElementById("updbtn").hidden = true;
            document.getElementById("jobrequestno").disabled = true;
            document.getElementById("requino").disabled = true;
            document.getElementById("department").disabled = true;
            document.getElementById("date").disabled = true;
            document.getElementById("sections").disabled = true;
            document.getElementById("quantity").disabled = true;
            document.getElementById("description").disabled = true;
            document.getElementById("purpose").disabled = true;
            document.getElementById("_statustext").disabled = true;
            document.getElementById("_inputFeedback").disabled = true;
            document.getElementById("remark").disabled = true;
            document.getElementById("sections").disabled = true;
            document.getElementById("reqnobtn").hidden = true;
            $.ajax({
                url: "get_single_user.php",
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
                    /*$('#sections').val(json.section);*/
                    $('#quantity').val(json.quantity);
                    $('#description').val(json.description);
                    $('#purpose').val(json.purpose);

                    //drop down auto remove when clicking more info fix
                    var x = document.getElementById("sections");
                    var option = document.createElement("option");
                    option.text = json.section;
                    option.hidden = true;
                    option.disabled = true;
                    option.selected = true;
                    x.add(option);
                    var a = document.getElementById("remark");
                    var option2 = document.createElement("option");
                    option2.text = json.outsource;
                    option2.hidden = true;
                    option2.disabled = true;
                    option2.selected = true;
                    a.add(option2);
                    //drop down fix end
                    $('#_statustext').val(json.status);
                    $('#_step1').val(json.bdstatus);
                    $('#_step2').val(json.pcostatus);
                    $('#_step3').val(json.cadstatus);
                    $('#_inputFeedback').val(json.feedback);
                    /*$('#remark').val(json.outsource);*/
                    if(json.bdstatus != 'Pending' || json.status === 'Declined')
                    {
                        document.getElementById("_bdapprovedby").disabled = true;
                        document.getElementById("sections").disabled = true;
                        document.getElementById("remark").disabled = true;
                        document.getElementById("_inputFeedback").disabled = true;
                        document.getElementById("step1a").hidden = true;
                        document.getElementById("step1d").hidden = true;
                    }
                    else
                    {
                        document.getElementById("_bdapprovedby").disabled = false;
                        document.getElementById("sections").disabled = false;
                        document.getElementById("remark").disabled = false;
                        document.getElementById("_inputFeedback").disabled = false;
                        document.getElementById("step1a").hidden = false;
                        document.getElementById("step1d").hidden = false;
                    }

                    if(json.pcostatus != 'Pending' || json.status === 'Declined' || json.pcostatus === 'Declined')
                    {
                        document.getElementById("_pcoapprovedby").disabled = true;
                        document.getElementById("sections").disabled = true;
                        document.getElementById("remark").disabled = true
                        document.getElementById("_inputFeedback").disabled = true;
                        document.getElementById("step2a").hidden = true;
                        document.getElementById("step2d").hidden = true;
                        document.getElementById("reqnobtn").hidden = true;
                    }
                    else
                    {
                        document.getElementById("_pcoapprovedby").disabled = false;
                        document.getElementById("_inputFeedback").disabled = false;
                        document.getElementById("step2a").hidden = false;
                        document.getElementById("step2d").hidden = false;
                        document.getElementById("reqnobtn").hidden = false;

                    }

                    if(json.cadstatus != 'Pending' || json.status === 'Declined' || json.pcostatus === 'Declined')
                    {
                        document.getElementById("_cadapprovedby").disabled = true;
                        document.getElementById("sections").disabled = true;
                        document.getElementById("remark").disabled = true
                        document.getElementById("_inputFeedback").disabled = true;
                        document.getElementById("step3a").hidden = true;
                        document.getElementById("step3d").hidden = true;
                    }
                    else
                    {
                        document.getElementById("_cadapprovedby").disabled = false; 
                        document.getElementById("_inputFeedback").disabled = false;
                        document.getElementById("step3a").hidden = false;
                        document.getElementById("step3d").hidden = false;
                    }   

                    $('#_bdapprovedby').val(json.bdapprovedby);
                    $('#_pcoapprovedby').val(json.pcoapprovedby);
                    $('#_cadapprovedby').val(json.cadapprovedby);
                    $('#_inputFeedback').val(json.feedback);
                    

                    var dep = json.department;
                    var rqby = json.requestedby;
                    var datesub = json.date;
                    var purp = json.purpose;
                    $.ajax({
                        url: "multicount.php",
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

        $(document).on('click', '.btnprint', function(event) {
            var id = $(this).data('id');
            var trid = $(this).closest('trid').attr('majoreq');
            $.ajax({
                url: "get_single_user.php",
                data: {
                    id: id
                },
                type: 'POST',
                success: function(data) {
                    var json = JSON.parse(data);
                    $('#id').val(json.id);
                    $('#trid').val(trid);
                    $('#jobrequestno1').val(json.jobreqno);
                    $('#requino1').val(json.requino);
                    $('#requestedby1').val(json.requestedby);
                    $('#depart1').val(json.departmenthead);
                    $('#department1').val(json.department);
                    $('#date1').val(json.date);
                    $('#sections1').val(json.section);
                    $('#quantity1').val(json.quantity);
                    $('#item1').val(json.item);
                    $('#description1').val(json.description);
                    $('#purpose1').val(json.purpose);
                    $('#remarks1').val(json.outsource);
                    $('#printmodal').modal('show');

                    var dep = json.department;
                    var rqby = json.requestedby;
                    var datesub = json.date;
                    var purp = json.purpose;
                    $.ajax({
                        url: "multicount.php",
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
                                    iteratemultivals(dep, rqby, datesub, purp, i);
                                }
                            }
                        }
                    });
                }
            });
        });
        

        

        $(document).on('click', '.updateBtn', function() {

            var id = $('#id').val();
            var trid = $('#trid').val();
            var jobreqno = $('#jobrequestno').val();
            var requino = $('#requino').val();
            var department = $('#department').val();
            var date = $('#date').val();
            var section = $('#sections').val();
            var quantity = $('#quantity').val();
            var description = $('#description').val();
            var purpose = $('#purpose').val();
            var outsource = $('#remark').val();
            var feedback = $('#_inputFeedback').val();
            $.ajax({
                url: "update_request.php",
                data: {
                    jobreqno: jobreqno,
                    requino: requino,
                    department: department,
                    date: date,
                    section: section,
                    quantity: quantity,
                    description: description,
                    purpose: purpose,
                    outsource: outsource,
                    feedback: feedback,
                },
                type: 'POST',
                success: function(data) {
                    var json = JSON.parse(data);
                    status = json.status;
                    if (status == 'success') {
                        alert('Updated Successfully!');
                        $('#editUserModal').modal('hide');
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                    } else {
                        alert('failed');
                    }
                }
            });
        });

        //APPROVE=================================================


        $(document).on('click', '.step3approveBtn', function(event) {
            //var status = "Approved";
            var id = $('#jobrequestno').val();
            var trid = $('#trid').val();
            var dept = $('#department').val();
            var feedb = $('#_inputFeedback').val();
            var cadapprovedby = $('#_cadapprovedby').val();
            if(cadapprovedby != '' && feedb != '')
            {
                $.ajax({
                url: "step3approve.php",
                data: {
                    id: id,
                    dept: dept,
                    feedb: feedb,
                    cadapprovedby: cadapprovedby,
                },
                type: 'POST',
                success: function(data) {
                    var json = JSON.parse(data);
                    var status = json.status;
                    if (status == 'success') {
                        table = $('#datatable').DataTable();
                        table.draw();
                        $('#editUserModal').scrollTop(0);
                        $('#alert3').css('display', 'block');
                        $('#strongId3').html('Step 3 Approved Successfully!');  
                        $('#_step3').val('Approved');
                        $('#_statustext').val('Approved');
                        document.getElementById("step3a").hidden = true;
                        document.getElementById("step3d").hidden = true;
                        document.getElementById("_cadapprovedby").disabled = true;
                        document.getElementById("_inputFeedback").disabled = true;
                        
                    }
                    else
                    {
                        alert('Failed');
                    }
                }
            });
            }
            else
            {
                $('#editUserModal').scrollTop(0);
                $('#alert2').css('display', 'block');
                $('#strongId2').html('Please fill out required fields!');
            }
            
        });

        $(document).on('click', '.step1declineBtn', function(event) {
            var id = $('#jobrequestno').val();
            var trid = $('#trid').val();
            var dept = $('#department').val();
            var feedb = $('#_inputFeedback').val();
            if(feedb != '')
            {
                $.ajax({
                url: "step1decline.php",
                data: {
                    id: id,
                    dept: dept,
                    feedb: feedb,

                },
                type: 'POST',
                success: function(data) {
                    var json = JSON.parse(data);
                    var status = json.status;
                    if (status == 'success') {
                        table = $('#datatable').DataTable();
                        table.draw();
                        $('#editUserModal').scrollTop(0);
                        $('#alert3').css('display', 'block');
                        $('#strongId3').html('Step 1 Declined Successfully!');
                        $('#_step1').val('Declined');
                        $('#_statustext').val('Declined');
                        document.getElementById("step1a").hidden = true;
                        document.getElementById("step1d").hidden = true;
                        document.getElementById("_bdapprovedby").disabled = true;
                        document.getElementById("step3a").hidden = true;
                        document.getElementById("step3d").hidden = true;
                        document.getElementById("_cadapprovedby").disabled = true;
                        document.getElementById("step2a").hidden = true;
                        document.getElementById("step2d").hidden = true;
                        document.getElementById("_pcoapprovedby").disabled = true;
                        document.getElementById("reqnobtn").hidden = true;                        
                    } else {
                        alert('failed');
                        
                    }
                }
            });
            }
            else{
                $('#editUserModal').scrollTop(0);
                $('#alert2').css('display', 'block');
                $('#strongId2').html('Please provide a feedback when declining request!');
            }
            
        });
        $(document).on('click', '.step2approveBtn', function(event) {
            //var status = "Approved";\
            
            var id = $('#jobrequestno').val();
            var trid = $('#trid').val();
            var reqno = $('#requino').val();
            var dept = $('#department').val();
            var feedb = $('#_inputFeedback').val();
            var pcoapprovedby = $('#_pcoapprovedby').val();
            var pcoby = document.getElementById("_pcoapprovedby").value;
            if(pcoby !== '' && pcoby !== undefined && pcoby !== null)
            {
                if(reqno !== '' && reqno !== 0 && reqno !== undefined && reqno !== null)
                 {
                $.ajax({
                        url: "step2approve.php",
                        data: {
                            id: id,
                            reqno: reqno,
                            dept: dept,
                            feedb: feedb,
                            pcoapprovedby: pcoapprovedby,

                        },
                        type: 'POST',
                        success: function(data) {
                            var json = JSON.parse(data);
                            var status = json.status;
                            if (status == 'success') {
                                table = $('#datatable').DataTable();
                                table.draw();
                                $('#editUserModal').scrollTop(0);
                                $('#alert3').css('display', 'block');
                                $('#strongId3').html('Step 2 Approved Successfully!');  
                                /*table = $('#datatable').DataTable();
                                var button = '<a href="javascript:void();" data-id="' + id + '"  class="btn btn-sm btn-success btnDelete" >Approve</a> <a href= "javascript:void();" data-id="' + id + '" class ="btn btn-sm btn-info editBtn">More Info</a>';
                                var row = table.row("[id='" + trid + "']");
                                row.row("[id='" + trid + "']").data([department, date, button]);*/
                                //$('#_itemdesc_').text('');
                                document.getElementById("step2a").hidden = true;
                                document.getElementById("step2d").hidden = true;
                                document.getElementById("_pcoapprovedby").disabled = true;
                                document.getElementById("reqnobtn").hidden = true;
                                $('#_step2').val('Approved');
                            } else {
                                alert('failed');
                            }
                        }
                    });
                }
                else    
                {
                    $('#editUserModal').scrollTop(0);
                    $('#alert2').css('display', 'block');
                    $('#strongId2').html('Please add Requisition Number when approving request!');
                }

            }

            else
            {
                $('#editUserModal').scrollTop(0);
                $('#alert2').css('display', 'block');
                $('#strongId2').html('Please fill out required fields!');
            }

            
        });
        $(document).on('click', '.step2declineBtn', function(event) {
            var id = $('#jobrequestno').val();
            var trid = $('#trid').val();
            var dept = $('#department').val();
            var feedb = $('#_inputFeedback').val();
            if(feedb != '')
            {
                $.ajax({
                url: "step2decline.php",
                data: {
                    id: id,
                    dept: dept,
                    feedb: feedb,

                },
                type: 'POST',
                success: function(data) {
                    var json = JSON.parse(data);
                    var status = json.status;
                    if (status == 'success') {
                        table = $('#datatable').DataTable();
                        table.draw();
                        $('#editUserModal').scrollTop(0);
                        $('#alert3').css('display', 'block');
                        $('#strongId3').html('Step 2 Declined Successfully!');  
                        $('#_step2').val('Declined');
                        $('#_statustext').val('Declined');
                        document.getElementById("step1a").hidden = true;
                        document.getElementById("step1d").hidden = true;
                        document.getElementById("_bdapprovedby").disabled = true;
                        document.getElementById("step3a").hidden = true;
                        document.getElementById("step3d").hidden = true;
                        document.getElementById("_cadapprovedby").disabled = true;
                        document.getElementById("step2a").hidden = true;
                        document.getElementById("step2d").hidden = true;
                        document.getElementById("_pcoapprovedby").disabled = true;
                        document.getElementById("reqnobtn").hidden = true;

                    } else {
                        alert('failed');
                    }
                }
            });
            }
            else{
                $('#editUserModal').scrollTop(0);
                $('#alert2').css('display', 'block');
                $('#strongId2').html('Please provide a feedback when declining a request!');  
            }
            
        });


        $(document).on('click', '.step3declineBtn', function(event) {
            var id = $('#jobrequestno').val();
            var trid = $('#trid').val();
            var dept = $('#department').val();
            var feedb = $('#_inputFeedback').val();
            if(feedb != '')
            {
            $.ajax({
                url: "step3decline.php",
                data: {
                    id: id,
                    dept: dept,
                    feedb: feedb,

                },
                type: 'POST',
                success: function(data) {
                    var json = JSON.parse(data);
                    var status = json.status;
                    if (status == 'success') {
                        table = $('#datatable').DataTable();
                        table.draw();
                        $('#editUserModal').scrollTop(0);
                        $('#alert3').css('display', 'block');
                        $('#strongId3').html('Step 3 Declined Successfully!');  
                        $('#_step3').val('Declined');
                        $('#_statustext').val('Declined');
                        document.getElementById("step1a").hidden = true;
                        document.getElementById("step1d").hidden = true;
                        document.getElementById("_bdapprovedby").disabled = true;
                        document.getElementById("step3a").hidden = true;
                        document.getElementById("step3d").hidden = true;
                        document.getElementById("_cadapprovedby").disabled = true;
                        document.getElementById("step2a").hidden = true;
                        document.getElementById("step2d").hidden = true;
                        document.getElementById("_pcoapprovedby").disabled = true;
                        document.getElementById("reqnobtn").hidden = true;


                    } else {
                        alert('failed');
                    }
                }
            });
        }
        else{

            $('#editUserModal').scrollTop(0);
            $('#alert2').css('display', 'block');
            $('#strongId2').html('Please provide feedback before declining request');  
        }
        });
        $(document).on('click', '.assignReqnoBtn', function(event) {
            var id = $('#jobrequestno').val();
            var trid = $('#trid').val();
            document.getElementById("reqnobtn").hidden = true;
            $.ajax({
                url: "setrequisition.php",
                type: 'GET',
                success: function(data) {
                    var json = JSON.parse(data);
                    var addReqno = parseInt(json.totalno) + 1;
                    if(json.totalno == null || json.totalno ==''){
                        $('#requino').val("1");
                    }
                    else
                    {
                        $('#requino').val(addReqno);
                    }
                }
        });
    });

        $(document).on('click', '.step1approveBtn', function(event) {
            //var status = "Approved";
            var id = $('#jobrequestno').val();
            var trid = $('#trid').val();
            var dept = $('#department').val();
            var feedb = $('#_inputFeedback').val();
            
            var e = document.getElementById("sections");
            var section = e.options[e.selectedIndex].text;
            var e = document.getElementById("remark");
            var remark = e.options[e.selectedIndex].text;
            var bdapprovedby = $('#_bdapprovedby').val();
            if(
                id != '' &&
                dept != '' &&
                section != '' &&
                remark != '' &&
                bdapprovedby != ''
            )
            {
                $.ajax({
                url: "step1approve.php",
                data: {
                    id: id,
                    dept: dept,
                    feedb: feedb,
                    section: section,
                    remark: remark,
                    bdapprovedby: bdapprovedby,

                },
                type: 'POST',
                success: function(data) {
                    var json = JSON.parse(data);
                    var status = json.status;
                    if (status == 'success') {
                        table = $('#datatable').DataTable();
                        table.draw();
                        $('#editUserModal').scrollTop(0);
                        $('#alert3').css('display', 'block');
                        $('#strongId3').html('Step 1 Approved Successfully!');
                        $('#_step1').val('Approved');
                        document.getElementById("step1a").hidden = true;
                        document.getElementById("step1d").hidden = true;
                        document.getElementById("_bdapprovedby").disabled = true;  

                    } else {
                        alert('failed');
                    }
                }
            });
            }
            else{
                $('#editUserModal').scrollTop(0);
                $('#alert2').css('display', 'block');
                $('#strongId2').html('Please fill out required fields!');
            }
        });

        function allhide(divId)
                                    {
                                        var x = document.getElementById(divId);
                                        if(x.style.display === "block")
                                        {
                                            x.style.display = "none";
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

        function iteratemultival(dep, rqby, datesub, purp, i)
                {
                    $.ajax({
                            url: "getmultivalues.php",
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

                function iteratemultivals(dep, rqby, datesub, purp, i)
                {
                    $.ajax({
                            url: "getmultivalues.php",
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
                                var qua = document.getElementById("quantity"+i);
                                var des = document.getElementById("itemdesc"+i);
                                console.log(njson.item_desc, njson.quantity);
                                var newqid = "quantity" + i;
                                var newdesid= "itemdesc" + i;
                                console.log(newqid);
                                console.log(newdesid);
                                $('#'+newqid).val("test");
                                $('#'+newdesid).val("test");
                                document.getElementById("quantity"+i).value = njson.quantity;
                                document.getElementById("itemdesc"+i).value = njson.item_desc;     
                                }
                    });          

                }
             //datetime auto fill up
             var now = new Date();
            now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
            document.getElementById('deeto').value = now.toISOString().slice(0,16);
        
    </script>
    <!-- Script Process End-->
    <!-- add user modal-->
    <!-- Modal Popup -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="max-width:1000px;">
            <div class="modal-content">
                <div class="modal-header justify-content-center" style="max-width:1100px;">
                    <div class="col-md-2" style="width:17%;">
                        <h5 class="modal-title text-uppercase fw-bold" id="exampleModalLabel" >Job Request</h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="col-md-12">
                                        <div class="alert1" id="alert1" style = "display:none; width: 100%;">
                                            <span class="cbtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                                            <strong id = "strongId1"></strong>
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
                                <button type="button" class="btn btn-secondary col-md-2" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary col-md-2">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <script>
                    var now = new Date();
                    now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
                    var formattedDate = now.toISOString().slice(0, 19);
                    document.getElementById('deeto').value = formattedDate;
    </script>
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
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="fw-bold" for="date">Section:</label>
                                    <select class="" style="width: 150px; Border: 5px;" name="sections" id="sections" disabled>
                                        <option disabled selected value hidden></option>
                                        <option value="CARPENTRY">CARPENTRY</option>
                                        <option value="PLUMBING">PLUMBING</option>
                                        <option value="AIRCON">AIRCON</option>
                                        <option value="ELECTRICAL">ELECTRICAL</option>
                                        <option value="HOUSEKEEPING">HOUSEKEEPING</option>
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
                                <div class="col-md-1">
                                    <!--Id:step1approveBtn-->
                                    <a href="javascript:void();" class="btn btn-success step1approveBtn" id="step1a">Approve</a>
                                </div>
                                <div class="col-md-1" style="padding-left:18px;">
                                    <!--Id:step1declineBtn-->
                                    <a href="javascript:void();" class="btn btn-danger step1declineBtn" id="step1d">Decline</a>
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
                                <div class="col-md-1">
                                    <!--Id:step2approveBtn-->
                                    <a href="javascript:void();" class="btn btn-success step2approveBtn" id="step2a">Approve</a>
                                </div>
                                <div class="col-md-1" style="padding-left:18px;">
                                    <!--Id:step2declineBtn-->
                                    <a href="javascript:void();" class="btn btn-danger step2declineBtn" id="step2d">Decline</a>
                                </div>
                                
                                <div class="col-md-3">
                                            <!--Id:step1approveBtn-->
                                    <a href="javascript:void();" class="btn btn-warning assignReqnoBtn" id="reqnobtn">Add Requisition No.</a>
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
                                <div class="col-md-1">
                                    <!--Id:step3approveBtn-->
                                    <a href="javascript:void();" class="btn btn-success step3approveBtn" id="step3a">Approve</a>
                                </div>
                                <div class="col-md-1" style="padding-left:18px;">
                                    <!--Id:step3declineBtn-->
                                    <a href="javascript:void();" class="btn btn-danger step3declineBtn" id="step3d">Decline</a>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="fw-bold" style="padding-bottom:5px;" for="date">Remarks:</label>
                                    <select class="" style="width: 150px; Border: none;" id="remark" disabled>
                                        <option disabled selected value hidden></option>
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
                                    <a href="javascript:void();" class="btn btn-info text-white updateBtn disabled" id="updbtn" hidden>Update</a>
                                    <a href="javascript:void();" class="btn btn-secondary editfieldBtn">Edit</a>
                                    <!--<button type="" class="btn btn-primary approveBtn">Approve</button>
                                <button type="button" class="btn btn-danger">Decline</button>
                                <button type="submit" class="btn btn-info text-white">Update</button>-->
                                    <script>
                                        $(document).on('click', '.editfieldBtn', function(event) {
                                            var updtbtn = document.getElementById("updbtn");
                                            document.getElementById("quantity").disabled = false;
                                            document.getElementById("description").disabled = false;
                                            document.getElementById("purpose").disabled = false;
                                            document.getElementById("remark").disabled = false;
                                            document.getElementById("sections").disabled = false;
                                            document.getElementById("_inputFeedback").disabled = false;
                                            if(document.getElementById("_step1").value == 'Declined' || document.getElementById("_step1").value == 'Pending')
                                            {
                                            document.getElementById("step1a").hidden = false;
                                            document.getElementById("step1d").hidden = false;
                                            document.getElementById("_bdapprovedby").disabled = false;
                                            }
                                            if(document.getElementById("_step2").value == 'Declined' || document.getElementById("_step2").value == 'Pending')
                                            {
                                            document.getElementById("step2a").hidden = false;
                                            document.getElementById("step2d").hidden = false;
                                            document.getElementById("_pcoapprovedby").disabled = false;
                                            document.getElementById("reqnobtn").hidden = false;
                                            }

                                            if(document.getElementById("_step3").value == 'Declined' || document.getElementById("_step3").value == 'Pending' )
                                            {
                                            document.getElementById("step3a").hidden = false;
                                            document.getElementById("step3d").hidden = false;
                                            document.getElementById("_cadapprovedby").disabled = false;
                                            }
                                            updtbtn.classList.remove("disabled");
                                            updtbtn.classList.remove("text-white");
                                            document.getElementById("updbtn").hidden = false;

                                        });
                                    </script>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- edit user modalPopup end-->
    <!--Print section-->
    <div class="print-area">
        <div class="modal fade" id="printmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog " style="max-width:1100px;">
                <div class="modal-content" style="border: none; border-color: transparent;">
                    <div class="modal-header" style="max-width:1100px;">
                        <div class="col-md-5">
                            <h5 class="modal-title text-uppercase fw-bold" id="exampleModalLabel">Major Job Request</h5>
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
                                            <th class="col-md-3">JOB REQUEST NO.</th>
                                            <td><input style="border: none; border-color: transparent;" type="text" id="jobrequestno1" disabled></td>
                                        </tr>
                                        <tr>
                                            <th class="col-md-2" style="text-align: left;">REQUISITION NO.</th>
                                            <td><input style="border: none; border-color: transparent;" type="text" id="requino1" disabled></td>
                                        </tr>
                                        <tr>
                                            <th class="col-md-2" style="text-align: left;">DEPARTMENT</th>
                                            <td><input style="border: none; border-color: transparent;" type="text" id="department1" disabled></td>
                                        </tr>
                                        <tr>
                                            <th class="col-md-2" style="text-align: left;">DATE</th>
                                            <td><input style="border: none; border-color: transparent;" type="text" id="date1" disabled></td>
                                        </tr>
                                        <tr>
                                            <th class="col-md-2" style="text-align: left;">SECTIONS</th>
                                            <td><input style="border: none; border-color: transparent;" type="text" id="sections1" disabled></td>
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
                                            <td><textarea style="border: none; border-color: transparent;" class="form-control" rows="2" id="quantity1" disabled></textarea></td>
                                            <td colspan="3"><textarea style="border: none; border-color: transparent;" class="form-control col-md-3" rows="2" id="description1" disabled></textarea></td>
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
                                            <td colspan="3"><textarea style="border: none; border-color: transparent;" class="form-control" rows="2" id="purpose1" disabled></textarea></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr style="border: 0px; border: none">
                                            <th style="text-align: left; ; border: 0px; border: none">Requested by:</th>
                                            <td style="border: 0px; border: none "><input style="border: none; border-color: transparent;" type="text" id="requestedby1" disabled></td>
                                            <th style="text-align: left; ; border: 0px; border: none">Department head:</th>
                                            <td style="border: 0px; border: none "><input style="border: none; border-color: transparent;" type="text" id="depart1" disabled></td>
                                        </tr>
                                        <tr>
                                            <th class="col-md-3">B.1. RECOMMENDATION</th>
                                            <td><textarea style="border: none; border-color: transparent;" class="form-control" id=""></textarea></td>
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        For Canvass
                                                    </label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        For ordering
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="col-md-3">B.2. ESTIMATED COST</th>
                                            <td><textarea style="border: none; border-color: transparent;" class="form-control" id=""></textarea></td>
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        For PO approval
                                                    </label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        For delivery
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="col-md-3">B.3. RECOMMENDED BY</th>
                                            <td><textarea style="border: none; border-color: transparent;" class="form-control" id=""></textarea></td>
                                            <th>REMARKS:</th>
                                            <th><textarea style="border: none; border-color: transparent;" class="form-control" id="remarks1" disabled></textarea></th>
                                        </tr>
                                        <tr style="border: 0px; border: none">
                                            <th colspan="2" style="text-align:center ; border: 0px; border: none">NOTED BY:_______________________________</th>
                                            <th colspan="2" style="text-align:center ; border: 0px; border: none">APPROVED BY:MS.CANDICE GOTIANUY</th>
                                            <td style="border: 0px; border: none "></td>
                                            <td style="border: 0px; border: none "></td>
                                        </tr>
                                        <tr style="border: 0px; border: none ">
                                            <th colspan="2" style="text-align:center ; border: 0px; border: none">PROPERTY CUSTODIAN</th>
                                            <th colspan="2" style="text-align:center ; border: 0px; border: none">UC - CHANCELLOR</th>
                                            <td style="border: 0px; border: none "></td>
                                            <td style="border: 0px; border: none "></td>
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
    <div class="modal fade" id="createmajorrequest">
        <div class="modal-dialog ">
            <div class="modal-content ">
                <div class="modal-header" >
                    <h5 class="modal-title" id="exampleModalLabel">Success</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Successfully created Major Job request</p>
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
                    <p>Successfully approved Major Job request</p>
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
                    <p>Successfully declined Major Job request</p>
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
                    <p>Successfully updated Major Job request</p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>