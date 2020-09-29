<?php
//$be = "http://10.20.170.52/web/p_entry_report_place.php";
$err_msg = "";
$row_array_company ="";
$row_array_user = "";
$row_array_sum = array();
$refe= "";
if(isset($_SERVER['HTTP_REFERER'])){
    //print_r($_SERVER['HTTP_REFERER']);
    $refe = $_SERVER['HTTP_REFERER'];
    //if(strpos($refe,$be)){
        //print_r("テスト");
        session_start();
        $project_id = $_SESSION['count'];
        $project_id_now = json_encode($project_id);
        //print_r($project_id);
    //}else{
        //print_r("テスト2");
    //}
}
if(isset($_POST['search_user'])){
    require "conn.php";
    $id = $_POST["id"];
    $user_name = $_POST["user_name"];

    //①両方なし
    if($id =="" && $user_name == ""){
        $mysql_qry = "select * from users_information_1 inner join companies_information_1 on users_information_1.companies_id = companies_information_1.companies_id;";
    $result = mysqli_query($conn, $mysql_qry);
    if(mysqli_num_rows($result) > 0){
        //print_r($result);
        $row_array_company = array();
        $row_array_user = array();
        $i = 0;
        while($row = mysqli_fetch_assoc($result)){
            //1回目は追加、2回目から同じ値かどうかの確認
            //print_r($row);
            if($i == 0){
                $row_array_company[$i] = $row['companies_name'];
                $i++;
            }else{
                $key = in_array($row['companies_name'], $row_array_company);
                if($key){
                    
                }else{
                    $row_array_company[$i] = $row['companies_name'];
                    $i++;
                }   
        }
    }
        $i = 0;
        $num = 0;
        //値格納用の配列を作る
        for($j = 0; $j < count($row_array_company); $j++){
            $row_array_sum[$row_array_company[$j]] = array();
            print_r($row_array_company[$j]);
        }
        print_r($row_array_sum);
        //$row_array_sum = array($row_array_company ,$row_array_user);
        /*$resultt = mysqli_query($conn, $mysql_qry);
        while($ro = mysqli_fetch_assoc($resultt)){
            //配列の何番目の会社か調べる
            $com_num = array_search($ro['companies_name'], $row_array_company);
            array_push($row_array_sum[$com_num], $ro['users_name']);
            //$com_user_num = count($row_array_sum[$com_num]);
            //$row_array_sum[$com_num][$com_user_num] = $ro['user_name'];
        }
        //$row_array_sum = array($row_array_company, $row_array_user);
            
            //配列の中にいるユーザ数
            //$com_user_num = count($row_array_sum[$com_num]);
            //$row_array_sum[$com_num][$com_user_num] = $row;
       
        //print_r($row_array_company);
        print_r($row_array_sum);*/
}
    }elseif($id !="" && $user_name == ""){
        $mysql_qry = "select * from users_information_1 inner join companies_information_1 on users_information_1.companies_id = companies_information_1.companies_id where companies_name like '%$id%' ;";
        $result = mysqli_query($conn, $mysql_qry);
        if(mysqli_num_rows($result) > 0){
            $row_array_company= array();
            $row_array_user = array();
            $i = 0;
            while($row = mysqli_fetch_assoc($result)){
                $row_array_company[$i] = $row['companies_name'];
                $row_array_user[$i] = $row['users_name'];
                $i++;
            }
            print_r($row_array_user);
    }
    }elseif($id =="" && $user_name != ""){
        $mysql_qry = "select * from users_information_1 inner join companies_information_1 on users_information_1.companies_id = companies_information_1.companies_id where users_name like '%$user_name%';";
        $result = mysqli_query($conn, $mysql_qry);
        if(mysqli_num_rows($result) > 0){
            $row_array_company = array();
            $row_array_user = array();
            $i = 0;
            while($row = mysqli_fetch_assoc($result)){
                $row_array_company[$i] = $row['companies_name'];
                $row_array_user[$i] = $row['users_name'];
                $i++;
            }
            print_r($row_array_user);
    }
}elseif($id !="" && $user_name != ""){
        print_r("テスト");
        $mysql_qry = "select * from users_information_1 inner join companies_information_1 on users_information_1.companies_id = companies_information_1.companies_id where companies_name like '%$id%' or users_name like '%$user_name%';";
        $result = mysqli_query($conn, $mysql_qry);
        if(mysqli_num_rows($result) > 0){
            $row_array_company = array();
            $row_array_user = array();
            $i = 0;
            while($row = mysqli_fetch_assoc($result)){
                $row_array_company[$i] = $row['companies_name'];
                $row_array_user[$i] = $row['users_name'];
                $i++;
            }
            print_r($row_array_user);
    }
    }
   
}
$json_array_company = json_encode($row_array_company);
$json_array_user = json_encode($row_array_user);

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>ユーザ登録画面</title>
    </head>
    <body>
    <h2>ユーザを登録してください。</h2>
    <p>
        <form action="p_entry_user.php" method = "post">
        会社名<input type = "text" name = "id" value = ""><br />
        ユーザー名<input type ="text" name="user_name" value = ""><br />
        <input type = "submit" id = "search_user" name="search_user" value = "検索">
        </form>
    </p>     
    
    <form id="user_form">
    <table id = "user_info">
                <tr>
                    <th style="WIDTH: 200px" id="user_company">会社名</th>
                    <th style="WIDTH: 300px" id="user_name">ユーザ名</th>
                    <th> <input type = "checkbox" style="WIDTH: 60px" id="user_check" onclick="selectall()"></th>
                </tr>
            </table>
            <input type = "submit" id = "user_button" name="gotUser" value = "次へ">
    </form>
    <script type="text/javascript">
        //var names =[];
        var company = "";
        var user ="";
        var tableLength ="";
        var cell1 = [];
        var cell2 = [];
        var cell3 = [];
        if(<?php echo $json_array_company; ?>!=""){
            company = <?php echo $json_array_company; ?>;
            user = <?php echo $json_array_user; ?>;
            console.log(company.length);
            console.log(user.length);
            //テーブルの作成
            //テーブルの大きさ
            tableLength = company.length + user.length;
            //console.log(tableLength);
            //テーブルの取得
            var table = document.getElementById("user_info");
            //テーブルに要素の追加
            for(var i = 0; i < tableLength; i++){
                var row = table.insertRow(-1);
                cell1.push(row.insertCell(-1));
                cell2.push(row.insertCell(-1));
                cell3.push(row.insertCell(-1));
                cell1[i].innerHTML = "test";
                cell2[i].innerHTML = "sample";
                cell3[i].innerHTML = '<input type = "checkbox"/>';
            }
            
        }
        
    </script>
    </body>

</html>