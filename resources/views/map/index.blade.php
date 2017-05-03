@extends('layouts.app')
@section('title','谷歌地图实例')
@section('content')
    <div class="gtco-loader"></div>
    <div id="page">
        <!-- <div class="page-inner"> -->
        <nav class="gtco-nav" role="navigation">
            <div class="gtco-container">

                <div class="row">
                    <div class="col-sm-4 col-xs-12">
                        <div id="gtco-logo"><a href="index.html">Savory <em>.</em></a></div>
                    </div>
                </div>

            </div>
        </nav>
        <header id="gtco-header" class="gtco-cover gtco-cover-md" role="banner" style="background-image: url(images/img_bg_1.jpg)">
            <div class="overlay"></div>
            <div class="gtco-container">
                <div class="row">
                    <div class="col-md-12 col-md-offset-0 text-left">
                        <div class="row row-mt-13em ">
                            <div class="header-content col-md-8 col-md-offset-2 col-xs-12">
                                <div class="col-md-12">
                                    <h3>Who delivers in your neighborhood?</h3>
                                    <p>Enter your address below</p>
                                </div>
                                <div class="header-search col-md-12">
                                    <div class="col-md-8 no-padding" style="position: relative">
                                        <input id="autocomplete" type="text" class="form-control" placeholder="Where are you ?">
                                        <i class="glyphicon glyphicon-map-marker "></i>
                                    </div>
                                    <div class="col-md-4">
                                        <button id="search" class="btn btn-success">Find food</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <div id="gtco-features">
            <div class="gtco-container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2 text-center gtco-heading animate-box">
                        <h2 class="cursive-font">Our Services</h2>
                        <p>Dignissimos asperiores vitae velit veniam totam fuga molestias accusamus alias autem provident. Odit ab aliquam dolor eius.</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-6">
                        <div class="feature-center animate-box" data-animate-effect="fadeIn">
						<span class="icon">
							<i class="ti-face-smile"></i>
						</span>
                            <h3>Happy People</h3>
                            <p>Dignissimos asperiores vitae velit veniam totam fuga molestias accusamus alias autem provident. Odit ab aliquam dolor eius.</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="feature-center animate-box" data-animate-effect="fadeIn">
						<span class="icon">
							<i class="ti-thought"></i>
						</span>
                            <h3>Creative Culinary</h3>
                            <p>Dignissimos asperiores vitae velit veniam totam fuga molestias accusamus alias autem provident. Odit ab aliquam dolor eius.</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="feature-center animate-box" data-animate-effect="fadeIn">
						<span class="icon">
							<i class="ti-truck"></i>
						</span>
                            <h3>Food Delivery</h3>
                            <p>Dignissimos asperiores vitae velit veniam totam fuga molestias accusamus alias autem provident. Odit ab aliquam dolor eius.</p>
                        </div>
                    </div>


                </div>
            </div>
        </div>
        <div id="gtco-counter" class="gtco-section">
            <div class="gtco-container">

                <div class="row">
                    <div class="col-md-8 col-md-offset-2 text-center gtco-heading animate-box">
                        <h2 class="cursive-font primary-color">Fun Facts</h2>
                        <p>Dignissimos asperiores vitae velit veniam totam fuga molestias accusamus alias autem provident. Odit ab aliquam dolor eius.</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-6 animate-box" data-animate-effect="fadeInUp">
                        <div class="feature-center">
                            <span class="counter js-counter" data-from="0" data-to="5" data-speed="5000" data-refresh-interval="50">1</span>
                            <span class="counter-label">Avg. Rating</span>

                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 animate-box" data-animate-effect="fadeInUp">
                        <div class="feature-center">
                            <span class="counter js-counter" data-from="0" data-to="43" data-speed="5000" data-refresh-interval="50">1</span>
                            <span class="counter-label">Food Types</span>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 animate-box" data-animate-effect="fadeInUp">
                        <div class="feature-center">
                            <span class="counter js-counter" data-from="0" data-to="32" data-speed="5000" data-refresh-interval="50">1</span>
                            <span class="counter-label">Chef Cook</span>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 animate-box" data-animate-effect="fadeInUp">
                        <div class="feature-center">
                            <span class="counter js-counter" data-from="0" data-to="1985" data-speed="5000" data-refresh-interval="50">1</span>
                            <span class="counter-label">Year Started</span>

                        </div>
                    </div>

                </div>
            </div>
        </div>

        <footer id="gtco-footer" role="contentinfo">
            <div class="overlay"></div>
            <div class="gtco-container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <div class="gtco-widget">
                            <h3>Get In Touch</h3>
                            <ul class="gtco-quick-contact">
                                <li><a href="#"><i class="icon-phone"></i> +1 234 567 890</a></li>
                                <li><a href="#"><i class="icon-mail2"></i> info@GetTemplates.co</a></li>
                                <li><a href="#"><i class="icon-chat"></i> Live Chat</a></li>
                            </ul>
                        </div>
                        <div class="gtco-widget">
                            <h3>Get Social</h3>
                            <ul class="gtco-social-icons">
                                <li><a href="#"><i class="icon-twitter"></i></a></li>
                                <li><a href="#"><i class="icon-facebook"></i></a></li>
                                <li><a href="#"><i class="icon-linkedin"></i></a></li>
                                <li><a href="#"><i class="icon-dribbble"></i></a></li>
                            </ul>
                        </div>
                        <div class="col-md-12 text-center copyright">
                            <p><small class="block">&copy; 2016 Free HTML5. All Rights Reserved.</small>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <div class="gototop js-top">
        <a href="#" class="js-gotop"><i class="icon-arrow-up"></i></a>
    </div>
