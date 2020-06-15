<?php

namespace App\Http\Controllers;

use App\Friend;
use App\Thing;
use Illuminate\Http\Request;
use App\User;
use App\Todolist;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PhpParser\Node\Expr\List_;

class ProjectController extends Controller
{
    /**
     * 登录界面
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function login(){
        return view('login');
    }

    /**
     * Ajax检测登录界面
     * @param Request $request
     * @throws \Illuminate\Validation\ValidationException
     */
    public function check_login(Request $request){
        $this->validate($request,[
            'name' => 'required',
            'password' => 'required',
            'email' => 'required|email',
        ]);
    }

    /**
     * 通过数据库检测是否有此用户 失败：重新登录 成功：进入用户界面
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function check_user(Request $request){
        $name = $request->get('name');
        $password = $request->get('password');
        $email = $request->get('email');
        $users = User::all();
        $flag = false;
        foreach ($users as $user){
            if ($user->name == $name && $user->password == $password && $user-> email ==$email){
                $flag = true;
            }
        }
        if ($flag){
            Session::put('name',$name);
            return redirect("/index");
        }else{
            print ("登录失败,请");
            print ("<a href='login'>重新登录</a>！");
        }
    }

    /**
     * 注销登录
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function out(){
        return view('login');
    }

    /**
     * 用户界面
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request){
        $name = Session::get('name');
        $data = DB::table('thing')->where('name',$name)->orWhere('share','like','%'.$name.'%')->paginate(6);
        return view('home',compact('data'));
    }

    /**
     * 注册界面
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function register(){
        return view('register');
    }

    /**
     * 注册界面Ajax检测
     * @param Request $request
     * @throws \Illuminate\Validation\ValidationException
     */
    public function check_register(Request $request){
        $this->validate($request,[
            'name' => 'required|min:2|max:20|unique:user',
            'password' => 'required',
            'email' => 'required|email|unique:user',
        ]);
    }

    /**
     * 注册成功：向数据库添加数据 失败：则返回
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function insert(Request $request){
        $result = User::create([
            'name'=>$request->get('name'),
            'password'=>$request->get('password'),
            'email'=>$request->get('email')
        ]);
        if ($result){
            return redirect('/login');
        }else{
            dump("aaa");
        }
    }

    /**
     * 添加事务界面
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add_thing(){
        return view('add_thing');
    }

    /**
     * 添加成功：返回用户界面 失败：重新添加
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|mixed
     */
    public function add_thing_op(Request $request){
        $name = Session::get('name','已隐藏');
        $work = $request->get('work');
        $status = $request->get('status');
        $share = $request->get('share');
        $result = Thing::create(['name'=>$name,'work' => $work, 'status' => $status, 'share' => $share.' ']);
        if ($result){
            //添加成功
            return redirect("/index");
        }else{
            //添加失败
            print ("添加失败,请");
            print ("<a href='add_thing'>重新添加</a>！");
        }
    }

