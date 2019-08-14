<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Laravel</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100%;
                margin: 0;
            }

            .full-height {
                height: 100%;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top:0px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
      <style type="text/css">
          td {
            border: 1px solid #636B6F;
            font-size: 20px;

          }
      </style>
    </head>
    <body>
       <a href="<?php echo url("login/loginout") ?>" style=" text-decoration: none; font-size: 20px;margin-left:1600px;">退出</a>
       <br><br><br>
       <div style="margin-left:20px;">
       用户名：<input type="text" name="" id="name">
       密码：<input type="password" name="" id="password">
       <button onclick="add()">添加</button>
       </div>
       <br><br>
        <table class="table" style="font-size: 20px; border:1px solid #636B6F;text-align: center;margin-left:20px;">
            <thead >
            <tr class="text-c">
            <th width="100">ID</th>
            <th width="100">用户名</th>
            <th width="100">密码</th>
            <th width="100">删除</th>
            <th width="100">修改</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
            </table>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title m-b-md" style="margin-top:-200px; ">
                   好小子，你登录成功了√！
                </div>
            </div>
        </div>

    </body>
 <script type="text/javascript" src="/laravel/blog/public/static/hui/lib/jquery/1.9.1/jquery.min.js"></script>
 <script type="text/javascript" src="/laravel/blog/public/static/hui/static/h-ui/js/H-ui.js"></script>

    <script type="text/javascript">
         function show() {
        
            $.ajax({
                url:'<?php echo url("show/show") ?>',
                
                dataType:'json',
                success:function (res) {
                    console.log(res)
                    var tr=''
                    for (var i = 0; i < res.length; i++) {
                        tr=tr+"<tr><td>"+res[i].id+"</td><td>"+res[i].name+"</td><td>"+res[i].password+"</td><td>删除</td><td>修改</td></tr>"
                  }
                  $('.table tbody').html(tr)
                }
            })
         }
         show()


          function add() {
               var name=$("#name").val()
               var password=$("#password").val()
               console.log(name)
               $.ajax({
                   url:'<?php echo url("show/addaction") ?>',
                   data:{
                    name:name,
                    password:password
                   },
                   dataType:'json',
                   success:function (res) {
                       console.log(res)
                   }
               })
          }

    </script>
</html>
