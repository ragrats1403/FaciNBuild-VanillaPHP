<?php
require_once('../authentication/anti_pagetrans.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Calendar of Activities</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" href="../../dependencies/bootstrap/css/bootstrap.min.css?<?= time() ?>" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../../dependencies/datatables/datatables.min.css?<?= time() ?>" />
    <link rel="stylesheet" type="text/css" href="../../../css/sidebar.css?<?= time() ?>">
    <link rel="stylesheet" type="text/css" href="../../../css/header.css?<?= time() ?>">
    <link rel="stylesheet" type="text/css" href="../../../css/body.css?<?= time() ?>">
    <link rel="stylesheet" type="text/css" href="../../../css/admin/adminaccount.css?<?= time() ?>" />
    <link href='../../dependencies/boxicons/css/boxicons.min.css?<?= time() ?>' rel='stylesheet'>

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
                    url: "reservations/functions/notification.php",
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
                    url: "reservations/functions/update_notification.php",
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
</header>

<body onload = "onfilterchk();">
<div class="sidebar">
        <div class="logo_content">
            <div class="logo">
                <img src="../../../../images/Brown_logo_faci.png" />
            </div>
        </div>
        <div class="navdiv">
            <ul class="nav_list">
                <li>
                    <a href="../../../../php/cad/cadcalendarofactivities.php">
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
                            <a class="dropdown-item" href="../../../../php/cad/major/majorjobreqlist.php">Major Job Request</a>
                        </ul>
                    </div>
                    <div class="dropdown">
                        <i class='bx bx-clipboard' style="margin-left:17px;"></i>
                        <button class="btn dropdown-toggle" style="box-shadow: none;" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            View/Create Request
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="../../../../php/cad/minor/minorjobreqlist.php">Minor Job Request</a>
                            <a class="dropdown-item" href="../../../../php/cad/majoruser/majorjobreqlist.php">Major Job Request</a>
                            <a class="dropdown-item" href="../../../../php/cad/reservations/cadreservation.php">Reservation</a>
                        </ul>
                    </div>
                </li>
            </ul>
            <div class="profile_content">
                <div class="profile">
                    <div class="profile_details">
                        <img src="../../../images/ico/profileicon.png" alt="" style="height: 45px; width:45px; object-fit:cover; border-radius:12px;" />
                        <div class="name_role">
                            <div class="name"><?php echo mb_strimwidth($_SESSION['department'], 0, 20, '…'); ?></div>
                            <div class="role">CAD</div>
                        </div>
                    </div>
                    <a href="../../../logout.php">
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
                        <div class="col-sm-12 shadow" style="width: 100%; background-color: #FFF;  padding-top: 100px; padding-left:50px; padding-right:50px; padding-bottom:50px; ">
                            <!-- padding-left:50px; padding-right:50px; padding-bottom:50px;-->
                            <h2 style="text-align: center">CALENDAR OF ACTIVITIES</h2>
                            <div class="col-md-3">
                                <input class="form-check-input" type="checkbox" id="facilityfilterchk" onclick="" onchange = "onfilterchk();">
                                <label class="form-check-label" >Filter By Facility</label>
                            </div>
                            <div class="col-md-3">
                                <select class="form-control input-sm col-xs-1" name="sections" id="faci" onchange="onfilterchk();" disabled>
                                        <option disabled selected value hidden> -- Select Facility -- </option>
                                            select = document.getElementById("faci");
                                            <?php include('../connection/connection.php');
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
                            <script>
                                function onfilterchk()
                                {
                                    var chkbox = document.getElementById("facilityfilterchk");
                                    var filter = document.getElementById("faci");
                                    var filterval = filter.options[filter.selectedIndex].text;
                                    if(chkbox.checked !== true)
                                    {
                                        $('#calendar').DataTable().clear().destroy();
                                        filter.disabled = true;
                                        fetchalldata();
                                    }
                                    else
                                    {
                                        if(filterval == " -- Select Facility -- ")
                                        {
                                            $('#calendar').DataTable().clear().destroy();
                                            filter.disabled = false;
                                            fetchalldata();
                                        }
                                        else
                                        {
                                            $('#calendar').DataTable().clear().destroy();
                                            filter.disabled = false;
                                            filtereddata(filterval);
                                        }
                                        
                                    }
                                }
                                
                            </script>
                            <table id="calendar" class="table">
                                <thead>
                                    <th>Event Name</th>
                                    <th>Date</th>
                                    <th>Time Start</th>
                                    <th>Time End</th>
                                    <th>Venue</th>
                                    <th>FD Status</th>
                                    <th>SAO Status</th>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../../dependencies/jquery/jquery-3.6.4.min.js"></script>
    <script type="text/javascript" src="../../dependencies/datatables/datatables.min.js"></script>
    <script src="../../dependencies/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        function fetchalldata()
        {
            $("#calendar").DataTable({
            'searching': false,
            'autoWidth': false,
            'bJQueryUI': true,
            'info': false,
            'serverSide': true,
            'processing': true,
            'paging': true,
            'order': [],
            'responsive': true,
            'ajax': {
                'url': "dfunctions/fetch_data.php",
                'type': "post",
            },
            fnCreatedRow: function(nRow, aData, iDataIndex) {
                $(nRow).attr("id", aData[0]);
                if (aData[6] === 'Approved') {
                    $(nRow).css('background-color', '#a7d9ae');
                }
                if (aData[5] === 'Approved' && aData[6] === 'Pending') {
                    //$(nRow).css('background-color', '#d9d2a7');//yellow
                    $(nRow).css('background-color', '#89afcc');
                }
            },
            'columnDefs': [{
                target: 5,
                visible: false,
            },
            {
                target: 6,
                visible: false,
            } 
            ],
            scrollY: 670,
            'scrollCollapse': false,
            'paging': false,
        });
        }

        function filtereddata(facility)
        {
            var faci = facility;
            $("#calendar").DataTable({
            'searching': false,
            'autoWidth': false,
            'bJQueryUI': true,
            'info': false,
            'serverSide': true,
            'processing': true,
            'paging': true,
            'order': [],
            'responsive': true,
            'ajax': {
                'url': "dfunctions/fetchwfilter.php",
                'type': "post",
                'data': {
                    facility: faci,
                },
            },
            fnCreatedRow: function(nRow, aData, iDataIndex) {
                $(nRow).attr("id", aData[0]);
                if (aData[6] === 'Approved') {
                    $(nRow).css('background-color', '#a7d9ae');
                }
                if (aData[5] === 'Approved' && aData[6] === 'Pending') {
                    //$(nRow).css('background-color', '#d9d2a7');//yellow
                    $(nRow).css('background-color', '#89afcc');
                }
            },
            'columnDefs': [{
                target: 5,
                visible: false,
            },
            {
                target: 6,
                visible: false,
            } 
            ],
            scrollY: 670,
            'scrollCollapse': false,
            'paging': false,
        });
        }
        
    </script>

</body>

</html>