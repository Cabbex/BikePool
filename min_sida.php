<?php
require __DIR__ . '/PHP/getBasicUserProfile.php';
session_start();
if ($_SESSION["loggedIn"] != true) {
    header("Location: http://casper.te4.nu/BikePool/index.php");
}
?>
<html>
    <head>
        <title>Min sida</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="TestApi/public_html/script.js" type="text/javascript"></script>
        <link href="bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="bower_components/bootstrap/less/jumbotron.less" type="text/css">
        <link href="CSS/design.css" rel="stylesheet" type="text/css"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <style>
            #map {
                height: 50%; 
                border: solid #BE524F;
            }
            html, body{
                padding-top: 60px;
                background-image: url(img/white_background2.jpg);
                background-repeat: no-repeat;
                background-size: cover;
            }
        </style>
    </head>
    <body>
        <header>
            <nav class="navbar navbar-default navbar-fixed-top" style="background-color: #BE524F;">
                <div class="container">
                    <div class="navbar-header">
                        <img src="img/rsz_21logo.png" alt="Treby IF" class="navbar-left"/>
                        <button type="button" class="navbar-toggle" style="background: white;"  data-toggle="collapse" data-target="#myNavbar">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>                        
                        </button>
                    </div>
                    <div class="collapse navbar-collapse" id="myNavbar">
                        <!-- left nav menu -->
                        <ul class="nav navbar-nav">
                            <li><a href="#"><span class="glyphicon glyphicon-home"></span> Home</a></li>
                            <li><a href="flode.php"><span class="glyphicon glyphicon-search"></span> The Flow</a></li>
                            <li><a href="#"><span class="glyphicon glyphicon-user"></span> My Page</a></li>
                        </ul>
                        <ul class="nav navbar-nav pull-right">
                            <li><a href="#"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>

                        </ul>
                    </div>
                </div>
            </nav>
        </header>

        <!-- Page content below -->
        <div class="container">
            <div class="col-sm-3">
                <div class="well">
                    <img src="img/ladda ned.png" class="img-responsive center-block" style="background-color: #BE524F; height: 38vh;"/>
                    <br/>
                    <a href="index.php">Edit Picture</a>
                    <br/>
                </div>
            </div>
            <div class="well col-sm-9" style="height: 50vh;">
                <h2><?php echo $name ?></h2>
                <br/>
                <h4>Profile</h4>
                <table class="table table-striped">

                    <tbody>
                        <tr>
                            <th>Email:</th>
                            <td><a><?php echo $email ?></a></td> 
                        </tr>
                        <tr>
                            <th>Phone number:</th>
                            <td><?php echo $nummer ?></td>
                        </tr>
                        <tr>
                            <th>Address:</th>
                            <td>Somewhere in sweden</td>
                        </tr>
                    </tbody>
                </table>
                <div class="text-right">
                    <button class="btn btn-danger">Edit Profile <span class="glyphicon glyphicon-edit"></span></button>
                </div>
            </div>
        </div>
        <div class="container">
            <div>
                <input id="station" type="text" />
                <input id="station2" type="text" />
                <input type="button" value="Visa" onclick="anrop();" />
                <span id="loader" style="margin-left: 10px">Laddar data ...</span>
            </div>
            <div id="result">

                <h3>Avgående tåg</h3>
                <table border="1" id="tableAvgaende">
                    <tr>
                        <th scope="col" style="width:40px;">Tid</th>
                        <th scope="col" style="width:200px;">Från</th>
                    </tr>
                </table>
                <h4>Ankommande tåg</h4>
                <table border="1" id="tableAnkommande">
                    <tr>
                        <th scope="col" style="width:40px;">Tid</th>
                        <th scope="col" style="width:200px;">Till</th>
                    </tr>
                </table>
            </div>
        </div>
        <div class="container"><div class="col-sm-offset-3 col-sm-9" id="map"></div></div>
        <!-- Bottom nav -->
        <footer class="footer">
            <div class="container" >
                <div class="row">
                    <div class="col-md-4">
                        <h2 class="text-white text-center">Boring Stuff</h2> 
                        <br/>
                        <p class="text-white">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam convallis quam et tellus elementum, a vulputate arcu pulvinar. Sed ut commodo ipsum, eu commodo purus. Nulla eget feugiat ipsum. Morbi dignissim, arcu eu lobortis iaculis, neque massa venenatis velit, placerat bibendum elit mauris sit amet velit.</p>
                    </div>
                    <div class="col-md-1 col-xs-2 col-xs-offset-2 col-md-offset-0 icons"><a href="https://www.facebook.com"><img src="img/facebook-white-256.png" alt="Vår Facebooksida"/></a></div>
                    <div class="col-md-1 col-xs-2 icons"><a href="https://www.instagram.com/"><img src="img/instagram.png" alt="Vår Instagramsida"/></a></div>
                    <div class="col-md-1 col-xs-2 icons"><a href="https://www.twitter.com"><img src="img/twitter.png" alt="Vår Twittersida"/></a></div>
                    <div class="col-md-1 col-xs-2 icons"><a href="https://www.youtube.com"><img src="img/youtube.png" alt="Vår Youtube kanal"/></a></div>
                    <div class="col-md-4 col-md-offset-0 col-xs-8 col-xs-offset-2">
                        <ul style="border-left: white solid; margin-top: 20px;">
                            <li class="text-white"><span class="glyphicon glyphicon-map-marker glyph_footer"></span>  Gamla Norrvägen 6, 352 43 Växjö, Sweden</li>
                            <li class="text-white"><span class="glyphicon glyphicon-earphone glyph_footer"></span>  + 0470-419 00</li>
                            <li class="text-white"><span class="glyphicon glyphicon-envelope glyph_footer"></span>  BikePool@support.com</li>
                            <br/>
                        </ul>  
                    </div>
                </div>
                <div class="row"><p class="text-center text-white" ><span class="glyphicon glyphicon-copyright-mark"></span>Copyright, All rights reserved.</p></div>
            </div>
        </footer>
        <script src="JS/modernizr-custom.js" type="text/javascript"></script>
        <script src="JS/googleMapScript.js" type="text/javascript"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCe6YvYhgU76_ke2Z64dwv1sHTpj6OibHE&callback=initMap"
        async defer></script>
    </body>
</html>

