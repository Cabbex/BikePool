<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html ng-app="userApp">
    <head>
        <meta charset="UTF-8">
        <title>Flöde</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="bower_components/bootstrap/less/jumbotron.less" type="text/css">
        <link href="CSS/design.css" rel="stylesheet" type="text/css"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="bower_components/angular/angular.min.js" type="text/javascript"></script>
        <script src="JS/flode.js" type="text/javascript"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <style>
            #map {
                height: 100%; 
                border: solid #BE524F;
            }
            html, body{
                padding-top: 50px;
                background-color: #f9f7f6;
                background-repeat: no-repeat;
                background-size: cover;
            </style>
        </head>
        <body ng-controller="userCtrl">
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
                                <li class=""><a href="#" class="text-white-hover"><span class="glyphicon glyphicon-home"></span> Home</a></li>
                                <li><a href="#" class="text-white-hover active"><span class="glyphicon glyphicon-search"></span> The Flow</a></li>
                                <li><a href="#" class="text-white-hover"><span class="glyphicon glyphicon-info-sign"></span> About</a></li>
                            </ul>
                            <!-- right dropdown menu -->
                            <ul class="nav navbar-nav navbar-right ul-nav">
                                <li class="dropdown">
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

            <div id="flow">
                <div class="content container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <h2>Find your partner</h2>
                            </div>
                            <div class="col-md-6">
                                <form class="search">
                                    <h3><input type="text" name="search" placeholder="Search.."></h3>
                                </form>
                            </div>
                            <table class="table table-striped">
                                <tr ng-repeat="user in users | filter:query | orderBy:sortField:reverse">
                                    <td>{{user.Namn}}</td>
                                    <td>{{user.Tillganglighet}}</td>
                                    <td>{{user.Tagtid}}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </body>
    </html>
