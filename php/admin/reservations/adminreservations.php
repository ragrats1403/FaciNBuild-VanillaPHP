<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Reservation</title>
    
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
                        <div class="col-md-2" style="width: 15%;"></div>
                        <div class="col-sm-12 shadow" style="width: 83%; background-color: #FFF; padding-top:50px; padding-left:50px; padding-right:50px;">
                            <!-- padding-left:50px; padding-top:50px; padding-right:50px;-->
                     </div>
                    </div>
                    
                    <div class="row">
                    <div class="col-md-2" style="width: 15%;"></div>
                        <div class="col-sm-12 shadow" style="width: 83%; background-color: #FFF; padding-left:50px; padding-right:50px; padding-bottom:50px; ">
                            <!-- padding-left:50px; padding-right:50px; padding-bottom:50px;-->
                            <form action="">
                                Please select the facilities you would like to request.<br><br>
                                    <input type="checkbox" id="annex_avr" name="Annex AVR" value="annex_avr">
                                    <label for="annex_avr"> Annex AVR</label>
                                    <input type="checkbox" id="new_avr" name="New AVR" value="new_avr">
                                    <label for="new_avr"> New AVR</label>
                                    <input type="checkbox" id="cbe_functionhall" name="CBE Function Hall" value="cbe_functionhall">
                                    <label for="cbe_functionhall"> CBE Function Hall</label>
                                    <input type="checkbox" id="auditorium" name="Auditorium" value="auditorium">
                                    <label for="auditorium"> Auditorium</label>
                                    <input type="checkbox" id="be_functionhall" name="BE Function Hall" value="be_functionhall">
                                    <label for="be_functionhall"> BE Function Hall</label><br><br>

                                    Date Filed: <input type="textbox"> Actual Date of Use: <input type="textbox"> Time in: <input type="textbox"> Time Out: <input type="textbox"><br>
                                    Requesting Party: <input type="textbox"> Department/College: <input type="textbox"><br>
                                    Purpose of Activity: <input type="textbox"><br>
                                    Estimated No. of Audience/Participants: <input type="textbox"> Stage Performers (if any): <input type="textbox">
                                    <br><br>
                                    NB: All other equipment(e.g. Backdrop, chairs, etc.,) shall be the responsibility of the requesting party.
                                    Technician’s, Electrical, Janitor’s and security guards overtime fees/excess fees are subject to the terms an condition provided at the bank thereof.<br>
                                    Secure Reservation from the AVR (filled up by the AVR personnel only) Date: Time:<br>
                                    2. The activity is officially endorsed and approved by the adviser, Chairperson/Dean, Department Head,
                                    and the SAO/ Cultural Directory. (if “disapproved”, it must be so stated, citing briefly the reason thereof)<br><br>
                                    
                                    <table id="datatable" class="table">
                                    <thead>
                                        <th>Equipments to Reserve</th>
                                        <th>Available</th>
                                        <th>Quantity to Reserve</th>
                                    </thead>
                                    Adviser <input type="textbox"> CHAIRPERSON/DEAN/DEPARTMENT <input type="textbox">
                            </form>
                            <div class="col-sm-12 d-flex justify-content-end">
                                 <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">View Add ons</button>
                            </div>
                        
                        </div>
                        <div class="col-md-2"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>