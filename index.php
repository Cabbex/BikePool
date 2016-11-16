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
        <title>BikePool</title>      
        <link href="main.css" rel="stylesheet"/>
        <script src="bower_components/jquery/dist/jquery.min.js" type="text/javascript"></script>
        <script src="js/typed.js" type="text/javascript"></script>
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
                <a href="index.php"><img class="img-responsive" src="img/Logo.png" alt="BikePool"/></a><br/><br/>
                <div class="type-wrap">
                    <div id="typed-strings">
                        <span>Vill du förenkla ditt liv som <strong>pendlare?</strong></span>
                        <p>Vill du <strong>cykla</strong> till skolan/jobbet?</p>
                        <p><strong>BikePool</strong> hjälper dig!</p>
                        <p>Välkommen!</p>
                    </div>
                    <span id="typed" style="white-space:pre;"></span>
                </div>
            </div>
        </div>


        <div id="about">
            <h1>Vad är BikePool?</h1>
        </div>

    </body>
</html>
