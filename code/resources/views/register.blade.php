<DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Test</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.staticfile.org/jquery/1.10.2/jquery.min.js"></script>

<body>
<div style="margin: auto;width: 500px;margin-top: 100px">
<form method="post">
    <div class="form-group">
        <label>Name:</label>
        <input type="text" name="name" class="form-control" placeholder="Name" required="">
    </div>
    <div class="form-group">
        <label>Password:</label>
        <input type="password" name="password" class="form-control" placeholder="Password" required="">
    </div>
    <div class="form-group">
        <strong>Email:</strong>
        <input type="email" name="email" class="form-control" placeholder="Email" required="">
    </div>
    <div class="form-group">
        <button class="btn btn-success btn-submit" style="margin-left: 200px">注册</button>
    </div>
    <div id="response"></div>
</form>
</div>
</body>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')    //携带csrf_token，否则会返回错误500
        }
    });

    $(".btn-submit").click(function (e) {
        document.getElementById("response").innerHTML = "";
        e.preventDefault();
        var name = $("input[name=name]").val();
        var password = $("input[name=password]").val();
        var email = $("input[name=email]").val();
        $.ajax({
            type: 'POST',
            url: '/check_register',
            data: {name: name, password: password, email: email},
            success: function () {
                location.href = "{{'insert'}}?name="+name+"&password="+password+"&email="+email;
            },
            error: data => {
                if (data.status === 422) {
                    var errors = $.parseJSON(data.responseText);    //转json格式，或直接使用 data.responseJSON
                    $.each(errors, function (key, value) {
                        $('#response').addClass("alert alert-danger");
                        if ($.isPlainObject(value)) {
                            $.each(value, function (key, value) {
                                console.log(key + " " + value);
                                $('#response').show().append(value + "<br/>");

                            });
                        } else {
                            $('#response').show().append(value + "<br/>"); //this is my div with messages
                        }
                    });
                }
            }
        });
    });
</script>

</html>
