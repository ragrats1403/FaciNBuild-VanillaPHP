<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Major Job Request List</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">-->
    <link type="text/css" href="../../../dependencies/bootstrap/css/bootstrap.min.css?<?= time() ?>" rel="stylesheet">
    <!--<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.1/datatables.min.css" />-->
    <link rel="stylesheet" type="text/css" href="../../../dependencies/datatables/datatables.min.css?<?= time() ?>" />
    <link rel="stylesheet" type="text/css" href="../../../../css/sidebar.css?<?= time() ?>">
    <link rel="stylesheet" type="text/css" href="../../../../css/header.css?<?= time() ?>">
    <link rel="stylesheet" type="text/css" href="../../../../css/body.css?<?= time() ?>">
    <link rel="stylesheet" type="text/css" href="../../../../css/print.css?<?= time() ?>">
    <link rel="stylesheet" type="text/css" href="../../../../css/admin/adminaccount.css?<?= time() ?>" />
    <!--<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>-->
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
        <?php
        session_start();
        ?>
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
                        <div class="col-sm-12 shadow" style="width: 100%; background-color: #FFF; padding-top: 100px; padding-left:50px; padding-right:50px; padding-bottom:50px; ">
                            <!-- padding-left:50px; padding-right:50px; padding-bottom:50px;-->
                            <table id="datatable" class="table">
                                <thead>
                                    <th>Job Request no.</th>
                                    <th>Requisition no.</th>
                                    <th>Department</th>
                                    <th>Quantity</th>
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
    <!-- Script Process Start-->
    <!--<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>-->
    <script src="../../../dependencies/jquery/jquery-3.6.4.min.js"></script>
    <!--<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.1/datatables.min.js"></script>-->
    <script type="text/javascript" src="../../../dependencies/datatables/datatables.min.js"></script>
    <!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>-->
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
            'paging': false
        });
    </script>
    <script type="text/javascript">
        //print button event
        $(document).on('click', '.btnprint', function(event) {
            var id = $(this).data('id');
            var trid = $(this).closest('trid').attr('majoreq');
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
                            if(mjson.count>1)
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
                    alert('Successfully Requested Job Request!');
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
                            
                            document.getElementById("savechange").disabled = false;
                            
                        }


                }
            }
        });
    } else {
        alert("Please fill all the Required fields");
    }
});


        $(document).on('click', '.btnDelete', function(event) {
            var table = $('#datatable').DataTable();
            event.preventDefault();
            var id = $(this).data('id');
            if (confirm('Are you sure to delete this request?')) {
                $.ajax({
                    url: "functions/delete_user.php",
                    data: {
                        id: id
                    },
                    type: 'POST',
                    success: function(data) {
                        var json = JSON.parse(data);
                        status = json.status;

                        if (status == 'success') {
                            $('#' + id).closest('tr').remove();

                        } else {
                            alart('failed');
                            return;
                        }
                    }
                });
            } else {
                return null;
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
            document.getElementById("jobrequestno").disabled = true;
            document.getElementById("requino").disabled = true;
            document.getElementById("department").disabled = true;
            document.getElementById("date").disabled = true;
            document.getElementById("quantity").disabled = true;
            document.getElementById("description").disabled = true;
            document.getElementById("purpose").disabled = true;
            document.getElementById("remark").disabled = true;
            document.getElementById("sections").disabled = true;
            document.getElementById("_statustext").disabled = true;
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
                    $('#quantity').val(json.quantity);
                    $('#_req').val(json.requestedby);
                    $('#_dephead').val(json.departmenthead);
                    $('#description').val(json.description);
                    $('#purpose').val(json.purpose);
                    $('#_statustext').val(json.status);
                    $('#_step1').val(json.bdstatus);
                    $('#_step2').val(json.pcostatus);
                    $('#_step3').val(json.cadstatus);
                    $('#_bdapprovedby').val(json.bdapprovedby);
                    $('#_pcoapprovedby').val(json.pcoapprovedby);
                    $('#_cadapprovedby').val(json.cadapprovedby);
                    $('#_inputFeedback').val(json.feedback);
                    //auto enable fields when designated approval is set to pending
                    if(json.bdstatus != 'Pending')
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



        $(document).on('click', '.step1approveBtn', function(event) {
            var id = $('#jobrequestno').val();
            var trid = $('#trid').val();
            var dept = $('#department').val();
            var feedb = $('#_inputFeedback').val();
            var e = document.getElementById("sections");
            var section = e.options[e.selectedIndex].text;
            var e = document.getElementById("remark");
            var remark = e.options[e.selectedIndex].text;
            var bdapprovedby = $('#_bdapprovedby').val();
            if (id != '' &&
                dept != '' &&
                section != '' &&
                remark != '' &&
                bdapprovedby != '') {
                $.ajax({
                    url: "functions/step1approve.php",
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
                            $('#deletemodal').modal('show');
                            $('#department').val('');
                            $('#sections').val('');
                            $('#remark').val('');
                            $('#_inputFeedback').val('');
                            $('#_bdapprovedby').val('');
                            $('#_statustext').val('Approved');
                            $('#editUserModal').modal('hide');
                            $('body').removeClass('modal-open');
                        } else {
                            alert('failed');
                        }
                    }
                });
            } else {
                $('#alert1').css('display', 'block');
                $('#strongId').html('Please fill up required fields!');
            }
        });
        $(document).on('click', '.loadImage', function(event) {
            $.ajax({
                url: "functions/testfetchimage.php",
                type: "GET",
                dataType: "json",
                success: function(response) {
                    var status = response.status;
                    if (status === "success") {
                        var imageData = response.image;
                        var imageSource = "data:image/jpg;base64," + imageData;
                        $("#testimage").attr("src", imageSource);
                    } else {
                        console.log("Failed to fetch image");
                        alert("Failed to fetch image");
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log("AJAX error:", textStatus, errorThrown);
                }
            });
        });
        $(document).on('click', '.step1declineBtn', function(event) {
            var id = $('#jobrequestno').val();
            var trid = $('#trid').val();
            var dept = $('#department').val();
            var feedb = $('#_inputFeedback').val();
            if(feedb != '')
            {
                $.ajax({
                    url: "functions/step1decline.php",
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
                            $('#declinemodal').modal('show');
                            $('#_step1').val('Declined');
                            $('#_statustext').val('Declined');
                            $('#editUserModal').modal('hide');
                            $('body').removeClass('modal-open');
                        } else {
                            alert('failed');
                        }
                    }
                });
            }
            else
            {
                $('#alert1').css('display', 'block');
                $('#strongId').html('Please provide a feedback when declining request ');
            }
            
        });

        $(document).on('click', '.updateBtn', function() {
            var id = $('#id').val();
            var trid = $('#trid').val();
            var jobreqno = $('#jobrequestno').val();
            var requino = $('#requino').val();
            var department = $('#department').val();
            var date = $('#date').val();
            var e = document.getElementById("sections");
            var section = e.options[e.selectedIndex].text;
            var quantity = $('#quantity').val();
            var item = $('#item').val();
            var description = $('#description').val();
            var purpose = $('#purpose').val();
            var e = document.getElementById("remark");
            var outsource = e.options[e.selectedIndex].text;
            var feedback = $("#_inputFeedback").val();
            $.ajax({
                url: "functions/update_user.php",
                data: {
                    jobreqno: jobreqno,
                    requino: requino,
                    department: department,
                    date: date,
                    section: section,
                    quantity: quantity,
                    item: item,
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
                        table = $('#datatable').DataTable();
                        /*var button = '<a href= "javascript:void();" data-id="'+jobreqno+'" class ="btn btn-sm btn-info editBtn">More Info</a>';
                        var row = table.row("[id='" + trid + "']");
                        row.row("[id='" + trid + "']").data([jobreqno, requino, department, date, section, quantity, item , description,purpose , outsource]);*/
                        $('#editUserModal').modal('hide');
                    } else {
                        alert('failed');
                    }
                }
            });
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

                function iteratemultivals(dep, rqby, datesub, purp, i)
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

                $("#printmodal").on("hide.bs.modal", function () {
                    const myNode =  document.getElementById('container2');
                    while (myNode.firstChild) {
                    myNode.removeChild(myNode.lastChild);
                    }
                        $('#testtable').DataTable().clear().destroy();
                                        $("#quantity1").val("");
                                        $("#quantity2").val("");
                                        $("#quantity3").val("");
                                        $("#quantity4").val("");
                                        $("#quantity5").val("");
                                        $("#description1").val("");
                                        $("#itemdesc2").val("");
                                        $("#itemdesc3").val("");
                                        $("#itemdesc4").val("");
                                        $("#itemdesc5").val("");
                });
        </script>
    <!-- Script Process End-->
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
                                    <label class="fw-bold" for="date">Item with Complete Description</label>
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
                            
                            <div class="col-md-12">
                                        <div class="alert1" id="alert1" style = "display:none; width: 100%;">
                                            <span class="cbtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                                            <strong id = "strongId"> Please fill in the blanks</strong>
                                        </div>
                                        <div class="alert2" id="alert1" style = "display:none; width: 100%;">
                                            <span class="cbtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                                            <strong id = "strongId"> Please provide a feedback when declining request</strong>
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
                            <div>
                                <div class="modal-footer justify-content-md-center">
                                    <a href="javascript:void();" class="btn btn-primary step1approveBtn" id="step1a">Approve</a>
                                    <a href="javascript:void();" class="btn btn-danger step1declineBtn" id="step1d">Decline</a>
                                    <a href="javascript:void();" class="btn btn-info text-white updateBtn disabled" id="updbtn" hidden>Update</a>
                                    <a href="javascript:void();" class="btn btn-secondary editfieldBtn" hidden>Edit</a>
                                </div>
                            </div>
                            <script>
                                $('#printmodal').on('hidden.bs.modal', function () {
                                $('textarea').val(''); // clear all textareas
                                location.reload(); // reload the page
                                });
                            </script>
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
                    <h5 class="modal-title" id="exampleModalLabel">Success</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Successfully approved Major job request</p>
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
                    <p>Successfully declined Major job request</p>
                </div>
            </div>
        </div>
    </div>
    <script>
        //date auto fill
        var now = new Date();
        now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
        document.getElementById('deeto').value = now.toISOString().substring(0, 10);
        //date end
    </script>
</body>

</html>