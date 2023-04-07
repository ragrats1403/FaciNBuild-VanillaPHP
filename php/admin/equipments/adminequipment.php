<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Equipment</title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.1/datatables.min.css" />
    <link rel="stylesheet" type="text/css" href="../../../css/sidebar.css?<?=time()?>">
    <link rel="stylesheet" type="text/css" href="../../../css/header.css?<?=time()?>">
    <link rel="stylesheet" type="text/css" href="../../../css/body.css?<?=time()?>">
    <link rel="stylesheet" type="text/css" href="../../../css/admin/adminaccount.css?<?=time()?>" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'> 

</head>
<header class="shadow">
    <div class= "imgctrl">
        
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
                xhr.open("GET", "../../connection/notification.php");
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
                xhr.open("POST", "../../connection/update_notification.php");
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
      <nav class="gnav">
        </nav>
    </div>
</header>

<body>
    <div class="sidebar">
        <div class="logo_content">
            <div class="logo">
                <img src="../../../images/Black_logo.png" />
            </div>
        </div>
        <div class ="navdiv">
        <ul class="nav_list">
                <li>
                    <a href="../../../php/admin/reservations/admincalendar.php">
                        <i class='bx bx-calendar'></i>
                        <span class="link_name">Calendar of Activities</span>
                    </a>
                </li>
                <li>
                    <a href="../../../php/admin/accounts/admin_account.php">
                        <i class='bx bx-user'></i>
                        <span class="link_name">Account</span>
                    </a>
                </li>
                <li>
                    <div class="dropdown">
                        <i class='bx bx-clipboard' style="margin-left:17px;"></i>
                        <span class="jobrequestdr btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Create/Manage Request
                        </span>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="../../../php/admin/jobrequest/minor/minorjobreqlist.php">Minor Job Request</a>
                            <a class="dropdown-item" href="../../../php/admin/jobrequest/major/majorjobreqlist.php">Major Job Request</a>
                            <a class="dropdown-item" href="../../../php/admin/reservations/adminreservations.php">Reservations</a>  
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="../../../php/admin/equipments/adminequipment.php">
                        <i class='bx bx-wrench'></i>
                        <span class="link_name">Facilities Equipment</span>
                    </a>
                </li>
            </ul>
        <div class="profile_content">
                <div class="profile">
                    <div class="profile_details">
                    <img src="../../../images/ico/profileicon.png" alt="" style = "height: 45px; width:45px; object-fit:cover; border-radius:12px;" />
                        <div class="name_role">
                        <div class="name"><?php echo mb_strimwidth($_SESSION['department'], 0, 20, '…');?></div>
                        <div class="role">System Administrator</div>
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
    <!--<script></script>
        let btn = document.querySelector("#btn");
        let sidebar = document.querySelector(".sidebar");

        btn.onclick = function() {
            sidebar.classList.toggle("active");
        }
    </script>-->


     <!-- Data Table Start-->
    <!--<h1 class="text-center">Faci N Build Test table control</h1>-->
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
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                                    
                                    <select class="form-control input-sm col-xs-1" name="sections" id="faci">
                                    <option id = "selected" disabled selected value hidden> -- Select Facility -- </option>
                                    select = document.getElementById("faci");
                                    <?php include('../../connection/connection.php');
                                    $sql = "SELECT facilityname FROM facility";
                                    $query = mysqli_query($con,$sql);
                                        $i=1;
                                        while($row = mysqli_fetch_assoc($query)){
                                        echo "<option value=$i>".$row["facilityname"]."</option>";
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
                                    <select class="form-control input-sm col-xs-1" name="sections" id="_facility" >
                                        <option disabled selected value hidden> -- Select Facility -- </option>
                                            select = document.getElementById("faci");
                                            <?php include('../../connection/connection.php');
                                            $sql = "SELECT facilityname FROM facility";
                                            $query = mysqli_query($con,$sql);
                                            $i=1;
                                            while($row = mysqli_fetch_assoc($query)){
                                                echo "<option value=$i>".$row["facilityname"]."</option>";
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
    <!-- edit user modalPopup end-->
    <!-- Data Table End-->

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <!-- Script Process Start-->
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.1/datatables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
        $('#datatable').DataTable({
            'serverSide': true,
            'processing': true,
            'paging': true,
            'order': [],
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
        scrollY: 200,
        scrollCollapse: true,
        paging: false 

        });
    </script>
    <script type="text/javascript">
        //add button control
        $(document).on('submit', '#saveUserForm', function(event) {
            event.preventDefault();
            var equipmentname = $('#inputEqname').val();
            var qty = $('#inputQty').val();
            var e = document.getElementById("faci");
            var facility = e.options[e.selectedIndex].text;
            
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
                            alert('Successfully Added Equipment!');
                            $('#inputEqname').val('');
                            $('#inputQty').val('');
                            $('#inputFacility').val('');
                            $('#addUserModal').modal('hide');
                            $('body').removeClass('modal-open');
                            $('.modal-backdrop').remove();
                        }
                    }
                });
            } else {
                alert("Please fill all the Required fields");
            }
        });
        //delete user button control
        $(document).on('click', '.btnDelete', function(event) {
            var table = $('#datatable').DataTable();
            event.preventDefault();
            var id = $(this).data('id');
            if (confirm('Are you sure to delete this Equipment?')) {


                $.ajax({
                    url: "delete_equipments.php",
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
                    var x = document.getElementById("_facility");
                    var option = document.createElement("option");
                    option.text = json.facility;
                    option.hidden = true;
                    option.disabled = true;
                    option.selected = true;
                    x.add(option);                    
                    //$('#_inputFacility').val(json.facility);
                    $('#editUserModal').modal('show');
                }
            });
        });
        //update
        $(document).on('submit', '#updateUserForm', function() {
            var id = $('#id').val();
            var trid = $('#trid').val();
            var equipmentname = $('#_inputEqname').val();
            var qty = $('#_inputQty').val();
            var e = document.getElementById("_facility");
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
                        alert('Updated Successfully!');
                        table = $('#datatable').DataTable();
                        var button = '<a href="javascript:void();" class="btn btn-sm btn-info" data-id="' + id + '" >Edit</a>';
                        var row = table.row("[id='" + trid + "']");
                        row.row("[id='" + trid + "']").data([id, equipmentname, qty, facility, button]);
                        $('#editUserModal').modal('hide');
                    } else {
                        alert('failed');
                    }
                }
            });
        });
    </script>
    <!-- Script Process End-->
    
</body>

</html>