@endsection

@section('css')
    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">
    <link rel="stylesheet" href="{{ asset('/css/map/icomoon.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/map/style1.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/map/themify-icons.css') }}">
    <style>
        .main-header,.footer{
            display: none;
        }
    </style>
@endsection
@section('script')
    <script src="{{ asset('/js/jquery.easing.1.3.js') }}"></script>
    <script>
        (function () {
            'use strict';
            var goToTop = function() {

                $('.js-gotop').on('click', function(event){

                    event.preventDefault();

                    $('html, body').animate({
                        scrollTop: $('html').offset().top
                    }, 500, 'easeInOutExpo');

                    return false;
                });

                $(window).scroll(function(){

                    var $win = $(window);
                    if ($win.scrollTop() > 200) {
                        $('.js-top').addClass('active');
                    } else {
                        $('.js-top').removeClass('active');
                    }

                });

            };
            // Loading page
            var loaderPage = function() {
                $(".gtco-loader").fadeOut("slow");
            };
            $(function(){
                goToTop();
                loaderPage();
            });
        }());
        var autocomplete,dist,state;
        function initAutocomplete() {
            geolocate();
            autocomplete = new google.maps.places.Autocomplete(
                    (document.getElementById('autocomplete')),
                    {types: ['geocode'],componentRestrictions: {country:"US"}}
                    );
            var geolocation = {lat: 39.9535552, lng: -75.156301};//固定中心点经纬度
            var circle = new google.maps.Circle(
                    {
                        center: geolocation, //中心
                        radius: 16093.44 //半径
                    });
            autocomplete.setBounds(circle.getBounds());
            autocomplete.addListener('place_changed', Distance);
        }
        function Distance() {
            // Get the place details from the autocomplete object.
            var place = autocomplete.getPlace();
            for (var i = 0; i < place.address_components.length; i++) {
                var addressType = place.address_components[i].types[0];
                if (addressType == 'administrative_area_level_1') {
                    state = place.address_components[i].short_name;
                    console.log('State:'+state+'('+place.address_components[i].long_name+')');
                }
            }
            if(place.formatted_address){
                computer_distance(place.formatted_address);//计算距离
            }
        }
        function computer_distance(_start) {
            console.time('计时器');
            var start = _start ;
            var end = "100 N 10th St Philadelphia PA 19107";
            var request = {
                origin: start,
                destination: end,
                travelMode: google.maps.DirectionsTravelMode.DRIVING
            };
            var directionsService = new google.maps.DirectionsService();
            directionsService.route(request, function (response, status) {
                if (status == google.maps.DirectionsStatus.OK) {
                    var route = response.routes[0];
                    var d_mi = route.legs[0].distance.value;//单位是米
                    dist = (d_mi/1609.344).toFixed(2);//距离，单位英里保留两位小数
                    console.info("距离为："+dist+'英里');
                    console.timeEnd('计时器');
                }else{
                    dist = -1;
                    console.log("Computer Distance failed due to: "+status)
                }
            });
        }
        function geolocate() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var geolocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    var circle = new google.maps.Circle({
                        center: geolocation,
                        radius: position.coords.accuracy
                    });
                    var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                    var geocoder = new google.maps.Geocoder();

                    geocoder.geocode({'latLng': latlng}, function(results, status) {
                        if (status == google.maps.GeocoderStatus.OK) {
                            if (results[0]) {
//                                console.log(results[0]);
                                for (var i = 0; i < results[0].address_components.length; i++) {
                                    var addressType = results[0].address_components[i].types[0];
                                    if (addressType == 'administrative_area_level_1') {
                                        state = results[0].address_components[i].short_name;
                                        console.log('State:'+state+'('+results[0].address_components[i].long_name+')');
                                    }
                                }
                                $('#autocomplete').val(results[0].formatted_address);
                                computer_distance(results[0].formatted_address)
                            } else {
                                console.log ('No results found');
                            }
                        } else {
                            dist = -1;
                            console.log ('Geocoder failed due to: ' + status);
                        }
                    });
                });
            }
        }
        $('#search').click(function () {
            if(dist <10 && dist != -1 && state == 'PA'){
                window.location.href = 'https://www.516delivery.com/order'
            }else{
                confirm('对不起，您所在地址不在服务区内!');
            }
        })
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBH8maSo3ESL-gI6IpgD61-Jg7Tsl0OWLI&libraries=places&callback=initAutocomplete" async defer></script>
@endsection