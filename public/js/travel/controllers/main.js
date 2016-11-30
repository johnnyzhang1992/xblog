'use strict';

/**
 * @ngdoc function
 * @name baidumapApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the baidumapApp
 */
angular.module('baidumapApp')
    .controller('MainCtrl',function ($scope,$http) {
        $http.get("data/data.json")
            .success(function(response) {
                $scope.poi_data = response.poi_data;
            });
        // window.onload = loadJScript();  //异步加载地图
        var current_lat,current_lng;
        $(document).ready(
            bdMapController.init.handle(function () {
                bdMapController.render.addMarker();
            })
        );
        $scope.searchbox_toggle = true;//搜索框显示
        $scope.remove_latlng = true;
        $scope.get_latlng = function () {
            $scope.remove_latlng = !$scope.remove_latlng;
            //单击获取点击的经纬度
            bdMapController.map.addEventListener("click", function (e) {
                $('#current_lat').html("纬度："+e.point.lat);
                $('#current_lng').html("经度："+e.point.lng);
            });
        };//获取坐标函数
        $scope.box_show = false;
        $scope.tool_toogle_box = function () {//搜索框显示函数
            $scope.box_show = !$scope.box_show;
        };
        $scope.measure = function () {
            bdMapController.render.open_distance_tool()
        };//打开坐标获取控件
        $scope.hide_latlng = function () {
            $scope.remove_latlng = true;
            // bdMapController.map.removeEventListener("click", function () {});
        };//是否隐藏坐标显示面板
        // searchbox
        $scope.clear = false;

        $scope.input_change = function () {
            if($scope.sole_input.length>=2){
                $scope.clear = true;
            }else{
                $scope.clear = false;
            }
        };//搜索框输入监控
        $scope.clear_input = function () {
            $scope.sole_input= '';
            $scope.clear = false;
        };//情况输入框
        $scope.route_loading = function () {

        };
        // 百度地图API功能
        function G(id) {
            return document.getElementById(id);
        }

        var ac = new BMap.Autocomplete({//建立一个自动完成的对象
            "input" : "sole-input"
            ,"location" : bdMapController.map
        });

        ac.addEventListener("onhighlight", function(e) {  //鼠标放在下拉列表上的事件
            var str = "";
            var _value = e.fromitem.value;
            var value = "";
            if (e.fromitem.index > -1) {
                value = _value.province +  _value.city +  _value.district +  _value.street +  _value.business;
            }
            str = "FromItem<br />index = " + e.fromitem.index + "<br />value = " + value;

            value = "";
            if (e.toitem.index > -1) {
                _value = e.toitem.value;
                value = _value.province +  _value.city +  _value.district +  _value.street +  _value.business;
            }
            str += "<br />ToItem<br />index = " + e.toitem.index + "<br />value = " + value;
            G("searchResultPanel").innerHTML = str;
        });
        function setPlace(){
            bdMapController.map.clearOverlays();    //清除地图上所有覆盖物
            function myFun(){
                var pp = local.getResults().getPoi(0).point;    //获取第一个智能搜索的结果
                bdMapController.map.centerAndZoom(pp, 18);
                bdMapController.map.addOverlay(new BMap.Marker(pp));    //添加标注
            }
            var local = new BMap.LocalSearch(bdMapController.map, { //智能搜索
                onSearchComplete: myFun
            });
            local.search(myValue);
        }
        var myValue;
        ac.addEventListener("onconfirm", function(e) {    //鼠标点击下拉列表后的事件
            var _value = e.item.value;
            myValue = _value.province +  _value.city +  _value.district +  _value.street +  _value.business;
            G("searchResultPanel").innerHTML ="onconfirm<br />index = " + e.item.index + "<br />myValue = " + myValue;

            setPlace();
        });
        // routebox
        $scope.route_start_clear = false;
        $scope.route_end_clear = false;
        $scope.start_input_change = function () {
            if($scope.route_start.length>=2){
                $scope.route_start_clear = true;
            }else{
                $scope.route_start_clear = false;
            }
        };
        $scope.end_input_change =function () {
            if($scope.route_end.length>=2){
                $scope.route_end_clear = true;
            }else{
                $scope.route_end_clear = false;
            }
        };
        $scope.clear_start_input = function () {
            $scope.route_start = '';
            $scope.route_start_clear = false;
        };
        $scope.clear_end_input = function () {
            $scope.route_end = '';
            $scope.route_end_clear = false;
        };
        $scope.route_searchbox = false;
        $scope.route_type= 'bus';
        $scope.route_toggle = function () {
            $scope.route_searchbox = !$scope.route_searchbox;
            $scope.searchbox_toggle = !$scope.searchbox_toggle;
        };
        $scope.show_bus = function () {
            $scope.route_type= 'bus';
            $('#r-result').html('');
        };
        $scope.show_drive = function () {
            $scope.route_type= 'drive';
            $('#r-result').html('');
        };
        $scope.show_walk = function () {
            $scope.route_type= 'walk';
            $('#r-result').html('');
        };
        $scope.show_bike = function () {
            $scope.route_type= 'bike';
            $('#r-result').html('');
        };
        $scope.route_revert =function () {
            //交换起点和终点
            $scope.route_mid = $scope.route_start;
            $scope.route_start = $scope.route_end;
            $scope.route_end = $scope.route_mid;
        };
        // var bus_routePolicy = [BMAP_TRANSIT_POLICY_LEAST_TIME,BMAP_TRANSIT_POLICY_LEAST_TRANSFER,BMAP_TRANSIT_POLICY_LEAST_WALKING,BMAP_TRANSIT_POLICY_AVOID_SUBWAYS];
        // var drive_routePolicy = [BMAP_DRIVING_POLICY_LEAST_TIME,BMAP_DRIVING_POLICY_LEAST_DISTANCE,BMAP_DRIVING_POLICY_AVOID_HIGHWAYS];
       //公交
        var transit = new BMap.TransitRoute(bdMapController.map, {
            renderOptions: {
                map: bdMapController.map,
                panel: "r-result"
            }
        });
        // 0:最少时间,1:最少步行,2:不乘地铁
        var driving = new BMap.DrivingRoute(bdMapController.map, {
            renderOptions:{
                map: bdMapController.map,
                panel: "r-result",
                autoViewport: true
            }
        });
        // 0:最少时间,1:最短距离,2:避开高速
        var walking = new BMap.WalkingRoute(bdMapController.map, {
            renderOptions:{
                map: bdMapController.map,
                panel: "r-result",//结果面板
                autoViewport: true
            }
        });
        var ac_bus = new BMap.Autocomplete({//建立一个自动完成的对象
            "input" : "route-end-input",
            "location" : bdMapController.map
        });

        ac_bus.addEventListener("onconfirm", function(e) {    //鼠标点击下拉列表后的事件
            var start = $scope.route_start;
            var end   = $scope.route_end;
            bdMapController.map.clearOverlays();
            switch($scope.route_type)
            {
                case 'bus':
                    transit.search(start,end);
                    break;
                case 'drive':
                    driving.search(start,end);
                    break;
                case 'walk':
                    walking.search(start, end);
                    break;
                case 'bike':
                    walking.search(start, end);
                    break;
                default:
                    console.log('route_default');
            }
        });
    });



