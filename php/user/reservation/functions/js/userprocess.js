//table display start
$('#datatable').DataTable({
    'serverSide': true,
    'processing': true,
    'paging': true,
    'order': [],
    'ajax': {
        'url': 'functions/fetch_data.php',
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

//table display end
 
//edit button control 
$(document).on('click', '.editBtn', function(event){
    var id = $(this).data('id');
    var trid = $(this).closest('tr').attr('reservationid');
    document.getElementById("_facility").disabled = true;
    document.getElementById("_eventname").disabled = true;
    document.getElementById("_datefiled").disabled = true;
    document.getElementById("_actualdate").disabled = true;
    document.getElementById("_timein").disabled = true;
    document.getElementById("_timeout").disabled = true;
    document.getElementById("_reqparty").disabled = true;
    document.getElementById("_collegeordepartment").disabled = true;
    document.getElementById("_purpose").disabled = true;
    document.getElementById("_numparticipants").disabled = true;
    document.getElementById("_stageperformers").disabled = true;
    document.getElementById("_adviser").disabled = true;
    document.getElementById("_chairdeandep").disabled = true;

    $.ajax({
        url: "functions/get_reservation_details.php",
        data: {
            id: id
        },
        type: 'POST',
        success: function(data) {
            var json = JSON.parse(data);
            //var itemwdesc = json.item + json.item_desc;
            $('#trid').val(trid);
            $('#_ID').val(id);
            $('#_facility').val(json.facility);
            $('#_eventname').val(json.eventname);
            $('#_datefiled').val(json.datefiled);
            $('#_actualdate').val(json.actualdateofuse);
            $('#_timein').val(json.timestart);
            $('#_timeout').val(json.timeend);
            $('#_reqparty').val(json.requestingparty);
            $('#_collegeordepartment').val(json.department);
            $('#_purpose').val(json.purposeofactivity);
            $('#_numparticipants').val(json.participants);
            $('#_stageperformers').val(json.stageperformers);
            $('#_adviser').val(json.adviser);
            $('#_chairdeandep').val(json.chairperson);
            $('#_statustext').val(json.status);
            $('#test').modal('show');;

    
            
        }
    });
    //$('#test').modal('show');
});


//closeinfomodal
$('#closemodal').click(function() {
    $('#myModal').modal('hide');
});

