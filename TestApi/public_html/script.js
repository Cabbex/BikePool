
var tagid_s = new Array();
var tagid_d = new Array();
var tagid_r = new Array();
var isdone = false;
var station;
var station2;


var Stations = new Array();
$(document).ready(function () {
    $.support.cors = true; // Enable Cross domain requests
    try {
        $.ajaxSetup({
            url: "http://api.trafikinfo.trafikverket.se/v1/data.json",
            error: function (msg) {
                if (msg.statusText == "abort")
                    return;
                alert("Request failed: " + msg.statusText + "\n" + msg.responseText);
            }
        });
    } catch (e) {
        alert("Ett fel uppstod vid initialisering.");
    }
    // Create an ajax loading indicator
    var loadingTimer;
    $("#loader").hide();
    $(document).ajaxStart(function () {
        loadingTimer = setTimeout(function () {
            $("#loader").show();
        }, 200);
    }).ajaxStop(function () {
        clearTimeout(loadingTimer);
        $("#loader").hide();
    });
    // Load stations
    PreloadTrainStations();
});

function PreloadTrainStations() {
    // Request to load all stations
    var xmlRequest = "<REQUEST>" +
            // Use your valid authenticationkey
            "<LOGIN authenticationkey='26439355863f47a381f6b5ba336ca5d8' />" +
            "<QUERY objecttype='TrainStation'>" +
            "<FILTER/>" +
            "<INCLUDE>Prognosticated</INCLUDE>" +
            "<INCLUDE>AdvertisedLocationName</INCLUDE>" +
            "<INCLUDE>LocationSignature</INCLUDE>" +
            "</QUERY>" +
            "</REQUEST>";
    $.ajax({
        type: "POST",
        contentType: "text/xml",
        dataType: "json",
        data: xmlRequest,
        success: function (response) {
            if (response == null)
                return;
            try {
                var stationlist = [];
                $(response.RESPONSE.RESULT[0].TrainStation).each(function (iterator, item)
                {
                    // Save a key/value list of stations
                    Stations[item.LocationSignature] = item.AdvertisedLocationName;
                    // Create an array to fill the search field autocomplete.
                    if (item.Prognosticated == true)
                        stationlist.push({label: item.AdvertisedLocationName, value: item.LocationSignature});
                });
                fillSearchWidget(stationlist);
            } catch (ex) {
            }
        }
    });
}

function fillSearchWidget(data) {
    $("#station").val("");
    $("#station").autocomplete({
        // Make the autocomplete fill with matches that "starts with" only
        source: function (request, response) {
            var matches = $.map(data, function (tag) {
                if (tag.label.toUpperCase().indexOf(request.term.toUpperCase()) === 0) {
                    return {
                        label: tag.label,
                        value: tag.value
                    }
                }
            });
            response(matches);
        },
        select: function (event, ui) {
            var selectedObj = ui.item;
            $("#station").val(selectedObj.label);
            // Save selected stations signature
            $("#station").data("sign", selectedObj.value);
            return false;
        },
        focus: function (event, ui) {
            var selectedObj = ui.item;
            // Show station name in search field
            $("#station").val(selectedObj.label);
            return false;
        }
    });
    $("#station2").val("");
    $("#station2").autocomplete({
        // Make the autocomplete fill with matches that "starts with" only
        source: function (request, response) {
            var matches = $.map(data, function (tag) {
                if (tag.label.toUpperCase().indexOf(request.term.toUpperCase()) === 0) {
                    return {
                        label: tag.label,
                        value: tag.value
                    }
                }
            });
            response(matches);
        },
        select: function (event, ui) {
            var selectedObj = ui.item;
            $("#station2").val(selectedObj.label);
            // Save selected stations signature
            $("#station2").data("sign2", selectedObj.value);
            return false;
        },
        focus: function (event, ui) {
            var selectedObj = ui.item;
            // Show station name in search field
            $("#station2").val(selectedObj.label);
            return false;
        }
    });
}

