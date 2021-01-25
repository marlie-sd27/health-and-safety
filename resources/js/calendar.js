import {Calendar} from '@fullcalendar/core';
import interactionPlugin from '@fullcalendar/interaction';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from '@fullcalendar/list';

document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar')

    // var eventSources = [
    //     {
    //         url: '/api/calendar/allDeadlines',
    //         headers: {'Authorization': "Bearer DcIimzp3M2118X2flCHuN1ybn9Au3uRIlaKLJdjSXL8uuO1Af4GZNupppWnv"}
    //     }
    // ];


    var calendar = new Calendar(calendarEl, {
        plugins: [interactionPlugin, dayGridPlugin, timeGridPlugin, listPlugin],
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,listMonth'
        },
        initialDate: new Date(),
        navLinks: true, // can click day/week names to navigate views
        editable: true,
        eventSources:
            [
            {
                url: '/calendar/deadlines',
            },
            {
                url: '/training/ajax',
                color: '#8149d9',
            }
        ],
    });

    calendar.render();
});
