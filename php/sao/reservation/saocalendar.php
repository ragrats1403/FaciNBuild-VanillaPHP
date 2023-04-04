<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>CALENDAR OF ACTIVITIES</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.1/datatables.min.css" />
    <link rel="stylesheet" type="text/css" href="../../../../css/sidebar.css?<?= time() ?>">
    <link rel="stylesheet" type="text/css" href="../../../../css/header.css?<?= time() ?>">
    <link rel="stylesheet" type="text/css" href="../../../../css/body.css?<?= time() ?>">
    <link rel="stylesheet" type="text/css" href="../../../../css/admin/adminaccount.css?<?= time() ?>" />
    <link rel="stylesheet" type="text/css" href="../../../../css/modal.css/modal.css?<?= time() ?>" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script type="text/javascript" src="js/autofill.js"></script>
</head>

<header class="shadow">
    <div class="imgctrl">

    </div>
    <div class="navplace">
        <div>
            <button type="button" class="icon-button">
                <span class='bx bxs-bell'></i>
                    <span class="icon-button__badge"></span>
        </div>
        <p>Hello, SAO</p>
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
        <div class="navdiv">
            <ul class="nav_list">
                <li>
                    <a href="../../../php/sao/reservation/saocalendar.php">
                        <i class='bx bx-calendar'></i>
                        <span class="link_name">Calendar of Activities</span>
                    </a>
                </li>
                <li>
                    <div class="dropdown">
                        <i class='bx bx-notepad' style="margin-left:17px;"></i>
                        <span class="jobrequestdr btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Manage Request
                        </span>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                         <a class="dropdown-item" href="../../../php/sao/reservation/saoreservation.php">Reservation</a>
                        </ul>
                        </div>
                    <div class="dropdown">
                        <i class='bx bx-clipboard' style="margin-left:17px;"></i>
                        <span class="jobrequestdr btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            View/Create Request
                        </span>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                         <a class="dropdown-item" href="../../../php/sao/major/majorjobreqlist.php">Major Request</a>  
                         <a class="dropdown-item" href="../../../php/sao/minor/minorjobreqlist.php">Minor Request</a>
                         <a class="dropdown-item" href="../../../php/sao/reservation/saoreservation.php">Reservation</a>
                        </ul>
                    </div>
            </li>
        </ul>
        <div class="profile_content">
                <div class="profile">
                    <div class="profile_details">
                    <img src="../../../images/ico/profileicon.png" alt="" style = "height: 45px; width:45px; object-fit:cover; border-radius:12px;" />
                        <div class="name_role">
                        <div class="name">SAO</div>
                        <div class="role">Hello SAO</div>
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
                            <h2 style= "text-align: center">CALENDAR OF ACTIVITIES</h2>
                            <table id="datatable" class="table">
                                <thead>
                                    <th>Event Name</th>
                                    <th>Date</th>
                                    <th>Time Start</th>
                                    <th>Time End</th>
                                    <th>Venue</th>
                                    <th>Option</th>
                                </thead>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>