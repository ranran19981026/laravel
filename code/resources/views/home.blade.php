<DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Home</title>
</head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.staticfile.org/jquery/1.10.2/jquery.min.js"></script>
{{--分页样式--}}
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
<body>
<div class="container" style="width: 700px;margin: auto;margin-top: 50px">
<div style="float: left">
    <a class="btn btn-primary" href="add_thing">添加</a>
</div>
<div style="float: right;margin: 5px">
    <button class="btn btn-danger btn-submit" onclick="out();">注销</button>
</div>

    <table border="1" class="table table-bordered table-hover" >
        <thead>
        <tr>
            <th>list</th>
            <th>work</th>
            <th>status</th>
            <th>leader</th>
            <th>share</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $val)
            <tr>
                <th><a href="list?id={{$val->id}}">查看</a></th>
                <td>{{$val->work}}</td>
                <td>{{$val->status}}</td>
                <th>{{$val->name}}</th>
                @if(Session::get('name') == $val->name)
                    <td>{{$val->share}}</td>
                    <td>
                        <a class="btn btn-primary" href="update_thing?id={{$val->id}}">修改</a>
                        <a class="btn btn-warning" href="delete_thing?id={{$val->id}}">删除</a>
                    </td>
                @endif
                @if(Session::get('name') != $val->name)
                    <td>{{$val->share}}</td>
                    <td>
                        <a class="btn btn-success" href="accept?id={{$val->id}}">接受</a>
                        <a class="btn btn-danger" href="un_accept?id={{$val->id}}">不接受</a>
                    </td>
                @endif
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td colspan="6">{{$data->links()}}</td>
        </tr>
        </tfoot>
    </table>
</div>
</body>
<script>
    function out() {
        location.href = "{{'out'}}";
    };
</script>
</html>
