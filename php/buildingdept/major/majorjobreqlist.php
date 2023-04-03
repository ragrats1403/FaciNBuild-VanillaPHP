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
    <link rel="stylesheet" type="text/css" href="../../../../css/modal.css/modal.css?<?= time() ?>" />
    <link rel="stylesheet" type="text/css" href="../../../../css/admin/adminaccount.css?<?=time()?>" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'> 
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.3/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/js/bootstrap.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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
        <p>Hello, Building</p>
      <nav class="gnav">
        </nav>
    </div>
</header>

<body style="padding-top: 0px;">

<div class="sidebar">
        <div class="logo_content">
            <div class="logo">
                <img src="../../../../images/Black_logo.png" />
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
                <div class="dropdown">
                    <i class='bx bx-clipboard' style="margin-left:17px;" ></i>
                    <span class="jobrequestdr btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Manage Request
                    </span>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="../../../php/buildingdept/minor/minorjobreqlist.php">Minor Job Request</a>
                        <a class="dropdown-item" href="../../../php/buildingdept/major/majorjobreqlist.php">Major Job Request</a>
                    </ul>
                </div>
                </li>
                <li>
                <div class="dropdown">
                    <i class='bx bx-clipboard' style="margin-left:17px;" ></i>
                    <span class="jobrequestdr btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        View/Create Request
                    </span>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="../../../php/buildingdept/minor/minorjobreqlist.php">Minor Job Request</a>
                        <a class="dropdown-item" href="../../../php/buildingdept/major/majorjobreqlist.php">Major Job Request</a>
                        <a class="dropdown-item" href="../../../php/buildingdept/reservation/buildingdeptreservation.php">Reservation</a>
                    </ul>
                </div>
                </li>
        <div class="profile_content">
                <div class="profile">
                    <div class="profile_details">
                    <img src="../../../../images/ico/profileicon.png" alt="" style = "height: 45px; width:45px; object-fit:cover; border-radius:12px;" />
                        <div class="name_role">
                            <div class="name">Building Dept.</div>
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
                        <div class="col-sm-12 shadow" style="width: 100%; background-color: #FFF; padding-top: 100px; padding-left:50px; padding-right:50px; padding-bottom:50px; ">
                            <!-- padding-left:50px; padding-right:50px; padding-bottom:50px;-->
                            <table id="datatable" class="table" >
                                <thead>
                                    <th>Job Request no.</th>
                                    <th>Requisition no.</th>
                                    <th>Department</th>
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
        $(document).on('submit', '#addUserModal', function(event) {
            event.preventDefault();
            var requino = $('#requi').val();
            var department = $('#depart').val();
            var date = $('#deeto').val();
            var quantity = $('#quan').val();
            var item = $('#ite').val();

            var e = document.getElementById("section");//dropdown
            var section = e.options[e.selectedIndex].text;//end

            var description = $('#desc').val();
            var purpose = $('#purp').val();

            var e = document.getElementById("mark");//dropdown
            var outsource = e.options[e.selectedIndex].text;//end

            if (department != '' && date != '' && quantity != '' && item != '' && section != '' && description != '' && purpose != '' && outsource != '') {
            $.ajax({
                url: "add_data.php",
                data: {
                    requino: requino,
                    department: department,
                    date: date,
                    quantity: quantity,
                    item: item,
                    section: section,
                    description: description,
                    purpose: purpose,
                    outsource: outsource
                },
                type: 'POST',
                success: function(data) {
                    var json = JSON.parse(data);
                    status = json.status;
                    if (status = 'success') {
                        table = $('#datatable').DataTable();
                        table.draw();
                        alert('Successfully Added User!');
                        $('#requi').val('');
                        $('#depart').val('');
                        $('#deeto').val('');
                        $('#quan').val('');
                        $('#ite').val('');
                        $('#section').val('');
                        $('#desc').val('');
                        $('#purp').val('');
                        $('#mark').val('');
                        $('#addUserModal').modal('hide');
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                    }
                }
            });
        }
            else {
                alert("Please fill all the Required fields");
            }
        });
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
        //edit button control */
        $(document).on('click', '.editBtn', function(event) {
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
                    $('#jobrequestno').val(json.jobreqno);
                    $('#requino').val(json.requino);
                    $('#department').val(json.department);
                    $('#date').val(json.date);
                    var e = document.getElementById("sections");
                    var section = e.options[e.selectedIndex].text;
                    e.options[e.selectedIndex].text = json.section;
                    /*$('#sections').val(json.section);*/
                    $('#quantity').val(json.quantity);
                    $('#item').val(json.item);
                    $('#description').val(json.description);
                    $('#purpose').val(json.purpose);
                    var e = document.getElementById("remark");
                    var outsource = e.options[e.selectedIndex].text;
                    e.options[e.selectedIndex].text = json.outsource;

                    $('#_statustext').val(json.status);
                    $('#_step1').val(json.bdstatus);
                    $('#_step2').val(json.pcostatus);
                    $('#_step3').val(json.cadstatus);
                    /*$('#remark').val(json.outsource);*/
                    $('#editUserModal').modal('show');
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
            var e = document.getElementById("sections");
            var section = e.options[e.selectedIndex].text;
            var quantity = $('#quantity').val();
            var item = $('#item').val();
            var description = $('#description').val();
            var purpose = $('#purpose').val();
            var e = document.getElementById("remark");
            var outsource = e.options[e.selectedIndex].text;

            $.ajax({
                url: "update_user.php",
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
                    outsource: outsource
                },
                type: 'POST',
                success: function(data) {
                    var json = JSON.parse(data);
                    status = json.status;
                    if (status == 'success') {
                        alert('Updated Successfully!');
                        var e = document.getElementById("sections");
                        e.options[e.selectedIndex].text = json.section;
                        var e = document.getElementById("remark");
                        e.options[e.selectedIndex].text = json.outsource;
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


        //APPROVE=================================================
        

        $(document).on('click', '.step1approveBtn', function(event){

            //var status = "Approved";
            var id = $('#jobrequestno').val();
            var trid = $('#trid').val();
            $.ajax({
                url: "step1approve.php",
                data: {
                    id: id,
                    
                },
                type: 'POST',
                success: function(data) {
                    var json = JSON.parse(data);
                    var status = json.status;
                    if (status == 'success') {
                        table = $('#datatable').DataTable();
                        table.draw();
                        alert('Step 1 Approved Successfully!');
                        $('#editUserModal').modal('hide');
                        /*table = $('#datatable').DataTable();
                        var button = '<a href="javascript:void();" data-id="' + id + '"  class="btn btn-sm btn-success btnDelete" >Approve</a> <a href= "javascript:void();" data-id="' + id + '" class ="btn btn-sm btn-info editBtn">More Info</a>';
                        var row = table.row("[id='" + trid + "']");
                        row.row("[id='" + trid + "']").data([department, date, button]);*/
                        $('#_step1').val('Approved');
                    } else { 
                        alert('failed');
                    }
                }
            });
            //alert('test');
        });


    $(document).on('click', '.step1declineBtn', function(event){
        var id = $('#jobrequestno').val();
        var trid = $('#trid').val();
        $.ajax({
            url: "step1decline.php",
            data: {
                id: id,
                
            },
            type: 'POST',
            success: function(data) {
                var json = JSON.parse(data);
                var status = json.status;
                if (status == 'success') {
                    table = $('#datatable').DataTable();
                    table.draw();
                    alert('Step 1 Declined Successfully!');

                
                    /*table = $('#datatable').DataTable();
                    var button = '<a href="javascript:void();" data-id="' + id + '"  class="btn btn-sm btn-success btnDelete" >Approve</a> <a href= "javascript:void();" data-id="' + id + '" class ="btn btn-sm btn-info editBtn">More Info</a>';
                    var row = table.row("[id='" + trid + "']");
                    row.row("[id='" + trid + "']").data([department, date, button]);*/
                    //$('#_itemdesc_').text('');
                    $('#_step1').val('Declined');
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

                            <div class="row justify-content-center" style="padding-bottom:10px;">
                                <div class="col-md-6 ">
                                    <label class="fw-bold" for="date">Job Request no.</label>
                                    <input type="name" class="form-control input-sm col-xs-1" id="no" placeholder="Job request no." disabled>
                                </div>
                                <div class="col-md-6 ">
                                    <label class="fw-bold" for="date">Requisition no.</label>
                                    <input type="name" class="form-control input-sm col-xs-1" id="requi" placeholder="Requisition no.">
                                </div>
                            </div>
                            <div class="row justify-content-center" style="padding-bottom:13px;">
                                <div class="col-md-6 ">
                                    <label class="fw-bold" for="date">Department</label>
                                    <input type="name" class="form-control input-sm col-xs-1" id="depart" placeholder="Department">
                                </div>
                                <div class="col-md-6 ">
                                    <label class="fw-bold" for="date">Date</label>
                                    <input type="date" class="form-control input-sm col-xs-1" id="deeto" placeholder="Date">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <h5 class="text-uppercase fw-bold" >A. Requisition(To be filled up by the requesting party)</h5>
                                    <label class="fw-bold" for="date">Section:</label>
                                    <select class="" style="width: 150px; Border: 5px;" name="section" id="section">
                                        <option value="0">Select</option>
                                        <option value="C">CARPENTRY</option>
                                        <option value="P">PLUMBING</option>
                                        <option value="A">AIRCON</option>
                                        <option value="E">ELECTRICAL</option>

                                    </select>
                                </div>
                            </div>
                            <div>
                                <div class="col-md-2" style="padding-bottom:10px; width:20%">
                                    <label class="fw-bold" for="date">Quantity:</label>
                                    <input type="form-control" class="form-control input-sm col-xs-1" id="quan" placeholder="Quantity">
                                </div>
                            </div>
                            
                            <div>
                                <div class="col-md-2" style="padding-bottom:10px; width:20%">
                                    <label class="fw-bold" for="date">Item Name:</label>
                                    <input type="form-control" class="form-control input-sm col-xs-1" id ="ite"placeholder="Item">
                                </div>
                            </div>
                            <div class="justify-content-center" style="padding-bottom:10px;">
                                <div class="col-md-12">
                                    <label class="fw-bold" for="date">Description:</label>
                                    <textarea placeholder="Description" class="form-control" rows="2" id="desc"></textarea>
                                </div>
                            </div>
                            <div class="justify-content-center" style="padding-bottom:10px;">
                                <div class="col-md-12">
                                    <label class="fw-bold" for="date">Purpose:</label>
                                    <textarea placeholder="Purpose" class="form-control" rows="2" id="purp"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="fw-bold" style="padding-bottom:5px;" for="date">Remarks:</label>
                                    <select class="" style="width: 150px; Border: none;" name="cars" id="mark">
                                        <option value="0">Select</option>
                                        <option value="volvo">Outsource</option>
                                        <option value="saab">Bill of materials</option>
                                    </select>
                                </div>
                            </div>
                        <div class="modal-footer justify-content-md-center">
                            <button type="button" class="btn btn-secondary col-md-2" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary col-md-2">Save Changes</button>
                        </div>
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
        <div class="modal-dialog "style="max-width:1100px;">
            <div class="modal-content">
                <div class="modal-header justify-content-center" style="max-width:1100px;">
                    <div class="col-md-2" style="width:17%;">
                        <h5 class="modal-title text-uppercase fw-bold" id="exampleModalLabel" >Job Request</h5>
                    </div>
                    <div class="col-md-12" style="width:15%">
                        <label class=""  for="inputName">Status:</label>
                        <input type="text" style="width:60%" class="col-sm-1" name="id" class="form-control" id= "_statustext" disabled>
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
                            <div class="row justify-content-center" style="padding-bottom:13px;">
                                <div class="col-md-6 ">
                                    <label class="fw-bold" for="date">Department</label>
                                    <input type="name" class="form-control input-sm col-xs-1" id="department" placeholder="Department" disabled>
                                </div>
                                <div class="col-md-6 ">
                                    <label class="fw-bold" for="date">Date</label>
                                    <input type="name" class="form-control input-sm col-xs-1" id="date" placeholder="Date" disabled>
                                </div>
                            </div>   
                            <div class="row">
                                <div class="col-md-12" >
                                    <h5 class="text-uppercase fw-bold" >A. Requisition(To be filled up by the requesting party)</h5>
                                    <label class="fw-bold" for="date">Quantity:</label>
                                    <input type="form-control" class="form-control input-sm col-xs-1" id="quantity" placeholder="Quantity" disabled>
                                </div>
                            </div>
                            
                            <div>
                                <div class="col-md-2" style="padding-bottom:10px; width:20%">
                                    <label class="fw-bold" for="date">Item Name:</label>
                                    <input type="form-control" class="form-control input-sm col-xs-1" id ="item"placeholder="Item" disabled>
                                </div>
                            </div>
                            <div class="justify-content-center" style="padding-bottom:10px;">
                                <div class="col-md-12">
                                    <label class="fw-bold" for="date">Description:</label>
                                    <textarea placeholder="Description" class="form-control" rows="2" id="description"></textarea>
                                </div>
                            </div>
                            <div class="justify-content-center" style="padding-bottom:10px;">
                                <div class="col-md-12">
                                    <label class="fw-bold" for="date">Purpose:</label>
                                    <textarea placeholder="Purpose" class="form-control" rows="2" id="purpose"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="fw-bold" for="date">Section:</label>
                                    <select class="" style="width: 150px; Border: 5px;" name="sections" id="sections">
                                        <option value="se">Select</option>
                                        <option value="CARPENTRY">CARPENTRY</option>
                                        <option value="PLUMBING">PLUMBING</option>
                                        <option value="AIRCON">AIRCON</option>
                                        <option value="ELECTRICAL">ELECTRICAL</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row" style="padding-top:6px;">     
                                <div class="col-md-1" style="margin-top:5px;">
                                    <label class="fw-bold" for="inputName">Step 1 Status:</label>
                                </div> 
                                <div class="col-md-2" style="margin-top:5px;">
                                    <input class="form-control" type="text" style="width:100%; height:80%;" name="" id= "_step1" disabled>
                                </div> 
                            </div>
                            <div class="row" style="padding-top:6px;">     
                                <div class="col-md-1" style="margin-top:5px;">  
                                    <label class="fw-bold" for="inputName">Step 2 Status:</label>
                                </div> 
                                <div class="col-md-2" style="margin-top:5px;">
                                    <input class="form-control" type="text" style="width:100%; height:80%;" name="" id= "_step2" disabled>
                                </div> 
                            </div>
                            <div class="row" style="padding-top:6px;">     
                                <div class="col-md-1" style="margin-top:5px;">
                                    <label class="fw-bold" for="inputName">Step 3 Status:</label>
                                </div> 
                                <div class="col-md-2" style="margin-top:5px;">
                                    <input class="form-control" type="text" style="width:100%; height:80%;" name="" id= "_step3" disabled>
                                </div> 
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="fw-bold" style="padding-bottom:5px;" for="date">Remarks:</label>
                                    <select class="" style="width: 150px; Border: none;" id="remark">
                                        <option value="1">Select</option>
                                        <option value="Outsource">Outsource</option>
                                        <option value="Bill of materials">Bill of materials</option>
                                    </select>
                                </div>
                            </div>
                        <div>
                            <div class="modal-footer justify-content-md-center">
                                <a href= "javascript:void();" class ="btn btn-success step1approveBtn">Approve</a>
                                <a href= "javascript:void();" class ="btn btn-danger step1declineBtn">Decline</a>
                                <a href= "javascript:void();" class ="btn btn-info text-white updateBtn">Update</a>
                                <!--<button type="" class="btn btn-primary approveBtn">Approve</button>
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
</body>

</html>