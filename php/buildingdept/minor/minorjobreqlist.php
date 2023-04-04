<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Minor Job Request List</title>
     <!--dependencies-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.1/datatables.min.css" />
    <link rel="stylesheet" type="text/css" href="../../../../css/sidebar.css?<?=time()?>">
    <link rel="stylesheet" type="text/css" href="../../../../css/header.css?<?=time()?>">
    <link rel="stylesheet" type="text/css" href="../../../../css/body.css?<?=time()?>">
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
                <img src="../../../images/Brown_logo_faci.png" />
            </div>
        </div>
        <div class ="navdiv">
        <ul class="nav_list">
            <li>
                <a href="../../../php/buildingdept/buildingcalendar.php">
                    <i class='bx bx-calendar'></i>
                    <span class="link_name">Calendar of Activities</span>
                </a>
            </li>
            <li>
                <div class="dropdown">
                    <i class='bx bx-notepad' style="margin-left:17px;" ></i>
                    <span class="jobrequestdr btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Manage Request
                    </span>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="../../../php/buildingdept/minor/minorjobreqlist.php">Minor Job Request</a>
                        <a class="dropdown-item" href="../../../php/buildingdept/major/majorjobreqlist.php">Major Job Request</a>
                    </ul>
                </div>
            </li>
            <<li>
                <a href="../../../php/buildingdept/reservation/buildingdeptreservation.php">
                    <i class='bx bx-clipboard'></i>
                    <span class="link_name">Reservation</span>
                </a>
            </li>
        </ul>
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

    
    
   <div class="table1">
        <div class="container-fluid">
            <div class="row">
                <div class="container">
                    <div class="row">
                        <div class="col-md-2" style="width: 15%;"></div>
                        <div class="col-sm-12 shadow" style="width: 100%; background-color: #FFF; padding-top: 100px; padding-left:50px; padding-right:50px; padding-bottom:50px; ">
                            <!-- padding-left:50px; padding-right:50px; padding-bottom:50px;-->
                            <table id="datatable" class="table" >
                                <thead>
                                    <th>ID</th>
                                    <th>Department</th>
                                    <th>Section</th>
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
    <!-- Script Process Start-- DO NOT MOVE THIS Script tags!!-->
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.1/datatables.min.js"></script>
    <script type="text/javascript" src="functions/js/process.js?random=<?php echo uniqid(); ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    
                        
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
                            <div class="row">
                                <h5 class="text-uppercase fw-bold" >A. Requisition(To be filled up by the requesting party)</h5>
                                <div class="row">
                                    <div class="col-md-3" style="margin-top:5px; width:24%;">
                                        <label class="fw-bold" for="date">Section:</label>
                                        <select class="" style="width: 150px; Border: 5px;" name="sect" id="sect">
                                            <option value="C">CARPENTRY</option>
                                            <option value="P">PLUMBING</option>
                                            <option value="A">AIRCON</option>
                                            <option value="E">ELECTRICAL</option>
                                        </select>
                                    </div>
                                </div>
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
                    <div class="col-md-12" style="width:15%">
                        <label class=""  for="inputName">Status:</label>
                        <input type="text" style="width:60%" class="col-sm-1" name="_ID" class="form-control" id= "_statustext">
                    </div>
                    <div class="col-md-1" style="width:10%">
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
                                    <textarea class="form-control" rows="2" id="_itemdesc" placeholder="Description" disabled></textarea>
                                </div>
                            </div>
                            <div class="justify-content-center">
                                <div class="col-md-12" >
                                    <label class="fw-bold" for="date">Purpose:</label>
                                    <textarea class="form-control" rows="2" id="_purpose" placeholder="Purpose" disabled></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="fw-bold" style="padding-top:20px;" for="date">Section:</label>
                                    <select class="" style="width: 150px; Border: 5px;" name="sections" id="_sect">
                                        <option value="C">CARPENTRY</option>
                                        <option value="P">PLUMBING</option>
                                        <option value="A">AIRCON</option>
                                        <option value="E">ELECTRICAL</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row" style="padding-top:6px;">     
                                <div class="col-md-1" style="margin-top:5px;">
                                    <label class="fw-bold" for="inputName">Step 1 Status:</label>
                                </div> 
                                <div class="col-md-2" style="margin-top:5px;">
                                    <input class="form-control" type="text" style="width:100%; height:80%;" name="" id= "_step1">
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
                                <button onclick = "enableFields()" type="button" class="btn btn-primary col-md-1" id="edit-button">Edit</button>
                            <button type="button" class="btn btn-success col-md-1" id="end-editing">Update</button>
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
                            <button onclick = "enableFields2()" type="button" class="btn btn-primary col-md-1" id="edit-button">Edit</button>
                            <button type="button" class="btn btn-success col-md-1" id="end-editing">Update</button>
                        </div>
                        <div class="justify-content-center">
                                <div class="col-md-12" >
                                    <label class="fw-bold" for="date">Feedback:</label>
                                    <textarea class="form-control" rows="2" id="_inputFeedback" placeholder="Feedback"></textarea>
                                </div>
                            </div>
                        <div>
                        <div class="modal-footer justify-content-md-center">
                            <a href= "javascript:void();" class ="btn btn-primary step1approveBtn">Approve</a>
                            <a href= "javascript:void();" class ="btn btn-danger step1declineBtn">Decline</a>
                            <a href= "javascript:void();" class ="btn btn-info text-white updateBtn">Update</a>
                            <!--<button type="" class="btn btn-primary approveBtn">Approve</button>
                            <button type="button" class="btn btn-danger">Decline</button>
                            <button type="submit" class="btn btn-info text-white">Update</button>-->
                         </div>
                        </div>
                            <!-- Form Controls End-->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        //datetime auto fill up
        var now = new Date();
        now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
        document.getElementById('datemajorjr').value = now.toISOString().slice(0,16);
        //Requesting department auto fill up
        
        /*  var deptname;
        document.getElementById('inputRoleID').value = deptname;*/

        /*toggle edit and update buttons*/
        const paragraph = document.getElementById("");          //NOT DONE YET!
        const edit_button = document.getElementById("edit-button");
        const end_button = document.getElementById("end-editing");

        edit_button.addEventListener("click", function() {
        paragraph.contentEditable = true;
        } );

        end_button.addEventListener("click", function() {
        paragraph.contentEditable = false;
        } )
        //Onclick event for enabling button
        function autofilldate(filldate) {

            //document.getElementById("_daterendered").valueAsDate = today;
            //document.getElementById('_daterendered').value = new Date().toISOString();
            /*var now = new Date();
            now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
            document.getElementById('_daterendered').value = now.toISOString().substring(0, 10);
            
            */
            var now = new Date();
            now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
            document.getElementById(filldate).value = now.toISOString().substring(0, 10);
            
        }
        function enableFields() {
            document.getElementById("_renderedby").disabled = false;
            document.getElementById("_daterendered").disabled = false;
           
            autofilldate("_daterendered");
            
        }
        function enableFields2() {
            document.getElementById("_confirmedby").disabled = false;
            document.getElementById("_dateconfirmed").disabled = false;
            autofilldate("_dateconfirmed");
        }
        
    </script>
    <!-- edit user modalPopup end-->
</body>
</html>