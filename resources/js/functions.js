

export function index() {
    $('#saveBtn').val("create-user");
    $('#user_id').val('');
    $('#userForm').trigger("reset");
    $('#modelHeading').html("<i class='fa fa-plus'></i> Create New User");
    $('#saveBtn').html('Submit')
    $('#ajaxModel').modal('show');
}

export function store(formData,url, table) {
 

        if ($('#saveBtn').text() === 'Save Changes') {
            $('#saveBtn').html('Updating...');
        } else {
            $('#saveBtn').html('Sending...');
        }

        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-center",
            "preventDuplicates": true,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "3000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            contentType: false,
            processData: false,
            success: (response) => {

                if ($('#saveBtn').text() === 'Updating...') {
                    toastr.success('Successfully Updated');
                    console.log('Successfully Updated');
                    $('#saveBtn').html('Save Changes');
                } else {
                    toastr.success(response.message);
                    console.log('Successfully Added');
                    $('#saveBtn').html('Submit');
                    console.log($('#saveBtn').text());
                }



               
                $('#userForm').trigger("reset");
                $('#ajaxModel').modal('hide');
                table.draw();


                $(".print-error-msg").css('display', 'none')

            },
            error: function(response) {

                if (response.status === 422) {
                    let errors = response.responseJSON.errors;

                    $.each(errors, function(key, value) {


                        toastr.error(value[0]);
                    });

                }
                $('#saveBtn').html('Submit');
                $('#userForm').find(".print-error-msg").find("ul").html('');
                $('#userForm').find(".print-error-msg").css('display', 'block');
                $.each(response.responseJSON.errors, function(key, value) {
                    $('#userForm').find(".print-error-msg").find("ul").append('<li>' + value + '</li>');
                });
            }
        });
}
    

export function showUser(user_id,url) {

console.log(user_id);
console.log(url);
$.get(url + '/' + user_id, function(data) {
    $('#showModel').modal('show');

    $('.first-name').text(data.firstName);
    $('.last-name').text(data.lastName);

})
}

export function editUser(user_id,url) {
$.get(url + '/' + user_id + '/edit', function(data) {
    $('#modelHeading').html("<i class='fa-regular fa-pen-to-square'></i> Edit User");
    $('#saveBtn').val("edit-user");

    $('#ajaxModel').modal('show');
    $('#user_id').val(data.id);
    $('#firstName').val(data.firstName);
    $('#lastName').val(data.lastName);
    $('#contactNumber').val(data.contactNumber);
    $('#age').val(data.age);
    $('#gender').val(data.gender);
    $('#email').val(data.email);
    $('#password').val(data.password);
    $('#saveBtn').html('Save Changes')
})
}

export function deleteUser(user_id,url, table) {

        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!',
          showClass: {
            popup: 'slow-animation-show'
          },
          hideClass: {
            popup: 'slow-animation-hide'
          }
          

        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
                url: url + '/' + user_id,
                type: "DELETE",
           
              success: function(response) {
                console.log(response);
                Swal.fire(
                  'Deleted!',
                  'Your file has been deleted.',
                  'success'
                )
                table.draw();
              }
            });
          }
        })
        
// $.ajax({
//     type: "DELETE",
//     url: url + '/' + user_id,
//     success: function(data) {
//         table.draw();
//     },
//     error: function(data) {
//         console.log('Error:', data);
//     }
// });
}


