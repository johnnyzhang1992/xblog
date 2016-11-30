/**
 * Created by zq199 on 2016/9/1.
 * BaiDuMap config
 */
'use strict';
//百度地图API功能
var bdMapController = {
    /* --------config start----- */
    // ws_url: '//' + window.location.host + '/',
    // site_url: '//' + window.location.host + '/',
    map: null,
    zoom: 7,
    bdMap_ak: 'V5YM1CIwjDz2OEFTs4EAoPpv',
    //init BaiDuMap start
    init: {
        handle: function(){
            bdMapController.init.initMap();
            bdMapController.init.initController();
            bdMapController.init.initGeoLocationControl();
            bdMapController.init.initTool();

            bdMapController.render.marker_render();
        },
        initMap: function () {
            bdMapController.map = new BMap.Map("map");// 创建地图实例
            var point = new BMap.Point(112.424106,34.613064);// 创建点坐标
            bdMapController.map.centerAndZoom(point, bdMapController.zoom);//设置地图中心
            // bdMapController.render.addMarker(point);
        },
        initController: function () {
            //初始化控件
            // 导航
            var bottom_left_control = new BMap.ScaleControl({
                anchor: BMAP_ANCHOR_BOTTOM_LEFT,
                offset:new BMap.Size(60, 40)
            });// 左上角，添加比例尺
            var top_right_navigation = new BMap.NavigationControl({
                // 靠左上角位置
                anchor: BMAP_ANCHOR_BOTTOM_RIGHT,
                offset: new BMap.Size(40, 80),
                // LARGE类型
                type: BMAP_NAVIGATION_CONTROL_SMALL,
                // 启用显示定位
                enableGeolocation: true
            });  //左上角，添加默认缩放平移控件
            var city_list_control = new BMap.CityListControl({
                anchor: BMAP_ANCHOR_TOP_RIGHT,
                offset: new BMap.Size(243, 90)
                // 切换城市之间事件
                // onChangeBefore: function(){
                //    alert('before');
                // },
                // 切换城市之后事件
                // onChangeAfter:function(){
                //   alert('after');
                // }
            });//城市列表
            var overview_map_control = new BMap.OverviewMapControl();//缩略图
            var map_type_control = new BMap.MapTypeControl({
                    anchor: BMAP_ANCHOR_BOTTOM_RIGHT,
                    offset: new BMap.Size(20, 40)
                });//地图类型
            /*缩放控件type有四种类型:BMAP_NAVIGATION_CONTROL_SMALL：仅包含平移和缩放按钮；BMAP_NAVIGATION_CONTROL_PAN:仅包含平移按钮；BMAP_NAVIGATIO*/
            bdMapController.map.addControl(bottom_left_control);//比例尺
            bdMapController.map.addControl(top_right_navigation);//导航
            bdMapController.map.addControl(overview_map_control);//缩略图
            bdMapController.map.addControl(map_type_control);//地图类型
            bdMapController.map.addControl(city_list_control);//城市列表
        },
        initGeoLocationControl: function () {
            // 添加定位控件
            var geolocationControl = new BMap.GeolocationControl();
            geolocationControl.addEventListener("locationSuccess", function(e){
                // 定位成功事件
                var address = '';
                address += e.addressComponent.province;
                address += e.addressComponent.city;
                address += e.addressComponent.district;
                address += e.addressComponent.street;
                address += e.addressComponent.streetNumber;
                // alert("当前定位地址为：" + address);
            });
            geolocationControl.addEventListener("locationError",function(e){
                // 定位失败事件
                alert(e.message);
            });
            bdMapController.map.addControl(geolocationControl);
        },
        initTool: function () {
            // 启用小工具
            bdMapController.map.enableScrollWheelZoom();//启用滚轮放大缩小
            bdMapController.map.enableInertialDragging();
            bdMapController.map.enableContinuousZoom();
            // bdMapController.map.SearchInfoWindow();
        }
    },
    render: {
        //小图标渲染函数
        addMarker:function (latlng,name,tag,address,desc) {
            if(tag=='spot'){
                tag = '景点';
            }else if(tag =='university'){
                tag = '大学';
            }
            var marker = new BMap.Marker(latlng);
            // bdMapController.map.addOverlay(marker);
            //信息窗infoWindows
            // var sContent =
            //     "<div><a href='#/"+tag+"/"+id+"' target='_blank'>"+
            //     "<img id='imgDemo' src='http://app.baidu.com/map/images/tiananmen.jpg' width='100%' height='104' title='"+name+"'/></a>" +
            //     "<p style='margin:0;line-height:1.5;font-size:13px;text-indent:2em'>"+name+"</p>" +
            //     "</div>";
            // var infoWindow = new BMap.InfoWindow(sContent);  // 创建信息窗口对象
            var content = '<div style="margin:0;line-height:20px;padding:2px;">' +
                '<img src="../images/yeoman.png" alt="" style="float:right;zoom:1;overflow:hidden;width:100px;height:100px;margin-left:3px;"/>' +
                '地址：'+ address+'<br><i class="glyphicon glyphicon-tag"></i>' +tag+ '<br/>描述：'+desc + '</div>';
            //创建检索信息窗口对象
            var searchInfoWindow = null;
            searchInfoWindow = new BMapLib.SearchInfoWindow(bdMapController.map, content, {
                title  : name,      //标题
                width  : 290,             //宽度
                height : 105,              //高度
                panel  : "panel",         //检索结果面板
                enableAutoPan : true,     //自动平移
                searchTypes   :[
                    BMAPLIB_TAB_SEARCH,   //周边检索
                    BMAPLIB_TAB_TO_HERE,  //到这里去
                    BMAPLIB_TAB_FROM_HERE //从这里出发
                ]
            });
            marker.addEventListener("click", function(e){//小图标添加监听事件"click"
                searchInfoWindow.open(marker);
            });
            bdMapController.map.addOverlay(marker); //在地图中添加marker
        },
        // 获取图标信息
        marker_render: function()  {
            var marker_points = {};
            $.ajax({
                type:"get",
                // url: "data/get_data.php",
                url: "data/data.json",
                // dataType: "json",
                async : false,
                data:{},
                success: function (data) {
                    marker_points = data.poi_data;
                }
            });
            if(marker_points.length !== 0){
                for (var i = 0; i < marker_points.length; i ++) {
                    var marker_point = marker_points[i];
                    var latlng = new BMap.Point(marker_point.lng,marker_point.lat);
                    var name = marker_point.name;
                    var tag =marker_point.tag;
                    var address =marker_point.address;
                    var desc =marker_point.description;
                    bdMapController.render.addMarker(latlng,name,tag,address,desc);
                }
            }

            // var bounds = bdMapController.map.getBounds();
            // var sw = bounds.getSouthWest();
            // var ne = bounds.getNorthEast();
            // var lngSpan = Math.abs(sw.lng - ne.lng);
            // var latSpan = Math.abs(ne.lat - sw.lat);
        },
        open_distance_tool: function () {
            var myDis = new BMapLib.DistanceTool(bdMapController.map);
            myDis.open();  //开启鼠标测距
            //myDis.close();  //关闭鼠标测距大
        }
    }
};
// function loadJScript(){
//     var script = document.createElement("script");
//     script.type = "text/javascript";
//     script.src = "http://api.map.baidu.com/api?v=2.0&ak=V5YM1CIwjDz2OEFTs4EAoPpv&callback=bdMapController.init.handle";
//     document.body.appendChild(script);
// }
//
//
// window.onload = loadJScript();  //异步加载地图
$(document).ready(
    bdMapController.init.handle(function () {
        bdMapController.render.addMarker();
    })
);

