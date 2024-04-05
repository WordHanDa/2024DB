<?php
header("Content-Type: application/json; charset=utf-8");// 回傳 json 格式的資料

$host = "localhost";
$user = "root";// 資料庫登入帳號
$password = "";// 資料庫登入密碼
$database = "city";
$link = mysqli_connect($host, $user, $password) or die("無法連接資料庫");// 建立與資料庫的連線物件
mysqli_select_db($link, $database);// 選擇資料庫
mysqli_query($link, "SET NAMES utf8");// 設定編碼

// 根據 GET 参數設定相關值
if (!empty($_GET['act'])) {
    $action = $_GET['act'];
}
if (!empty($_GET['val'])) {
    $val = $_GET['val'];
}
if (!empty($_GET['val2'])) {
    $val2 = $_GET['val2'];
}
if (!empty($_GET['val3'])) {
    $val3 = $_GET['val3'];
}
if (!empty($_GET['val4'])) {
    $val4 = $_GET['val4'];
}

$list = array(); // 存放查詢結果的陣列
switch ($action) {

    case 'city': // 查詢城市資料
        $sql = "SELECT * FROM city WHERE 1";
        $result = mysqli_query($link, $sql); // 執行SQL查詢
        while ($row = mysqli_fetch_assoc($result)) { // 從查詢結果中取得下一列關聯數組
            $list[] = $row; // 將關聯數組加入回傳結果陣列
        }
        break;
        
    case 'site_id': // 查詢地區資料
        $sql = "SELECT * FROM site WHERE city_id = '$val'";
        $result = mysqli_query($link, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $list[] = $row;
        }
        break;

    case 'road': // 查詢道路資料
        $sql = "SELECT * FROM road WHERE site_id = '$val'";
        $result = mysqli_query($link, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $list[] = $row;
        }
        break;

    case 'insertcity': // 查詢道路資料
        $sql = "INSERT INTO city VALUES('$val','$val2')";
        mysqli_query($link, $sql);
        break;

    case 'insertsite': // 查詢道路資料
        $sql = "INSERT INTO site VALUES('$val','$val2','$val3')";
        mysqli_query($link, $sql);
        break;

    case 'insertroad': // 查詢道路資料
        $sql = "INSERT INTO road VALUES('$val','$val2')";
        mysqli_query($link, $sql);
        break;
    
    case 'updatecity': // 查詢道路資料
        $sql = "UPDATE city SET city_id='$val2', city='$val3' WHERE city_id='$val'";
        $result = mysqli_query($link, $sql);
        break;
    
    case 'updatesite': // 查詢道路資料
        $sql = "UPDATE site SET site_id='$val2', site='$val3' WHERE site_id='$val'";
        mysqli_query($link, $sql);
        break;
    
    case 'updateroad': // 查詢道路資料
        $list=array();
        $sql = "UPDATE road SET site_id='$val3', road='$val4' WHERE site_id='$val' AND road='$val2'";
        mysqli_query($link, $sql);
        break;
    case 'deletecity': // 查詢道路資料
        $sql = "DELETE FROM city WHERE city_id='$val'";
        mysqli_query($link, $sql);
        break;
    
    case 'deletesite': // 查詢道路資料
        $sql = "DELETE FROM site WHERE site_id='$val'";
        mysqli_query($link, $sql);
        break;
        
    case 'deleteroad': // 查詢道路資料
        $list=array();
        $sql = "DELETE FROM city WHERE site_id='$val' AND road = '$val2'";
        mysqli_query($link, $sql);
        break;
}

echo json_encode($list); // 將陣列$list轉換成JSON格式的字串並輸出
return;

// 釋放記憶體
mysqli_free_result($result);

// 關閉連線
mysqli_close($link);

?>