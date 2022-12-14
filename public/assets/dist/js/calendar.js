document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        scrollTime: '00:00', // undo default 6am scrollTime
        editable: false, // enable draggable events
        selectable: true,
        height: 650,
        aspectRatio: 1.8,
        headerToolbar: {
            left: 'prev,next',
            center: 'title',
            right: 'timeGridWeek,dayGridMonth,dayGridDay'
        },
        events: '{{route('get-all-appointments')}}',

        dateClick: function (info) {
            function tConvert(time) {
                // Check correct time format and split into components
                time = time.toString().match(/^([01]\d|2[0-3])(:)([0-5]\d)(:[0-5]\d)?$/) || [time];

                if (time.length > 1) { // If time format correct
                    time = time.slice(1);  // Remove full string match value
                    time[5] = +time[0] < 12 ? 'AM' : 'PM'; // Set AM/PM
                    time[0] = +time[0] % 12 || 12; // Adjust hours
                }
                return time.join(''); // return adjusted time or original string
            }

            var dd = info.date;
            var roleAdminRecep = "<?php echo auth()->user()->hasRole(['admin', 'recep']) ?>";
            var date = dd.toLocaleDateString('en-CA');
            $('#selected_date').html(date);
            $('#new_list').hide();
            $('#new_list').show();
            $('#no_list').empty();
            $.ajax({
                type: "GET",
                url: "{{url('/appointment/get-appointments-per-date?date=')}}" + date,
                dataType: 'json',
                success: function (response, textStatus, xhr) {
                    if (response == '') {
                        $('#new_list').empty();
                        $('#no_list').append('No Available Appointments')
                    } else {
                        $('#new_list').empty();
                        $('#no_list').empty();
                        for (let i = 0; i < response.length; i++) {
                            url = "{{route('prescriptions.create')}}" + "?date=" + response[i].date + "&patient_id=" + response[i].patient_id
                            link = "<a href=" + url + " class='btn btn-info btn-sm' title='Create Prescription'><i class='fas fa-file'></i></a>";
                            // if role is admin or receptionist show doctor name in appointments table else don't show doctor name in appointments table
                            if (roleAdminRecep == 1) {
                                $('#new_list').append(
                                    '<tr>' +
                                    '<td>' + response[i].id + '</td>' +
                                    '<td>' + response[i].patient_name + '</td>' +
                                    '<td>' + response[i].doctor_name + '</td>' +
                                    '<td>' + tConvert(response[i].time) + '</td>' +
                                    '</tr>'
                                );
                            } else {
                                $('#new_list').append(
                                    '<tr>' +
                                    '<td>' + response[i].id + '</td>' +
                                    '<td>' + response[i].patient_name + '</td>' +
                                    '<td>' + tConvert(response[i].time) + '</td>' +
                                    '<td>' +
                                    link
                                    + '</td>' +
                                    '</tr>'
                                );
                            }
                        }
                    }
                },
                error: function () {
                    console.log('Errors...Something went wrong!!!!');
                }
            });
        }
    });
    calendar.changeView('dayGridMonth');
    calendar.render();
});
