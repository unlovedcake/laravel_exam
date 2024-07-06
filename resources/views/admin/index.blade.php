<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

<style>
    .slow-animation-show {
        animation: swal2-show 1s;
    }

    .slow-animation-hide {
        animation: swal2-hide 1s;
    }

    /* .swal2-modal {
        background-color: rgba(63, 255, 106, 0.69) !important;
        border: 3px solid white;
        position: relative !important;
        top: 100px !important;
    } */
</style>


<div class="container">
    <div class="card mt-5">
        <h2 class="card-header"><i class="fa-regular fa-credit-card"></i> Laravel Exam</h2>
        <div class="card-body">
            <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-3">

                <button type="submit" name="action" value="add" class="btn btn-success btn-sm" href="javascript:void(0)" id="createNewUser"> <i class="fa fa-plus"></i> Create New User</button>
            </div>

            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th width="60px">No</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Contact No.</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th width="280px">Action</th>

                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

</div>




<!-- Modal Edit -->
<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="userForm" name="userForm" class="form-horizontal">
                    <input type="hidden" name="user_id" id="user_id">
                    @csrf

                    <div class="alert alert-danger print-error-msg" style="display:none">
                        <ul></ul>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-3 control-label">First Name:</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="firstName" name="firstName" placeholder="First Name" value="" maxlength="50">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-3 control-label">Last Name:</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Last Name" value="" maxlength="50">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-3 control-label">Contact No.:</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="contactNumber" name="contactNumber" placeholder="Contact No." value="" maxlength="50">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Age:</label>
                        <div class="col-sm-12">
                            <input type="number" id="age" name="age" placeholder="Enter price" class="form-control"></input>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Gender:</label>
                        <div class="col-sm-12">
                            <select class="block mt-1 w-full" id="genderSelect" name="gender">
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Email:</label>
                            <div class="col-sm-12">
                                <input type="email" id="email" name="email" placeholder="Enter email" class="form-control"></input>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Password:</label>
                            <div class="col-sm-12">
                                <input type="password" id="password" name="password" placeholder="Enter password" class="form-control"></input>
                            </div>
                        </div>
                    </div>



                    <div class="form-group">
                        <div class="col-sm-12">
                            <button type="submit" class="col-sm-12 btn btn-success mt-2" id="saveBtn" value="create"><i class="fa fa-save"></i> Submit
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="showModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"><i class="fa-regular fa-eye"></i> Show User Info</h4>
            </div>
            <div class="modal-body">

                <p><strong>First Name:</strong> <span class="first-name"></span></p>
                <p><strong>Last Name:</strong> <span class="last-name"></span></p>
                <div class="mt-2" id="avatar">

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include jQuery and Toastr JS -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>




<script type="module">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.index') }}",
        columns: [{
                data: 'id',
                name: 'id'
            },

            {
                data: 'firstName',
                name: 'firstName'
            },
            {
                data: 'lastName',
                name: 'lastName'
            },
            {
                data: 'contactNumber',
                name: 'contactNumber'
            },
            {
                data: 'age',
                name: 'age'
            },
            {
                data: 'gender',
                name: 'gender'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ]
    });

    $('#createNewUser').click(function() {
        index();
    });



    $('body').on('click', '.showUser', function() {

        var user_id = $(this).data('id');

        showUser(user_id, "{{ route('admin.index') }}");

    });

    $('body').on('click', '.editUser', function() {
        var user_id = $(this).data('id');


        editUser(user_id, "{{ route('admin.index') }}");

    });

    $('#userForm').submit(function(e) {
        e.preventDefault();
        let formData = new FormData(this);

        store(formData, "{{ route('admin.store') }}", table);



    });

    $('body').on('click', '.deleteUser', function() {

        var user_id = $(this).data("id");

        deleteUser(user_id, "{{ route('admin.store') }}", table);


    });
</script>

