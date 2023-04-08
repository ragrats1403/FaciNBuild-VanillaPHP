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
            $('#_renderedby, #_daterendered, #_confirmedby, #_dateconfirmed, #_statustext, #_step1').prop('disabled', true);
            $('#_daterendered, #_dateconfirmed').val('');
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
    $.ajax({
        url: "functions/step1approve.php",
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
    $.ajax({
        url: "functions/step1decline.php",
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
                $('#editMinorjreqmodal').modal('hide');
            } else { 
                alert('failed');
            }
        }
        });
});

//steps decline end


