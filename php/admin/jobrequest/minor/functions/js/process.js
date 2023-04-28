//table display start

        var dpt = "<?php echo $_SESSION['department'];?>";
        $('#datatable').DataTable({
    'serverSide': true,
    'processing': true,
    'paging': true,
    'order': [],
    'responsive': true,
    'ajax': {
        'url': 'functions/fetch_data.php',
        'type': 'post',
        'data': {
            'dpt': dpt,
        },
    },
    'fnCreatedRow': function(nRow, aData, iDataIndex) {
        $(nRow).attr('id', aData[0]);
        if (aData[4] === 'Approved') {
            $(nRow).css('background-color', '#a7d9ae');
        }
        if (aData[4] === 'Declined') {
            $(nRow).css('background-color', '#e09b8d');
        }
        if (aData[4] === 'Pending') {
            $(nRow).css('background-color', '#d9d2a7');
        }
    },
    'columnDefs': [{
        'targets': [0, 4],
        'orderable': false,
    }],
    scrollY: 670,
    'scrollCollapse': true,
    'paging': false,
});
//table display end

 //add button control
 /*$(document).on('submit', '#saveUserForm', function(event) {
    event.preventDefault();
    var department = $('#department').val();
    var date = $('#datemajorjr').val();
    var quantity = $('#_quantity_').val();
    var itemname = $('#_item_').val();
    var description = $('#_itemdesc_').val();
    var purpose = $('#_purpose_').val();
    /*var renderedby = $('#renderedby').val();
    var daterendered = $('#daterendered').val();
    var confirmedby = $('#confirmedby').val();
    var dateconfirmed = $('#dateconfirmed').val();
    if (department != '' && date != '' && quantity != '' && itemname != '' && description != '' && purpose != '') {
        $.ajax({
            url: "functions/add_data.php",
            data: {
                department: department,
                date: date,
                quantity: quantity,
                itemname: itemname,
                description: description,
                purpose: purpose,
            },
            type: 'POST',
            success: function(data) {
                var json = JSON.parse(data);
                var status = json.status;
                if (status = 'success') {
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                    table = $('#datatable').DataTable();
                    table.draw();
                    alert('Successfully Created Request!');
                    $('#department').val('');
                    var now = new Date();
                    now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
                    document.getElementById('datemajorjr').value = now.toISOString().slice(0,16);
                    $('#_quantity_').val('');
                    $('#_item_').val('');
                    $('#_itemdesc_').val('');
                    $('#_purpose_').val('');
                    $('#addUserModal').modal('hide');
                    //force remove faded background  -Ragrats
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                    //force remove end
                }
            }
        });
    } else {
        alert("Please fill all the Required fields");
    }
});*/

$(document).on('submit', '#saveUserForm', function(event) {
    var department = $('#department').val();
    var date = $('#datemajorjr').val();
    var quantity = $('#_quantity_').val();
    var description = $('#_itemdesc_').val();
    var purpose = $('#_purpose_').val();
    var renderedby = $('#renderedby').val();
    var daterendered = $('#daterendered').val();
    var confirmedby = $('#confirmedby').val();
    var dateconfirmed = $('#dateconfirmed').val();
    var requestedby = $('#requestedby').val();
    if (department != '' && date != '' && quantity != '' && requestedby != '' && description != '' && purpose != '' && renderedby != '' && daterendered != '' && confirmedby != '' && dateconfirmed != '') {
        $.ajax({
            url: "functions/add_data.php",
            data: {
                department: department,
                date: date,
                quantity: quantity,
                requestedby: requestedby,
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
                    alert('Requested Successfully!');
                    $('#_quantity_').val('');
                    $('#_item_').val('');
                    $('#_itemdesc_').val('');
                    $('#_purpose_').val('');
                    $('#renderedby').val('');
                    $('#daterendered').val('');
                    $('#confirmedby').val('');
                    $('#dateconfirmed').val('');
                    $('#requestedby').val('');
                    $('#addUserModal').modal('hide');
                    $("body").removeClass("modal-open");
                    $(".modal-backdrop").remove();
                }
            }
        });
    } else {
        alert("Please fill all the Required fields");
    }
});

$(document).on('click', '.renderUpdate', function(event){
   
});

