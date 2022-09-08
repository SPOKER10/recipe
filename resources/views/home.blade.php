@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <section class="ftco-section">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-md-6 text-center mb-5">
                                    <h2 class="heading-section">Make an appointment</h2>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="content w-100">
                                        <div class="calendar-container">
                                          <div class="calendar"> 
                                            <div class="year-header"> 
                                              <span class="left-button fa fa-chevron-left" id="prev"> </span> 
                                              <span class="year" id="label"></span> 
                                              <span class="right-button fa fa-chevron-right" id="next"> </span>
                                            </div> 
                                            <table class="months-table w-100"> 
                                              <tbody>
                                                <tr class="months-row">
                                                  <td class="month">Jan</td> 
                                                  <td class="month">Feb</td> 
                                                  <td class="month">Mar</td> 
                                                  <td class="month">Apr</td> 
                                                  <td class="month">May</td> 
                                                  <td class="month">Jun</td> 
                                                  <td class="month">Jul</td>
                                                  <td class="month">Aug</td> 
                                                  <td class="month">Sep</td> 
                                                  <td class="month">Oct</td>          
                                                  <td class="month">Nov</td>
                                                  <td class="month">Dec</td>
                                                </tr>
                                              </tbody>
                                            </table> 
                                            
                                            <table class="days-table w-100"> 
                                              <td class="day">Sun</td> 
                                              <td class="day">Mon</td> 
                                              <td class="day">Tue</td> 
                                              <td class="day">Wed</td> 
                                              <td class="day">Thu</td> 
                                              <td class="day">Fri</td> 
                                              <td class="day">Sat</td>
                                            </table> 
                                            <div class="frame"> 
                                              <table class="dates-table w-100"> 
                                              <tbody class="tbody">             
                                              </tbody> 
                                              </table>
                                            </div> 
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">MAKE</button>
                                          </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- MODAL -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Select appointment hour</h5>
                              </div>
                              <div class="modal-body">
                                <form>
                                <img src="{{ asset('img/consultants.png') }}" width="200" style="display: block;margin-left: auto;margin-right: auto;">
                                <br/>Availability Program: <b>Monday to Friday</b>, <b>9:00-13:00</b>, <b>15:30-21:00</b>.
                                <hr>
                                  <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label">PLEASE ENTER HOUR:</label>
                                    <br/><small>Exemple: <b>12:00</b></small>
                                    <input type="text" class="form-control" id="hour">
                                  </div>
                                </form>
                              </div>
                                <div id="alert" class="alert alert-danger" role="alert" style="display:none;">
                                  Invalid hour format! Please re-enter the hour!
                                </div>
                                <div id="alert2" class="alert alert-danger" role="alert" style="display:none;">
                                  Internal error, please try again later!
                                </div>
                                <div id="alert3" class="alert alert-danger" role="alert" style="display:none;">
                                  The consultants are available from Monday to Friday, 9:00-13:00, 15:30-21:00!
                                </div>
                                <div id="alert4" class="alert alert-danger" role="alert" style="display:none;">
                                  This hour is not available, please choose another hour!
                                </div>
                              <div class="modal-footer">
                                <button id="sendBTN" onClick="sendApp()" type="button" class="btn btn-primary">Send appointment</button>
                              </div>
                            </div>
                          </div>
                        </div>
                    </section>
                </div>

                <hr>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <b>Last Appointments</b>
                    <table class="table">
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col"><i class="fa fa-child"></i> Name</th>
                          <th scope="col"><i class="fa fa-clock-o"></i> Start Date</th>
                          <th scope="col"><i class="fa fa-clock-o"></i> End Date</th>
                          <th scope="col"><i class="fa fa-gavel"></i> Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        @isset($apps)
                            @foreach($apps as $a)
                                <tr>
                                    <th scope="row">{{ $a->id }}</th>
                                    <td>{{ $a->user_name }}</td>
                                    <td>{{ date('d-m-Y H:i', strtotime($a->start_date)) }}</td>
                                    <td>{{ date('d-m-Y H:i', strtotime($a->end_date)) }}</td>
                                    <td>
                                        @if(date('d-m-Y H:i') < date('d-m-Y H:i', strtotime($a->end_date)))
                                            <span class="badge bg-warning text-dark">In Pending...</span>
                                        @else
                                            <span class="badge bg-success text-dark">Done</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endisset
                      </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script src="{{ asset('js/jquery.min.js') }}"></script>
<script>

var currentDate = new Date().toLocaleDateString();
var currentDate2 = new Date();

var days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

function validateHhMm(inputField) {
    var isValid = /^([0-1]?[0-9]|2[0-4]):([0-5][0-9])(:[0-5][0-9])?$/.test(inputField);
    return isValid;
}

function getDayName(date = new Date(), locale = 'en-US') {
  return date.toLocaleDateString(locale, {weekday: 'long'});
}

