<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>jQuery Validation 插件</title>
</head>
<body>
<form id="demoForm">
    <fieldset>
        <legend>用户登录</legend>
        <p id="info"></p>
        <p id="info2" style="display: none">输入错误</p>
        <p>
            <label for="username">用户名</label>
            <input type="text" id="username" name="username"/>
        </p>

        <p>
            <label for="password">密码</label>
            <input type="password" id="password" name="password"/>
        </p>

        <p>
            <label for="confirm-password">确认密码</label>
            <input type="password" id="confirm-password" name="confirm-password"/>
        </p>

        <p>
            <button id="check">检查表单</button>
        </p>
        <p>
            <input type="submit" value="登录"/>
        </p>
    </fieldset>
</form>

<script type="text/javascript" src="scripts/jquery-2.1.1.js"></script>
<script type="text/javascript" src="scripts/jquery.validate.min.js"></script>
<script type="text/javascript" src="scripts/messages_zh.js"></script>
<script>
    var validator;
    $(document).ready(function () {
        $.validator.setDefaults({
            debug: true
        });

        validator = $("#demoForm").validate({
            rules: {
                username: {
                    //required: true,
                    postcode : "中国"
                },
                password: {
                    required: true,
                    minlength: 2,
                    maxlength: 16
                },
                "confirm-password": {
                    equalTo: "#password"
                }
            },
            messages: {
                username: {
                    required: "必须填写用户名",
                    minlength: "用户名最小为2位",
                    maxlength: "用户名最大为10位",
                    rangelength: "用户名应该在2-10位",
                    remote: "用户名不存在"
                },
                password: {
                    required: "必须填写密码",
                    minlength: "密码最小为2位",
                    maxlength: "密码最大为16位"
                },
                "confirm-password": {
                    equalTo: "两次输入的密码不一致"
                }
            },
            submitHandler: function (form) {
                console.log($(form).serialize());
            }
        });

        $.validator.addMethod("postcode", function(value, element, params){
            var postcode = /^[0-9]{6}$/;
            return this.optional(element) || (postcode.test(value));
        }, $.validator.format("请填写正确的{0}邮编！"));

        $("#check").click(function () {
            alert($("#demoForm").valid() ? "填写正确！" : "填写错误！");
        });
    });

</script>

</body>
</html>