<script type="text/javascript">
    $(function() {

        /*------------------------------------------
         --------------------------------------------
         Pass Header Token
         --------------------------------------------
         --------------------------------------------*/
        // $.ajaxSetup({
        //     headers: {
        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //     }
        // });

        /*------------------------------------------
        --------------------------------------------
        Render DataTable
        --------------------------------------------
        --------------------------------------------*/
        // var table = $('.data-table').DataTable({
        //     processing: true,
        //     serverSide: true,
        //     ajax: "{{ route('admin.index') }}",
        //     columns: [{
        //             data: 'id',
        //             name: 'id'
        //         },

        //         {
        //             data: 'firstName',
        //             name: 'firstName'
        //         },
        //         {
        //             data: 'lastName',
        //             name: 'lastName'
        //         },
        //         {
        //             data: 'contactNumber',
        //             name: 'contactNumber'
        //         },
        //         {
        //             data: 'age',
        //             name: 'age'
        //         },
        //         {
        //             data: 'gender',
        //             name: 'gender'
        //         },
        //         {
        //             data: 'action',
        //             name: 'action',
        //             orderable: false,
        //             searchable: false
        //         },
        //     ]
        // });

        /*------------------------------------------
        --------------------------------------------
        Click to Button
        --------------------------------------------
        --------------------------------------------*/
        // $('#createNewUser').click(function() {
        //     $('#saveBtn').val("create-user");
        //     $('#user_id').val('');
        //     $('#userForm').trigger("reset");
        //     $('#modelHeading').html("<i class='fa fa-plus'></i> Create New User");
        //     $('#saveBtn').html('Submit')
        //     $('#ajaxModel').modal('show');
        // });

        /*------------------------------------------
        --------------------------------------------
        Click to Edit Button
        --------------------------------------------
        --------------------------------------------*/
        // $('body').on('click', '.showUser', function() {
        //     var user_id = $(this).data('id');
        //     $.get("{{ route('admin.index') }}" + '/' + user_id, function(data) {
        //         $('#showModel').modal('show');

        //         $('.first-name').text(data.firstName);
        //         $('.last-name').text(data.lastName);

        //     })
        // });

        /*------------------------------------------
        --------------------------------------------
        Click to Edit Button
        --------------------------------------------
        --------------------------------------------*/
        // $('body').on('click', '.editUser', function() {
        //     var user_id = $(this).data('id');
        //     $.get("{{ route('admin.index') }}" + '/' + user_id + '/edit', function(data) {
        //         $('#modelHeading').html("<i class='fa-regular fa-pen-to-square'></i> Edit User");
        //         $('#saveBtn').val("edit-user");

        //         $('#ajaxModel').modal('show');
        //         $('#user_id').val(data.id);
        //         $('#firstName').val(data.firstName);
        //         $('#lastName').val(data.lastName);
        //         $('#contactNumber').val(data.contactNumber);
        //         $('#age').val(data.age);
        //         $('#gender').val(data.gender);
        //         $('#email').val(data.email);
        //         $('#password').val(data.password);
        //         $('#saveBtn').html('Save Changes')
        //     })
        // });

        // $('#userForm').submit(function(e) {
        //     e.preventDefault();

        //     let formData = new FormData(this);

        //     if ($('#saveBtn').text() === 'Save Changes') {
        //         $('#saveBtn').html('Updating...');
        //     } else {
        //         $('#saveBtn').html('Sending...');
        //     }

        //     toastr.options = {
        //         "closeButton": true,
        //         "debug": false,
        //         "newestOnTop": true,
        //         "progressBar": true,
        //         "positionClass": "toast-top-center",
        //         "preventDuplicates": true,
        //         "onclick": null,
        //         "showDuration": "300",
        //         "hideDuration": "1000",
        //         "timeOut": "3000",
        //         "extendedTimeOut": "1000",
        //         "showEasing": "swing",
        //         "hideEasing": "linear",
        //         "showMethod": "fadeIn",
        //         "hideMethod": "fadeOut"
        //     };

        //     $.ajax({
        //         type: 'POST',
        //         url: "{{ route('admin.store') }}",
        //         data: formData,
        //         contentType: false,
        //         processData: false,
        //         success: (response) => {

        //             if ($('#saveBtn').text() === 'Updating...') {
        //                 toastr.success('Successfully Updated');
        //                 console.log('Successfully Updated');
        //             } else {
        //                 toastr.success(response.message);
        //                 console.log('Successfully Added');
        //                 console.log($('#saveBtn').text());
        //             }



        //             $('#saveBtn').html('Submit');
        //             $('#userForm').trigger("reset");
        //             $('#ajaxModel').modal('hide');
        //             table.draw();


        //             $(".print-error-msg").css('display', 'none')

        //         },
        //         error: function(response) {

        //             if (response.status === 422) {
        //                 let errors = response.responseJSON.errors;

        //                 $.each(errors, function(key, value) {


        //                     toastr.error(value[0]);
        //                 });

        //             }
        //             $('#saveBtn').html('Submit');
        //             $('#userForm').find(".print-error-msg").find("ul").html('');
        //             $('#userForm').find(".print-error-msg").css('display', 'block');
        //             $.each(response.responseJSON.errors, function(key, value) {
        //                 $('#userForm').find(".print-error-msg").find("ul").append('<li>' + value + '</li>');
        //             });
        //         }
        //     });

        // });


        // $('body').on('click', '.deleteUser', function() {

        //     var user_id = $(this).data("id");
        //     confirm("Are You sure want to delete?");

        //     $.ajax({
        //         type: "DELETE",
        //         url: "{{ route('admin.store') }}" + '/' + user_id,
        //         success: function(data) {
        //             table.draw();
        //         },
        //         error: function(data) {
        //             console.log('Error:', data);
        //         }
        //     });
        // });

    });
</script>