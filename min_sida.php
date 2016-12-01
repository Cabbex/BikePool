
<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="bower_components/bootstrap/less/jumbotron.less" type="text/css">
        <link href="CSS/googleMap.css" rel="stylesheet" type="text/css"/>
        
    </head>
    <body>
        <header>
            <div>
                <nav class="navbar navbar-default navbar-fixed-top" style="background-color: #C72532;">
                    <div class="navbar-header">
                          <a class="navbar-brand" href="#"><img src="img/Logo.png" style=""/></a>
                      </div>
                    <div class="container" id="special">
                      
                      <ul class="nav navbar-nav">   
                          <li class="active"><a href="#"><span class="glyphicon glyphicon-home"></span> Home</a></li>
                        <li><a href="#"><span class="glyphicon glyphicon-search"></span> Flödet</a></li>
                        <li><a href="#"><span class="glyphicon glyphicon-heart"></span> Favoriter</a></li> 
                        <li><a href="#"><span class="glyphicon glyphicon-info-sign"></span> Om BP</a></li> 
                      </ul>
                        
                        <a href="#" class="navbar-text navbar-right">Logga ut</a>
                        <a class="navbar-text navbar-right"> <span class="glyphicon glyphicon-globe"></span> </a>
                        <a class="navbar-text navbar-right"> <span class="glyphicon glyphicon-envelope"> </span></a>
                        <a class="navbar-text navbar-right"> <span class="glyphicon glyphicon-user"></span></a>
                    </div>
                </nav>
                
                
            </div>
        </header>
        <div class="container">
            <div class="col-sm-3">
                <div class="well">
                    <img src="img/ladda ned.png" class="img-responsive" style="background-color: red;"/>
                    <br/>
                    <a>Redigera profilbild</a>
                    <br/>
                     </div>
            </div>
            <div class="well col-sm-9">
                    <h2>Jones Amor Trabelsi</h2>
                    <br/>
                    <h4>Description:</h4>
                    <table class="table table-striped">
                      
                      <tbody>
                        <tr>
                            <th>Email:</th>
                            <td><a>jt96001@utb.vaxjo.se</a></td> 
                        </tr>
                        <tr>
                            <th>Telefon nummer:</th>
                          <td>072-252 80 43</td>
                        </tr>
                        <tr>
                            <th>Adress:</th>
                          <td>Storgatan 13</td>
                        </tr>
                        <tr>
                            <th>Födelsedatum:</th>
                          <td>9 December</td>
                        </tr>
                      </tbody>
                    </table>
                    <div class="text-right">
                        <button class="btn btn-danger">Ändra Profil <span class="glyphicon glyphicon-edit"></span></button>
                    </div>
            </div>
            
        </div>
        <div class="col-sm-offset-1 col-sm-10" id="map"></div>
        
        <script src="js/modernizr-custom.js" type="text/javascript"></script>
        <script src="js/googleMapScript.js" type="text/javascript"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCe6YvYhgU76_ke2Z64dwv1sHTpj6OibHE&callback=initMap"
    async defer></script>
    </body>
</html>
