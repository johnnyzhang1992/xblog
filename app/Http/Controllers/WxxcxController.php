<?php
/**
 * Created by PhpStorm.
 * User: zq199
 * Date: 2017/6/8
 * Time: 15:49
 */

namespace App\Http\Controllers;
use Iwanli\Wxxcx\Wxxcx;
use Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WxxcxController extends Controller
{
    protected $wxxcx;

    function __construct(Wxxcx $wxxcx)
    {
        $this->wxxcx = $wxxcx;
    }

    /**
     * 小程序登录获取用户信息
     * @date   2017-05-27T14:37:08+0800
     * return user
     */
    public function getWxUserInfo(Request $request)
    {
        //code 在小程序端使用 wx.login 获取
        $code = $request->input('code', '');
        //encryptedData 和 iv 在小程序端使用 wx.getUserInfo 获取
        $encryptedData = $request->input('encryptedData', '');
        $iv = $request->input('iv', '');

        //根据 code 获取用户 session_key 等信息, 返回用户openid 和 session_key
        $userInfo = $this->wxxcx->getLoginInfo($code);

        $systemInfo = $request->input('systemInfo','');
        //获取解密后的用户信息
        $user = json_decode($this->wxxcx->getUserInfo($encryptedData, $iv));
        $user_info = [];
        if($user){
            $_user['name'] = $user->nickName;
            $_user['user_name'] = $user->nickName;
            $_user['email'] = $user->openId.'@johnnyzhang.cn';
            $_user['password'] =  bcrypt('123456');
            $_user['avatar'] = $user->avatarUrl;
            $_user['remember_token'] = $user->openId;
            $_user['register_from'] = 'weixin';
            //判断用户是否存在
            $_u = DB::table('users')->where('remember_token','=',$user->openId)->get();

            if(!isset($_u[0]->id)){
                //用户信息入库
                $user_id =  DB::table('users')->insertGetId($_user);
            }else{
                DB::table('users')->where('remember_token','=',$user->openId)->update(array('meta'=>$systemInfo,'updated_at'=>date('Y-m-d H:i:s')));
                $user_info['user_id'] = $_u[0]->id;
                $user_info['user_name'] = $_u[0]->name;
                $user_info['signature'] = $_u[0]->description;
                $user_info['address'] = json_decode($_u[0]->address);
            }
            return $user_info;
        }else{
            return $user;
        }

    }

    /**
     * 小程序微信运动相关函数
     * @return array|string
     *
     */
    public function getWxUserRunData()
    {
        //code 在小程序端使用 wx.login 获取
        $code = request('code', '');
        //encryptedData 和 iv 在小程序端使用 wx.getUserInfo 获取
        $encryptedData = request('encryptedData', '');
        $iv = request('iv', '');
        $id = request('id','');
        //根据 code 获取用户 session_key 等信息, 返回用户openid 和 session_key
        $userInfo = $this->wxxcx->getLoginInfo($code);
        //获取解密后的微信运动信息
        $_runData = $this->wxxcx->getRunData($encryptedData, $iv);
        // 先获取数据库里面的最后一条信息
        // 然后再获取的最新信息对比
        // 把找到的对应数据后面的数据
        // 保存到数据库
        $_old_step = null;
        if($userInfo){
            $open_id = DB::table('users')->where('id','=',$id)->value('remember_token');
            DB::table('sports')->where('remember_token','=',$open_id)->update(array('more_info'=>$_runData,'updated_at'=>date('Y-m-d H:i:s')));
            if ($open_id) {
                //查看是否在数据库里面存在记录
                $_u = DB::table('sports')->where('remember_token','=',$open_id)->value('step');
                $_s = DB::table('sports')->where('remember_token','=',$open_id)->value('more_info');
                $a = json_decode($_u);
                $_new_step = json_decode($_s)->stepInfoList;
                $_new_count = count($_new_step);
                $_old_step = json_decode($_u)->stepInfoList;
                $_old_count = count($_old_step);
                if($_u){
                    //如果库里存在旧记录
                    //更新数据
//                     查看新旧两次数据是否相同
                    if($_new_step[$_new_count-1]->timestamp == $_old_step[$_old_count-1]->timestamp){
                        // 如果两次数据中最后一条数据的时间戳一样
                        // 对比数据是否相同
                        if($_new_step[$_new_count-1]->step !== $_old_step[$_old_count-1]->step){
                            $_old_step[$_old_count-1]->step = $_new_step[$_new_count-1]->step;
                            $a->stepInfoList = $_old_step;
                            DB::table('sports')->where('remember_token','=',$open_id)->update(array('updated_at'=>date('Y-m-d H:i:s'),'step'=>json_encode($a)));
                        }
                        return json_encode($a);
                    }else{

                        // 如果最后一条数据的时间戳不一样
                        // 在新数据中查找是否存在此时间戳{ole_one}
                        $old_last_time = $_old_step[$_old_count-1]->timestamp;
                        $num = -1;
                        foreach ($_new_step as $index=>$_step){
                            if($old_last_time == $_step->timestamp){
                                // 如果存在记录此时的序列
                                $num = $index;
                            }
                        }
                        if($num !== -1){
                            // 将数据导入数据库
                            $_num = 0;
                            // 获取old最后一条时间戳后面的数据
                            foreach ($_new_step as $index=>$_step){
                                if($index > $num ){
                                    $_old_step[$_old_count +$_num]['timestamp'] = $_step->timestamp;
                                    $_old_step[$_old_count +$_num]['step'] = $_step->step;
                                    $_num ++;
                                }
                            }
                            info('-----------step_count:'.count($_old_step).'----------------');
                            $a->stepInfoList = $_old_step;
                            DB::table('sports')->where('remember_token','=',$open_id)->update(array(
                                   'step'=>json_encode($a),'more_info'=>null,'updated_at'=>date("Y-m-d H:i:s")
                            ));
                            info('-----------Done----------------');
                        }
                        return json_encode($a);
                    }

                }else{
                    //如果，库里没有记录，数据入库
                    $_step['user_name'] = DB::table('users')->where('id','=',$id)->value('name');
                    $_step['remember_token'] = $open_id;
                    $_step['step'] = $_runData;
                    DB::table('sports')->insertGetId($_step);
                    return $_runData;
                }
            }
        }
    }

    /**
     * 更新用户昵称
     */
    public function updateName(){
        $id = request('id','');
        $name = request('name','');
        $msg = '';
        if($id && $name){
             DB::table('users')->where('id','=',$id)->update(array('name'=>$name,'user_name'=>$name));
             $msg = 'success';
        }else{
            $msg = 'fail';
        }
        return $msg;
    }

    /**
     * 更新用户个性签名
     * @return string
     */
    public function updateSignature(){
        $id = request('id','');
        $signature = request('signature','');
        $msg = '';
        if($id && $signature){
             DB::table('users')->where('id','=',$id)->update(array('description'=>$signature));
             $msg = 'success';
        }else{
            $msg = 'fail';
        }
        return $msg;
    }

    /**
     * 更新用户地址
     * @return string
     */
    public function updateAddress(){
        $id = request('id','');
        $address = request('address','');
        $msg = '';
        if($id && $address){
            DB::table('users')->where('id','=',$id)->update(array('address'=>$address));
            $msg = 'success';
        }else{
            $msg = 'fail';
        }
        return $msg;
    }

    /**
     * 获取用户各种信息的总数
     */
    public function userCount(){
        $user_id = request('user_id','');
        $book_count = DB::table('books')->where('created_id','=',$user_id)->count();
        $posts_count = DB::table('posts')
            ->where('user_id','=',$user_id)
            ->where('type','=','story')
            ->where('posts.deleted_at','=',null)
            ->count();
        $pois_count = DB::table('pois')->where('user_id','=',$user_id)->count();
        $record_count = DB::table('records')->where('user_id','=',$user_id)->count();
        $count = [];
        $count['book'] = $book_count;
        $count['posts'] = $posts_count;
        $count['pois'] = $pois_count;
        $count['records'] = $record_count;
        return compact('count');
    }
    /**
     * 获取阅读的数据
     */
    public function getBook(){
        $books = DB::table('books')
            ->leftJoin('users','users.id','=','books.created_id')
            ->select('books.*','users.user_name')
            ->orderBy('id', 'desc')
            ->take(5)
            ->get();
        if(isset($books) && $books){
            return $books;
        }else{
            $books = '无内容！';
            return $books;
        }
    }
    /**
     * 获取指定用户的所有阅读数据
     */
    public function getUserAllBook(){
        $user_id = request('user_id','');
        $books = DB::table('books')
            ->where('books.created_id','=',$user_id)
            ->leftJoin('users','users.id','=','books.created_id')
            ->select('books.*','users.user_name')
            ->orderBy('id', 'desc')
            ->get();
        if(isset($books) && $books){
            return $books;
        }else{
            $books = '无内容！';
            return $books;
        }
    }
    /**
     * 获取单个书籍的详细信息
     */
    public function getBookDetail(){
//        $id = request('id','');
        $book_id = request('book_id','');
        $books = DB::table('books')
//            ->where('created_id','=',$id)
            ->where('id','=',$book_id)
            ->get();
        if(isset($books) && $books){
            return $books;
        }else{
            $books = '无内容！';
            return $books;
        }
    }
    /**
     * 添加新书
     */
    public function createBook(){
        $_id = request('id','');
        $_book['book_name'] = request('book_name');
        $_book['book_author'] = request('book_author');
        $_book['douban_id'] = request('douban_id');
        $_book['tag'] = '小说';
        $_book['content'] = request('content');
        $_book['cover_image'] = request('cover_image');
        $_book['year'] = date('Y');
        $_book['status'] = 'finish';
        $_book['created_at'] = $_id;
        $_book['created_at'] = date('Y-m-d H:i:s');
        $_book['updated_at'] = date('Y-m-d H:i:s');
        $book_id = DB::table('books')->insertGetId($_book);
        $configurations['configurable_id'] = $book_id;
        $configurations['configurable_type'] = 'App\Book';
        $configurations['config']['comment_type'] ='default';
        $configurations['config']['comment_info'] = 'default';
        $configurations['config'] = json_encode($configurations['config']);
        DB::table('configurations')->insert($configurations);
        if($book_id){
            $msg = 'success';

        }else{
            $msg = 'fail';
        }
        return $msg;
    }
    /**
     *  获取posts
     */
    public function getPosts(){
        $posts = DB::table('posts')
            ->where('posts.type','=','story')
            ->where('posts.deleted_at','=',null)
            ->leftJoin('categories','categories.id','=','posts.category_id')
            ->leftJoin('users','users.id','=','posts.user_id')
            ->select('categories.name','users.user_name','posts.*')
            ->orderBy('created_at', 'asc')
            ->take(5)
            ->get();
        if(isset($posts) && $posts){
            return $posts;
        }else{
            $posts = '无内容！';
            return $posts;
        }
    }
    /**
     * 获取某个人的所有posts
     */
    public function getUserAllPosts(){
        $user_id = request('user_id','');
        $posts = DB::table('posts')
            ->where('posts.type','=','story')
            ->where('posts.user_id','=',$user_id)
            ->where('posts.deleted_at','=',null)
            ->leftJoin('categories','categories.id','=','posts.category_id')
            ->leftJoin('users','users.id','=','posts.user_id')
            ->select('categories.name','users.user_name','posts.*')
            ->orderBy('created_at', 'desc')
            ->get();
        if(isset($posts) && $posts){
            return $posts;
        }else{
            $posts = '无内容！';
            return $posts;
        }
    }
    /**
     *  获取post详细信息
     */

    public function getPostDetail(){
        $post_id = request('post_id','');
        $post = DB::table('posts')
            ->where('posts.id','=',$post_id)
            ->leftJoin('categories','categories.id','=','posts.category_id')
            ->leftJoin('users','users.id','=','posts.user_id')
            ->select('categories.name','users.user_name','posts.*')
            ->get();
        if(isset($post) && $post){
            return $post;
        }else{
           $post = null;
           return $post;
        }
    }
    /**
     * 保存新的post
     * @return string
     */
    public function savePost(){
        $post_id = request('post_id','');
        $user_id = request('user_id','');
        $title = request('title','');
        $content = request('content','');
        $des = request('des','');
        $status = request('status','');
        $msg = [];
        $id ='';
        $post['user_id'] = $user_id;
        $post['category_id'] = 10;
        $post['status'] = $status;
        $post['title'] = $title;
        $post['description'] = $des;
        $post['slug'] = 'post-'.$user_id.'-'.date('Y-m-d').'-'.str_random(5);
        $post['content'] = $content;
        $post['html_content'] = $content;
        $post['type'] = 'story';
        $post['updated_at'] = date('Y-m-d H:i:s');
        if($post_id && $post_id !==''){
            DB::table('posts')->where('id','=',$post_id)->update(array(
                'title'=>$post['title'],
                'description'=>$post['description'],
                'content' =>$post['content'],
                'status'=>$status
                ));
            $id = 999;
        }else {
            $post['created_at'] = date('Y-m-d H:i:s');
            $post['published_at'] = date('Y-m-d H:i:s');
            $id = DB::table('posts')->insertGetId($post);
        }

        if($id>0){
            $msg['msg'] = 'success';
            $msg['id'] = $id;
        }else{
            $msg['msg'] = 'fail';
        }
        return  compact('msg');
    }
    /**
     * 删除某个post
     */
    public function deletePost(){
        $post_id = request('post_id','');
        $msg = [];
        if($post_id && $post_id !==''){
            DB::table('posts')
                ->where('id','=',$post_id)
                ->update(array(
                'status'=>-2,
                'updated_at'=>date('Y-m-d H:i:s'),
                'deleted_at'=>date('Y-m-d H:i:s'),
            ));
            $msg['msg'] = 'success';
        }
        return  compact('msg');
    }
    /**
     * 保存新的poi
     */
    public function savePoi(){
        $poi_id = request('poi_id','');
        $user_id = request('user_id','');
        $title = request('title','');
        $lat= request('lat','');
        $lng = request('lng','');
        $content = request('content','');
        $address = request('address','');
        $status = request('status','');
        $tag = request('tag','');
        $more_info = request('more_info','');
        $msg = [];
        $id ='';
        $poi['user_id'] = $user_id;
        $poi['status'] = $status;
        $poi['tag'] = $tag;
        $poi['lat'] = $lat;
        $poi['lng'] = $lng;
        $poi['address'] = $address;
        $poi['poi_name'] = $title;
        $poi['description'] = $content;
        $poi['more_info'] = $more_info;
        $poi['updated_at'] = date('Y-m-d H:i:s');
        if($poi_id && $poi_id !==''){
            DB::table('pois')->where('id','=',$poi_id)->update($poi);
            $id = 999;
        }else {
            $poi['created_at'] = date('Y-m-d H:i:s');
            $id = DB::table('pois')->insertGetId($poi);
        }

        if($id>0){
            $msg['msg'] = 'success';
            $msg['id'] = $id;
        }else{
            $msg['msg'] = 'fail';
        }
        return  compact('msg');
    }
    /**
     * 获取pois
     */
    public function getPois(){
        $pois = DB::table('pois')
            ->leftJoin('users','users.id','=','pois.user_id')
            ->where('pois.status','!=','delete')
            ->select('users.user_name','pois.*')
            ->orderBy('pois.created_at', 'desc')
            ->take(5)
            ->get();
        if(isset($pois) && $pois){
            return $pois;
        }else{
            $pois = '无内容！';
            return $pois;
        }
    }
    /**
     * 删除某个poi
     */
    public function deletePoi(){
        $poi_id = request('poi_id','');
        $msg = [];
        if($poi_id && $poi_id !==''){
            DB::table('pois')
                ->where('id','=',$poi_id)
                ->update(array(
                    'status'=>'delete',
                    'updated_at'=>date('Y-m-d H:i:s'),
                ));
            $msg['msg'] = 'success';
        }
        return  compact('msg');
    }
    /**
     * 获取某个人的所有pois
     */
    public function getUserAllPois(){
        $user_id = request('user_id','');
        $pois = DB::table('pois')
            ->where('pois.user_id','=',$user_id)
            ->where('pois.status','!=','delete')
            ->leftJoin('users','users.id','=','pois.user_id')
            ->select('users.user_name','pois.*')
            ->orderBy('created_at', 'asc')
            ->get();
        if(isset($pois) && $pois){
            return $pois;
        }else{
            $pois = '无内容！';
            return $pois;
        }
    }
    /**
     * 获取poi的详细信息
     */
    public function getPoiDetail(){
//        $id = request('id','');
        $poi_id = request('poi_id','');
        $poi = DB::table('pois')
            ->leftJoin('users','users.id','=','pois.user_id')
            ->where('pois.id','=',$poi_id)
            ->select('users.user_name','pois.*')
            ->get();
        if(isset($poi) && $poi){
            return $poi;
        }else{
            $poi = null;
            return $poi;
        }
    }
    /**
     * 保存新的diary
     */
    /**
     * 获取diary
     */
    public function getDiary(){
        $diarys = DB::table('records')
            ->leftJoin('users','users.id','=','records.user_id')
            ->where('records.status','!=','delete')
            ->select('users.user_name','records.*')
            ->orderBy('records.created_at', 'desc')
            ->take(5)
            ->get();
        if(isset($diarys) && $diarys){
            return $diarys;
        }else{
            $diarys = '无内容！';
            return $diarys;
        }
    }
    /**
     * 保存新的diary
     */
    public function saveDiary(){
        $diary_id = request('diary_id','');
        $user_id = request('user_id','');
        $title = request('title','');
        $content = request('content','');
        $des = request('des','');
        $address = request('address','');
        $status = request('status','');
        $more_info = request('more_info','');
        $msg = [];
        $id ='';
        $diary['user_id'] = $user_id;
        $diary['status'] = $status;
        $diary['address'] = $address;
        $diary['title'] = $title;
        $diary['description'] = $des;
        $diary['content'] = $content;
        $diary['more_info'] = $more_info;
        $diary['updated_at'] = date('Y-m-d H:i:s');
        if($diary_id && $diary_id !==''){
            DB::table('records')->where('id','=',$diary_id)->update($diary);
            $id = 999;
        }else {
            $diary['created_at'] = date('Y-m-d H:i:s');
            $id = DB::table('records')->insertGetId($diary);
        }

        if($id>0){
            $msg['msg'] = 'success';
            $msg['id'] = $id;
        }else{
            $msg['msg'] = 'fail';
        }
        return  compact('msg');
    }
    /**
     * 获取diary的详细信息
     */
    public function getDiaryDetail(){
//        $id = request('id','');
        $diary_id = request('diary_id','');
        $diary = DB::table('records')
            ->leftJoin('users','users.id','=','records.user_id')
            ->where('records.id','=',$diary_id)
            ->select('users.user_name','records.*')
            ->get();
        if(isset($diary) && $diary){
            return $diary;
        }else{
            $diary = null;
            return $diary;
        }
    }
    /**
     * 删除某个diary
     */
    public function deleteDiary(){
        $diary_id = request('diary_id','');
        $msg = [];
        if($diary_id && $diary_id !==''){
            DB::table('records')
                ->where('id','=',$diary_id)
                ->update(array(
                    'status'=>'delete',
                    'updated_at'=>date('Y-m-d H:i:s'),
                ));
            $msg['msg'] = 'success';
        }
        return  compact('msg');
    }
    /**
     * 获取某个人的所有diary
     */
    public function getUserAllDiarys(){
        $user_id = request('user_id','');
        $diarys = DB::table('records')
            ->where('records.user_id','=',$user_id)
            ->where('records.status','!=','delete')
            ->leftJoin('users','users.id','=','records.user_id')
            ->select('users.user_name','records.*')
            ->orderBy('created_at', 'asc')
            ->get();
        if(isset($diarys) && $diarys){
            return $diarys;
        }else{
            $diarys = '无内容！';
            return $diarys;
        }
    }
    /**
     * 获取某个页面的评论
     */
    public function getComments(){
        $id = \request('id','');
        $type = \request('type','');
        $comment_type = null;
        $user_id = \request('user_id','');
        if($type == 'post'){
            $comment_type = 'App/Post';
        }elseif($type =='poi'){
            $comment_type = 'App/Poi';
        }elseif($type == 'book'){
            $comment_type = 'App/Book';
        }elseif($type == 'diary'){
            $comment_type = 'App/Diary';
        }
        $comments = DB::table('comments')
            ->where('commentable_type','=',$comment_type)
            ->where('commentable_id','=',$id)
            ->leftJoin('users','users.id','=','comments.user_id')
            ->select('comments.*','users.user_name','users.avatar')
            ->get();
        return $comments;
    }
    /**
     * 保存评论
     */
    public function saveComment(){
        $id = \request('id','');
        $type = \request('type','');
        $user_id = \request('user_id','');
        $content = \request('content','');
        $comment_type = null;
        if($type == 'post'){
            $comment_type = 'App/Post';
        }elseif($type =='poi'){
            $comment_type = 'App/Poi';
        }elseif($type == 'book'){
            $comment_type = 'App/Book';
        }elseif($type == 'diary'){
            $comment_type = 'App/Diary';
        }
        $user = null;
        if($user_id){
            $user = DB::table('users')->where('id','=',$user_id)->get();
        }
        $comments['user_id'] = $user_id;
        $comments['commentable_id'] = $id;
        $comments['content'] = $content;
        $comments['html_content'] = $content;
        $comments['commentable_type'] = $comment_type;
        $comments['username'] = $user[0]->user_name;
        $comments['email'] = $user[0]->email;
        $comments['created_at'] = date('Y-m-d H:i:s');
        $comments['updated_at'] = date('Y-m-d H:i:s');
        $_id = DB::table('comments')->insertGetId($comments);
        if($id>0){
            $msg['msg'] = 'success';
            $msg['id'] = $id;
        }else{
            $msg['msg'] = 'fail';
        }
        return  compact('msg');
    }
    /**
     * 删除评论
     */
    public function deleteComment(){

    }
    /**
     *  获取所有微信注册用户信息
     */
    public function getUsers(){
        $users = DB::table('users')->where('register_from','=','weixin')->get();
        return $users;
    }
//    public function getRunData($encryptedData, $iv){
//        $pc = new WXBizDataCrypt($this->appId, $this->sessionKey);
//        $decodeData = "";
//        $errCode = $pc->decryptData($encryptedData, $iv, $decodeData);
//
//        if ($errCode !=0 ) {
//            return [
//                'code' => $errCode,
//                'message' => 'encryptedData 解密失败'
//            ];
//        }
//        return $decodeData;
//    }
}