//工具
// MarkerTool：标注工具。通过此工具用户可在地图任意区域添加标注。
// MarkerClusterer：多标注聚合器。此工具解决加载大量点要素到地图上造成缓慢，且产生覆盖现象的问题。
// MarkerManager：标注管理工具。此工具提供展示、隐藏、清除所有标注。
// RichMarker：富标注工具。此工具为用户提供自定义Marker样式，并添加点击、双击、拖拽等事件。
// DistanceTool：测距工具。通过此工具用户可测量地图上任意位置之间的距离。
// RectangleZoom：区域缩放工具。此工具将根据用户拖拽绘制的矩形区域大小对地图进行放大或缩小操作。
// MapWrapper：地图搬家工具。此工具提供了将Google或GPS坐标形式的Marker添加到百度地图上的功能。
// InfoBox：自定义信息窗口工具。类似于infoWindow，比infoWindow更有灵活性，比如可以定制border，关闭按钮样式等。
// LuShu：路书，轨迹运动工具。此工具用以实现marker沿路线运动，并有暂停等功能。
// CityList：城市列表工具。此工具为用户直接生成城市列表，并且自带选择城市操作。
// AreaRestriction：区域限制工具。此工具为用户提供百度地图浏览区域限制设置。
// GeoUtils：几何运算工具。此工具提供判断点与矩形、 圆形、多边形线、多边形面的关系,并提供计算折线长度和多边形的面积的公式。
// TrafficControl：实时交通控件。此工具提供将交通流量图层在地图上的实时显示，隐藏等。
// SearchControl：检索控件。此工具针对移动端，提供城市列表选择、本地检索框、公交驾车查询框。并提供相应功能。
// DrawingManager：鼠标绘制工具。通过此工具用户可以在地图任意位置上画点、画线、画面并显示线的距离及面的面积。
// EventWrapper：事件封装工具。该工具提供了更人性化的事件使用方法。
// TextIconOverlay：自定义覆盖物工具。用户可以使用该工具在地图上添加文字和图标样式的覆盖物。
// SearchInRectangle：拉框缩放工具，用于实现三种拉框搜索效果。
// SearchInfoWindow：“百度地图样式”的信息窗口工具。该工具为用户提供带搜索框的信息窗口，该窗口内容可自由定制多种风格。同时，用户可以将信息窗口标题以短信方式发送到手机上。