function Search() {
    var sign = $("#station").data("sign");
    console.log(sign);
    // Clear html table
    $('#timeTableDeparture tr:not(:first)').remove();

    // Request to load announcements for a station by its signature
    var xmlRequest = "<REQUEST version='1.0'>" +
            "<LOGIN authenticationkey='26439355863f47a381f6b5ba336ca5d8' />" +
            "<QUERY objecttype='TrainAnnouncement' " +
            "orderby='AdvertisedTimeAtLocation' >" +
            "<FILTER>" +
            "<AND>" +
            "<OR>" +
            "<AND>" +
            "<GT name='AdvertisedTimeAtLocation' " +
            "value='$dateadd(-00:15:00)' />" +
            "<LT name='AdvertisedTimeAtLocation' " +
            "value='$dateadd(14:00:00)' />" +
            "</AND>" +
            "<GT name='EstimatedTimeAtLocation' value='$now' />" +
            "</OR>" +
            "<EQ name='LocationSignature' value='" + sign + "' />" +
            "<EQ name='ActivityType' value='avgang' />" +
            //"<EQ name='AdvertisedTrainIdent' value='"+trainId+"' />" +

            "</AND>" +
            "</FILTER>" +
            // Just include wanted fields to reduce response size.
            "<INCLUDE>AdvertisedTimeAtLocation</INCLUDE>" +
            "<INCLUDE>AdvertisedTrainIdent</INCLUDE>" +
            "</QUERY>" +
            "</REQUEST>";
    $.ajax({
        type: "POST",
        contentType: "text/xml",
        dataType: "json",
        data: xmlRequest,
        success: function (response) {
            if (response == null)
                return;
            if (response.RESPONSE.RESULT[0].TrainAnnouncement == null)
                jQuery("#timeTableDeparture tr:last").
                        after("<tr><td colspan='4'>Inga avgångar hittades</td></tr>");
            try {
                renderTrainAnnouncement(response.RESPONSE.RESULT[0].TrainAnnouncement);

                for (var i = 0; i < response.RESPONSE.RESULT[0].TrainAnnouncement.length; i++) {
                    tagid_s.push(response.RESPONSE.RESULT[0].TrainAnnouncement[i].AdvertisedTrainIdent);
                }
                if (isdone === true) {
                    console.log("CHECK TRAINS!");
                    checkTrains();
                } else {
                    console.log("FÖRSTA KLAR!");
                    isdone = true;
                }
            } catch (ex) {
                console.log("fångad av en stormvind");
            }

        }

    });
}

function renderTrainAnnouncement(announcement) {
    $(announcement).each(function (iterator, item) {
        var advertisedtime = new Date(item.AdvertisedTimeAtLocation);
        var hours = advertisedtime.getHours() - 1;
        var minutes = advertisedtime.getMinutes();
        if (minutes < 10)
            minutes = "0" + minutes;
        if (hours == -1) {
            hours = 23;
        }


//        jQuery("#timeTableDeparture tr:last").
//                after("<tr><td>" + hours + ":" + minutes + "</td><td>" + station +
//                        "</td><td>" + tagid + "</td>");
    });
}
function Search2() {
    var sign2 = $("#station2").data("sign2");

    $('#timeTableDeparture2 tr:not(:first)').remove();
    var xmlRequest = "<REQUEST version='1.0'>" +
            "<LOGIN authenticationkey='26439355863f47a381f6b5ba336ca5d8' />" +
            "<QUERY objecttype='TrainAnnouncement' " +
            "orderby='AdvertisedTimeAtLocation' >" +
            "<FILTER>" +
            "<AND>" +
            "<OR>" +
            "<AND>" +
            "<GT name='AdvertisedTimeAtLocation' " +
            "value='$dateadd(-00:15:00)' />" +
            "<LT name='AdvertisedTimeAtLocation' " +
            "value='$dateadd(14:00:00)' />" +
            "</AND>" +
            "<GT name='EstimatedTimeAtLocation' value='$now' />" +
            "</OR>" +
            "<EQ name='LocationSignature' value='" + sign2 + "' />" +
            "<EQ name='ActivityType' value='ankomst' />" +
            // "<EQ name='AdvertisedTrainIdent' value='"+trainId+"' />" +
            "</AND>" +
            "</FILTER>" +
            // Just include wanted fields to reduce response size.
            "<INCLUDE>AdvertisedTimeAtLocation</INCLUDE>" +
            "<INCLUDE>AdvertisedTrainIdent</INCLUDE>" +
            "</QUERY>" +
            "</REQUEST>";
    $.ajax({
        type: "POST",
        contentType: "text/xml",
        dataType: "json",
        data: xmlRequest,
        success: function (response) {
            if (response == null)
                return;
            if (response.RESPONSE.RESULT[0].TrainAnnouncement == null)
                jQuery("#timeTableDeparture2 tr:last").
                        after("<tr><td colspan='4'>Inga avgångar hittades</td></tr>");
            try {
                renderTrainAnnouncement2(response.RESPONSE.RESULT[0].TrainAnnouncement);
                for (var i = 0; i < response.RESPONSE.RESULT[0].TrainAnnouncement.length; i++) {
                    tagid_d.push(response.RESPONSE.RESULT[0].TrainAnnouncement[i].AdvertisedTrainIdent);
                }

                if (isdone === true) {
                    console.log("Check Trains");
                    checkTrains();

                } else {
                    console.log("Andra är klar!");
                    isdone = true;
                }
            } catch (ex) {
                console.log("Error: " + ex);
            }

        }

    })
}


