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
    /*var renderedby = $('#renderedby').val();
    var daterendered = $('#daterendered').val();
    var confirmedby = $('#confirmedby').val();
    var dateconfirmed = $('#dateconfirmed').val();*/
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
                    $('#addUserModal').modal('hide');
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
    if (confirm('Are you sure to delete this user?')) {


        $.ajax({
            url: "functions/delete_user.php",
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
    var name = $('#_inputName').val();
    var username = $('#_inputUsername').val();
    var password = $('#_inputPassword').val();
    var rolelevel = $('#_inputRoleLevel').val();
    var roleid = $('#_inputRoleID').val();
    var feedback = $('#_inputFeedback').val();
    $.ajax({
        url: "functions/update_data.php",
        data: {
            id: id,
            name: name,
            username: username,
            password: password,
            rolelevel: rolelevel,
            roleid: roleid
        },
        type: 'POST',
        success: function(data) {
            var json = JSON.parse(data);
            status = json.status;
            if (status == 'success') {
                alert('Updated Successfully!');
                table = $('#datatable').DataTable();
                var button = '<a href="javascript:void();" class="btn btn-sm btn-info" data-id="' + id + '" >Edit</a> <a href="javascript:void();" class="btn btn-sm btn-danger" data-id="' + id + '" >Delete</a>';
                var row = table.row("[id='" + trid + "']");
                row.row("[id='" + trid + "']").data([id, name, username, password, rolelevel, roleid, button]);
                $('#editUserModal').modal('hide');
            } else { 
                alert('failed');
            }
        }
    });
});