<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API 时钟</title>
</head>
<body>
    <h1>API 时钟</h1>
    <div id="data-container">Loading data...</div>

    <script>
        // 假设的 API 端点
        const apiEndpoint = 'https://zzrbk.rth5.com/API/time_api.php';

        // 使用 fetch API 调用 API 端点
        fetch(apiEndpoint)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                const dataContainer = document.getElementById('data-container');
                dataContainer.textContent = JSON.stringify(data, null, 2); // 格式化 JSON 字符串
            })
            .catch(error => {
                console.error('There has been a problem with your fetch operation:', error);
                document.getElementById('data-container').textContent = 'Failed to fetch data.';
            });
    </script>
</body>
</html>