    /**
     * 删除事件操作
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete_thing(Request $request){
        $id = $request->get('id');
        $result = Thing::where('id', $id)->delete();
        if ($result){
            return redirect("/index");
        }else{
            print ("删除失败,请");
            print ("<a href='index'>重新删除</a>！");
        }
    }

    /**
     * 修改事件
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update_thing(Request $request){
        $id = $request->get('id');
        Session::put('id',$id);
        $data = Thing::find($id);
        return view('update_thing',compact('data'));
    }

    /**
     * 修改事件操作
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update_thing_op(Request $request){
        $id = Session::get('id');
        $work = $request->get('work');
        $status = $request->get('status');
        $share = $request->get('share');
        Thing::where('id', $id) -> update(['work' => $work, 'status' => $status, 'share' => $share.' ']);
        return redirect("/index");
    }

    /**
     * 接受事件
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function accept(Request $request){
        $name = Session::get('name');
        $id = $request->get('id');

        //创建thing的用户
        $var = Thing::find($id);
        $share = $var->share;

        if (strpos($share,$name.'已接受 ') !== false){

        }elseif (strpos($share,$name.'未接受 ') !== false){
            $str = str_replace($name.'未接受 ', $name.'已接受 ', $share);
            Thing::where('id',$id) -> update(['status'=>'进行中','share'=>$str]);
        }else{
            $str = str_replace($name, $name.'已接受 ', $share);
            Thing::where('id',$id) -> update(['status'=>'进行中','share'=>$str]);
        }
        return redirect("/index");
    }

    /**
     * 不接受事件
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function un_accept(Request $request){
        $name = Session::get('name');
        $id = $request->get('id');

        //创建thing的用户
        $var = Thing::find($id);
        $share = $var->share;

        if (strpos($share,$name.'未接受 ') !== false){

        }elseif (strpos($share,$name.'已接受 ') !== false){
            $str = str_replace($name.'已接受 ', $name.'未接受 ', $share);
            Thing::where('id',$id) -> update(['status'=>'待接受','share'=>$str]);
        }else{
            $str = str_replace($name, $name.'未接受 ', $share);
            Thing::where('id',$id) -> update(['status'=>'待接受','share'=>$str]);
        }
        return redirect("/index");
    }

    /**
     * 在Session中添加id 重定向到list_all
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function list(Request $request){
        $id = $request->get('id');
        Session::put('id',$id);
        return redirect('list_all');
    }

    /**
     * 全部list
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function list_all(Request $request){
        $id = Session::get('id');
        $name = Session::get('name');
        if (Session::has('进行中')){
            $data = DB::table('todolist')->where('thing_id',$id)->where('status','进行中')->paginate(10);
            Session::forget('进行中');
        }elseif (Session::has('已完成')){
            $data = DB::table('todolist')->where('thing_id',$id)->where('status','已完成')->paginate(10);
            Session::forget('已完成');
        }else{
            $data = DB::table('todolist')->where('thing_id',$id)->paginate(10);
        }
        $friend = DB::table('friend')->where('name', $name)->get();

        $s_name = $request->get('name');
        $s_email = $request->get('email');
        if ($s_name || $s_email){
            Session::put('s_name',$s_name);
            Session::put('s_email',$s_email);
            if (!$s_email){
                $s_email = '无名氏';
            }
            if (!$s_name){
                $s_name = '123@qq.com';
            }
            $user = DB::table('user')->where('name', 'like', '%' . $s_name . '%')->orwhere('email', 'like', '%' . $s_email . '%')->get();
            return view('list',compact('data','friend','user'));
        }else {
            $user = false;
            return view('list', compact('data', 'friend','user'));
        }
    }

    /**
     * 正在进行的list
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function list_do(){
        Session::put('进行中','进行中');
        return redirect('list_all');
    }

    /**
     * 已完成的list
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function list_end(){
        Session::put('已完成','已完成');
        return redirect('list_all');
    }

    /**
     * 添加list界面
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add_list(){
        return view('add_list');
    }

    /**
     * 添加list操作
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function add_list_op(Request $request){
        $id = Session::get('id');
        $item = $request->get('item');
        $status = $request->get('status');
        $result = Todolist::create(['item' => $item, 'status' => $status, 'thing_id' => $id]);
        if ($result){
            return redirect('list_all');
        }else{
            print ("添加失败,请");
            print ("<a href='add_list'>重新添加</a>！");
        }
    }

    /**
     * 更新list界面
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update_list(Request $request){
        $id = $request->get('id');
        $data = Todolist::find($id);
        return view('update_list',compact('data'));
    }

    /**
     * 更新list操作
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update_list_op(Request $request){
        $id = $request->get('id');
        $item = $request->get('item');
        $status = $request->get('status');
        Todolist::where('id',$id)->update(['item'=>$item,'status'=>$status]);
        return redirect('list_all');
    }

    /**
     * 部分选中删除
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delSelect(Request $request){
        $id = $request->input('uid');
        //foreach ($ids as $id){
            Todolist::where('id',$id)->delete();
        //}
        return redirect('list_all');
    }

    /**
     * 删除已完成的list
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function del_list_end(){
        Todolist::where('status','已完成')->delete();
        return redirect('list_all');
    }

    /**
     * 添加朋友
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function add_friend(Request $request){
        $name = Session::get('name');
        $friend = $request->get('friend');
        Friend::create(['name'=>$name,'friend'=>$friend]);
        return redirect('list_all');
    }

    /**
     * 删除好友
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete_friend(Request $request){
        $id = $request->get('id');
        Friend::where('id',$id)->delete();
        return redirect('list_all');
    }
}
