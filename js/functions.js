String.prototype.capitalize = function() {
    return this.replace(/(?:^|\s)\S/g, function(a) { return a.toUpperCase(); });
};

//var date_format = 'MMM dS, yyyy h:mm tt';
var date_format = 'yyyy-MM-dd h:mm tt';
var date_format_long = 'dddd, MMM dS, yyyy h:mm tt';
var date_format_short = 'yyyy-MM-dd h:mm tt';
var date_format_short_notime = 'yyyy-MM-dd';
var date_format_drupal = 'yyyy-MM-dd HH:mm';
var date_format_drupal_notime = 'yyyy-MM-dd';

(function($){

    var hideLoadingTimer;
window.loadingIndicator = {
  inited: false,
  init: function() {
    if (!$('#loadingIndicator').length) {
        $("body").append($('<div id="loadingIndicator" style="background:#fff;width:100%; height:100%; position:fixed;top:0;bottom:0;left:0;right:0;z-index:1000;opacity:0.8;display:none;"><p id="working-text">Working...  Please be patient.</p></div>'));
        $("#loadingIndicator").height($(window).height());
        $("#loadingIndicator").spin();
    }
    this.inited = true;
  },
  show: function() {
    if (!this.inited) { this.init(); }
    clearTimeout(hideLoadingTimer);
    $("#loadingIndicator").height($(window).height()).fadeIn(250);
  },
  hide: function() {
    $("#loadingIndicator").fadeOut(250);
  }
};


$(document).ready(function() {
 $(document).on('ajaxStart',function() {
     window.loadingIndicator.show();
     clearTimeout(hideLoadingTimer);
 }) 
 $(document).on('ajaxComplete',function() {
        //  hide using a timer that ajaxStart can clear if it receives a new request
        //  this way, the loading indicator doesn't hide/show multiple times per page load.
        hideLoadingTimer = setTimeout(function() {
            window.loadingIndicator.hide();
        },2500);
     if ($('.views-exposed-widget select').length && $.fn.chosen != undefined) {
         $('.views-exposed-widget select').chosen({disable_search:true}).trigger('chosen:updated');
     }
 })
});
window.datestampToDate = function(ts) {
    var d = new Date(ts * 1000);
    return d.toString(date_format) + ' ' + d.getTimezone();
}

window.mysqldateToString = function(time, format) {
    var date = null;
    var d = Date.parse(time);
    var format = format || date_format;
    if (d) {
        date = d.toString(format);
    }
    return date;
}

window.timestampRange = function(timeObj) {
    var this_timezone = new Date().getTimezone();
    var startDateString = '', endDateString = '';
    if (typeof(timeObj.value) == 'object') {
        startDateString = timeObj.value.date;
        if (typeof(timeObj.value.time) != "undefined") {
            startDateString += ' ' + timeObj.value.time;
        }
    }
    else if (typeof(timeObj.value) == 'string') {
        startDateString = timeObj.value;
    }
    
    if (typeof(timeObj.value2) != "undefined" && timeObj.value2 != null) {           
        if (typeof(timeObj.value2) == 'object') {
            endDateString = timeObj.value2.date;
            if (typeof(timeObj.value2.time) != "undefined") {
                endDateString += ' ' + timeObj.value2.time;
            }
        }
        else if (typeof(timeObj.value2) == 'string') {
            endDateString = timeObj.value2;
        }
    }
    var noend = timeObj.value2 == null || startDateString == endDateString; 
    if (noend) {
        var startDate = mysqldateToString(startDateString, date_format_drupal);
        if (Date.parse(startDateString).toString('H:mm') == '0:00' ) {
            startDate = mysqldateToString(startDateString, date_format_drupal_notime) + ' (All Day)';
        }
        return startDate + ' ' + this_timezone + ' (No End)';
    }
    else {
        var startDate = mysqldateToString(startDateString, date_format_drupal);
        if (Date.parse(startDateString).toString('H:mm') == '0:00' ) {
            startDate = mysqldateToString(startDateString, date_format_drupal_notime) + ' (All Day)';
        }
        var endDate = mysqldateToString(endDateString, date_format_drupal);
        if (Date.parse(endDateString).toString('H:mm') == '0:00' ) {
            endDate = mysqldateToString(endDateString, date_format_drupal_notime) + ' (All Day)';
        }
        return startDate + ' ' + this_timezone + ' - ' + endDate + ' ' + this_timezone;
    }     
}

window.dateRange = function(timeObj) {
    var val = '';
    if (timeObj.hasOwnProperty('value_formatted')) {
        val += timeObj.value_formatted;
    }
    if (timeObj.hasOwnProperty('value2_formatted')) {
        val += ' to ' + timeObj.value2_formatted;
    }
    if (val != '') { return val; }
    var startDateString = '', endDateString = '';
    var startHasTime = false;
    var endHasTime = false;
    if (typeof(timeObj.value) == 'object') {
        startDateString = timeObj.value.date;
        if (typeof(timeObj.value.time) != "undefined") {
            startDateString += ' ' + timeObj.value.time;
           startHasTime = true;
        }
    }
    else if (typeof(timeObj.value) == 'string') {
        startDateString = timeObj.value;
        var s = startDateString.split(' ');
        if (s.length > 1) {
            startHasTime = true;
        }
    }
    
    if (typeof(timeObj.value2) != "undefined" && timeObj.value2 != null) {           
        if (typeof(timeObj.value2) == 'object') {
            endDateString = timeObj.value2.date;
            if (typeof(timeObj.value2.time) != "undefined") {
                endDateString += ' ' + timeObj.value2.time;
                endHasTime = true;
            }
        }
        else if (typeof(timeObj.value2) == 'string') {
            endDateString = timeObj.value2;
            var s = endDateString.split(' ');
            if (s.length > 1) {
                endHasTime = true;
            }
        }
    }
    var noend = timeObj.value2 == null || startDateString == endDateString;
    if (noend) {
        var startDate = mysqldateToString(startDateString, date_format_short);
        var this_timezone = Date.parse(startDateString).getTimezone();
        if (Date.parse(startDateString).toString('H:mm') == '0:00') {
            startHasTime = false;
            startDate = mysqldateToString(startDateString, date_format_short_notime) + ' (All Day)';
        }
        var output = startDate;
        if (startHasTime) {
            output += ' ' + this_timezone;
        }
        output += ' (No End)';
        return output;
    }
    else {
        var startDate = mysqldateToString(startDateString, date_format_short);
        var this_timezone = Date.parse(startDateString).getTimezone();
        console.log(startDateString, this_timezone);
        if (Date.parse(startDateString).toString('H:mm') == '0:00') {
            startDate = mysqldateToString(startDateString, date_format_short_notime);
            startHasTime = false;
            startDate += ' (All Day)';
        }
        if (startHasTime) {
            startDate += ' ' + this_timezone;
        }
        var endDate = mysqldateToString(endDateString, date_format_short);
        var this_timezone = Date.parse(endDateString).getTimezone();
        if (Date.parse(endDateString).toString('H:mm') == '0:00' ) {
            endDate = mysqldateToString(endDateString, date_format_short_notime);
            endHasTime = false;
             endDate += ' (All Day)';
        }
        if (endHasTime) {
            endDate += ' ' + this_timezone;
        }
        return startDate + ' &mdash; ' + endDate;
    }   
}

$(document).ready(function() {
    // apply chosen to stragglers..
    if (jQuery.fn.chosen != undefined) {
        $('.views-exposed-widget select, select#edit-submitted-office-location,select[name="items_per_page"], .table-refresh-container select').chosen({disable_search:true});
        //$('#eaton-backbone-event-registrant-form [name="visitor_type"]').chosen({disable_search:true});
    }
})
})(jQuery);