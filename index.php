<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <title>张钊睿的博客</title>
    <link rel="stylesheet" href="template">
</head>
<body>
    <div class="bg-img"></div>
    <main>
        <h1>欢迎来到我的博客！</h1>
        <p>站内文章</p>
        <a href="https://zzrbk{$rthSuffix}/zzrwz/index">文章</a>
	    <a href="https://zzrbk{$rthSuffix}/doc/index">API文档</a>
        <a href="https://zzrbk{$rthSuffix}/wapindex.php">WAP手机网站(正在开发)</a>
        <p>站内工具</p>
        <a href="https://zzrbk{$rthSuffix}/gongju/time.html">时钟</a>
        <a href="https://zzrbk{$rthSuffix}/404.html">跳转404页面</a>
        <a href="https://zzrbk{$rthSuffix}/gongju/cesu.html">测试延迟</a>
        <a href="https://zzrbk{$rthSuffix}/gongjucodemaoji.html">编程猫记</a>
        <a href="https://zzrbk{$rthSuffix}/gongju/calls.html">远程流</a>
        <a href="https://zzrbk{$rthSuffix}/gongju/datashangchuan.html">文件上传(已烂尾)</a>
        <a href="https://zzrbk{$rthSuffix}/picture/index.html">图片下载</a>
        <a href="https://zzrbk{$rthSuffix}/gongju/edge-mode.html">设备和浏览器信息检测</a>

        <a href="https://zzrbk{$rthSuffix}/mp4/微软我真的好喜欢你啊！！！.mp4">小视频下载</a>
        <p>站外链接</p>
        <a href="https://www.locyanfrp.cn/#home">乐青映射</a>
        <a href="https://zzrbk{$rthSuffix}/gongju/calls-huiyi.html">公共会议室</a>
        <a href="https://lieri{$rthSuffix}/Software">winver的软件下载专区</a>
        <a href="https://baidu.com/">百度一下</a>
        <a href="https://zzrbk{$rthSuffix}/gongju/rili.html">日历</a>
        <a href="https://qq.com/">腾讯新闻</a>
        <a href="https://zzrbk{$rthSuffix}/youzi.html">友情链接</a>


        <?php
        const DATA_FILENAME = "md5.json";

        // 获取设备信息（浏览器类型和操作系统）
        $device = $_SERVER['HTTP_USER_AGENT'];

        // 生成唯一的用户标识符（设备信息）
        $user_id = md5($device);

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

        // 如果用户不存在于数据库中，初始化为 0
        if (!isset($data[$user_id])) {
            $data[$user_id] = ['name' => '匿名访客', 'visits' => 0];
        }

        // 更新数据库的值
        $data[$user_id]['visits']++;

        // 写入数据库
        file_put_contents(DATA_FILENAME, json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
        ?>

        <p>欢迎，<?php echo htmlspecialchars($data[$user_id]['name']); ?>！您使用此设备访问了本站 <?php echo $data[$user_id]['visits']; ?> 次。</p>

        <?php if (!isset($_COOKIE['user_name'])): ?>
            <form action="update_name.php" method="get">
                <p>欢迎，<a href="update_name.php?user_id=<?php echo $user_id; ?>">修改名字</a><?php echo htmlspecialchars($data[$user_id]['name']); ?>！您使用此设备访问了本站 <?php echo $data[$user_id]['visits']; ?> 次。</p>
            </form>
        <?php else: ?>
            <p>当前名字：<?php echo htmlspecialchars($data[$user_id]['name']); ?> <a href="update_name.php?user_id=<?php echo $user_id; ?>">修改名字</a></p>
        <?php endif; ?>

        <div class="search-container">
            <form action="https://www.bing.com/search" method="get" target="_blank">
                <input type="text" name="q" placeholder="请输入搜索内容">
                <input type="submit" value="必应搜索">
            </form>
        </div>
        <div id="footer">
		<style>
        body {
            font-family: Arial, sans-serif;
            text-align: center; /* 使搜索框居中显示 */
            margin-top: 50px; /* 顶部留白 */
        }
        .search-container {
            display: flex;
            justify-content: center; /* 使输入框和按钮在一行上并居中 */
            align-items: center; /* 垂直居中 */
        }
        input[type="text"] {
            width: 300px;
            padding: 10px;
            margin-right: 5px; /* 与按钮之间留有间隔 */
        }
        input[type="submit"] {
            padding: 10px 20px;
        }
    </style>
		<p>本网站使用了Cookie以改善您的的体验</p>
		<p>Email: beibing@zzrbk.ip-ddns.com</p>
		<img style="display:inline-block;vertical-align:middle;width:20px;height:20px" alt="萌ICP备案号" src="/icon/moe.png">
		<a href="https://winver18.pages.dev/301.html">萌icp备20250666号</a>
		<p>© 2022-2025 张钊睿</p>
		<a href="https://ipw.cn/ipv6webcheck/?site=zzrbk{$rthSuffix}" title="本站支持IPv6访问"target='_blank'>
			<img style='display:inline-block;vertical-align:middle' alt="本站支持IPv6访问" src="https://static.ipw.cn/icon/ipv6-s1.svg">
		</a>
		<a href="https://ipw.cn/ssl/?site=zzrbk{$rthSuffix}" title="本站支持SSL安全访问" target='_blank'>
			<img style='display:inline-block;vertical-align:middle' alt="本站支持SSL安全访问" src="https://static.ipw.cn/icon/ssl-s1.svg">
		</a>
    </main>
</body>
</html>