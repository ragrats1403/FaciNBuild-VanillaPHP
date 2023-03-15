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
    event.preventDefault();
    var department = $('#department').val();
    var date = $('#datemajorjr').val();
    var quantity = $('#_quantity_').val();
    var itemname = $('#_item_').val();
    var description = $('#_itemdesc_').val();
    var purpose = $('#_purpose_').val();

    var e = document.getElementById("sect");
    var section = e.options[e.selectedIndex].text;
    /*var renderedby = $('#renderedby').val();
    var daterendered = $('#daterendered').val();
    var confirmedby = $('#confirmedby').val();
    var dateconfirmed = $('#dateconfirmed').val();*/
    if (department != '' && date != '' && quantity != '' && itemname != '' && description != '' && purpose != '' && section != '') {
        $.ajax({
            url: "functions/add_data.php",
            data: {
                department: department,
                date: date,
                quantity: quantity,
                itemname: itemname,
                description: description,
                purpose: purpose,
                section: section
                
                
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
//testbutton 
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
    $.ajax({
        url: "functions/get_request_details.php",
        data: {
            id: id
        },
        type: 'POST',
        success: function(data) {
            var json = JSON.parse(data);
            //var itemwdesc = json.item + json.item_desc;
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
            var e = document.getElementById("_sect");
            var section = e.options[e.selectedIndex].text;

            e.options[e.selectedIndex].text = json.section;
            $('#_inputFeedback').val(json.feedback);
            $('#editMinorjreqmodal').modal('show');

            //$('#_datemajorjr').val(json.datesubmitted);
            $('').val();
            $('').val();
            $('').val();
            $('').val();
            $('').val();

            /*$('#_inputName').val(json.name)
            $('#_inputUsername').val(json.username);
            $('#_inputPassword').val(json.password);
            $('#_inputRoleLevel').val(json.rolelevel);
            $('#_inputRoleID').val(json.roleid);*/
            
        }
    });
});

$(document).on('submit', '#updateUserForm', function() {
    var id = $('#id').val();
    var trid = $('#trid').val();
    var department = $('#department').val();
    var date = $('#datemajorjr').val();
    var quantity = $('#_quantity_').val();
    var itemname = $('#_item_').val();
    var description = $('#_itemdesc_').val();
    var purpose = $('#_purpose_').val();
    var feedback = $('#_inputFeedback').val();
    $.ajax({
        url: "functions/update_data.php",
        data: {
            id: id,
            department: department,
            date: date,
            quantity: quantity,
            itemname: itemname,
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