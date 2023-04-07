<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Calendar of Activities</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.1/datatables.min.css" />
    <link rel="stylesheet" type="text/css" href="../../../css/sidebar.css?<?= time() ?>">
    <link rel="stylesheet" type="text/css" href="../../../css/header.css?<?= time() ?>">
    <link rel="stylesheet" type="text/css" href="../../../css/body.css?<?= time() ?>">
    <link rel="stylesheet" type="text/css" href="../../../css/admin/adminaccount.css?<?= time() ?>" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

</head>

<header class="shadow">
    <div class="imgctrl">

    </div>
    <div class="navplace">
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="notification-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style=" background-color: transparent;
  border: none;">
                <i class='bx bxs-bell' style='color:#ffffff'></i>
                <span class="icon-button__badge"></span>
            </button>
            <div class="dropdown-menu" aria-labelledby="notification-dropdown">
                <div class="dropdown-header">Notifications</div>
                <div class="dropdown-divider"></div>
                <div class="notification-list"></div>
                <u><a class="dropdown-item text-center mark-as-read" href="#">Mark all as read</a></u>
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

            // Fetch the notifications and update the badge and list
            function fetchNotifications() {
                // Make an AJAX request to fetch the notifications
                const xhr = new XMLHttpRequest();
                xhr.open("GET", "../../../php/connection/notification.php");
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        // Parse the response JSON
                        const notifications = JSON.parse(xhr.responseText);

                        // Update the badge count
                        notificationBadge.innerText = notifications.length;

                        // Clear the existing list
                        notificationList.innerHTML = "";

                        // Add each notification to the list
                        notifications.forEach(notification => {
                            const notificationItem = document.createElement("div");
                            notificationItem.classList.add("dropdown-item");
                            if (!notification.is_read) {
                                notificationItem.classList.add("font-weight-bold");
                            }
                            notificationItem.innerHTML = `
            <div class="d-flex align-items-center">
              <div class="flex-grow-1">${notification.message}</div>
              <div class="text-muted">${notification.created_at}</div>
            </div>
            <div class="dropdown-divider"></div>
          `;
                            notificationList.appendChild(notificationItem);
                        });
                    }
                };
                xhr.send();
            }

            // Call fetchNotifications() on page load
            fetchNotifications();

            // Poll for new notifications every 5 seconds
            setInterval(fetchNotifications, 5000);

            // Get the "Mark all as read" button
            const markAsReadButton = document.querySelector(".mark-as-read");

            // Add a click event listener to the button
            markAsReadButton.addEventListener("click", function(event) {
                // Prevent the default behavior of the link
                event.preventDefault();

                // Make an AJAX request to mark all notifications as read
                const xhr = new XMLHttpRequest();
                xhr.open("POST", "../../../php/connection/update_notification.php");
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        // Update the "is_read" property of each notification to 1
                        notifications.forEach(notification => {
                            notification.is_read = 1;
                        });

                        // Update the badge count
                        notificationBadge.innerText = "0";

                        // Clear the existing list
                        notificationList.innerHTML = "";
                    }
                }
                xhr.send();
            });
        </script>
        <p>Hello, <?php echo $_SESSION['department'];?></p>
        </div>
        <nav class="gnav">
        </nav>
</header>

<body>
    <div class="sidebar">
        <div class="logo_content">
            <div class="logo">
                <img src="../../../images/Brown_logo_faci.png" />
            </div>
        </div>

        <div class="navdiv">
            <ul class="nav_list">
                <li>
                    <a href="../../../php/user/userdashboard.php">
                        <i class='bx bx-calendar'></i>
                        <span class="link_name">Calendar of Activities</span>
                    </a>
                </li>
                <li>
                    <div class="dropdown">
                        <i class='bx bx-clipboard' style="margin-left:17px;"></i>
                        <span class="jobrequestdr btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Job Request
                        </span>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="../../../../php/user/minor/minorjobreqlist.php">Minor Job Request</a>
                            <a class="dropdown-item" href="../../../../php/user/major/majorjobreqlist.php">Major Job Request</a>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="../../../php/user/reservation/userreservation.php">
                        <i class='bx bx-check-square'></i>
                        <span class="link_name">Reservation</span>
                    </a>
                </li>
            </ul>

            <div class="profile_content">
                <div class="profile">
                    <div class="profile_details">
                        <img src="../../../images/ico/profileicon.png" alt="" style="height: 45px; width:45px; object-fit:cover; border-radius:12px;" />
                        <div class="name_role">
                            <div class="name"><?php echo $_SESSION['department']; ?></div>
                            <div class="role">User</div>
                        </div>
                    </div>
                    <a href="../../../logout.php">
                        <i class='bx bx-log-out' id="log_out"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.3/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <div class="table1">

        <div class="container-fluid">
            <div class="row">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 shadow" style="width: 100%; background-color: #FFF;  padding-top: 100px; padding-left:50px; padding-right:50px; padding-bottom:50px; ">
                            <!-- padding-left:50px; padding-right:50px; padding-bottom:50px;-->
                            <h2 style="text-align: center">CALENDAR OF ACTIVITIES</h2>
                            <table id="calendar" class="table">
                                <thead>
                                    <th>Event Name</th>
                                    <th>Date</th>
                                    <th>Time Start</th>
                                    <th>Time End</th>
                                    <th>Venue</th>
                                </thead>
                            </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.1/datatables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script>
            $("#calendar").DataTable({
                serverSide: true,
                processing: true,
                paging: true,
                order: [],
                ajax: {
                url: "dfunctions/fetch_data.php",
                type: "post",
                },
                fnCreatedRow: function (nRow, aData, iDataIndex) {
                $(nRow).attr("id", aData[0]);
                },
                columnDefs: [
                {
                    target: [0, 3],
                    orderable: false,
                },
                ],
                scrollY: 200,
                scrollCollapse: true,
                paging: false,
            });
        </script>

</body>

</html>