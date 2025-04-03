var baseUrl = window.location.origin + '/etms/js/';

function EmpAllData() {

    $.ajax({
        type: "POST",
        url: baseUrl + "server/Employee.php",
        data: 'set=getall',
        dataType: "json",
        success: function (response) {
            let no = 1;
            let rows = response.map((e) => {
                let content = `Name: ${e.empname}<br>Emp No: ${e.empno}<br>Position: ${e.empposition}<br>Role: ${e.emprole}<br>Email: ${e.email}`;

                let view = `<a tabindex='0' class='btn btn-sm btn-outline-warning' role='button' data-bs-toggle='tooltip' data-bs-placement='top' title='${content}'> <i class="fa-regular fa-eye"></i></a>`;

                let actionbtn = view + " <a class='btn btn-sm btn-outline-info btnEdit'> <i class='fa-regular fa-pen-to-square'></i></a>  <a class='btn btn-sm btn-outline-danger btnDelete'> <i class='fa-regular fa-trash-can'></i></a>";
        
                
                return "<tr><td><span class='d-none empid'>" + e.id + "</span>" + no++ + "</td><td>" + e.empname + "</td><td>" + e.empno + "</td><td>" + e.empposition + "</td><td>" + e.email + "</td><td>" + actionbtn + "</td></tr>";
            }).join('');

            $('#tdata').empty();

            $('#tdata').append(rows);

            $('#tdata').removeClass('d-none').hide().fadeIn("slow");;

           // $('form')[0].reset();

            new DataTable('#dataload').ajax.reload();
            $('[data-bs-toggle="tooltip"]').tooltip({
                html: true // Enable HTML content in tooltips
            });
        }
    });
}

function EmpGetRow(id, callback) {
    let passing = {
        id: id,
        set: 'getbyid'
    };
    $.ajax({
        type: "POST",
        url: baseUrl + "server/Employee.php",
        data: passing,
        dataType: "json",
        success: function (response) {
            callback(response);
        }
    });
}

function EmpDeleteRow(id) {

    $.ajax({
        type: "POST",
        url: baseUrl + "server/Employee.php",
        data: { id: id, set:'empdelete'},
        dataType: "json",
        success: function (response) {
            if (response.affected_rows == 1) {
              $('#alert').text('Data deleted sucessfully');
              $('#alert').removeClass('d-none');

                setTimeout(function () {
                    $('#alert').fadeOut();
                    $('#alert').text('Employee succesfully added');
                }, 3000);
                EmpAllData();
            }
        }
    });
}

function FormSubmit(data) {
    // console.log(data + '&set=submit');
    $.ajax({
        type: "POST",
        url: baseUrl + "server/Employee.php",
        data: data + '&set=submit',
        dataType: "json",
        success: function (response) {
            //console.log(response);
            if (response.affected_rows == 1) {
                $('#alert').removeClass('d-none');

                setTimeout(function () {
                    $('#alert').fadeOut();
                }, 3000);

                EmpAllData();
                

            }
            
        }
    });
}