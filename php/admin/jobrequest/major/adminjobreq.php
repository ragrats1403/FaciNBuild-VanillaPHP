<!DOCTYPE html>
<html lang="en">

<head>
    <!--<meta charset="UTF-8">
    <title>Job Request</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../../../css/sidebar.css?<?=time()?>">
    <link rel="stylesheet" type="text/css" href="../../../css/header.css?<?=time()?>">
    <link rel="stylesheet" type="text/css" href="../../../css/body.css?<?=time()?>">
    <link rel="stylesheet" type="text/css" href="../../../css/admin/adminaccount.css?<?=time()?>" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    -->
    <meta charset="UTF-8">
    <title>Job Request</title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.1/datatables.min.css" />
    <link rel="stylesheet" type="text/css" href="../../../../css/sidebar.css?<?=time()?>">
    <link rel="stylesheet" type="text/css" href="../../../../css/header.css?<?=time()?>">
    <link rel="stylesheet" type="text/css" href="../../../../css/body.css?<?=time()?>">
    <link rel="stylesheet" type="text/css" href="../../../../css/admin/adminaccount.css?<?=time()?>" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'> 
</head>

<header>
    <div class= "imgctrl">
        
    </div>
    <div class="navplace">
        <p>Hello, Administrator</p>
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
                <a href="../../../php/admin/accounts/admin_account.php">
                    <i class='bx bx-user'></i>
                    <span class="link_name">Account</span>
                </a>
            </li>
            <li>
                <div class="dropdown">
                    <i class='bx bx-clipboard' style="margin-left:17px;" ></i>
                    <span class="jobrequestdr btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Job Request
                    </span>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="../../../php/admin/jobrequest/minor/minorjobreqlist.php">Minor Job Request</a>
                        <a class="dropdown-item" href="../../../php/admin/jobrequest/major/majorjobreqlist.php">Major Job Request</a>
                    </ul>
                </div>
            </li>
            <li>
                <a href="../../../php/admin/equipments/adminequipment.php">
                    <i class='bx bx-wrench'></i>
                    <span class="link_name">Equipment</span>
                </a>
            </li>
            <li>
                <a href="../../../php/admin/reservations/adminreservations.php">
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
                            <div class="name">Admin</div>
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
                        <div class="col-md-2 " style="padding-left:100px;"></div>
                        <div class="col-md-8 " style="background-color: #fff4c4; padding-left:50px; padding-top:50px; padding-right:50px;">

                            <div class="row justify-content-center" style="padding-bottom:10px;">
                                <h1 class="text-center text-uppercase fw-bold" style="padding-bottom:10px;">Major Job Request form</h1>
                                <div class="col-md-6 ">
                                    <input type="name" class="form-control input-sm col-xs-1" id="Namemajorjr" placeholder="Job request no.">
                                </div>
                                <div class="col-md-6 ">
                                    <input type="name" class="form-control input-sm col-xs-1" id="numbermajorjr" placeholder="Requisition no.">
                                </div>
                            </div>
                            <div class="row justify-content-center" style="padding-bottom:13px;">
                                <div class="col-md-6 ">
                                    <input type="name" class="form-control input-sm col-xs-1" id="departmentmajorjr" placeholder="Department">
                                </div>
                                <div class="col-md-6 ">
                                    <input type="name" class="form-control input-sm col-xs-1" id="datemajorjr" placeholder="Date">
                                </div>
                            </div>
                            <div class="justify-content-center" style="padding-bottom:10px;">
                                <h5 class="text-uppercase fw-bold" style="padding-bottom:10px;" >A. Requisition(To be filled up by the requesting party)</h5>
                                <div class="col-md-2 ">
                                    <input type="name" class="form-control input-sm col-xs-1" id="departmentmajorjr" placeholder="Quantity">
                                </div>
                            </div>
                            <div class="row justify-content-center" style="padding-bottom:10px;">
                                <h5 class="text-uppercase fw-bold" style="padding-bottom:10px;" >ITEM WITH COMPLETE DESCRIPTION</h5>
                                <div class="col-md-10" >
                                    <textarea placeholder="Description" class="form-control" rows="2" id="description"></textarea>
                                </div>
                                <div class="col-md-2 ">
                                <button class="text-secondary btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"  aria-haspopup="true" aria-expanded="false" style="background-color: #fff;">Dropdown button </button>
                                </div>
                            </div>

                            <div class="justify-content-center" style="padding-bottom:10px;">
                                <div class="col-md-12" >
                                    <textarea placeholder="Purpose" class="form-control" rows="2" id="purpose"></textarea>
                                </div>
                            </div>
                            
                            <div class="row justify-content-center" style="padding-bottom:10px;">
                                <div class="col-md-6" >
                                    <label class="fw-bold" for="renderedby">Requested by</label>
                                    <input type="name" class="form-control input-sm col-xs-1" id="departmentmajorjr">
                                </div>
                                <div class="col-md-6" >
                                    <label class="fw-bold" for="date">Approved by</label>
                                    <input type="date" class="form-control input-sm col-xs-1" id="departmentmajorjr">
                                </div>
                            </div>
                            <div class=" row justify-content-center" style="padding-bottom:10px;">
                                <div class="col-md-6" style="padding-bottom:10px;" >
                                    <label class="fw-bold" for="renderedby">Department Head</label>
                                    <input type="name" class="form-control input-sm col-xs-1" id="departmentmajorjr">
                                </div>
                                <div class="col-md-6" >
                                    <label class="fw-bold" for="date">Noted By</label>
                                    <input type="name" class="form-control input-sm col-xs-1" id="departmentmajorjr">
                                </div>
                                <div class="col-md-7" style="background-color: #fff4c4;">
                                </div>
                                <label class="fw-bold" style="padding-left:825px;" for="renderedby">PROPERTY CUSTODIAN</label>
                            </div>

                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>