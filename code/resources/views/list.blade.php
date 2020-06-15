<DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Home</title>
</head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.staticfile.org/jquery/1.10.2/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js"></script>
<style type="text/css">
    #pull_right{
        text-align:center;
    }
    .pull-right {
        /*float: left!important;*/
    }
    .pagination {
        display: inline-block;
        padding-left: 0;
        margin: 20px 0;
        border-radius: 4px;
    }
    .pagination > li {
        display: inline;
    }
    .pagination > li > a,
    .pagination > li > span {
        position: relative;
        float: left;
        padding: 6px 12px;
        margin-left: -1px;
        line-height: 1.42857143;
        color: #428bca;
        text-decoration: none;
        background-color: #fff;
        border: 1px solid #ddd;
    }
    .pagination > li:first-child > a,
    .pagination > li:first-child > span {
        margin-left: 0;
        border-top-left-radius: 4px;
        border-bottom-left-radius: 4px;
    }
    .pagination > li:last-child > a,
    .pagination > li:last-child > span {
        border-top-right-radius: 4px;
        border-bottom-right-radius: 4px;
    }
    .pagination > li > a:hover,
    .pagination > li > span:hover,
    .pagination > li > a:focus,
    .pagination > li > span:focus {
        color: #2a6496;
        background-color: #eee;
        border-color: #ddd;
    }
    .pagination > .active > a,
    .pagination > .active > span,
    .pagination > .active > a:hover,
    .pagination > .active > span:hover,
    .pagination > .active > a:focus,
    .pagination > .active > span:focus {
        z-index: 2;
        color: #fff;
        cursor: default;
        background-color: #428bca;
        border-color: #428bca;
    }
    .pagination > .disabled > span,
    .pagination > .disabled > span:hover,
    .pagination > .disabled > span:focus,
    .pagination > .disabled > a,
    .pagination > .disabled > a:hover,
    .pagination > .disabled > a:focus {
        color: #777;
        cursor: not-allowed;
        background-color: #fff;
        border-color: #ddd;
    }
    .clear{
        clear: both;
    }
</style>
<script>
    function del_friend(id) {
        //用户安全提示
        if (confirm("您确定要删除吗？")){
            location.href = "delete_friend?id="+id;
        }
    }

    window.onload = function () {
        //删除选中的记录
        document.getElementById("delSelect").onclick = function () {
            //表单提交
            if (confirm("您确定要删除选中条目吗？")) {
                let flag = false;
                //判断是否有选中条目
                let cbs = document.getElementsByName("uid");
                for (let i = 0; i < cbs.length; i++) {
                    if (cbs[i].checked){
                        flag = true;
                        break;
                    }
                }
                if (flag) {
                    document.getElementById("form").submit();
                }
            }
        }

        //全选功能 使checked状态相同
        document.getElementById("firstCb").onclick = function () {
            let cbs = document.getElementsByName("uid");
            for (let i = 0; i < cbs.length; i++) {
                cbs[i].checked = this.checked;
            }
        }
    }
</script>
<body>
<div class="container" style="width: 650px; margin:auto; margin-top: 50px">
<div style="float: left">
    <a class="btn btn-primary" href="add_list">添加</a>
    <a class="btn btn-success" href="list_all">全部</a>
    <a class="btn btn-success" href="list_do">进行中</a>
    <a class="btn btn-success" href="list_end">已完成</a>
    <a class="btn btn-success" href="del_list_end">删除已完成</a>
    <div style="float: left" class="dropdown">
        <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
            好友
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
            @foreach($friend as $val)
                <li><a href="javascript:del_friend({{$val->id}});">{{$val->friend}}</a></li>
            @endforeach
        </ul>
    </div>
</div>
<div style="float: right;margin: 5px">
    <a class="btn btn-primary" href="javascript:void(0);" id="delSelect">删除选中</a>
    <button class="btn btn-danger btn-submit" onclick="out();">返回</button>
</div>
    <form id="form" action="delSelect" method="post">
    <table border="1" class="table table-bordered table-hover" >
        <thead>
        <tr>
            <th><input type="checkbox" id="firstCb"></th>
            <th>item</th>
            <th>status</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $val)
            <tr>
                <th><input type="checkbox" name="uid" value="{{$val->id}}"></th>
                <td>{{$val->item}}</td>
                <td>{{$val->status}}</td>
                <td>
                    <a class="btn btn-primary" href="update_list?id={{$val->id}}">修改</a>
                    <a class="btn btn-warning" href="delSelect?uid={{$val->id}}">删除</a>
                </td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td colspan="4">{{$data->links()}}</td>
        </tr>
        </tfoot>
    </table>
        <input type="hidden" name="_token" value="{{csrf_token()}}">
    </form>
</div>

<div class="container" style="width: 650px; margin:auto; margin-top: 50px">
    <div style="float: left">
        <form action="list_all" method="post" class="form-inline">
            <div class="form-group">
                <label for="exampleInputName1">姓名</label>
                <input type="text" name="name" class="form-control" id="exampleInputName1" value="{{Session::get('s_name')}}">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail">邮箱</label>
                <input type="text" name="email" class="form-control" id="exampleInputEmail" value="{{Session::get('s_email')}}">
            </div>
            <button type="submit" class="btn btn-default">查询</button>
            <input type="hidden" name="_token" value="{{csrf_token()}}">
        </form>
    </div>
    <div style="float: right">
        <a class="btn btn-primary" href="list_all">添加</a>
    </div>
    <table border="1" class="table table-bordered table-hover" >
        <thead>
        <tr>
            <th>名称</th>
            <th>邮箱</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @if($user)
            @foreach($user as $val)
                <tr>
                    <td>{{$val->name}}</td>
                    <td>{{$val->email}}</td>
                    <td>
                        <a class="btn btn-success" href="add_friend?friend={{$val->name}}">添加</a>
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
</div>
</body>
<script>
    function out() {
        location.href = "{{'index'}}";
    };
</script>
</html>
