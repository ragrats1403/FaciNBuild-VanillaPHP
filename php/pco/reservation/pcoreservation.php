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
    <link rel="stylesheet" type="text/css" href="../../../../css/modal.css/modal.css?<?= time() ?>" />
    <link rel="stylesheet" type="text/css" href="../../../../css/admin/adminaccount.css?<?=time()?>" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script type="text/javascript" src="js/autofill.js"></script>
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
                $.ajax({
                url: "functions/notification.php",
                type: 'GET',
                success: function(data) {
                    
                    var notifications = JSON.parse(data);
                    var len = data.length;
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
                        }
                }
                

            });
            }
            document.addEventListener("DOMContentLoaded", function() {
                fetchNotifications();
                setInterval(fetchNotifications, 5000);
                });
                const markAsReadButton = document.querySelector(".mark-as-read");
                markAsReadButton.addEventListener("click", function(event) {   
                    $.ajax({
                        url: "functions/update_notification.php",
                        type: 'POST',
                        success: function(data) {
                            var json = JSON.parse(data);
                            var len = json.length;
                            for(let i = 0; i<notifications.length; i++){
                                const notification = notifications[i];
                                notification.is_read = 1;
                            }
                             // Update the badge count
                            notificationBadge.innerText = "0";

                            // Clear the existing list
                            notificationList.innerHTML = "";
                        }
                    });


                });
 
        </script>
        <p>Hello, <?php echo $_SESSION['department'];?></p>
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
        <div class ="navdiv">
        <ul class="nav_list">
            <li>
                <a href="../../../../php/pco/pcocalendar.php">
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
                        <a class="dropdown-item" href="/../../../php/pco/major/majorjobreqlist.php">Major Job Request</a>
                    </ul>
                </div>
                <div class="dropdown">
                    <i class='bx bx-notepad' style="margin-left:17px;" ></i>
                    <span class="jobrequestdr btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        View/Create Request
                    </span>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="../../../php/pco/major/majorjobreqlist.php">Major Job Request</a>
                        <a class="dropdown-item" href="../../../php/pco/minor/minorjobreqlist.php">Minor Job Request</a>
                        <a class="dropdown-item" href="../../../php/pco/reservation/pcoreservation.php">Request Reservation</a>
                    </ul>
                </div>
            </li>
        </ul>
        <div class="profile_content">
                <div class="profile">
                    <div class="profile_details">
                    <img src="../../../../images/ico/profileicon.png" alt="" style = "height: 45px; width:45px; object-fit:cover; border-radius:12px;" />
                        <div class="name_role">
                        <div class="name"><?php echo mb_strimwidth($_SESSION['department'], 0, 20, '…');?></div>
                            <div class="role">PCO Department</div>
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
                        <div class="col-sm-12 shadow" style="width: 100%; background-color: #FFF; padding-top: 100px; padding-left:50px; padding-right:50px; padding-bottom:50px;">
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
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">Create Reservation</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 

    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="max-width:1100px;">
            <div class="modal-content">
                <div class="modal-header" style="max-width:1100px;">
                        <h5 class="modal-title text-uppercase fw-bold" id="exampleModalLabel" >Reservation Form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ">
                <form action="">
                        Please select the facilities you would like to request.<br><br>
                            <input type="checkbox" id="annex_avr" name="Annex AVR" value="annex_avr">
                            <label for="annex_avr"> Old AVR</label>
                            <input type="checkbox" id="new_avr" name="New AVR" value="new_avr">
                            <label for="new_avr"> New AVR</label>
                            <input type="checkbox" id="cbe_functionhall" name="CBE Function Hall" value="cbe_functionhall">
                            <label for="cbe_functionhall"> CBE Function Hall</label>
                            <input type="checkbox" id="auditorium" name="Auditorium" value="auditorium">
                            <label for="auditorium"> Auditorium</label>
                            <input type="checkbox" id="be_functionhall" name="BE Function Hall" value="be_functionhall">
                            <label for="be_functionhall"> BE Function Hall</label><br><br>

                            <div class="row justify-content-center" style="padding-bottom:13px;">
                                <div class="col-md-6 ">
                                    <label class="fw-bold" for="date">Date Filed:</label>
                                    <input type="datetime-local" class="form-control input-sm col-xs-1" id="datefiled" placeholder="Date Filed">
                                </div>
                                <div class="col-md-6 ">
                                    <label class="fw-bold" for="date">Actual Date of Use:</label>
                                    <input type="datetime-local" class="form-control input-sm col-xs-1" id="actualdate" placeholder="Actual Date of Use">
                                </div>
                            </div>
                                <div class="col-md-6 ">
                                    <label class="fw-bold" for="date">Time In:</label>
                                    <input type="datetime-local" class="form-control input-sm col-xs-1" id="timein" placeholder="Time In">
                                </div>
                                <div class="col-md-6 ">
                                    <label class="fw-bold" for="date">Time Out:</label>
                                    <input type="datetime-local" class="form-control input-sm col-xs-1" id="timeout" placeholder="Time Out">
                                </div>
                                <div class="col-md-6 ">
                                    <label class="fw-bold" for="date">Requesting Party:</label>
                                    <input type="name" class="form-control input-sm col-xs-1" id="reqparty" placeholder="Requesting Party">
                                </div>
                                <div class="col-md-6 ">
                                    <label class="fw-bold" for="date">College/Department:</label>
                                    <input type="name" class="form-control input-sm col-xs-1" id="collegeordepartment" placeholder="College/Department">
                                </div>
                            <div class="justify-content-center">
                                <div class="col-md-12" >
                                    <label class="fw-bold" for="date">Purpose of Activity:</label>
                                    <textarea class="form-control" rows="2" id="_purpose_" placeholder="Purpose"></textarea>
                                </div>
                            </div>
                                <div class="col-md-6 ">
                                    <label class="fw-bold" for="date">Estimated No. of Audience/Participants:</label>
                                    <input type="name" class="form-control input-sm col-xs-1" id="numparticipants" placeholder="Estimated No. of Audience/Participants">
                                </div>
                                <div class="col-md-6 ">
                                    <label class="fw-bold" for="date">Stage Performers (if any):</label>
                                    <input type="name" class="form-control input-sm col-xs-1" id="stageperformers" placeholder="Stage Performers (if any)">
                                </div>
                            <br><br><br>
                            <label>NB: All other equipment (e.g. Backdrop, chairs, etc.,) shall be the responsibility of the requesting party.
                            Technician’s, Electrical, Janitor’s and security guards overtime fees/excess fees are subject to the terms an condition provided at the bank thereof.<br>
                            Secure Reservation from the AVR (filled up by the AVR personnel only) 
                            <div class="col-md-6 ">
                                    <label class="fw-bold" for="date">Date and Time</label>
                                    <input type="datetime-local" class="form-control input-sm col-xs-1" id="date_avr" placeholder="Date"><br>
                            </div>
                            2. The activity is officially endorsed and approved by the adviser, Chairperson/Dean, Department Head,
                            and the SAO/ Cultural Directory. (if “disapproved”, it must be so stated, citing briefly the reason thereof)<br><br></label>
                            
                            <div class="col-md-6 ">
                                    <label class="fw-bold" for="date">Adviser</label>
                                    <input type="name" class="form-control input-sm col-xs-1" id="adviser" placeholder="Adviser">
                                </div>
                                <div class="col-md-6 ">
                                    <label class="fw-bold" for="date">CHAIRPERSON/DEAN/DEPARTMENT</label>
                                    <input type="name" class="form-control input-sm col-xs-1" id="chairdeandep" placeholder="CHAIRPERSON/DEAN/DEPARTMENT">
                                </div>

                            <table id="datatable" class="table">
                            <thead>
                                <th>Equipments to Reserve</th>
                                <th>Available</th>
                                <th>Quantity to Reserve</th>
                            </thead>
                             </table> 
                             <h5 class="fw-bold" style="text-align:center;">OTHER TERMS AND CONDITION PRIOR TO APPROVAL</h5>
                             <label>1. ADMINISTRATION OR INSTITUTIONAL FUNCTIONS OR ACTIVITIES WILL BE GIVEN PRIORITY. PRIOR NOTICE AND REASSIGNMENT/RESCHEDULING OF AFFECTED PROGRAM OR ACTIVITIES WILL BE REARRANGED.
                             <br>
                             <br>
                             2. RESERVATION SHOULD BE MADE FIVE(5) DAYS PRIOR TO THE ACTUAL DATE OF USE.
                             <br>
                             <br>
                             3. The requesting party agrees on the following:<br>
                             3.1 To remove any and all backdrops, props, papers and things brought by user.<br>
                             3.2 To free and discharged the University of Cebu Lapu-lapu and Mandaue and its officers from any and all suits, actions or damages arising from the accidents, injuries, damages or incidents that may be suffered by the requesting party's use of the school facilities, and to personally assume any and all such obligations and liabilities.
                             3.3 When the use exceeds beyond the regular duty of electricians, technicians and staff, the requesting party will provide snack/meals and pay their overtime fees at the rates fixed by the HR Office.
                             3.4 When janitorial services are required by the University of Cebu Lapu-lapu and Mandaue to efficiently clean the used venues/areas, the requesting party will pay their janitorial overtime fees fixed by the HR Office.
                             3.5 When security guards are required by the University of Cebu Lapu-lapu and Mandaue by reason of nature the affair and/or number of target population, the user will provide security guards at the cost of the requesting party/user, who shall directly request the security agency.
                             <br>
                             <br>
                             4. STRICTLY NO ID, NO ENTRY; electricity will be charged, no alcohol inside, NO ENTRY for those students who are under the influence of alcohol and drugs.
                             <br>
                             <br>
                             5. When tickets are sold by the requesting party , the use of the venues shall be subject to further conditions.
                             <br>
                             <br>
                             6. If the requesting party is an outsider, and if allowed, they will pay the rentals to be fixed by the University.
                             <br>
                             <br>
                             ADDENDA (by UCLM)
                             <br>
                             <br>
                             The undersigned requesting party and/or its officers, advisers and department head bind themselves to any and all of the terms and conditions stipulated in this FORM.
                             <br>
                             <br>
                            

                             </label>
                                  
                    <div class="col-sm-12 d-flex justify-content-end">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal1">Add-On</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>
</html>