function sendApp() {
    var hour = document.getElementById('hour');
    var hour_replace = hour.value.replace(':', '');
    var dayName = getDayName(new Date(currentDate));
    
    if(!validateHhMm(hour.value)) document.getElementById("alert").style.display = "inline"; 
    else if(dayName == "Saturday" || dayName == "Sunday" || (hour_replace < "0900" || (hour_replace > "1200" && hour_replace < "1530"))
        || ((hour_replace < "1530" && hour_replace > "1200") || (hour_replace > "2000"))) {
        document.getElementById("alert3").style.display = "inline";
        setInterval(hideInternError3, 3000);
    }
    else {
        document.getElementById("alert").style.display = "none";
        document.getElementById("sendBTN").disabled = true;

        $.ajax({
            data: {'date': currentDate+' '+hour.value, "_token": "{{ csrf_token() }}",},
            url: "{{ route("postAppointment") }}",
            type: "POST",
            success: function (data) {
                if(data == false) {
                    document.getElementById("sendBTN").disabled = false;
                    document.getElementById("alert4").style.display = "inline";
                    setInterval(hideInternError4, 3000);
                }
                else document.location.reload(true);
            },
            error: function () {
                document.getElementById("sendBTN").disabled = false;

                document.getElementById("alert2").style.display = "inline"; 
                setInterval(hideInternError2, 3000);
            }
        });
    }
}

function hideInternError() {
  document.getElementById("alert2").style.display = "none"; 
} 
function hideInternError3() {
  document.getElementById("alert3").style.display = "none"; 
} 
function hideInternError4() {
  document.getElementById("alert4").style.display = "none"; 
} 

