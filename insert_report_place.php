<?php
if(isset($_POST['file'])){
    //mysqlとの接続
$link = mysqli_connect('localhost', 'root', '');
if (!$link) {
    die('Failed connecting'.mysqli_error());
}
//print('<p>Successed connecting</p>');

//DBの選択
$db_selected = mysqli_select_db($link , 'test_db');
if (!$db_selected){
    die('Failed Selecting table'.mysql_error());
}

$projects_id = $_POST["id"];
$pdf_name = $_POST["file"];
//文字列をutf8に設定
mysqli_set_charset($link , 'utf8');

//pdfテーブルの取得
$result_pdf_file  = mysqli_query($link ,"SELECT pdf_id FROM pdf_information_1 where project_id = '$projects_id' AND pdf_name ='$pdf_name';");
if (!$result_pdf_file) {
    die('Failed query'.mysql_error());
}
//データ格納用配列の取得
$pdf_id = array();
$i = 0;
while ($row_pdf = mysqli_fetch_assoc ($result_pdf_file)) {
    $pdf_id[$i] = $row_pdf['pdf_id'];
    $i++;
}
//print_r($pdf_id);
$close_flag = mysqli_close($link);

require "conn.php";

$p_id = $pdf_id[0];
//print_r($p_id);
$report_place_name = $_POST["s_name"];
$page = $_POST["s_page"];
$x = $_POST["s_x"];
$y = $_POST["s_y"];
$sql = "INSERT INTO report_places_infomation_1 VALUES ('', '$p_id', '$report_place_name', '$page', '$x','$y','');";
$result  = mysqli_query($conn, $sql);

exit;
}
?>