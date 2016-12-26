<form role="form"  class="form-horizontal" action="{{ url('admin/poi/create') }}" method="post">
{{ csrf_field() }}
    <!--标签（Tag）-->
    <div class="form-group">
        <label class="col-sm-2 control-label" for="tag">标签(Tag)</label>
        <div class="col-sm-10">
            <input  type="text" id="tag" ng-model="tag" name="_poi[tag]"  class="form-control">
        </div>
    </div>
    <!--经纬度（LatLng）-->
    <div class="form-group">
        <div class="col-sm-6" style="padding-left: 0">
            <label class="col-sm-4 control-label" for="lat">经度(Lat)</label>
            <div class="col-sm-8">
                <input  type="text" id="lat" ng-model="lat" name="_poi[lat]"  class="form-control">
            </div>
        </div>
        <div class="col-sm-6" style="padding-left: 0">
            <label class="col-sm-4 control-label" for="lng">纬度(Lng)</label>
            <div class="col-sm-8">
                <input  type="text" id="lng" ng-model="lng" name="_poi[lng]" class="form-control">
            </div>
        </div>
    </div>
    <!--名称-->
    <div class="form-group">
        <label class="col-sm-2 control-label" for="name">名称(Name)</label>
        <div class="col-sm-10">
            <input  type="text" id="name" ng-model="name" name="_poi[poi_name]"  class="form-control">
        </div>
    </div>
    <!--地址(Address)-->
    <div class="form-group">
        <label class="col-sm-2 control-label" for="address">地址(Address)</label>
        <div class="col-sm-10">
            <input  type="text" id="address" ng-model="address " name="_poi[address]"  class="form-control">
        </div>
    </div>
    <div class="form-group">
        <label for="comment_info" class="control-label">评论信息</label>
        <select style="margin-top: 5px" id="comment_info" name="comment_info" class="form-control">
            <option value="default" >默认</option>
            <option value="force_disable" >强制关闭</option>
            <option value="force_enable" >强制开启</option>
        </select>
    </div>
    <div class="form-group">
        <label for="comment_type" class="control-label">评论类型</label>
        <select id="comment_type" name="comment_type" class="form-control">
            <option value="default">默认</option>
            <option value="raw">自带评论</option>
            <option value="disqus">Disqus</option>
            <option value="duoshuo">多说</option>
        </select>
    </div>
    <!--描述-->
    <div class="form-group">
        <label class="col-sm-2 " for="description">描述(Description)</label>
        <div class="col-sm-10">
            <textarea  rows="3" id="description" ng-model="description" name="_poi[description]" class="form-control">目的地描述</textarea>
        </div>
    </div>
    <button type="submit"  class="btn btn-success btn-lg" style="width: 100%;">保存</button>
</form>