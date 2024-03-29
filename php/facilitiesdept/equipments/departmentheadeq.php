<?php
require_once('../../authentication/anti_pagetrans.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Equipments</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" href="../../../dependencies/bootstrap/css/bootstrap.min.css?<?= time() ?>" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../../../dependencies/datatables/datatables.min.css?<?= time() ?>" />
    <link rel="stylesheet" type="text/css" href="../../../../css/sidebar.css?<?=time()?>">
    <link rel="stylesheet" type="text/css" href="../../../../css/header.css?<?=time()?>">
    <link rel="stylesheet" type="text/css" href="../../../../css/body.css?<?=time()?>">
    <link rel="stylesheet" type="text/css" href="../../../../css/admin/adminaccount.css?<?=time()?>" />
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
                    url: "../reservations/functions/notification.php",
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
                    url: "../reservations/functions/update_notification.php",
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
                    <a href="../../../../php/facilitiesdept/reservations/facilitiescalendar.php">
                        <i class='bx bx-calendar'></i>
                        <span class="link_name">Calendar of Activities</span>
                    </a>
                </li>
                <li>
                    <a href="../../../php/facilitiesdept/equipments/departmentheadeq.php">
                        <i class='bx bx-wrench'></i>
                        <span class="link_name">Equipment</span>
                    </a>
                </li>
                <li>
                    <div class="dropdown">
                        <i class='bx bx-notepad' style="margin-left:17px;"></i>
                        <button class="btn dropdown-toggle" style="box-shadow: none;"type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            Manage Request
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="../../../php/facilitiesdept/managereserve/managereservation.php">Reservations</a>
                        </ul>
                    </div>
                    <div class="dropdown">
                        <i class='bx bx-clipboard' style="margin-left:17px;"></i>
                        <button class="btn dropdown-toggle" style="box-shadow: none;"type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            View/Create Request
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="../../../php/facilitiesdept/minor/minorjobreqlist.php">Minor Job Request</a>
                            <a class="dropdown-item" href="../../../php/facilitiesdept/major/majorjobreqlist.php">Major Job Request</a>
                            <a class="dropdown-item" href="../../../php/facilitiesdept/reservations/reservations.php">Reservations</a>
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
                            <div class="role">Facilities Department</div>
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
                        <div class="col-sm-12 shadow" style="width: 100%; background-color: #fff; padding-top: 100px; padding-left:50px; padding-right:50px; padding-bottom:50px; ">
                            <!-- padding-left:50px; padding-right:50px; padding-bottom:50px;-->
                            <table id="datatable" class="table">
                                <thead>
                                    <th>ID</th>
                                    <th>Equipment Name</th>
                                    <th>Quantity</th>
                                    <th>Facility Stored</th>
                                    <th>Options</th>

                                </thead>
                                <tbody>
                                    <tr>
                                        <!---
                                    <td>1</td>
                                    <td>Rajesh</td>
                                    <td>raj@gmail.com</td>
                                    <td>131131231</td>
                                    <td>Mumbai</td>
                                    <td><a class="btn ">Edit</a><a href="">Delete</a></td>
                                    -->

                                    </tr>
                                </tbody>
                            </table>
                            <div class="col-sm-12 d-flex justify-content-end">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">Add New Equipment</button>
                            </div>
                        </div>
                        <div class="col-md-2"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Data Table End-->

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <!-- Script Process Start-->
    <script src="../../../dependencies/jquery/jquery-3.6.4.min.js"></script>
    <script type="text/javascript" src="../../../dependencies/datatables/datatables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.1/datatables.min.js"></script>
    <script src="../../../dependencies/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        $('#datatable').DataTable({
            'serverSide': true,
            'processing': true,
            'paging': true,
            'order': [],
            'responsive': true,
            'ajax': {
                'url': 'fetch_data.php',
                'type': 'post',

            },
            'fnCreatedRow': function(nRow, aData, iDataIndex) {
                $(nRow).attr('id', aData[0]);
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
        //add button control
        $(document).on('submit', '#saveUserForm', function(event) {
            event.preventDefault();
            var equipmentname = $('#inputEqname').val();
            var qty = $('#inputQty').val();
            var facility = $('#inputFacility').val();
            if (equipmentname != '' && qty != '' && facility != '') {
                $.ajax({
                    url: "add_equipments.php",
                    data: {
                        equipmentname: equipmentname,
                        qty: qty,
                        facility: facility
                    },
                    type: 'POST',
                    success: function(data) {
                        var json = JSON.parse(data);
                        status = json.status;
                        if (status = 'success') {
                            table = $('#datatable').DataTable();
                            table.draw();
                            $('#addeqmodal').modal('show');
                            $('#inputEqname').val('');
                            $('#inputQty').val('');
                            $('#inputFacility').val('');
                            $('#addUserModal').modal('hide');
                        }
                    }
                });
            } else {
                $('#alert1').css('display', 'block');
                $('#strongId').html('Please fill all the Required fields');
            }
        });
        //delete user button control
        $(document).on("click", ".btnDelete", function (event) {
            event.preventDefault();
            var id = $(this).data("id");
            $('#deletemodal').modal('show');
            
            $('#deletemodal').on('click', '.btn-danger', function() {
                $.ajax({
                url: "delete_equipments.php",
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
            var trid = $(this).closest('tr').attr('id');
            $.ajax({
                url: "get_single_eq.php",
                data: {
                    id: id
                },
                type: 'POST',
                success: function(data) {
                    var json = JSON.parse(data);
                    $('#id').val(json.id);
                    $('#trid').val(trid);
                    $('#_inputEqname').val(json.equipmentname)
                    $('#_inputQty').val(json.quantity);
                    //$('#_inputFacility').val(json.facility);
                    var x = document.getElementById("_inputFacility");
                    var option = document.createElement("option");
                    option.text = json.facility;
                    option.hidden = true;
                    option.disabled = true;
                    option.selected = true;
                    x.add(option); 
                    $('#editUserModal').modal('show');
                }
            });
        });

        $(document).on('submit', '#updateUserForm', function() {
            var id = $('#id').val();
            var trid = $('#trid').val();
            var equipmentname = $('#_inputEqname').val();
            var qty = $('#_inputQty').val();
            var e = document.getElementById("_inputFacility");
            var facility = e.options[e.selectedIndex].text;
            $.ajax({
                url: "update_equipments.php",
                data: {
                    id: id,
                    equipmentname: equipmentname,
                    qty: qty,
                    facility: facility
                },
                type: 'POST',
                success: function(data) {
                    var json = JSON.parse(data);
                    status = json.status;
                    if (status == 'success') {
                        $('#updateeqmodal').modal('show');
                        table = $('#datatable').DataTable();
                        table.draw();
                        $('#editUserModal').modal('hide');
                    } else {
                        alert('failed');
                    }
                }
            });
        });
    </script>
    <!-- Script Process End-->
    <!-- add user modal-->
    <!-- Modal Popup -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Equipment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
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
                <div class="modal-body">
                    <form id="saveUserForm" action="javascript:void();" method="POST">
                        <div class="modal-body">
                            <!-- Form Controls-->
                            <div class="mb-3 row">
                                <label for="inputEqname" class="col-sm-2 col-form-label">Equipment Name</label>
                                <div class="col-sm-10">
                                    <input type="text" name="inputEqname" class="form-control" id="inputEqname">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputQty" class="col-sm-2 col-form-label">Quantity</label>
                                <div class="col-sm-10">
                                    <input type="text" name="inputQty" class="form-control" id="inputQty">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputFacility" class="col-sm-2 col-form-label">Facility</label>
                                <div class="col-sm-10">
                                    <!--<input type="text" class="form-control" id="inputFacility" name="inputFacility">-->

                                    <select name="inputFacility" id="inputFacility" class="form-control">
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
                            </div>


                            <!-- Form Controls End-->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- add user modal end-->
    <!-- edit user modal-->
    <!-- Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Equipment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="updateUserForm" action="javascript:void();" method="POST">
                        <div class="modal-body">
                            <input type="hidden" id="id" name="id" value="">
                            <input type="hidden" id="trid" name="trid" value="">
                            <!-- Form Controls-->
                            <div class="mb-3 row">
                                <label for="inputEqname" class="col-sm-2 col-form-label">Equipment Name</label>
                                <div class="col-sm-10">
                                    <input type="text" name="_inputEqname" class="form-control" id="_inputEqname">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputQty" class="col-sm-2 col-form-label">Quantity</label>
                                <div class="col-sm-10">
                                    <input type="text" name="_inputQty" class="form-control" id="_inputQty">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputFacility" class="col-sm-2 col-form-label">Facility</label>
                                <div class="col-sm-10">
                                    <!--<input type="text" class="form-control" id="inputFacility" name="inputFacility">-->
                                    <select name="_inputFacility" id="_inputFacility" class="form-control">
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
                            </div>

                            <!-- Form Controls End-->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
    <div class="modal fade" id="addeqmodal">
        <div class="modal-dialog ">
            <div class="modal-content ">
                <div class="modal-header" >
                    <h5 class="modal-title" id="exampleModalLabel">Success</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Successfully added equipment!</p>
                </div>
            </div>
        </div>
    </div>  
    <div class="modal fade" id="updateeqmodal">
        <div class="modal-dialog ">
            <div class="modal-content ">
                <div class="modal-header" >
                    <h5 class="modal-title" id="exampleModalLabel">Success</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Successfully updated equipment!</p>
                </div>
            </div>
        </div>
    </div>  
    <!-- edit user modalPopup end-->

</body>

</html>