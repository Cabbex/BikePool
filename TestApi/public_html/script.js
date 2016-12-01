
                var typ;
                var trainId;

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
                    
                    // Clear html table
                    $('#timeTableDeparture tr:not(:first)').remove();

                    // Request to load announcements for a station by its signature
                    var xmlRequest = "<REQUEST version='1.0'>" +
                            "<LOGIN authenticationkey='26439355863f47a381f6b5ba336ca5d8' />" +
                            "<QUERY objecttype='TrainAnnouncement' limit='1' " +
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
                            "<EQ name='AdvertisedTrainIdent' value='"+trainId+"' />" +
                            "</AND>" +
                            "</FILTER>" +
                            // Just include wanted fields to reduce response size.
                            "<INCLUDE>AdvertisedTimeAtLocation</INCLUDE>" +
                            "<INCLUDE>FromLocation</INCLUDE>" +
                            "<INCLUDE>ToLocation</INCLUDE>" +
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
                        var toList = new Array();
                       
                        $(item.ToLocation).each(function (iterator, toItem) {
                            toList.push(Stations[toItem]);

                        });
                       

                        var owner = "";
                        if (item.InformationOwner != null)
                            owner = item.InformationOwner;
                        jQuery("#timeTableDeparture tr:last").
                                after("<tr><td>" + hours + ":" + minutes + "</td><td>" + toList.join(', ') +
                                        "</td>");
                       
                        if (item.TechnicalTrainIdent != null) {
                                typ = item.TechnicalTrainIdent;

                            console.log(typ);
                        }
                    });
                }
                function Search2(){
                    var sign2 = $("#station2").data("sign2");
                    
                    $('#timeTableDeparture2 tr:not(:first)').remove();
                    var xmlRequest = "<REQUEST version='1.0'>" +
                            "<LOGIN authenticationkey='26439355863f47a381f6b5ba336ca5d8' />" +
                            "<QUERY objecttype='TrainAnnouncement' limit='1' " +
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
                            "<EQ name='AdvertisedTrainIdent' value='"+trainId+"' />" +
                            "</AND>" +
                            "</FILTER>" +
                            // Just include wanted fields to reduce response size.
                            "<INCLUDE>AdvertisedTimeAtLocation</INCLUDE>" +
                            "<INCLUDE>FromLocation</INCLUDE>" +
                            "<INCLUDE>ToLocation</INCLUDE>" +
                            "<INCLUDE>TechnicalTrainIdent</INCLUDE>" +
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
                                renderTrainAnnouncement2(response.RESPONSE.RESULT[0].TrainAnnouncement); console.log("test");
                            } catch (ex) {
                                console.log("fångad av en stormvind 2");
                            }

                        }

                    });
                }
                

                function renderTrainAnnouncement2(announcement) {
                    $(announcement).each(function (iterator, item) {
                        var advertisedtime2 = new Date(item.AdvertisedTimeAtLocation);
                        var hours2 = advertisedtime2.getHours() - 1;
                        var minutes2 = advertisedtime2.getMinutes();
                        if (minutes2 < 10)
                            minutes2 = "0" + minutes2;

                        var foList = new Array();
                        $(item.FromLocation).each(function (iterator, foItem) {
                            foList.push(Stations[foItem]);
                        });

                        var owner2 = "";
                        if (item.InformationOwner != null)
                            owner2 = item.InformationOwner;
                        jQuery("#timeTableDeparture2 tr:last").
                                after("<tr><td>" + hours2 + ":" + minutes2 + "</td><td>" + foList.join(', ') +
                                        "</td>");
                        if (item.TechnicalTrainIdent != null) {
                                typ = item.TechnicalTrainIdent;

                            console.log(typ);
                        }
                    });
                }
                function anrop(){
                    trainId = document.getElementById("trainId").value;
                    console.log(trainId);
                    Search();
                    Search2();
                    
                }
