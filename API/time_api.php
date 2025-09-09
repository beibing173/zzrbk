<?php
header('Content-Type: application/json');

// 获取当前时间
$current_time = date('Y-m-d H:i:s');

// 返回JSON响应
echo json_encode(['success' => true, 'time' => $current_time]);
?>