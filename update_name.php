<?php
// 定义存储MD5数据的文件名
const DATA_FILENAME = "md5.json";

// 获取设备信息（浏览器类型和操作系统）
$device = $_SERVER['HTTP_USER_AGENT'];

// 生成唯一的用户标识符（设备信息）
$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : md5($device);

// 读取数据库
if (file_exists(DATA_FILENAME)) {
    $data = json_decode(file_get_contents(DATA_FILENAME), true);
    if (!is_array($data)) {
        // 如果文件内容不是有效的 JSON 格式，初始化为空数组
        $data = [];
    }
} else {
    // 如果文件不存在，初始化为空数组
    $data = [];
}

// 检查是否有用户提交的新名字
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_name = isset($_POST['new_name']) ? trim($_POST['new_name']) : null;
    if ($new_name !== null && !empty($new_name)) {
        // 更新用户的名字
        $data[$user_id] = [
            'name' => $new_name,
            'md5' => md5($new_name)  // 假设MD5值是基于名字生成的
        ];
        // 更新 Cookie 中的名字
        setcookie('user_name', $new_name, time() + 30 * 24 * 60 * 60, '/');
    }

    // 写入数据库
    file_put_contents(DATA_FILENAME, json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));

    // 重定向回主页面
    header('Location: index.php');
    exit;
}

// 获取当前用户的名字
$current_name = isset($data[$user_id]) ? $data[$user_id]['name'] : "未设置名字";
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>名称检测与更新</title>
    <link rel="stylesheet" href="css/update_name.css">
</head>
<body>
    <div class="container">
        <h1>名称检测与更新</h1>
		<link rel="stylesheet" href="template">
    <div class="bg-img"></div>

        <p>当前名字：<?php echo htmlspecialchars($current_name); ?></p>
        <form action="" method="post">
            <label for="new_name">新名字：</label>
            <input type="text" id="new_name" name="new_name" placeholder="请输入新的名字">
            <input type="submit" value="更新名字">
        </form>
		<p>如果你的名字是Bug体验用户，请不要修改，这是有BUG的现象，我们正在修！！！</p>
        <a href="index.php">返回主页</a>
    </div>
</body>
</html>