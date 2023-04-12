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

 //add button control
 $(document).on('submit', '#saveUserForm', function(event) {
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
    var feedback = $('#_inputFeedback').val();
    if (department != '' && date != '' && quantity != '' && itemname != '' && description != '' && purpose != '' && renderedby != '' && daterendered != '' && confirmedby != '' && dateconfirmed != '') {
        $.ajax({
            url: "functions/add_data.php",
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
                feedback: feedback,
                
            },
            type: 'POST',
            success: function(data) {
                var json = JSON.parse(data);
                status = json.status;
                if (status = 'success') {
                    table = $('#datatable').DataTable();
                    table.draw();
                    alert('Successfully Added User!');
                    $('#_quantity_').val('');
                    $('#_item_').val('');
                    $('#_itemdesc_').val('');
                    $('#_purpose_').val('');
                    $('#renderedby').val('');
                    $('#daterendered').val('');
                    $('#confirmedby').val('');
                    $('#dateconfirmed').val('');
                    $('#_inputFeedback').val('');
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
$(document).on('click', '.renderUpdate', function(event){
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
                alert('Updated Successfully!');
                document.getElementById("_renderedby").disabled = false;
                document.getElementById("_daterendered").disabled = false;
            } else { 
                alert('failed');
            }
        }
    });
    //alert('test');
});
$(document).on('click', '.confirmUpdate', function(event){
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
                alert('Updated Successfully!');
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
});


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


//edit button control 


$(document).on('click', '.updateBtn', function() {
    var id = $('#_ID').val();
    var trid = $('#trid').val();
    var department = $('#_department').val();
    var date = $('#_datemajorjr').val();
    var quantity = $('#_quantity').val();
    var itemname = $('#_item').val();
    var description = $('#_itemdesc').val();
    var e = document.getElementById("_sect");
    var section = e.options[e.selectedIndex].text;
    var purpose = $('#_purpose').val();
    var feedback = $('#_inputFeedback').val();
    $.ajax({
        url: "functions/update_data.php",
        data: {
            id: id,
            department: department,
            date: date,
            quantity: quantity,
            itemname: itemname,
            section:section,
            description: description,
            purpose: purpose,
            feedback: feedback
        },
        type: 'POST',
        success: function(data) {
            var json = JSON.parse(data);
            var status = json.status;
            if (status == 'success') {
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

    $(document).on('click', '.editBtn', function(event) {
            var id = $(this).data('id');
            var trid = $(this).closest('tr').attr('minorjobid');
            document.getElementById("_renderedby").disabled = true;
            document.getElementById("_daterendered").disabled = true;
            document.getElementById("_confirmedby").disabled = true;
            document.getElementById("_dateconfirmed").disabled = true;
            document.getElementById("_step1").disabled = true;
            $('#_renderedby, #_daterendered, #_confirmedby, #_dateconfirmed, #_statustext, #_step1','#_renderedby','#_daterendered','#_confirmedby','#_dateconfirmed').prop('disabled', true);
            
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
            $('#_item').val(json.item);
            $('#_purpose').val(json.purpose);
            $('#_statustext').val(json.status);
            $('#_step1').val(json.bdstatus);
            $('#_renderedby').val(json.renderedby);
            $('#_daterendered').val(json.daterendered);
            $('#_confirmedby').val(json.confirmedby);
            $('#_dateconfirmed').val(json.dateconfirmed);
            var e = document.getElementById("_sect");
            var section = e.options[e.selectedIndex].text;
            e.options[e.selectedIndex].text = json.section;
            $('#_inputFeedback').val(json.feedback);
            $('#editMinorjreqmodal').modal('show');
            },
            error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
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
    $.ajax({
        url: "functions/step1approve.php",
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
                alert('Approved Successfully!');
               
                /*table = $('#datatable').DataTable();
                var button = '<a href="javascript:void();" data-id="' + id + '"  class="btn btn-sm btn-success btnDelete" >Approve</a> <a href= "javascript:void();" data-id="' + id + '" class ="btn btn-sm btn-info editBtn">More Info</a>';
                var row = table.row("[id='" + trid + "']");
                row.row("[id='" + trid + "']").data([department, date, button]);*/
                $('#_step1').val('Approved');
                $('#editMinorjreqmodal').modal('hide');
            } else { 
                alert('failed');
            }
        }
    });
    //alert('test');


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

            
                /*table = $('#datatable').DataTable();
                var button = '<a href="javascript:void();" data-id="' + id + '"  class="btn btn-sm btn-success btnDelete" >Approve</a> <a href= "javascript:void();" data-id="' + id + '" class ="btn btn-sm btn-info editBtn">More Info</a>';
                var row = table.row("[id='" + trid + "']");
                row.row("[id='" + trid + "']").data([department, date, button]);*/
                //$('#_itemdesc_').text('');
                $('#_step1').val('Declined');
                $('#_statustext').val('Declined');
                $('#editMinorjreqmodal').modal('hide');
            } else { 
                alert('failed');
            }
        }
        });
});

//steps decline end


