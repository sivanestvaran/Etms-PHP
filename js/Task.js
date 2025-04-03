var baseUrl = window.location.origin + '/etms/js/';

function TaskAllData() {

    $.ajax({
        type: "POST",
        url: baseUrl + "server/Task.php",
        data: 'set=getall',
        dataType: "json",
        success: function (response) {
            let no = 1;
            let rows = response.map((e) => {
                let content = `Start Date: ${e.startdate}<br>End Date: ${e.enddate}<br>Status: ${e.completeflag}`;

                let view = `<a tabindex='0' class='btn btn-sm btn-outline-warning' role='button' data-bs-toggle='tooltip' data-bs-placement='top' title='${content}'> <i class="fa-regular fa-eye"></i></a>`;

                let actionbtn = view + " <a class='btn btn-sm btn-outline-info btnEdit'> <i class='fa-regular fa-pen-to-square'></i></a>  <a class='btn btn-sm btn-outline-danger btnDelete'> <i class='fa-regular fa-trash-can'></i></a>";


                return "<tr><td><span class='d-none empid'>" + e.id + "</span>" + no++ + "</td><td>" + e.projname + "</td><td>" + e.taskname + "</td><td>" + e.tasktarget + "</td><td>" + actionbtn + "</td></tr>";
            }).join('');

            $('#tdata').empty();

            $('#tdata').append(rows);

            $('#tdata').removeClass('d-none').hide().fadeIn("slow");;

            // $('form')[0].reset();

             DataTable('#dataload').ajax.reload();
            $('[data-bs-toggle="tooltip"]').tooltip({
                html: true // Enable HTML content in tooltips
            });
        }
    });
}

function TaskGetRow(id, callback) {
    let passing = {
        id: id,
        set: 'getbyid'
    };
    $.ajax({
        type: "POST",
        url: baseUrl + "server/Task.php",
        data: passing,
        dataType: "json",
        success: function (response) {
            callback(response);
        }
    });
}

function ProjectTaskGetRow(id) {
    let passing = {
        id: id,
        set: 'getbyprojid'
    };
    $.ajax({
        type: "POST",
        url: baseUrl + "server/Task.php",
        data: passing,
        dataType: "json",
        success: function (response) {
            let no = 1;
            let rows = response[0].map((e) => {
               
                return "<tr><td>"+ no++ + "</td><td>" + e.taskname + "</td><td>" + e.completeflag + "</td></tr>";
            }).join('');

            $('#tdata').empty();

            $('#tdata').append(rows);

            $('#tdata').removeClass('d-none').hide().fadeIn("slow");

            $('#totaltask').text(no);
           
             let completetask = response[1][0].complete;
             let pendingtask = response[2][0].pending;
             let totalemployee = response[3][0].totemployee;
             let duration = parseInt(response[4]);
             console.log(totalemployee);
             $('#completetask').text(completetask);
             $('#pendingtask').text(pendingtask);
             $('#totalemployee').text(totalemployee);
             $('#duration').text(duration);



            // $('form')[0].reset();

            new DataTable('#dataload');
        }
    });
}

function TaskDeleteRow(id) {

    $.ajax({
        type: "POST",
        url: baseUrl + "server/Task.php",
        data: { id: id, set: 'taskdelete' },
        dataType: "json",
        success: function (response) {
            if (response.affected_rows == 1) {
                $('#alert').text('Data deleted sucessfully');
                $('#alert').removeClass('d-none');

                setTimeout(function () {
                    $('#alert').fadeOut();
                    $('#alert').text('Task succesfully added');
                }, 3000);
                TaskAllData();
            }
        }
    });
}

function FormSubmit(data) {
    // console.log(data + '&set=submit');
    $.ajax({
        type: "POST",
        url: baseUrl + "server/Task.php",
        data: data + '&set=submit',
        dataType: "json",
        success: function (response) {
            //console.log(response);
            if (response.affected_rows == 1) {
                $('#alert').removeClass('d-none');

                setTimeout(function () {
                    $('#alert').fadeOut();
                }, 3000);

                TaskAllData();


            }

        }
    });

}

function UpdateDate(empid, taskid, indication) {
    $.ajax({
        type: "POST",
        url: baseUrl + "server/Task.php",
        data: { taskid: taskid, set: 'updatedate', indication: indication },
        dataType: "json",
        success: function (response) {
            //console.log("test");
            if (response.affected_rows == 1) {

                alert("Date Updated Succesfully");

            } else {
                alert(response);
            }
            EmployeeTask(empid);
        }
    });
}

function EmployeeTask(empid) {
    $.ajax({
        type: "POST",
        url: baseUrl + "server/Task.php",
        data: { empid: empid, set: 'getemployeetask' },
        dataType: "json",
        success: function (response) {
            let rows = response.map((e) => {
                let btntext = '';
                if (e.startdate == '') {
                    btntext = "<button type='button' id='' class='btn btn-sm btn-outline-success btntask'>Start</button>";
                    leftdays = e.tasktarget;
                } else if (e.startdate != '' && e.enddate == '') {
                    btntext = "<button type='button' id='' class='btn btn-sm btn-outline-danger btntask'>Stop</button>";
                    let parts = e.startdate.split('-');
                    let day = parseInt(parts[0]);
                    let month = parseInt(parts[1]) - 1;
                    let year = parseInt(parts[2]);

                    let taskstartdate = new Date(year, month, day);
                    let today = new Date();
                    leftdays = Math.floor((today - taskstartdate) / (1000 * 3600 * 24));
                   
                } else {
                    btntext = "<button type='button' id='' class='btn btn-sm btn-outline-secondary btntask' disabled>Completed</button>";
                    leftdays = 0;
                }

                target = leftdays > e.tasktarget ? "<td class='text-danger'>" + leftdays + "</td>" : "<td class='text-success'>" + leftdays + "</td>";



                return "<tr><td>" + e.projname + "</td><td>" + e.taskname + "</td>" + target +"<td><span class='d-none taskid' id=''>" + e.id + "</span>" + btntext + "</td></tr>";

            }).join('');

            //console.log(rows);

            $('#tdata').empty();

            $('#tdata').append(rows);

            $('#tdata').removeClass('d-none').hide().fadeIn("slow");

            new DataTable('#dataload');
        }
    });
}