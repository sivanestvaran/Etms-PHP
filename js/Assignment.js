var baseUrl = window.location.origin + '/etms/js/';



function AssignGetRow(id, callback) {
    let passing = {
        id: id,
        set: 'getbyid'
    };
    $.ajax({
        type: "POST",
        url: baseUrl + "server/Assignment.php",
        data: passing,
        dataType: "json",
        success: function (response) {
            callback(response);
        }
    });
}


function FormSubmit(data) {
    // console.log(data + '&set=submit');
    $.ajax({
        type: "POST",
        url: baseUrl + "server/Assignment.php",
        data: data + '&set=submit',
        dataType: "json",
        success: function (response) {
            //console.log(response);
            if (response.affected_rows == 1) {
                $('#alert').removeClass('d-none');

                setTimeout(function () {
                    $('#alert').fadeOut();
                }, 3000);

              
                

            }
            
        }
    });
}