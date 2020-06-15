<DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Test2</title>
    </head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.staticfile.org/jquery/1.10.2/jquery.min.js"></script>
</head>
<body>
<div class="container" style="width: 600px">
    <center><h3>添加List</h3></center>
    <form action="update_list_op?id={{$data->id}}" method="post">
        <div class="form-group">
            <label for="item" class="col-sm-2 control-label">item：</label>
            <input type="text" class="form-control" id="item" name="item" value="{{$data->item}}">
        </div>

        <div class="form-group">
            <label for="status">Status：</label>
            <select name="status" id="status" class="form-control">
            @if($data->status == '进行中')
                <option value="进行中" selected>进行中</option>
                <option value="已完成">已完成</option>
            @endif
            @if($data->status == '已完成')
                <option value="进行中">进行中</option>
                <option value="已完成" selected>已完成</option>
            @endif
            </select>
        </div>

        <div class="form-group">
            <input class="btn btn-primary" type="submit" value="提交" style="margin-left: 250px">
        </div>

        <input type="hidden" name="_token" value="{{csrf_token()}}">
    </form>
</div>
</body>
</html>
