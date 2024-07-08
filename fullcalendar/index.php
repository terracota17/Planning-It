<!DOCTYPE html>
<html>

<head>
<link rel="stylesheet" href="../css/fullcalendar.min.css" />
<script src="../js/jquery.min.js"></script>
<script src="../js/moment.min.js"></script>
<script src="../js/fullcalendar.min.js"></script>

<script>

$(document).ready(function () {
    var calendar = $('#calendar').fullCalendar({
        editable: true,
        events: "../fullcalendar/fetchevent.php",
        displayEventTime: false,
        eventRender: function (event, element, view) {
            if (event.allDay === 'true') {
                event.allDay = true;
            } else {
                event.allDay = false;
            }
        },
        selectable: true,
        selectHelper: true,
        select: function (start, end, allDay) {
            var title = prompt('Event Title:');

            if (title) {
                var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
                var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");

                $.ajax({
                    url: '../fullcalendar/addevent.php',
                    data: 'title=' + title + '&start=' + start + '&end=' + end,
                    type: "POST",
                    success: function (data) {
                        displayMessage("Added Successfully");
                    }
                });
                calendar.fullCalendar('renderEvent',
                        {
                            title: title,
                            start: start,
                            end: end,
                            allDay: allDay
                        },
                true
                        );
            }
            calendar.fullCalendar('unselect');
        },
        
        editable: true,
        eventDrop: function (event, delta) {
                    var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
                    var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
                   var parametros = { "id" : event.id  , "start" :start  , "end" : end };
                    $.ajax({
                        url: '../fullcalendar/edit-event.php',
                        data: 'title=' + event.title + '&start=' + start + '&end=' + end + '&id=' + event.id,
                        type: "POST",
                        url: '../fullcalendar/edit-event.php',
                        data:  parametros,
                        success: function (response) {

                            displayMessage("Evento Editado");
                        }
                    });
                },
        eventClick: function (event) {
            var deleteMsg = confirm("¿De verdad quieres eliminar ese evento");
            if (deleteMsg) {
               var idd = event.id;
                var parametros = { "id" : idd };
                $.ajax({
                    type: "POST",
                    url: "../fullcalendar/delete-event.php",
                    data: parametros,
                    success: function (response) {
                        if(parseInt(response) > 0) {
                            $('#calendar').fullCalendar('removeEvents', event.id);
                            displayMessage("Evento Eliminado");
                        }
                    }
                });
            }
        }

    });
});

function displayMessage(message) {
	    $(".response").html("<div class='success'>"+message+"</div>");
    setInterval(function() { $(".success").fadeOut(); }, 1000);
}

</script>


</head>
<body>
    <link rel="stylesheet" type="text/css" href="../css/estilo.css" />
    <link rel="stylesheet" type="text/css" href="../css/all.min.css" />
    <?php
        require ('../includes/vistas/comun/cabeceraArea.php');        
    ?>
    <h1 style = "text-align:center;"> Calendario de Eventos</h1>
    <div class="response"></div>
    <div id='calendar'></div>
</body>

</html>