function renderTrainAnnouncement2(announcement) {
    $(announcement).each(function (iterator, item2) {
        var advertisedtime2 = new Date(item2.AdvertisedTimeAtLocation);
        var hours2 = advertisedtime2.getHours() - 1;
        var minutes2 = advertisedtime2.getMinutes();
        if (minutes2 < 10)
            minutes2 = "0" + minutes2;
        if (hours2 == -1) {
            hours2 = 23;
        }

//            jQuery("#timeTableDeparture2 tr:last").
//                after("<tr><td>" + hours2 + ":" + minutes2 + "</td><td>" + station2 +
//                    "</td><td>" + tagid2 + "</td>");
    });
}

function Search3(i) {
    var sign = $("#station").data("sign");
    $('#timeTableDeparture2 tr:not(:first)').remove();
    var xmlRequest = "<REQUEST version='1.0'>" +
            "<LOGIN authenticationkey='26439355863f47a381f6b5ba336ca5d8' />" +
            "<QUERY objecttype='TrainAnnouncement' " +
            "orderby='AdvertisedTimeAtLocation' >" +
            "<FILTER>" +
            "<AND>" +
            "<OR>" +
            "<AND>" +
            "<GT name='AdvertisedTimeAtLocation' " +
            "value='$dateadd(-00:15:00)' />" +
            "<LT name='AdvertisedTimeAtLocation' " +
            "value='$dateadd(14:00:00)' />" +
            "</AND>" +
            "<GT name='EstimatedTimeAtLocation' value='$now' />" +
            "</OR>" +
            "<EQ name='LocationSignature' value='" + sign + "' />" +
            "<EQ name='ActivityType' value='ankomst' />" +
            "<EQ name='AdvertisedTrainIdent' value='" + tagid_r[i] + "' />" +
            "</AND>" +
            "</FILTER>" +
            // Just include wanted fields to reduce response size.
            "<INCLUDE>AdvertisedTimeAtLocation</INCLUDE>" +
            "<INCLUDE>AdvertisedTrainIdent</INCLUDE>" +
            "</QUERY>" +
            "</REQUEST>"; 
    $.ajax({
        type: "POST",
        contentType: "text/xml",
        dataType: "json",
        data: xmlRequest,
        success: function (response) {

            if (response == null)
                return;
            if (response.RESPONSE.RESULT[0].TrainAnnouncement == null)
                jQuery("#timeTableDeparture tr:last").
                        after("<tr><td colspan='4'>Inga avgångar hittades 3</td></tr>");
            try {
                renderTrainAnnouncement3(response.RESPONSE.RESULT[0].TrainAnnouncement);
                i++;
                if(i < tagid_r.length){
                    Search3(i);
                }
            } catch (ex) {
                console.log("error: " + ex);
            }

        }
    });
}


