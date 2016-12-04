<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="bower_components/bootstrap/less/jumbotron.less" type="text/css">
        <link href="CSS/design.css" rel="stylesheet" type="text/css"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <style>
            #map {
              height: 100%; 
              border: solid #BE524F;
            }
            html, body{
                      padding-top: 60px;
                      background-image: url(img/white_background2.jpg);
                      background-repeat: no-repeat;
                      background-size: cover;
        </style>
    </head>
    <body>
        <header>
            <nav class="navbar  navbar-fixed-top" style="background-color: #BE524F;">
                <div class="container">
                    <!-- navbar header -->
                    <div class="navbar-header">
                      <button type="button" class="navbar-toggle" style="background: white;"  data-toggle="collapse" data-target="#myNavbar">
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>                        
                    </button>
                      <a class="navbar-brand test" href="#"><img src="img/Logo.png" width="300"/></a>
                  </div>
                  <div class="collapse navbar-collapse" id="myNavbar">
                      <!-- left nav menu -->
                    <ul class="nav navbar-nav ul-nav">
                        <li class=""><a href="#" class="text-white-hover active"><span class="glyphicon glyphicon-home"></span> Home</a></li>
                        <li><a href="#" class="text-white-hover"><span class="glyphicon glyphicon-search"></span> The Flow</a></li>
                        <li><a href="#" class="text-white-hover"><span class="glyphicon glyphicon-info-sign"></span> About</a></li>
                    </ul>
                      <!-- right dropdown menu -->
                    <ul class="nav navbar-nav navbar-right ul-nav">
                        <li class="dropdown">
                            <img src="img/caspooor.jpg" width="40" class="img-circle"/>
                            <a class="dropdown-toggle text-white text-white-hover" data-toggle="dropdown" href="#" style="float: right;">My profile <span class="caret"></span></a>
                            
                        <ul class="dropdown-menu" style="background: #BE524F;">
                            <li><a href="#" class="text-white text-white-hover">Help</a></li>
                            <li><a href="#" class="text-white text-white-hover">Options</a></li>
                            <li><a href="#" class="text-white text-white-hover">Log out</a></li>
                        </ul>
                      </li>
                    </ul>
                  </div>
                </div>
            </nav>
        </header>
        
        <!-- Page content below -->
        <div class="container">
            <div class="col-sm-3">
                <div class="well">
                    <img src="img/caspooor.jpg" class="img-responsive center-block" style="background-color: #BE524F; height: 38vh;"/>
                    <br/>
                    <a>Edit Picture</a>
                    <br/>
                </div>
            </div>
            <div class="well col-sm-9" style="height: 50vh;">
                    <h2>Casper Björk</h2>
                    <br/>
                    <h4>Profile</h4>
                    <table class="table table-striped">
                      
                      <tbody>
                        <tr>
                            <th>Email:</th>
                            <td><a>bjork.casper@utb.vaxjo.se</a></td> 
                        </tr>
                        <tr>
                            <th>Phone number:</th>
                            <td>It's classified</td>
                        </tr>
                        <tr>
                            <th>Address:</th>
                            <td>Somewhere in sweden</td>
                        </tr>
                        <tr>
                            <th>Birthday:</th>
                            <td>29 April</td>
                        </tr>
                      </tbody>
                    </table>
                    <div class="text-right">
                        <button class="btn btn-danger">Edit Profile <span class="glyphicon glyphicon-edit"></span></button>
                    </div>
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
        <script src="js/modernizr-custom.js" type="text/javascript"></script>
        <script src="js/script.js" type="text/javascript"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCe6YvYhgU76_ke2Z64dwv1sHTpj6OibHE&callback=initMap"
    async defer></script>
    </body>
</html>

