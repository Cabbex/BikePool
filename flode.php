<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html ng-app="userApp">
    <head>
        <meta charset="UTF-8">
        <title>Bikepool</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="bower_components/bootstrap/less/jumbotron.less" type="text/css">
        <link href="CSS/design.css" rel="stylesheet" type="text/css"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="bower_components/angular/angular.min.js" type="text/javascript"></script>
        <script src="JS/flode.js" type="text/javascript"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

        </head>
        <body ng-controller="userCtrl">
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
                                <li><a href="#"><span class="glyphicon glyphicon-search"></span> The Flow</a></li>
                                <li><a href="#"><span class="glyphicon glyphicon-user"></span> My Page</a></li>
                            </ul>
                            <ul class="nav navbar-nav pull-right">
                                <li><a href="#"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>

                            </ul>
                        </div>
                    </div>
                </nav>
            </header>

            <div id="flow">
                <div class="content container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <h2>Find your partner</h2>
                            </div>
                            <table class="table table-striped">
                                <tr>
                                    <th><a ng-click="sortField = 'Namn'; reverse = !reverse;">Name</a></th>
                                    <th><a ng-click="sortField = 'Tillganglighet'; reverse = !reverse;">Availability</a></th>
                                    <th><a ng-click="sortField = 'Tagtid'; reverse = !reverse;">Train time</a></th>
                                    <th><input class="pull-right" placeholder="Search.." type="text" ng-model="query"/></th>
                                </tr>
                                <tr ng-repeat="user in users| filter:query | orderBy:sortField:reverse">
                                    
                                    <td>{{user.Namn}}</td>
                                    <td>{{user.Tillganglighet}}</td>
                                    <td>{{user.Tagtid}}</td>
                                    <td><button class="btn btn-primary pull-right" >Profile</button></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </body>
    </html>