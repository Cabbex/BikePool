
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
                console.log("Preload error "+ ex);
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
            //"<INCLUDE>AdvertisedTimeAtLocation</INCLUDE>" +
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
                console.log("Error Search "+ ex);
            }

        }

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
            //"<INCLUDE>AdvertisedTimeAtLocation</INCLUDE>" +
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
                jQuery("#tableAvgaende tr:last").
                        after("<tr><td colspan='4'>Inga avgångar hittades 3</td></tr>");
            try {
                //1
                utSkrivtTabel(response.RESPONSE.RESULT[0].TrainAnnouncement, station,"tableAvgaende");
                i++;

                
                if (tagid_r.length > i) {
                    Search3(i);
                }
            } catch (ex) {
                console.log("error: " + ex);
            }

        }
    });
}

function utSkrivtTabel(announcement,city,tagg) {
    $(announcement).each(function (iterator, item3) {
        var advertisedtime3 = new Date(item3.AdvertisedTimeAtLocation);
        var hours3 = advertisedtime3.getHours() - 1;
        var minutes3 = advertisedtime3.getMinutes();
        if (minutes3 < 10)
            minutes3 = "0" + minutes3;
        if (hours3 == -1) {
            hours3 = 23;
        }

        jQuery("#"+ tagg +" tr:last").
                after("<tr><td>" + hours3 + ":" + minutes3 + "</td><td>" + city +
                        "</td>");

    });
    console.log(tagid_r);
}


function Search4(i) {
    var sign2 = $("#station2").data("sign2");
    console.log("Search4 i:" + i+ " av "+tagid_r.length);
    console.log("Search4 sign:" + sign2);
    console.log("Search4 tåg_id:" + tagid_r[i]);

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
                jQuery("#tableAnkommande tr:last").
                        after("<tr><td colspan='4'>Inga avgångar hittades 4</td></tr>");
            try {
                console.log(i); //3
                utSkrivtTabel(response.RESPONSE.RESULT[0].TrainAnnouncement,station2,"tableAnkommande");
                console.log("##Response##");
                console.log(response.RESPONSE.RESULT);
                i++;
                if (tagid_r.length > i) {
                    Search4(i);
                }

            } catch (ex) {
                console.log("error: " + ex);
            }

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

function addTime(){
    avfard = document.getElementById("avfard").value;
    ankommande = document.getElementById("ankommande").value;
    
    if(avfard === "" || ankommande === ""){
        document.getElementById("insattningstxt").value = "Enter data before submiting!";
    }
    window.open("PHP/insertTime.php?time="+avfard+"-"+ankommande,"_self");
}