(function($) {

"use strict";

$(document).ready(function(){
    var date = new Date();
    var today = date.getDate();
    // Set click handlers for DOM elements
    $(".right-button").click({date: date}, next_year);
    $(".left-button").click({date: date}, prev_year);
    $(".month").click({date: date}, month_click);
    $("#add-button").click({date: date}, new_event);
    // Set current month as active
    $(".months-row").children().eq(date.getMonth()).addClass("active-month");
    init_calendar(date);
    var events = check_events(today, date.getMonth()+1, date.getFullYear());
});

// Initialize the calendar by appending the HTML dates

function init_calendar(date) {
    $(".tbody").empty();
    $(".events-container").empty();
    var calendar_days = $(".tbody");
    var month = date.getMonth();
    var year = date.getFullYear();
    var day_count = days_in_month(month, year);
    var row = $("<tr class='table-row'></tr>");
    var today = date.getDate();
    // Set date to 1 to find the first day of the month
    date.setDate(1);
    var first_day = date.getDay();
    var sel_date = new Date(year, month, today);

    // 35+firstDay is the number of date elements to be added to the dates table
    // 35 is from (7 days in a week) * (up to 5 rows of dates in a month)
    for(var i=0; i<35+first_day; i++) {
        // Since some of the elements will be blank, 
        // need to calculate actual date from index
        var day = i-first_day+1;
        // If it is a sunday, make a new row
        if(i%7===0) {
            calendar_days.append(row);
            row = $("<tr class='table-row'></tr>");
        }
        // if current index isn't a day in this month, make it blank
        if(sel_date.getMonth() < currentDate2.getMonth() && (sel_date.getYear() < currentDate2.getYear() || sel_date.getYear() == currentDate2.getYear())) {
            var curr_date = $("<td class='table-date nil'>"+"</td>");
            row.append(curr_date);
        }
        else if(i < first_day || day > day_count || (day < currentDate2.getDate() && sel_date.getMonth() == currentDate2.getMonth())) {
            var curr_date = $("<td class='table-date nil'>"+"</td>");
            row.append(curr_date);
        }   
        else {
            var curr_date = $("<td class='table-date'>"+day+"</td>");
            var events = check_events(day, month, year);
            if(today===day && $(".active-date").length===0) {
                curr_date.addClass("active-date");
            }
            // If this date has any events, style it with .event-date
            if(events.length!==0) {
                curr_date.addClass("event-date");
            }
            // Set onClick handler for clicking a date
            curr_date.click({events: events, month: month, day:day, year:year}, date_click);
            row.append(curr_date);
        }
    }
    // Append the last row and set the current year
    calendar_days.append(row);
    $(".year").text(year);
}

// Get the number of days in a given month/year
function days_in_month(month, year) {
    var monthStart = new Date(year, month, 1);
    var monthEnd = new Date(year, month + 1, 1);
    return (monthEnd - monthStart) / (1000 * 60 * 60 * 24);    
}

// Event handler for when a date is clicked
function date_click(event) {
    $(".events-container").show(250);
    $("#dialog").hide(250);
    $(".active-date").removeClass("active-date");
    $(this).addClass("active-date");
    event.data.month++;

    currentDate = event.data.year+'-'+event.data.month+'-'+event.data.day;
};

// Event handler for when a month is clicked
function month_click(event) {
    $(".events-container").show(250);
    $("#dialog").hide(250);
    var date = event.data.date;
    $(".active-month").removeClass("active-month");
    $(this).addClass("active-month");
    var new_month = $(".month").index(this);
    date.setMonth(new_month);
    init_calendar(date);
}

// Event handler for when the year right-button is clicked
function next_year(event) {
    $("#dialog").hide(250);
    var date = event.data.date;
    var new_year = date.getFullYear()+1;
    $("year").html(new_year);
    date.setFullYear(new_year);
    init_calendar(date);
}

// Event handler for when the year left-button is clicked
function prev_year(event) {
    $("#dialog").hide(250);
    var date = event.data.date;
    var new_year = date.getFullYear()-1;
    $("year").html(new_year);
    date.setFullYear(new_year);
    init_calendar(date);
}

// Event handler for clicking the new event button
function new_event(event) {
    // if a date isn't selected then do nothing
    if($(".active-date").length===0)
        return;
    // remove red error input on click
    $("input").click(function(){
        $(this).removeClass("error-input");
    })
    // empty inputs and hide events
    $("#dialog input[type=text]").val('');
    $("#dialog input[type=number]").val('');
    $(".events-container").hide(250);
    $("#dialog").show(250);
    // Event handler for cancel button
    $("#cancel-button").click(function() {
        $("#name").removeClass("error-input");
        $("#count").removeClass("error-input");
        $("#dialog").hide(250);
        $(".events-container").show(250);
    });
    // Event handler for ok button
    $("#ok-button").unbind().click({date: event.data.date}, function() {
        var date = event.data.date;
        var name = $("#name").val().trim();
        var count = parseInt($("#count").val().trim());
        var day = parseInt($(".active-date").html());
        // Basic form validation
        if(name.length === 0) {
            $("#name").addClass("error-input");
        }
        else if(isNaN(count)) {
            $("#count").addClass("error-input");
        }
        else {
            $("#dialog").hide(250);
            console.log("new event");
            new_event_json(name, count, date, day);
            date.setDate(day);
            init_calendar(date);
        }
    });
}

// Adds a json event to event_data
function new_event_json(name, count, date, day) {
    var event = {
        "occasion": name,
        "invited_count": count,
        "year": date.getFullYear(),
        "month": date.getMonth()+1,
        "day": day
    };
    event_data["events"].push(event);
}

// Checks if a specific date has any events
function check_events(day, month, year) {
    var events = [];
    for(var i=0; i<event_data["events"].length; i++) {
        var event = event_data["events"][i];
        if(event["day"]===day &&
            event["month"]===month &&
            event["year"]===year) {
                events.push(event);
            }
    }
    return events;
}

// Given data for events in JSON format
var event_data = {
    "events": [
    {
        "occasion": " Repeated Test Event ",
        "invited_count": 120,
        "year": 2020,
        "month": 5,
        "day": 10,
        "cancelled": true
    },
    {
        "occasion": " Repeated Test Event ",
        "invited_count": 120,
        "year": 2020,
        "month": 5,
        "day": 10,
        "cancelled": true
    },
        {
        "occasion": " Repeated Test Event ",
        "invited_count": 120,
        "year": 2020,
        "month": 5,
        "day": 10,
        "cancelled": true
    },
    {
        "occasion": " Repeated Test Event ",
        "invited_count": 120,
        "year": 2020,
        "month": 5,
        "day": 10
    },
        {
        "occasion": " Repeated Test Event ",
        "invited_count": 120,
        "year": 2020,
        "month": 5,
        "day": 10,
        "cancelled": true
    },
    {
        "occasion": " Repeated Test Event ",
        "invited_count": 120,
        "year": 2020,
        "month": 5,
        "day": 10
    },
        {
        "occasion": " Repeated Test Event ",
        "invited_count": 120,
        "year": 2020,
        "month": 5,
        "day": 10,
        "cancelled": true
    },
    {
        "occasion": " Repeated Test Event ",
        "invited_count": 120,
        "year": 2020,
        "month": 5,
        "day": 10
    },
        {
        "occasion": " Repeated Test Event ",
        "invited_count": 120,
        "year": 2020,
        "month": 5,
        "day": 10,
        "cancelled": true
    },
    {
        "occasion": " Repeated Test Event ",
        "invited_count": 120,
        "year": 2020,
        "month": 5,
        "day": 10
    },
    {
        "occasion": " Test Event",
        "invited_count": 120,
        "year": 2020,
        "month": 5,
        "day": 11
    }
    ]
};

const months = [ 
    "January", 
    "February", 
    "March", 
    "April", 
    "May", 
    "June", 
    "July", 
    "August", 
    "September", 
    "October", 
    "November", 
    "December" 
];

})(jQuery);

</script>