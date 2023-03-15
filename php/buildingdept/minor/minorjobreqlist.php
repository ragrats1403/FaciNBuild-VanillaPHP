<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Job Request List</title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.1/datatables.min.css" />
    <link rel="stylesheet" type="text/css" href="../../../../css/sidebar.css?<?=time()?>">
    <link rel="stylesheet" type="text/css" href="../../../../css/header.css?<?=time()?>">
    <link rel="stylesheet" type="text/css" href="../../../../css/body.css?<?=time()?>">
    <link rel="stylesheet" type="text/css" href="../../../../css/admin/adminaccount.css?<?=time()?>" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'> 
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
        <p>Hello, Building Department</p>
      <nav class="gnav">
        </nav>
    </div>
</header>

<body style="padding-top: 0px;">

<div class="sidebar">
        <div class="logo_content">
            <div class="logo">
                <img src="../../../../images/Brown_logo_faci.png" />
            </div>
        </div>
        <div class ="navdiv">
        <ul class="nav_list">
            <li>
                <a href="../../../../php/buildingdept/buildingdeptdashboard.php">
                    <i class='bx bx-user'></i>
                    <span class="link_name">Calendar of Activities</span>
                </a>
            </li>
            <li>
                <div class="dropdown">
                    <i class='bx bx-clipboard' style="margin-left:17px;" ></i>
                    <span class="jobrequestdr btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Job Request
                    </span>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="../../../../php/buildingdept/minor/minorjobreqlist.php">Minor Job Request</a>
                        <a class="dropdown-item" href="../../../../php/buildingdept/major/majorjobreqlist.php">Major Job Request</a>
                    </ul>
                </div>
            </li>
            <li>
                <a href="../../../../php/buildingdept/reservation/buildingdeptreservation.php">
                    <i class='bx bx-check-square'></i>
                    <span class="link_name">Reservation</span>
                </a>
            </li>
        </ul>
        <div class="profile_content">
                <div class="profile">
                    <div class="profile_details">
                    <img src="../../../../images/ico/profileicon.png" alt="" style = "height: 45px; width:45px; object-fit:cover; border-radius:12px;" />
                        <div class="name_role">
                            <div class="name">Building Dept</div>
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
                        <div class="col-md-2" style="width: 15%;"></div>
                        <div class="col-sm-12 shadow" style="width: 83%; background-color: #FFF; padding-left:50px; padding-top:50px; padding-right:50px;">
                            <!-- padding-left:50px; padding-top:50px; padding-right:50px;-->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2" style="width: 15%;"></div>
                        <div class="col-sm-12 shadow" style="width: 83%; background-color: #FFF; padding-left:50px; padding-right:50px; padding-bottom:50px; ">
                            <!-- padding-left:50px; padding-right:50px; padding-bottom:50px;-->
                            <table id="datatable" class="table" >
                                <thead>
                                    <th>ID</th>
                                    <th>Department</th>
                                    <th>Date</th>
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
            var department = $('#department').val();
            var date = $('#datemajorjr').val();
            var quantity = $('#_quantity_').val();
            var itemname = $('#_item_').val();
            var description = $('#_itemdesc_').val();
            var purpose = $('#_purpose_').val();
            var renderedby = $('#renderedby').val();
            var daterendered = $('#daterendered').val();
            var confirmedby = $('#confirmedby').val();
            var dateconfirmed = $('#dateconfirmed').val();
            if (department != '' && date != '' && quantity != '' && itemname != '' && description != '' && purpose != '' && renderedby != '' && daterendered != '' && confirmedby != '' && dateconfirmed != '') {
                $.ajax({
                    url: "add_data.php",
                    data: {
                        department: department,
                        date: date,
                        quantity: quantity,
                        itemname: itemname,
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
                            alert('Successfully Added User!');
                            $('#department').val('');
                            $('#datemajorjr').val('');
                            $('#_quantity_').val('');
                            $('#_item_').val('');
                            $('#_itemdesc_').val('');
                            $('#_purpose_').val('');
                            $('#renderedby').val('');
                            $('#daterendered').val('');
                            $('#confirmedby').val('');
                            $('#dateconfirmed').val('');
                            $('#addUserModal').modal('hide');
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
            if (confirm('Are you sure to delete this user?')) {


                $.ajax({
                    url: "delete_user.php",
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
            var trid = $(this).closest('tr').attr('minorjobid');
            $.ajax({
                url: "get_request_details.php",
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
                    $('#_datemajorjr').val(json.datesubmitted);
                    $('#_department').val(json.department);
                    $('#_quantity').val(json.quantity);
                    $('#_itemdesc').val(json.item_desc);
                    $('#_item').val(json.item);
                    $('#_purpose').val(json.purpose);
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

        $(document).on('submit', '#updateUserForm', function() {
            var id = $('#id').val();
            var trid = $('#trid').val();
            var name = $('#_inputName').val();
            var username = $('#_inputUsername').val();
            var password = $('#_inputPassword').val();
            var rolelevel = $('#_inputRoleLevel').val();
            var roleid = $('#_inputRoleID').val();
            $.ajax({
                url: "update_user.php",
                data: {
                    id: id,
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
                    if (status == 'success') {
                        alert('Updated Successfully!');
                        table = $('#datatable').DataTable();
                        var button = '<a href="javascript:void();" class="btn btn-sm btn-info" data-id="' + id + '" >Edit</a> <a href="javascript:void();" class="btn btn-sm btn-danger" data-id="' + id + '" >Delete</a>';
                        var row = table.row("[id='" + trid + "']");
                        row.row("[id='" + trid + "']").data([id, name, username, password, rolelevel, roleid, button]);
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
        <div class="modal-dialog" style="max-width:1100px;">
            <div class="modal-content">
                <div class="modal-header justify-content-center" style="max-width:1100px;">
                    <div class="col-md-2" style="width:17%;">
                        <h5 class="modal-title text-uppercase fw-bold" id="exampleModalLabel" >Job Request</h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ">
                    <form id="saveUserForm" action="javascript:void();" method="POST">
                        <div class="modal-body">
                            <!-- Form Controls-->
                            <div class="row justify-content-center" style="padding-bottom:13px;">
                                <div class="col-md-6 ">
                                    <label class="fw-bold" for="date">Department:</label>
                                    <input type="name" class="form-control input-sm col-xs-1" id="department" placeholder="Department">
                                </div>
                                <div class="col-md-6 ">
                                    <label class="fw-bold" for="date">Date:</label>
                                    <input type="datetime-local" class="form-control input-sm col-xs-1" id="datemajorjr" placeholder="Date" disabled>
                                    
                                </div>
                            </div>
                            <div class="justify-content-center">
                                <h5 class="text-uppercase fw-bold" >Requisition(To be filled up by the requesting party)</h5>
                                <br>
                                <div class="row">
                                <div class="col-md-12">
                                    <label class="fw-bold" style="padding-bottom:20px;" for="date">Section:</label>
                                    <select class="" style="width: 150px; Border: 5px;" name="sections" id="sections">
                                        <option value="C">CARPENTRY</option>
                                        <option value="P">PLUMBING</option>
                                        <option value="A">AIRCON</option>
                                        <option value="E">ELECTRICAL</option>

                                    </select>
                                </div>
                            </div>
                                <div class="col-md-2" style="padding-bottom:10px">
                                    <label class="fw-bold" for="date">Quantity:</label>
                                    <input type="name" class="form-control input-sm col-xs-1" id="_quantity_" placeholder="Quantity">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2" style="padding-bottom:10px; width:20%">
                                    <label class="fw-bold" for="date">Item Name:</label>
                                    <input type="form-control" class="form-control" id ="_item_"placeholder="Item">
                                </div>
                            </div>

                            <div class="justify-content-center">
                                <div class="col-md-12" >
                                    <label class="fw-bold" for="date">Description:</label>
                                    <textarea class="form-control" rows="2" id="_itemdesc_" placeholder="Description"></textarea>
                                </div>
                            </div>

                            <div class="justify-content-center">
                                <div class="col-md-12" >
                                    <label class="fw-bold" for="date">Purpose:</label>
                                    <textarea class="form-control" rows="2" id="_purpose_" placeholder="Purpose"></textarea>
                                </div>
                            </div>

                            <!-- Form Controls End-->
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
    <!-- add user modal end-->
    <!-- edit user modal-->
    <!-- Modal -->

    
    <div class="modal fade" id="editMinorjreqmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog " style="max-width:1100px;">
            <div class="modal-content ">
                <div class="modal-header justify-content-center" style="max-width:1100px;">
                    <div class="col-md-2" style="width:17%;">
                        <h5 class="modal-title text-uppercase fw-bold" id="exampleModalLabel" >Job Request</h5>
                    </div>
                    <div class="col-md-2" style="width:15%">
                        <label class=""  for="inputName">Status:</label>
                        <input type="text" style="width:20%" class="col-sm-2" name="_ID" class="form-control" id="_ID">
                    </div>
                    <div class="col-md-2" style="width:30%">
                        <label class=""  for="inputName">ID:</label>
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
                                <h5 class="text-uppercase fw-bold" >A. Requisition(To be filled up by the requesting party)</h5>
                                <div class="col-md-2" style="padding-bottom:10px">
                                    <label class="fw-bold" for="date">Quantity:</label>
                                    <input type="name" class="form-control input-sm col-xs-1" id="_quantity" placeholder="Quantity" disabled>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2" style="padding-bottom:10px; width:20%">
                                    <label class="fw-bold" for="date">Item Name:</label>
                                    <input type="form-control" class="form-control" id ="_item"placeholder="Item" disabled>
                                </div>
                            </div>

                            <div class="justify-content-center">
                                <div class="col-md-12" >
                                    <label class="fw-bold" for="date">Description:</label>
                                    <textarea class="form-control" rows="2" id="_itemdesc" placeholder="Description"></textarea>
                                </div>
                            </div>

                            <div class="justify-content-center">
                                <div class="col-md-12" >
                                    <label class="fw-bold" for="date">Purpose:</label>
                                    <textarea class="form-control" rows="2" id="_purpose" placeholder="Purpose"></textarea>
                                </div>
                            </div>
                            
                            <div class="row justify-content-center" style="padding-bottom:10px;">
                                <div class="col-md-6" >
                                    <label class="fw-bold" for="renderedby">Rendered by:</label>
                                    <input type="name" class="form-control input-sm col-xs-1" id="_renderedby" disabled>
                                </div>
                                <div class="col-md-6" >
                                    <label class="fw-bold" for="date">Date:</label>
                                    <input type="date" class="form-control input-sm col-xs-1" id="_daterendered" disabled>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-md-right">
                                <button type="submit" class="btn btn-primary col-md-1" id="edit-button">Edit</button>
                            <button type="submit" class="btn btn-success col-md-1" id="end-editing">Update</button>
                        </div>
                            <div class="row justify-content-center" style="padding-bottom:10px;">
                                <div class="col-md-6" >
                                    <label class="fw-bold" for="renderedby">Confirmed by:</label>
                                    <input type="name" class="form-control input-sm col-xs-1" id="_confirmedby" disabled>
                                </div>
                                <div class="col-md-6" >
                                    <label class="fw-bold" for="date">Date:</label>
                                    <input type="date" class="form-control input-sm col-xs-1" id="_dateconfirmed" disabled>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-md-right">
                            <button type="submit" class="btn btn-primary col-md-1" id="edit-button">Edit</button>
                            <button type="submit" class="btn btn-success col-md-1" id="end-editing">Update</button>
                        </div>
                            <!-- Form Controls End-->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>