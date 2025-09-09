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
    if ($_POST['captcha'] == $_SESSION['captcha']) {
        header('Location: index.php');
        exit;
    } else {
        $error = '你为什么把验证码输入错误！';
    }
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
</body>
</html>