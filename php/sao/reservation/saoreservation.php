<?php
require_once('../../authentication/anti_pagetrans.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Reservation</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.1/datatables.min.css" />
    <link rel="stylesheet" type="text/css" href="../../../../css/sidebar.css?<?= time() ?>">
    <link rel="stylesheet" type="text/css" href="../../../../css/header.css?<?= time() ?>">
    <link rel="stylesheet" type="text/css" href="../../../../css/body.css?<?= time() ?>">
    <link rel="stylesheet" type="text/css" href="../../../../css/admin/adminaccount.css?<?= time() ?>" />
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

<body onload="bodyonload();">
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
                                <a class="dropdown-item" href="../../../php/sao/majoruser/majorjobreqlist.php">Major Request</a>
                                <a class="dropdown-item" href="../../../php/sao/minor/minorjobreqlist.php">Minor Request</a>
                                <a class="dropdown-item" href="../../../php/sao/reservation/saoreservation.php">Reservation</a>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <a href="../../../php/sao/generatereports/generatereports.php">
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


    <!--<script>
        let btn = document.querySelector("#btn");
        let sidebar = document.querySelector(".sidebar");

        btn.onclick = function() {
            sidebar.classList.toggle("active");
        }
    </script>-->
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
                                    <th>Event Name</th>
                                    <th>Requesting party</th>
                                    <th>Facility</th>
                                    <th>Date Filed</th>
                                    <th>Actual Date of Use</th>
                                    <th>Status</th>
                                    <th>Options</th>
                                </thead>
                            </table>
                            <div class="col-sm-12 d-flex justify-content-end">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reserModal">Create reservation</button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script Process Start-- DO NOT MOVE THIS Script tags!!-->
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.1/datatables.min.js"></script>
    <script type="text/javascript" src="functions/js/userprocess.js?random=<?php echo uniqid(); ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script>
        var dpt = "<?php echo $_SESSION['department'];?>";
        $('#datatable').DataTable({
    'serverSide': true,
    'processing': true,
    'paging': true,
    'order': [],
    'ajax': {
        'url': 'functions/fetch_data.php',
        'type': 'post',
        'data': {
            dpt: dpt,
        },
    },
    'fnCreatedRow': function(nRow, aData, iDataIndex) {
        $(nRow).attr('id', aData[0]);
        if (aData[6] === 'Approved') {
            $(nRow).css('background-color', '#a7d9ae');
        }
        if (aData[6] === 'Declined') {
            $(nRow).css('background-color', '#e09b8d');
        }
        if (aData[6] === 'Pending') {
            $(nRow).css('background-color', '#d9d2a7');
        }
    },
    'columnDefs': [{
        'targets': [0, 4],
        'orderable': false,
    }],
    scrollY: 200,
    scrollCollapse: true,
    paging: false,
});
    </script>
    <!-- Modal Popup for More Info button-->
    <div class="modal fade" id="test" aria-hidden="true">
        <div class="modal-dialog" style="max-width:1100px;">
            <div class="modal-content">
                <div class="modal-header justify-content-center" style="max-width:1100px;">
                    <div class="col-md-2" style="width:17%;">
                        <h5 class="modal-title text-uppercase fw-bold" id="exampleModalLabel">View Reservation</h5>
                    </div>
                    <div class="col-md-12" style="width:15%">
                        <label class="" for="inputName">Status:</label>
                        <input type="text" style="width:60%" class="col-sm-1" name="_ID" class="form-control" id="_statustext">
                    </div>
                    <div class="col-md-1" style="width:10%">
                        <label class="" for="inputName">ID:</label>
                        <input type="text" style="width:21%" class="col-sm-1" name="_ID" class="form-control" id="_ID" disabled>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>

                <div class="modal-body ">
                    <form action="">
                        Please select the facilities you would like to request.
                        <!--
                        <input type="checkbox" id="annex_avr" name="Annex AVR" value="annex_avr">
                        <label for="annex_avr"> Annex AVR</label>
                        <input type="checkbox" id="new_avr" name="New AVR" value="new_avr">
                        <label for="new_avr"> New AVR</label>
                        <input type="checkbox" id="cbe_functionhall" name="CBE Function Hall" value="cbe_functionhall">
                        <label for="cbe_functionhall"> CBE Function Hall</label>
                        <input type="checkbox" id="auditorium" name="Auditorium" value="auditorium">
                        <label for="auditorium"> Auditorium</label>
                        <input type="checkbox" id="be_functionhall" name="BE Function Hall" value="be_functionhall">
                        <label for="be_functionhall"> BE Function Hall</label><br><br>-->
                        <div class="row justify-content-center" style="padding-bottom:13px;">
                            <div class="col-md-6 ">
                                <!-- redacted
                                <select class="form-control input-sm col-xs-1" name="sections" id="faci">
                                    select = document.getElementById("faci");
                                    
                                    <?php include('../../connection/connection.php');
                                    $sql = "SELECT facilityname FROM facility";
                                    $query = mysqli_query($con, $sql);
                                    $i = 1;
                                    while ($row = mysqli_fetch_assoc($query)) {
                                        echo "<option value=$i>" . $row["facilityname"] . "</option>";
                                        $i++;
                                    }
                                    ?>               
                                </select>-->
                                <input type="text" class="form-control input-sm col-xs-1" id="_facility" placeholder="Facility">

                            </div>
                            <div class="col-md-6 ">
                                <input type="text" class="form-control input-sm col-xs-1" id="_eventname" placeholder="Event Name">
                            </div>
                        </div>
                        <div class="row justify-content-center" style="padding-bottom:13px;">
                            <div class="col-md-6 ">
                                <label class="fw-bold" for="date">Date Filed:</label>
                                <input type="date" class="form-control input-sm col-xs-1" id="_datefiled" placeholder="Date Filed" disabled>
                            </div>
                            <div class="col-md-6 ">
                                <label class="fw-bold" for="date">Actual Date of Use:</label>
                                <input type="date" class="form-control input-sm col-xs-1" id="_actualdate" placeholder="Actual Date of Use">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <label class="fw-bold" for="date">Time In:</label>
                            <input type="time" class="form-control input-sm col-xs-1" id="_timein" placeholder="Time In" pattern="[0-9]{2}:[0-9]{2}:[0-9]{2}">
                        </div>
                        <div class="col-md-2">
                            <label class="fw-bold" for="date">Time Out:</label>
                            <input type="time" class="form-control input-sm col-xs-1" id="_timeout" placeholder="Time Out" pattern="[0-9]{2}:[0-9]{2}:[0-9]{2}">
                        </div>

                        <div class="col-md-6 ">
                            <label class="fw-bold" for="date">Requesting Party:</label>
                            <input type="name" class="form-control input-sm col-xs-1" id="_reqparty" placeholder="Requesting Party">
                        </div>
                        <div class="justify-content-center">
                            <div class="col-md-12">
                                <label class="fw-bold" for="date">Purpose of Activity:</label>
                                <textarea class="form-control" rows="2" id="_purpose" placeholder="Purpose"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6 ">
                            <label class="fw-bold" for="date">Estimated No. of Audience/Participants:</label>
                            <input type="name" class="form-control input-sm col-xs-1" id="_numparticipants" placeholder="Estimated No. of Audience/Participants">
                        </div>
                        <div class="col-md-6 ">
                            <label class="fw-bold" for="date">Stage Performers (if any):</label>
                            <input type="name" class="form-control input-sm col-xs-1" id="_stageperformers" placeholder="Stage Performers (if any)">
                        </div>
                        <br><br><br>
                        <label>NB: All other equipment (e.g. Backdrop, chairs, etc.,) shall be the responsibility of the requesting party.
                            Technician’s, Electrical, Janitor’s and security guards overtime fees/excess fees are subject to the terms an condition provided at the bank thereof.<br>
                            Secure Reservation from the AVR (filled up by the AVR personnel only)
                            <br>
                            2. The activity is officially endorsed and approved by the adviser, Chairperson/Dean, Department Head,
                            and the SAO/ Cultural Directory. (if “disapproved”, it must be so stated, citing briefly the reason thereof)<br><br>
                        </label>

                        <div class="col-md-6 ">
                            <label class="fw-bold" for="date">Adviser</label>
                            <input type="name" class="form-control input-sm col-xs-1" id="_adviser" placeholder="Adviser">
                        </div>
                        <div class="col-md-6 ">
                            <label class="fw-bold" for="date">CHAIRPERSON/DEAN/DEPARTMENT</label>
                            <input type="name" class="form-control input-sm col-xs-1" id="_chairdeandep" placeholder="CHAIRPERSON/DEAN/DEPARTMENT">
                        </div>
                        <label class="fw-bold">Equipments Added To Reservation</label>
                        <div id="container3">
                            <div id="container4">

                            </div>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="_flexCheckDefault" disabled>
                            <label class="form-check-label" for="flexCheckDefault"> Add-on </label>
                        </div>
                        <div id="_myDIV1" style="display: none;">
                            <div class="col-sm-12 d-flex justify-content-center">
                                <h5 class="modal-title text-uppercase fw-bold " id="exampleModalLabel">Add-ons</h5>
                            </div>
                            <form id="saveUserForm" action="javascript:void();" method="POST">
                                <input type="hidden" id="eventname">
                                <!-- Form Controls-->
                                <div class="row justify-content-center" style="padding-bottom:13px;">
                                    <div class="col-md-6 ">
                                        <label class="fw-bold" for="date">Department:</label>
                                        <input type="name" class="form-control input-sm col-xs-1" id="_dept" placeholder="Department">
                                    </div>
                                    <div class="col-md-6 ">
                                        <label class="fw-bold" for="date">Date:</label>
                                        <input type="date" class="form-control input-sm col-xs-1" id="_dateresm" placeholder="Date" disabled>
                                    </div>
                                </div>
                                <div class="row">
                                    <h5 class="text-uppercase fw-bold">A. Requisition(To be filled up by the requesting party)</h5>

                                </div>
                                <div class="row">
                                    <div class="col-md-2" style="width:20%">
                                        <label class="fw-bold" for="date">Quantity:</label>
                                        <input type="name" class="form-control input-sm col-xs-1" id="_minorqres" placeholder="Quantity">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2" style="padding-bottom:10px; width:20%">
                                        <label class="fw-bold" for="date">Item Name:</label>
                                        <input type="form-control" class="form-control" id="_minoritemres" placeholder="Item">
                                    </div>
                                </div>
                                <div class="justify-content-center">
                                    <div class="col-md-12">
                                        <label class="fw-bold" for="date">Description:</label>
                                        <textarea class="form-control" rows="2" id="_minoritemdesc" placeholder="Description"></textarea>
                                    </div>
                                </div>

                                <div class="justify-content-center">
                                    <div class="col-md-12">
                                        <label class="fw-bold" for="date">Purpose:</label>
                                        <textarea class="form-control" rows="2" id="_minorpurpose" placeholder="Purpose"></textarea>
                                    </div>
                                </div>
                                <!-- Form Controls End-->
                            </form>
                        </div>
                        <!-- ADD ON SECTION END-->
                    </form>
                </div>
                <div class="modal-footer">
                    <div class="tacbox"></div>
                    <input id="termscond" type="checkbox" />
                    <label for="termscond"> I agree to these <a href="#"> Terms and Conditions prior to Approval</a></label>
                </div>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
            <script>
                document.getElementById("termscond").checked = true;
                document.getElementById("termscond").disabled = true;
                //date auto fill
                var now = new Date();
                now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
                document.getElementById('datefiled').value = now.toISOString().substring(0, 10);
                //date end
            </script>
        </div>
    </div>
    </div>
    <br>
    <br>
    <!-- Modal Popup End -->

    <!-- Create Reservation start-->
    <div class="modal " tabindex="-1" id="reserModal" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" style="max-width:1100px;">
            <div class="modal-content">
                <div class="modal-header justify-content-center" style="max-width:1100px;">
                    <h5 class="modal-title text-uppercase fw-bold" id="exampleModalLabel">Reservation Form</h5>
                </div>
                <div class="modal-body ">
                    <form action="">
                        Please select the facilities you would like to request.
                        <!--
                        <input type="checkbox" id="annex_avr" name="Annex AVR" value="annex_avr">
                        <label for="annex_avr"> Annex AVR</label>
                        <input type="checkbox" id="new_avr" name="New AVR" value="new_avr">
                        <label for="new_avr"> New AVR</label>
                        <input type="checkbox" id="cbe_functionhall" name="CBE Function Hall" value="cbe_functionhall">
                        <label for="cbe_functionhall"> CBE Function Hall</label>
                        <input type="checkbox" id="auditorium" name="Auditorium" value="auditorium">
                        <label for="auditorium"> Auditorium</label>
                        <input type="checkbox" id="be_functionhall" name="BE Function Hall" value="be_functionhall">
                        <label for="be_functionhall"> BE Function Hall</label><br><br>-->
                        <div class="row justify-content-center" style="padding-bottom:13px;">
                            <div class="col-md-6 ">
                                <select class="form-control input-sm col-xs-1" name="sections" id="faci" onchange="dynamicEq()">
                                    <option disabled selected value hidden> -- Select Facility -- </option>
                                    select = document.getElementById("faci");
                                    <?php include('../../connection/connection.php');
                                    $sql = "SELECT facilityname FROM facility";
                                    $query = mysqli_query($con, $sql);
                                    $i = 1;
                                    while ($row = mysqli_fetch_assoc($query)) {
                                        echo "<option value=$i>" . $row["facilityname"] . "</option>";
                                        $i++;
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6 ">
                                <input type="text" class="form-control input-sm col-xs-1" id="eventname_" placeholder="Event Name">
                            </div>
                        </div>
                        <div class="row justify-content-center" style="padding-bottom:13px;">
                            <div class="col-md-6 ">
                                <label class="fw-bold" for="date">Date Filed:</label>
                                <input type="date" class="form-control input-sm col-xs-1" id="datefiled" placeholder="Date Filed" disabled>
                            </div>
                            <div class="col-md-6 ">
                                <label class="fw-bold" for="date">Actual Date of Use:</label>
                                <input type="date" class="form-control input-sm col-xs-1" id="actualdate" placeholder="Actual Date of Use">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <label class="fw-bold" for="date">Time In:</label>
                            <input type="time" class="form-control input-sm col-xs-1" id="timein" placeholder="Time In">
                        </div>
                        <div class="col-md-2">
                            <label class="fw-bold" for="date">Time Out:</label>
                            <input type="time" class="form-control input-sm col-xs-1" id="timeout" placeholder="Time Out">
                        </div>

                        <div class="col-md-6 ">
                            <label class="fw-bold" for="date">Requesting Party:</label>
                            <input type="name" class="form-control input-sm col-xs-1" id="reqparty" placeholder="Requesting Party" value="<?php echo $_SESSION['department']; ?>" disabled>
                        </div>
                        <div class="justify-content-center">
                            <div class="col-md-12">
                                <label class="fw-bold" for="date">Purpose of Activity:</label>
                                <textarea class="form-control" rows="2" id="purpose" placeholder="Purpose"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6 ">
                            <label class="fw-bold" for="date">Estimated No. of Audience/Participants:</label>
                            <input type="name" class="form-control input-sm col-xs-1" id="numparticipants" placeholder="Estimated No. of Audience/Participants">
                        </div>
                        <div class="col-md-6 ">
                            <label class="fw-bold" for="date">Stage Performers (if any):</label>
                            <input type="name" class="form-control input-sm col-xs-1" id="stageperformers" placeholder="Stage Performers (if any)">
                        </div>
                        <br><br>
                        <label>NB: All other equipment (e.g. Backdrop, chairs, etc.,) shall be the responsibility of the requesting party.
                            Technician’s, Electrical, Janitor’s and security guards overtime fees/excess fees are subject to the terms an condition provided at the bank thereof.<br>
                            Secure Reservation from the AVR (filled up by the AVR personnel only)
                            <br>
                            <br>
                            The activity is officially endorsed and approved by the adviser, Chairperson/Dean, Department Head,
                            and the SAO/ Cultural Directory. (if “disapproved”, it must be so stated, citing briefly the reason thereof)<br><br>
                        </label>

                        <div class="col-md-6 ">
                            <label class="fw-bold" for="date">Adviser</label>
                            <input type="name" class="form-control input-sm col-xs-1" id="adviser" placeholder="Adviser">
                        </div>
                        <div class="col-md-6 ">
                            <label class="fw-bold" for="date">CHAIRPERSON/DEAN/DEPARTMENT</label>
                            <input type="name" class="form-control input-sm col-xs-1" id="chairdeandep" placeholder="CHAIRPERSON/DEAN/DEPARTMENT">
                        </div>
                        <br>
                        <label class="fw-bold" for="date">Facility Equipments</label>
                        <div class="table-responsive">
                            <table id="testtable" class="table" width="100%">
                                <thead>
                                    <th>Equipments Name</th>
                                    <th>Quantity</th>
                                    <th>Quantity to Reserve</th>
                                </thead>
                            </table>
                        </div>
                        <label class="fw-bold">Equipments Added To Reservation</label><br>
                        <!--<a href= "javascript:void();" class ="btn btn-primary testBtn" onclick = "testClick();">Test Console</a>-->
                        <div id="container1">
                            <div id="container2">
                            </div>
                        </div>
                        <!--<div class="col-sm-12 d-flex justify-content-end">
                            <a data-toggle="modal" href="#myModal2" class="btn btn-primary">Add-ons</a>
                        </div>-->
                        <!-- ADD ON SECTION-->
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" onclick="myFunction('_myDIV2')">
                            <label class="form-check-label" for="flexCheckDefault"> Add-on </label>
                        </div>
                        <div id="_myDIV2" style="display: none;">
                            <div class="col-sm-12 d-flex justify-content-center">
                                <h5 class="modal-title text-uppercase fw-bold " id="exampleModalLabel">Add-ons</h5>
                            </div>
                            <form id="saveUserForm" action="javascript:void();" method="POST">
                                <input type="hidden" id="eventname">
                                <!-- Form Controls-->
                                <div class="row justify-content-center" style="padding-bottom:13px;">
                                    <div class="col-md-6 ">
                                        <label class="fw-bold" for="date">Department:</label>
                                        <input type="name" class="form-control input-sm col-xs-1" id="_department" placeholder="Department">
                                    </div>
                                    <div class="col-md-6 ">
                                        <label class="fw-bold" for="date">Date:</label>
                                        <input type="date" class="form-control input-sm col-xs-1" id="dateminor" placeholder="Date" disabled>
                                    </div>
                                </div>
                                <div class="row">
                                    <h5 class="text-uppercase fw-bold">A. Requisition(To be filled up by the requesting party)</h5>

                                </div>
                                <div class="row">
                                    <div class="col-md-2" style="width:20%">
                                        <label class="fw-bold" for="date">Quantity:</label>
                                        <input type="name" class="form-control input-sm col-xs-1" id="_quantity_" placeholder="Quantity">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2" style="padding-bottom:10px; width:20%">
                                        <label class="fw-bold" for="date">Item Name:</label>
                                        <input type="form-control" class="form-control" id="_item_" placeholder="Item">
                                    </div>
                                </div>
                                <div class="justify-content-center">
                                    <div class="col-md-12">
                                        <label class="fw-bold" for="date">Description:</label>
                                        <textarea class="form-control" rows="2" id="_itemdesc_" placeholder="Description"></textarea>
                                    </div>
                                </div>

                                <div class="justify-content-center">
                                    <div class="col-md-12">
                                        <label class="fw-bold" for="date">Purpose:</label>
                                        <textarea class="form-control" rows="2" id="_purpose_" placeholder="Purpose"></textarea>
                                    </div>
                                </div>
                                <!-- Form Controls End-->
                            </form>
                        </div>
                        <!-- ADD ON SECTION END-->
                    </form>
                </div>
                <div class="modal-footer">
                    <div class="tacbox">
                        <input id="termscond" type="checkbox" onchange="updateButtonState()" />
                        <label for="termscond"> I agree to these <a href="termsandcondition.html" target="_blank"> Terms and Conditions prior to Approval</a></label>
                    </div>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <!--<button type="submit" class="btn btn-primary disabled" id='termscond-create'>Save Changes</button>-->
                    <a href="javascript:void();" class="btn btn-primary submitBtn disabled" id='termscond-create'>Save Changes</a>

                </div>
                <script type="text/javascript" src="functions/js/createresdep.js?random=<?php echo uniqid(); ?>"></script>

            </div>
        </div>
    </div>
    <!-- create reservation end -->






    <!-- BODY END-->
</body>

</html>