<?php
// login.php (chỉ hiển thị giao diện login)
?>
<!DOCTYPE html>
<html>

<head>
    <title>User form</title>
    <?php include 'views/meta.php'; ?>
</head>

<body>
    <?php include 'views/header.php'; ?>

    <div class="container">
        <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="panel-title">Login</div>
                    <div style="float:right; font-size: 80%; position: relative; top:-10px">
                        <a href="#">Forgot password?</a>
                    </div>
                </div>

                <div style="padding-top:30px" class="panel-body">
                    <form id="loginForm" class="form-horizontal" role="form">
                        <div class="margin-bottom-25 input-group">
                            <span class="input-group-addon">
                                <i class="glyphicon glyphicon-user"></i>
                            </span>
                            <input id="login-username" type="text" class="form-control" name="username"
                                placeholder="username or email" required>
                        </div>

                        <div class="margin-bottom-25 input-group">
                            <span class="input-group-addon">
                                <i class="glyphicon glyphicon-lock"></i>
                            </span>
                            <input id="login-password" type="password" class="form-control" name="password"
                                placeholder="password" required>
                        </div>

                        <div class="margin-bottom-25">
                            <input type="checkbox" name="remember" id="remember">
                            <label for="remember"> Remember Me</label>
                        </div>

                        <div class="margin-bottom-25 input-group">
                            <div class="col-sm-12 controls">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a id="btn-fblogin" href="#" class="btn btn-primary">
                                    Login with Facebook
                                </a>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12 control">
                                Don't have an account!
                                <a href="form_user.php">Sign Up Here</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JS xử lý login -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const loginForm = document.getElementById("loginForm");

            loginForm.addEventListener("submit", async function (e) {
                e.preventDefault(); // Chặn form gửi trực tiếp

                const formData = new FormData(loginForm);

                try {
                    const res = await fetch("login_submit.php", {
                        method: "POST",
                        body: formData
                    });

                    const data = await res.json();

                    if (data.status === "success") {
                        localStorage.setItem("user_id", data.user_id);
                        localStorage.setItem("csrf_token", data.csrf_token); // 👈 lưu token
                        alert(data.message);
                        window.location.href = data.redirect;
                    } else {
                        alert(data.message);
                    }
                } catch (err) {
                    alert("Lỗi kết nối server: " + err.message);
                    console.error("Chi tiết lỗi fetch:", err);
                }
            });
        });
    </script>

</body>

</html>