<?php
session_start();

// 生成随机验证码
function generateCaptcha() {
    $characters = 'abcde12345';
    $codeLength = 5;
    $code = '';
    for ($i = 0; $i < $codeLength; $i++) {
        $code .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $code;
}

// 验证用户输入的验证码
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['captcha']) && $_POST['captcha'] == $_SESSION['captcha']) {
        header('Location: index.php');
        exit;
    } elseif (isset($_POST['turnstile_token'])) {
        // 验证 Cloudflare Turnstile 的 token
        $turnstileToken = $_POST['turnstile_token'];
        $turnstileSecret = 'YOUR_TURNSTILE_SECRET_KEY'; // 替换为你的 Turnstile Secret Key
        $turnstileSiteKey = 'YOUR_TURNSTILE_SITE_KEY'; // 替换为你的 Turnstile Site Key
        $response = file_get_contents("https://challenges.cloudflare.com/turnstile/v0/siteverify?secret=$turnstileSecret&response=$turnstileToken");
        $result = json_decode($response, true);
        if ($result['success']) {
            header('Location: index.php');
            exit;
        }
    }
    $error = '你为什么把验证码输入错误！';
}

// 生成新的验证码并保存到会话中
$captcha = generateCaptcha();
$_SESSION['captcha'] = $captcha;
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>验证码验证</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .error { color: red; }
    </style>
    <!-- 引入 Cloudflare Turnstile 官方JS -->
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
</head>
<body>
    <h1>请输入验证码</h1>
    <p>请将上方验证码输入到以下输入框：</p>
    <p><strong>验证码：<?php echo $captcha; ?></strong></p>
    <form method="POST">
        <label for="captcha">验证码：</label>
        <input type="text" id="captcha" name="captcha" placeholder="输入验证码" required>
        <button type="submit">提交</button>
    </form>
    <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>

    <h1>Cloudflare 人机验证</h1>
    <div class="cf-turnstile" data-sitekey="YOUR_TURNSTILE_SITE_KEY" data-callback="onVerify"></div>
    <p>Cloudflare人机验证请等待</p>
    <p>加载不出来请多刷新几次</p>
    <p>本网站使用了Cookie以改善您的的体验</p>
    <p>Email: beibing@zzrbk.ip-ddns.com</p>
    <img style="display:inline-block;vertical-align:middle;width:20px;height:20px" alt="萌ICP备案号" src="/icon/moe.png">
	<a href="https://winver18.pages.dev/301.html">萌icp备20250666号</a>
    <p>© 2022-2025 张钊睿</p>
    <script>
        // 定义回调函数，当用户完成验证后调用
        function onVerify(token) {
            // 验证成功，提交表单
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '';
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'turnstile_token';
            input.value = token;
            form.appendChild(input);
            document.body.appendChild(form);
            form.submit();
        }
    </script>
</body>
</html>