<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Reservation</title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.1/datatables.min.css" />
    <link rel="stylesheet" type="text/css" href="../../../css/sidebar.css">
    <link rel="stylesheet" type="text/css" href="../../../css/header.css">
    <link rel="stylesheet" type="text/css" href="../../../css/admin/adminaccount.css" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="css/reservation.css">
    <link rel="stylesheet" type="text/css" href="../../../css/body.css">
    
</head>

<header class="shadow">
    <div class= "imgctrl">
        
    </div>
    <div class="navplace">
       <div>
        <button type="button" class="icon-button">    
        <span class='bx bxs-bell'></i>
        <span class="icon-button__badge"></span>
       </div>    
        <p>Hello, Welcome !</p>
      <nav class="gnav">
        </nav>
    </div>
</header>

<body>
    <div class="sidebar">
        <div class="logo_content">
            <div class="logo">
                <img src="../../../images/Brown_logo_faci.png" />
            </div>
        </div>
        <div class ="navdiv">
        <ul class="nav_list">
        <li>
                    <a href="#">
                        <i class='bx bx-clipboard'></i>
                        <span class="link_name">Calendar Of Activities</span>
                    </a>
                </li>
            <li>
                <a href="../../../php/systemadministrator/accounts/admin_account.php">
                    <i class='bx bx-user'></i>
                    <span class="link_name">Account</span>
                </a>
            </li>
            <li>
                <a href="../../../php/systemadministrator/equipments/adminequipment.php">
                    <i class='bx bx-wrench'></i>
                    <span class="link_name">Equipment</span>
                </a>
            </li>
            <li>
                <a href="../../../php/systemadministrator/reservations/adminreservations.php">
                    <i class='bx bx-check-square'></i>
                    <span class="link_name">Reservation</span>
                </a>
            </li>
        </ul>
        <div class="profile_content">
                <div class="profile">
                    <div class="profile_details">
                    <img src="../../../images/ico/profileicon.png" alt="" style = "height: 45px; width:45px; object-fit:cover; border-radius:12px;" />
                        <div class="name_role">
                            <div class="name">Name Here</div>
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
    <!--<script>
        let btn = document.querySelector("#btn");
        let sidebar = document.querySelector(".sidebar");

        btn.onclick = function() {
            sidebar.classList.toggle("active");
        }
    </script>-->

  

</div>
</div>



        <!-- Data Table Start-->
    <!--<h1 class="text-center">Faci N Build Test table control</h1>-->
    <div class="table1">

<div class="container-fluid">
    <div class="row">
        
        <div class="container">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8" style="background-color: #ccc; padding-left:50px; padding-top:50px; padding-right:50px;">
                    <!-- padding-left:50px; padding-top:50px; padding-right:50px;-->
                    <button type="button" class="btn btn-primary" style="margin-bottom:40px;" data-bs-toggle="modal" data-bs-target="#addUserModal">Request Reservation</button>
                    <br>
                    <h3>List of Reservations</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8" style="background-color: #ccc; padding-left:50px; padding-right:50px; padding-bottom:50px; ">
                    <!-- padding-left:50px; padding-right:50px; padding-bottom:50px;-->
                    <table id="datatable" class="table">
                        <thead>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th>Role Level</th>
                            <th>Role ID</th>
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
                </div>
                <div class="col-md-2"></div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- Data Table End-->

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
                'target': [0, 5],
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
            var name = $('#inputName').val();
            var username = $('#inputUsername').val();
            var password = $('#inputPassword').val();
            var rolelevel = $('#inputRolelevel').val();
            var roleid = $('#inputRoleID').val();
            if (username != '' && password != '' && rolelevel != '' && roleid != '') {
                $.ajax({
                    url: "add_user.php",
                    data: {
                        name: name,
                        username: username,
                        password: password,
                        rolelevel: rolelevel,
                        roleid: roleid
                    },
                    type: 'POST',
                    success: function(data) {
                        var json = JSON.parse(data);
                        status = json.status;
                        if (status = 'success') {
                            table = $('#datatable').DataTable();
                            table.draw();
                            alert('Successfully Added User!');
                            $('#inputPassword').val('');
                            $('#inputEventName').val('');
                            $('#inputUsername').val('');
                            $('#inputPassword').val('');
                            $('#inputRolelevel').val('');
                            $('#inputRoleID').val('');
                            $('#addUserModal').modal('hide');
                        }
                    }
                });
            } else {
                alert("Please fill all the Required fields");
            }
        });
    </script>

            


 <!-- Modal Popup -->
 <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Reservation Form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="saveUserForm" action="javascript:void();" method="POST">
                        <div class="modal-body">
                            <!-- Form Controls-->
                            <div class="mb-3 row">
                                <label for="inputFacility" class="col-sm-2 col-form-label">Select Facility</label>
                                <div class="col-sm-10">
                                    <!--<input type="text" class="form-control" id="inputFacility" name="inputFacility">-->
                                    
                                    <select name="inputFacility" id="inputFacility" class="form-control">
                                        <option value="AVR">AVR</option>
                                        <option value="OLD AVR">OLD AVR</option>
                                        <option value="FUNCTION HALL">FUNCTION HALL</option>
                                        <option value="AUDITORIUM">AUDITORIUM</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputEventName" class="col-sm-2 col-form-label">Event Name</label>
                                <div class="col-sm-10">
                                    <input type="text" name="inputEventName" class="form-control" id="inputEventName">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputPassword" class="col-sm-2 col-form-label">Event Date & Time</label>
                                <div class="col-sm-10">
                                    <!--<input type="text" class="form-control" id="inputPassword" name="inputPassword">--> 
                                    <input type="datetime-local" id="eventdate" name="eventdate">
                                </div>  
                            </div>
                            <div class="mb-3 row">
                                <label for="inputRolelevel" class="col-sm-2 col-form-label">Date Filled Up</label>
                                <div class="col-sm-10">
                                    
                                    <input type="datetime-local" id="datetoday" name="datetoday" disabled>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputRoleID" class="col-sm-2 col-form-label">Requesting Department</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputRoleID" name="inputRoleID" disabled>
                                </div>
                            </div>

                            <!-- Form Controls End-->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Request Reservations  </button>
                        </div>
                        <script>
                            //datetime auto fill up
                            var now = new Date();
                            now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
                            document.getElementById('datetoday').value = now.toISOString().slice(0,16);
                            //Requesting department auto fill up
                            
                            var deptname;
                            document.getElementById('inputRoleID').value = deptname;
                         </script>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- add user modal end-->




</body>

</html>