function renderTrainAnnouncement3(announcement) {
    $(announcement).each(function (iterator, item3) {
        var advertisedtime3 = new Date(item3.AdvertisedTimeAtLocation);
        var hours3 = advertisedtime3.getHours() - 1;
        var minutes3 = advertisedtime3.getMinutes();
        if (minutes3 < 10)
            minutes3 = "0" + minutes3;
        if (hours3 == -1) {
            hours3 = 23;
        }
        for (var i = 0; i < tagid_r.length; i++) {
        jQuery("#timeTableDeparture tr:last").
                after("<tr><td>" + hours3 + ":" + minutes3 + "</td><td>" + station +
                        "</td><td>" + tagid_r[i] + "</td>");
        }
    });
}
function Search4(i) {
    
   // for (var i = 0; i < tagid_r.length; i++) {
        var sign2 = $("#station2").data("sign2");
    

    $('#timeTableDeparture2 tr:not(:first)').remove();
    var xmlRequest = "<REQUEST version='1.0'>" +
            "<LOGIN authenticationkey='26439355863f47a381f6b5ba336ca5d8' />" +
            "<QUERY objecttype='TrainAnnouncement' " +
            "orderby='AdvertisedTimeAtLocation' >" +
            "<FILTER>" +
            "<AND>" +
            "<OR>" +
            "<AND>" +
            "<GT name='AdvertisedTimeAtLocation' " +
            "value='$dateadd(-00:15:00)' />" +
            "<LT name='AdvertisedTimeAtLocation' " +
            "value='$dateadd(14:00:00)' />" +
            "</AND>" +
            "<GT name='EstimatedTimeAtLocation' value='$now' />" +
            "</OR>" +
            "<EQ name='LocationSignature' value='" + sign2 + "' />" +
            "<EQ name='ActivityType' value='ankomst' />" +
            "<EQ name='AdvertisedTrainIdent' value='" + tagid_r[i] + "' />" +
            "</AND>" +
            "</FILTER>" +
            // Just include wanted fields to reduce response size.
            "<INCLUDE>AdvertisedTimeAtLocation</INCLUDE>" +
            "<INCLUDE>AdvertisedTrainIdent</INCLUDE>" +
            "</QUERY>" +
            "</REQUEST>";
    $.ajax({
        type: "POST",
        contentType: "text/xml",
        dataType: "json",
        data: xmlRequest,
        success: function (response) {
            if (response == null)
                return;
            if (response.RESPONSE.RESULT[0].TrainAnnouncement == null)
                jQuery("#timeTableDeparture2 tr:last").
                        after("<tr><td colspan='4'>Inga avgångar hittades 4</td></tr>");
            try {
                renderTrainAnnouncement4(response.RESPONSE.RESULT[0].TrainAnnouncement);
                i++;
                if(i < tagid_r.length){
                    Search4(i);
                }
              
            } catch (ex) {
                console.log("error: " + ex);
            }

        }

    });
    
}


function renderTrainAnnouncement4(announcement) {
    $(announcement).each(function (iterator, item4) {
        var advertisedtime4 = new Date(item4.AdvertisedTimeAtLocation);
        var hours4 = advertisedtime4.getHours() - 1;
        var minutes4 = advertisedtime4.getMinutes();
        if (minutes4 < 10)
            minutes4 = "0" + minutes4;
        if (hours4 == -1) {
            hours4 = 23;
        }
        for (var i = 0; i < tagid_r.length; i++) {
        jQuery("#timeTableDeparture2 tr:last").
                after("<tr><td>" + hours4 + ":" + minutes4 + "</td><td>" + station2 +
                        "</td><td>" + tagid_r[i] + "</td>");
            }
    });
}

function check(nr, tagid_s) {
    for (var i = 0; i < tagid_s.length; i++) {
        if (nr === tagid_s[i]) {
            return true;
        }
    }
    return false;
}

function checkTrains() {
    for (var i = 0; i < tagid_d.length; i++) {
        if (check(tagid_d[i], tagid_s)) {
            tagid_r.push(tagid_d[i]);
        }
    }
    console.log("Check trains är klar!");
    console.log(tagid_r);
    //jobba vidare...
    Search3(0);
    Search4(0);
}
   
function anrop() {
    station = document.getElementById("station").value;
    station2 = document.getElementById("station2").value;
    Search();
    Search2();
}
