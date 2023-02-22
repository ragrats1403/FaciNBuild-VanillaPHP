<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.1/datatables.min.css" />



    <title>Faci N Build</title>
</head>

<body>
    <h1 class="text-center">Faci N Build Test table control</h1>
    <div class="container-fluid">
        <div class="row">
            <div class="container">
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <button type="button" class="btn btn-primary" style="margin-bottom:40px;" data-bs-toggle="modal" data-bs-target="#addUserModal">Add User</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <table id="datatable" class="table">
                            <thead>
                                <th>Sno.</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>City</th>
                                <th>Options</th>

                            </thead>
                            <tbody>
                                <tr>
                                    <!---
                                    <td>1</td>
                                    <td>Rajesh</td>
                                    <td>raj@gmail.com</td>
                                    <td>131131231</td>
                                    <td>Mumbai</td>
                                    <td><a class="btn ">Edit</a><a href="">Delete</a></td>
                                    -->

                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-2"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.1/datatables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
        $('#datatable').DataTable({
            'serverSide': true,
            'processing': true,
            'paging': true,
            'order': [],
            'ajax': {
                'url': 'fetch_data.php',
                'type': 'post',

            },
            'fnCreatedRow': function(nRow, aData, iDataIndex) {
                $(nRow).attr('id', aData[0]);
            },
            'columnDefs': [{
                'target': [0, 5],
                'orderable': false,
            }]

        });
    </script>
    <script type="text/javascript">
        //add button control
        $(document).on('submit', '#saveUserForm', function(event) {
            event.preventDefault();
            var name = $('#inputUsername').val();
            var email = $('#inputEmail').val();
            var mobile = $('#inputMobile').val();
            var city = $('#inputCity').val();
            if (name != '' && email != '' && mobile != '' && city != '') {
                $.ajax({
                    url: "add_user.php",
                    data: {
                        name: name,
                        email: email,
                        mobile: mobile,
                        city: city
                    },
                    type: 'POST',
                    success: function(data) {
                        var json = JSON.parse(data);
                        status = json.status;
                        if (status = 'success') {
                            table = $('#datatable').DataTable();
                            table.draw();
                            alert('Successfully Added User!');
                            $('#inputUsername').val('');
                            $('#inputEmail').val('');
                            $('#inputMobile').val('');
                            $('#inputCity').val('');
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
                    url: "delete_user.php",
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
            var trid = $(this).closest('tr').attr('id');
            $.ajax({
                url: "get_single_user.php",
                data: {
                    id: id
                },
                type: 'POST',
                success: function(data) {
                    var json = JSON.parse(data);
                    $('#id').val(json.id);
                    $('#trid').val(trid);
                    $('#_inputUsername').val(json.username);
                    $('#_inputEmail').val(json.email);
                    $('#_inputMobile').val(json.mobile);
                    $('#_inputCity').val(json.city);
                    $('#editUserModal').modal('show');
                }
            });
        });

        $(document).on('submit', '#updateUserForm', function() {
            var id = $('#id').val();
            var trid = $('#trid').val();
            var username = $('#_inputUsername').val();
            var email = $('#_inputEmail').val();
            var mobile = $('#_inputMobile').val();
            var city = $('#_inputCity').val();
            $.ajax({
                url: "update_user.php",
                data: {
                    id: id,
                    username: username,
                    email: email,
                    mobile: mobile,
                    city: city
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
                        row.row("[id='" + trid + "']").data([id, username, email, mobile, city, button]);
                        $('#editUserModal').modal('hide');
                    } else {
                        alert('failed');
                    }
                }
            });
        });
    </script>

    <!-- add user modal-->
    <!-- Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="saveUserForm" action="javascript:void();" method="POST">
                        <div class="modal-body">
                            <!-- Form Controls-->
                            <div class="mb-3 row">
                                <label for="inputUsername" class="col-sm-2 col-form-label">Username</label>
                                <div class="col-sm-10">
                                    <input type="text" name="inputUsername" class="form-control" id="inputUsername">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputEmail" name="inputEmail">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputMobile" class="col-sm-2 col-form-label">Mobile</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputMobile" name="inputMobile">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputCity" class="col-sm-2 col-form-label">City</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputCity" name="inputCity">
                                </div>
                            </div>
                            <h3>Please select Equipments:</h3>
                            <div class="row-fluid">
                                <div class="checkbox inline">
                                    <input type="checkbox" name="values" value="Sepak Bola"> Table <br>
                                    <input type="checkbox" name="values" value="Membaca"> Test <br>
                                    <input type="checkbox" name="values" value="Menulis"> Test <br>
                                    <input type="checkbox" name="values" value="Memancing"> Test <br>
                                    <input type="checkbox" name="values" value="Sepak Bola"> Test <br>
                                    <input type="checkbox" name="values" value="Membaca"> Test <br>
                                    <input type="checkbox" name="values" value="Menulis"> Test <br>
                                    <input type="checkbox" name="values" value="Memancing"> Test <br>
                                    <input type="checkbox" name="values" value="Sepak Bola"> Test <br>
                                    <input type="checkbox" name="values" value="Membaca"> Test <br>
                                    <input type="checkbox" name="values" value="Menulis"> Test <br>
                                    <input type="checkbox" name="values" value="Memancing"> Test <br>
                                </div>
                            </div>
                            <!-- Form Controls End-->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- add user modal end-->
    <!-- edit user modal-->
    <!-- Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="updateUserForm" action="javascript:void();" method="POST">
                        <div class="modal-body">
                            <input type="hidden" id="id" name="id" value="">
                            <input type="hidden" id="trid" name="trid" value="">
                            <!-- Form Controls-->
                            <div class="mb-3 row">
                                <label for="inputUsername" class="col-sm-2 col-form-label">Username</label>
                                <div class="col-sm-10">
                                    <input type="text" name="_inputUsername" class="form-control" id="_inputUsername">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="_inputEmail" name="_inputEmail">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputMobile" class="col-sm-2 col-form-label">Mobile</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="_inputMobile" name="_inputMobile">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputCity" class="col-sm-2 col-form-label">City</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="_inputCity" name="_inputCity">
                                </div>
                            </div>
                            <!-- Form Controls End-->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- edit user modal end-->
</body>

</html>