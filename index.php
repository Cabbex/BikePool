<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="google-signin-client_id" content="490145815034-1ggkdb0rcrmh90v4fq74uqscsa4br3dp.apps.googleusercontent.com">
        <title>BikePool</title>      
        <link href="CSS/main.css" rel="stylesheet"/>
        <link href="bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <script src="https://apis.google.com/js/platform.js" async defer></script>
        <script src="bower_components/jquery/dist/jquery.min.js" type="text/javascript"></script>
        <script src="JS/typed.js" type="text/javascript"></script>
        <script src="JS/googleSignIn.js" type="text/javascript"></script>
        <script>
            $(function () {

                $("#typed").typed({
                    // strings: ["Typed.js is a <strong>jQuery</strong> plugin.", "It <em>types</em> out sentences.", "And then deletes them.", "Try it out!"],
                    stringsElement: $('#typed-strings'),
                    typeSpeed: 30,
                    backDelay: 500,
                    loop: false,
                    contentType: 'html', // or text
                    // defaults to false for infinite loop
                    loopCount: false,
                    callback: function () {
                        foo();
                    },
                    resetCallback: function () {
                        newTyped();
                    }
                });

                $(".reset").click(function () {
                    $("#typed").typed('reset');
                });

            });

            function newTyped() { /* A new typed object */
            }

            function foo() {
                console.log("Callback");
            }

        </script>

    </head>

    <body>

        <div class="start">
            <div class="wrap">
                <a href="index.php"><img src="img/Logo.png" class="img-responsive" alt="BikePool"/></a><br/>
                <div class="type-wrap">
                    <div id="typed-strings">
                        <span>Would you like to <strong>facilitate</strong> your life?</span>
                        <p>Do you want to <strong>bike</strong> to school/work?</p>
                        <p><strong>BikePool</strong> wants to help you!</p>
                        <p>Welcome!</p>
                    </div>
                    <span id="typed" style="white-space:pre;"></span>
                </div>
                <div class="container">
                    <div class="col-md-4">
                        <div class="g-signin2" data-onsuccess="onSignIn" data-theme="dark"></div>
                    </div>
                    <div class="col-md-4">
                        <a class="btn btn-default page-scroll" href="#about">Read more</a>
                    </div>
                </div>               
            </div>
        </div>

        <div class="section-about" id="about">
            <section class="container">
                <div class="row section">

                    <div class="col-sm-4">
                        <div class="media">
                            <div class="media-left">
                                <a>
                                    <img class="media-object slideanim" src="img/location.png" alt="Location"/>
                                </a>
                            </div>
                            <div class="media-body slideanim">
                                <h4 class="media-heading">Share eachothers bicycles</h4>
                                Specify your destination to find another partner to share your bicycle with. Your life couldn't be more perfect.
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="media">
                            <div class="media-left">
                                <a>
                                    <img class="media-object slideanim" src="img/staff.png" alt="Staff"/>
                                </a>
                            </div>
                            <div class="media-body slideanim">
                                <h4 class="media-heading">We are developers</h4>
                                Our goal was to create something helpful for travelers between citys. Four passionated developers created Bikepool.
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="media">
                            <div class="media-left">
                                <a>
                                    <img class="media-object slideanim" src="img/lock.png" alt="Login"/>
                                </a>
                            </div>
                            <div class="media-body slideanim">
                                <h4 class="media-heading">Login to find your partner</h4>
                                You're one step from revolution. Login to take part of this. Don't hesitate, you won't regret it. 
                            </div>
                        </div>
                    </div>

                </div>
            </section>

        </div>

        <div class="section-staff" id="staff">
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="staff-body slideanim">
                        <img class="img-circle" src="img/rsz_user2.png">
                        <h3 class="name">Gustav Andersson</h3>
                        <h4 class="task">Front End</h4>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 ">
                    <div class="staff-body slideanim">
                        <img class="img-circle" src="img/rsz_user2.png">
                        <h3 class="name">Jones Trabelsi</h3>
                        <h4 class="task">Front End</h4>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="staff-body slideanim">
                        <img class="img-circle" src="img/rsz_user2.png">
                        <h3 class="name">Casper Björk</h3>
                        <h4 class="task">Project Leader</h4>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="staff-body slideanim">
                        <img class="img-circle" src="img/rsz_user2.png">
                        <h3 class="name">Albin Arvidsson</h3>
                        <h4 class="task">Back End</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="section-footer">
            <footer class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div class="footer-body">
                            <h4 class="footer-header">About Bikepool</h4>
                            <p>Bikepool was born in 2016 as four hungry students put their brains together.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="footer-body">
                            <h4 class="footer-header">Our locations</h4>
                            <p>Gamla Norrvägen 6, 352 43 <i>Växjö</i><br/>Sweden</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="footer-body">
                            <h4 class="footer-header">Contact us</h4>
                            <p>If you have an opinion of what could be improved at Bikepool, feel free to send an email to the address below<br/>bikepool@gmail.com</p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <script>
            $(window).scroll(function () {
                $(".slideanim").each(function () {
                    var pos = $(this).offset().top;

                    var winTop = $(window).scrollTop();
                    if (pos < winTop + 800) {
                        $(this).addClass("slide");
                    }
                });
            });
        </script>
        <script src="JS/scrolling-nav.js" type="text/javascript"></script>
        <script src="JS/jquery.easing.min.js" type="text/javascript"></script>
    </body>
</html>