function renderedbyUpdate()
{
     //var status = "Approved";
     var id = $('#_ID').val();
     var trid = $('#trid').val();
     var renderedby = $('#_renderedby').val();
     var renderdate = $('#_daterendered').val();
     $.ajax({
         url: "functions/updaterender.php",
         data: {
             id: id,
             renderdate: renderdate,
             renderedby: renderedby,
             
         },
         type: 'POST',
         success: function(data) {
             var json = JSON.parse(data);
             var status = json.status;
             if (status == 'success') {
                 //alert('Updated Successfully!');
                 document.getElementById("_renderedby").disabled = false;
                 document.getElementById("_daterendered").disabled = false;
             } else { 
                 alert('failed');
             }
         }
     });
     //alert('test');
}
function confirmedbyUpdate()
{
    //var status = "Approved";
    var id = $('#_ID').val();
    var trid = $('#trid').val();
    var confirmby = $('#_confirmedby').val();
    var confirmdate = $('#_dateconfirmed').val();
    $.ajax({
        url: "functions/updateconfirmby.php",
        data: {
            id: id,
            confirmdate: confirmdate,
            confirmby: confirmby,
            
        },
        type: 'POST',
        success: function(data) {
            var json = JSON.parse(data);
            var status = json.status;
            if (status == 'success') {
                //alert('Updated Successfully!');
                document.getElementById("_confirmedby").disabled = false;
                document.getElementById("_dateconfirmed").disabled = false;
                /*table = $('#datatable').DataTable();
                var button = '<a href="javascript:void();" data-id="' + id + '"  class="btn btn-sm btn-success btnDelete" >Approve</a> <a href= "javascript:void();" data-id="' + id + '" class ="btn btn-sm btn-info editBtn">More Info</a>';
                var row = table.row("[id='" + trid + "']");
                row.row("[id='" + trid + "']").data([department, date, button]);*/
            } else { 
                alert('failed');
            }
        }
    });
    //alert('test');
}
$(document).on('click', '.confirmUpdate', function(event){

});
//delete user button control
$(document).on('click', '.btnDelete', function(event) {
    var table = $('#datatable').DataTable();
    event.preventDefault();
    var id = $(this).data('id');
    if (confirm('Are you sure to delete this request?')) {


        $.ajax({
            url: "functions/delete_data.php",
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
//approve button 
$(document).on('click', '.approveBtn', function(event){
    //var status = "Approved";
    var id = $('#_ID').val();
    var trid = $('#trid').val();
    $.ajax({
        url: "functions/approverequest.php",
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
                alert('Approved Successfully!');
               
                /*table = $('#datatable').DataTable();
                var button = '<a href="javascript:void();" data-id="' + id + '"  class="btn btn-sm btn-success btnDelete" >Approve</a> <a href= "javascript:void();" data-id="' + id + '" class ="btn btn-sm btn-info editBtn">More Info</a>';
                var row = table.row("[id='" + trid + "']");
                row.row("[id='" + trid + "']").data([department, date, button]);*/
                $('#editMinorjreqmodal').modal('hide');
            } else { 
                alert('failed');
            }
        }
    });
    //alert('test');
});
//reject/decline button
$(document).on('click', '.declineBtn', function(event){
    //var status = "Approved";
    var id = $('#_ID').val();
    var trid = $('#trid').val();
    $.ajax({
        url: "functions/declinerequest.php",
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
                alert('Request Declined Successfully!');
               
                /*table = $('#datatable').DataTable();
                var button = '<a href="javascript:void();" data-id="' + id + '"  class="btn btn-sm btn-success btnDelete" >Approve</a> <a href= "javascript:void();" data-id="' + id + '" class ="btn btn-sm btn-info editBtn">More Info</a>';
                var row = table.row("[id='" + trid + "']");
                row.row("[id='" + trid + "']").data([department, date, button]);*/
                $('#editMinorjreqmodal').modal('hide');
            } else { 
                alert('failed');
            }
        }
    });
    //alert('test');
});

$(document).on('click', '.btnprint', function(event) {
    var id = $(this).data('id');
    var trid = $(this).closest('trid').attr('majoreq');
    $.ajax({
        url: "functions/get_request_details.php",
        data: {
            id: id
        },
        type: 'POST',
        success: function(data) {
            var json = JSON.parse(data);
            $('#id').val(json.id);
            $('#trid').val(trid);
            $('#_idnum').val(json.minorjobid);
            $('#_department1').val(json.department);
            $('#_datemajorjr1').val(json.datesubmitted);
            $('#_section').val(json.section);
            $('#_quantity1').val(json.quantity);
            $('#_itemdesc1').val(json.item_desc);
            $('#_purpose1').val(json.purpose);
            $('#_requestedby1').val(json.requestedby);
            $('#_renderedby1').val(json.renderedby);
            $('#_notedby1').val(json.notedby);
            $('#_confirmedby1').val(json.confirmedby);
            $('#_daterendered1').val(json.daterendered);
            $('#_dateconfirmed1').val(json.dateconfirmed);
            $('#printmodal').modal('show');
        }
    });
});



//edit button control 
$(document).on('click', '.editBtn', function(event) {
    var id = $(this).data('id');
    var trid = $(this).closest('tr').attr('minorjobid');
    document.getElementById("_renderedby").disabled = true;
    document.getElementById("_daterendered").disabled = true;
    document.getElementById("_confirmedby").disabled = true;
    document.getElementById("_dateconfirmed").disabled = true;
    document.getElementById("_daterendered").value = null;
    document.getElementById("_dateconfirmed").value = null;
    document.getElementById("_sect").disabled = true;
    document.getElementById("_statustext").disabled = true;
    document.getElementById("_step1").disabled = true;
    document.getElementById("_inputFeedback").disabled = true;
    document.getElementById("_quantity").disabled = true;
    document.getElementById("_itemdesc").disabled = true;
    document.getElementById("_purpose").disabled = true;
    document.getElementById("_sect").disabled = true;
    document.getElementById("_purpose").disabled = true;
    document.getElementById("_requestedby").disabled = true;
    document.getElementById("updbtn").hidden = true;
    //document.getElementById("_sect").disabled = true;
    $.ajax({
        url: "functions/get_request_details.php",
        data: {
        id: id
        },
        type: 'POST',
        success: function(data) {
        var json = JSON.parse(data);
        $('#minorjobid').val(json.minorjobid);
        $('#trid').val(trid);
        $('#_ID').val(id);
        $('#_datemajorjr').val(json.datesubmitted);
        $('#_department').val(json.department);
        $('#_quantity').val(json.quantity);
        $('#_itemdesc').val(json.item_desc);
        $('#_purpose').val(json.purpose);
        $('#_statustext').val(json.status);
        $('#_step1').val(json.bdstatus);
        $('#_renderedby').val(json.renderedby);
        $('#_daterendered').val(json.daterendered);
        $('#_confirmedby').val(json.confirmedby);
        $('#_dateconfirmed').val(json.dateconfirmed);
        $('#_notedby').val(json.notedby);
        $('#_requestedby').val(json.requestedby);
        $('#_bdapprovedby').val(json.approvedby);
        var x = document.getElementById("_sect");
        var option = document.createElement("option");
        option.text = json.section;
        option.hidden = true;
        option.disabled = true;
        option.selected = true;
        x.add(option); 
        $('#_inputFeedback').val(json.feedback);
        if(json.bdstatus != 'Pending')
        {
            document.getElementById("_bdapprovedby").disabled = true;
            document.getElementById("_sect").disabled = true;
            document.getElementById("_inputFeedback").disabled = true;
            document.getElementById("_notedby").disabled = true;
            document.getElementById("step1a").hidden = true;
            document.getElementById("step1d").hidden = true;
        }
        else
        {
            document.getElementById("_bdapprovedby").disabled = false;
            document.getElementById("_sect").disabled = false;
            document.getElementById("_notedby").disabled = false;
            document.getElementById("_inputFeedback").disabled = false;
            document.getElementById("step1a").hidden = false;
            document.getElementById("step1d").hidden = false;
        }
        $('#editMinorjreqmodal').modal('show');
        },
        error: function(jqXHR, textStatus, errorThrown) {
        console.log(textStatus, errorThrown);
        }
    });
});

$(document).on('click', '.updateBtn', function() {
    var id = $('#_ID').val();
    var trid = $('#trid').val();
    var department = $('#_department').val();
    var date = $('#_datemajorjr').val();
    var quantity = $('#_quantity').val();
    var description = $('#_itemdesc').val();
    var purpose = $('#_purpose').val();
    var s = document.getElementById("_sect"); //dropdown
    var sect = s.options[s.selectedIndex].text; //end
    var feedback = $('#_inputFeedback').val();
    var notedby = $('#_notedby').val();
    var approvedby = $('#_bdapprovedby').val();
    var requestedby = $('#_requestedby').val();
    
    $.ajax({
        url: "functions/update_data.php",
        data: {
            id: id,
            department: department,
            date: date,
            quantity: quantity,
            description: description,
            purpose: purpose,
            sect: sect,
            feedback: feedback,
            notedby: notedby,
            approvedby: approvedby,
            requestedby: requestedby,
            
        },
        type: 'POST',
        success: function(data) {
            var json = JSON.parse(data);
            var status = json.status;
            if (status == 'success') {
                confirmedbyUpdate();
                renderedbyUpdate();
                alert('Updated Successfully!');
                table = $('#datatable').DataTable();
                table.draw();


                /*table = $('#datatable').DataTable();
                var button = '<a href="javascript:void();" data-id="' + id + '"  class="btn btn-sm btn-success btnDelete" >Approve</a> <a href= "javascript:void();" data-id="' + id + '" class ="btn btn-sm btn-info editBtn">More Info</a>';
                var row = table.row("[id='" + trid + "']");
                row.row("[id='" + trid + "']").data([department, date, button]);*/
                $('#editMinorjreqmodal').modal('hide');
            } else { 
                alert('failed');
            }
        }
    });
});



//steps approval javascript


//step 1
$(document).on('click', '.step1approveBtn', function(event){

 //var status = "Approved";
 var id = $('#_ID').val();
 var trid = $('#trid').val();
 var dept = $('#_department').val();
 var feedb = $('#_inputFeedback').val();
 var notedby = $('#_notedby').val();
 var approvedby = $('#_bdapprovedby').val();
 var e = document.getElementById("_sect");
 var section = e.options[e.selectedIndex].text;
 if(approvedby != '' && notedby != '' && section != '')
    {
        $.ajax({
            url: "functions/step1approve.php",
            data: {
                id: id,
                dept: dept,
                feedb: feedb,
                notedby: notedby,
                approvedby: approvedby,
                section: section,
    
                
            },
            type: 'POST',
            success: function(data) {
                var json = JSON.parse(data);
                var status = json.status;
                if (status == 'success') {
                    table = $('#datatable').DataTable();
                    table.draw();
                    alert('Approved Successfully!');
                    document.getElementById("step1a").hidden = true;
                    document.getElementById("step1d").hidden = true;
                    $('#_step1').val('Approved');
                    $('#editMinorjreqmodal').modal('hide');
                } else { 
                    alert('failed');
                }
            }
        });
    }
    else
    {
        alert("Please fill in required fields");
    }
});
//step 3
//alert('test');
//steps approval end

//steps decline start
$(document).on('click', '.step1declineBtn', function(event){
    var id = $('#_ID').val();
    var trid = $('#trid').val();
    var dept = $('#_department').val();
    var feedb = $('#_inputFeedback').val();
    if(feedb == '' || feedb == null || feedb == undefined)
    {
        alert("Please provide a feedback before declining request!");
    }
    else
    {
        $.ajax({
            url: "functions/step1decline.php",
            data: {
                id: id,
                dept: dept,
                feedb: feedb,
                
            },
            type: 'POST',
            success: function(data) {
                var json = JSON.parse(data);
                var status = json.status;
                if (status == 'success') {
                    table = $('#datatable').DataTable();
                    table.draw();
                    alert('Step 1 Declined Successfully!');
                    document.getElementById("step1a").hidden = true;
                    document.getElementById("step1d").hidden = true;


                    document.getElementById("_inputFeedback").disabled = true;
                    document.getElementById("_notedby").disabled = true;
                    document.getElementById("_bdapprovedby").disabled = true;
                    $('#_bdapprovedby').val('');
                    $('#_notedby').val('');
                
                    //$('#_itemdesc_').text('');
                    $('#_step1').val('Declined');
                    $('#_statustext').val('Declined');
                } else { 
                    alert('failed');
                }
            }
            });
    }
    

});

//steps decline end


//edit button keypress event
$(document).on('click', '.editfieldBtn', function(event) {
    var status = $('#_step1').val();

    document.getElementById("_quantity").disabled = false;
    document.getElementById("_itemdesc").disabled = false;
    document.getElementById("_purpose").disabled = false;
    document.getElementById("_requestedby").disabled = false;
    document.getElementById("updbtn").hidden = false;
    //document.getElementById("_dateconfirmed").disabled = false;
    document.getElementById("_sect").disabled = false;
    document.getElementById("_statustext").disabled = true;
    document.getElementById("_inputFeedback").disabled = false;
    document.getElementById("_renderedby").disabled = false;
    document.getElementById("_confirmedby").disabled = false;

    if(status != 'Approved')
    {
        document.getElementById("_notedby").disabled = false;
        document.getElementById("_bdapprovedby").disabled = false;
        document.getElementById("step1a").hidden = false;
        document.getElementById("step1d").hidden = false;

    }
    else
    {
        document.getElementById("step1a").hidden = true;
        document.getElementById("step1d").hidden = true;
    }
    //var notedby = $('#_notedby').val();
    //var approvedby = $('#_bdapprovedby').val();


});
//edit button keypress event end

