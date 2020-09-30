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
        $project_id =1;
        //$project_id = $_SESSION['count'];
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
                $row_array_sum[$row['companies_name']]["num"]=0;
                $i++;
            }else{
                $key = in_array($row['companies_name'], $row_array_company);
                if($key){
                    
                }else{
                    $row_array_company[$i] = $row['companies_name'];
                    $row_array_sum[$row['companies_name']]["num"]=0;
                    $i++;
                }   
        }
    }
        //$i = 0;
        //$num = 0;
        //値格納用の配列を作る
        //for($j = 0; $j < count($row_array_company); $j++){
            //$row_array_sum[$row_array_company[$j]] = array();
            //print_r($row_array_company[$j]);
        //}
        //print_r($row_array_sum);
        //$row_array_sum = array($row_array_company ,$row_array_user);
        $resultt = mysqli_query($conn, $mysql_qry);
        while($ro = mysqli_fetch_assoc($resultt)){
            //配列の何番目の会社か調べる
            //$com_num = array_search($ro['companies_name'], $row_array_company);
            //print_r($com_num);
            $row_array_sum[$ro['companies_name']][$row_array_sum[$ro['companies_name']]["num"]] = $ro['users_name'];
            $row_array_sum[$ro['companies_name']]["num"] += 1;
            //array_push($row_array_sum[$com_num], $ro['users_name']);
            //$com_user_num = count($row_array_sum[$com_num]);
            //$row_array_sum[$com_num][$com_user_num] = $ro['user_name'];
        }
        //print_r($row_array_sum["company1"]["num"]);
        //$row_array_sum = array($row_array_company, $row_array_user);
            
            //配列の中にいるユーザ数
            //$com_user_num = count($row_array_sum[$com_num]);
            //$row_array_sum[$com_num][$com_user_num] = $row;
       
        //print_r($row_array_company);
        //print_r($row_array_sum);
}
    }elseif($id !="" && $user_name == ""){
        //②ユーザ名なし
        $mysql_qry = "select * from users_information_1 inner join companies_information_1 on users_information_1.companies_id = companies_information_1.companies_id where companies_name like '%$id%' ;";
        $result = mysqli_query($conn, $mysql_qry);
        if(mysqli_num_rows($result) > 0){
            
            $row_array_company = array();
        $row_array_user = array();
        $i = 0;
        while($row = mysqli_fetch_assoc($result)){
            //1回目は追加、2回目から同じ値かどうかの確認
            //print_r($row);
            if($i == 0){
                $row_array_company[$i] = $row['companies_name'];
                $row_array_sum[$row['companies_name']]["num"]=0;
                $i++;
            }else{
                $key = in_array($row['companies_name'], $row_array_company);
                if($key){
                    
                }else{
                    $row_array_company[$i] = $row['companies_name'];
                    $row_array_sum[$row['companies_name']]["num"]=0;
                    $i++;
                }   
        }
    }
        $resultt = mysqli_query($conn, $mysql_qry);
        while($ro = mysqli_fetch_assoc($resultt)){
            $row_array_sum[$ro['companies_name']][$row_array_sum[$ro['companies_name']]["num"]] = $ro['users_name'];
            $row_array_sum[$ro['companies_name']]["num"] += 1;
        }
            
    }
    }elseif($id =="" && $user_name != ""){
        //③idなし
        $mysql_qry = "select * from users_information_1 inner join companies_information_1 on users_information_1.companies_id = companies_information_1.companies_id where users_name like '%$user_name%';";
        $result = mysqli_query($conn, $mysql_qry);
        if(mysqli_num_rows($result) > 0){
            $row_array_company = array();
        $row_array_user = array();
        $i = 0;
        while($row = mysqli_fetch_assoc($result)){
            //1回目は追加、2回目から同じ値かどうかの確認
            //print_r($row);
            if($i == 0){
                $row_array_company[$i] = $row['companies_name'];
                $row_array_sum[$row['companies_name']]["num"]=0;
                $i++;
            }else{
                $key = in_array($row['companies_name'], $row_array_company);
                if($key){
                    
                }else{
                    $row_array_company[$i] = $row['companies_name'];
                    $row_array_sum[$row['companies_name']]["num"]=0;
                    $i++;
                }   
        }
    }
        $resultt = mysqli_query($conn, $mysql_qry);
        while($ro = mysqli_fetch_assoc($resultt)){
            $row_array_sum[$ro['companies_name']][$row_array_sum[$ro['companies_name']]["num"]] = $ro['users_name'];
            $row_array_sum[$ro['companies_name']]["num"] += 1;
        }
    }//print_r($row_array_sum);
}elseif($id !="" && $user_name != ""){
        print_r("テスト");
        $mysql_qry = "select * from users_information_1 inner join companies_information_1 on users_information_1.companies_id = companies_information_1.companies_id where companies_name like '%$id%' or users_name like '%$user_name%';";
        $result = mysqli_query($conn, $mysql_qry);
        if(mysqli_num_rows($result) > 0){
            $row_array_company = array();
        $row_array_user = array();
        $i = 0;
        while($row = mysqli_fetch_assoc($result)){
            //1回目は追加、2回目から同じ値かどうかの確認
            //print_r($row);
            if($i == 0){
                $row_array_company[$i] = $row['companies_name'];
                $row_array_sum[$row['companies_name']]["num"]=0;
                $i++;
            }else{
                //両方記入されている
                $key = in_array($row['companies_name'], $row_array_company);
                if($key){
                    
                }else{
                    $row_array_company[$i] = $row['companies_name'];
                    $row_array_sum[$row['companies_name']]["num"]=0;
                    $i++;
                }   
        }
    }
        $resultt = mysqli_query($conn, $mysql_qry);
        while($ro = mysqli_fetch_assoc($resultt)){
            $row_array_sum[$ro['companies_name']][$row_array_sum[$ro['companies_name']]["num"]] = $ro['users_name'];
            $row_array_sum[$ro['companies_name']]["num"] += 1;
        }
            print_r($row_array_sum);
    }
    }
   
}
$json_array_company = json_encode($row_array_company);
$json_array_user = json_encode($row_array_user);
$json_array_sum = json_encode($row_array_sum);
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
    <table id = "user_info" name = "table1">
                <tr>
                    <th style="WIDTH: 200px" id="user_company">会社名</th>
                    <th style="WIDTH: 300px" id="user_name">ユーザ名</th>
                    <th> <input type = "checkbox" name = "ch" style="WIDTH: 60px" id="user_check" onclick="selectall(this)"></th>
                </tr>
            </table>
            <input type = "button" id = "user_button" name="gotUser" value = "次へ" onclick="gotuser()">
    </form>
    <script type="text/javascript">
        //var names =[];
        var sum = <?php echo $json_array_sum; ?>;
        console.log(sum['company1'][0]);
        var company = "";
        var user ="";
        var tableLength ="";
        var cell1 = [];
        var cell2 = [];
        var cell3 = [];
        if(<?php echo $json_array_company; ?>!=""){
            company = <?php echo $json_array_company; ?>;
            //user = <?php echo $json_array_user; ?>;
            console.log(company);
            console.log(user.length);
            //テーブルの作成
            var table = document.getElementById("user_info");
            //テーブルの大きさ(会社枠)
            var i = 0;
            //会社名
            for(var j = 0; j < company.length; j++){
                var row = table.insertRow(-1);
                cell1.push(row.insertCell(-1));
                cell2.push(row.insertCell(-1));
                cell3.push(row.insertCell(-1));
                cell1[i].innerHTML = company[j];
                cell3[i].innerHTML = '<input type = "checkbox" onclick="changeCom(this)"/>';
                i++;
                //ユーザ名
                for(var k = 0; k < sum[company[j]]['num']; k++){
                    var row = table.insertRow(-1);
                    cell1.push(row.insertCell(-1));
                    cell2.push(row.insertCell(-1));
                    cell3.push(row.insertCell(-1));
                    cell2[i].innerHTML = sum[company[j]][k];
                    cell3[i].innerHTML = '<input type = "checkbox" name = "ch"/>';
                    cell3[i].id = i;
                    i++;
                }
            }
            tableLength = company.length + user.length;
            
        }
        
    </script>
    <script>
        function selectall(th){
            for(var t = 1; t < table.rows.length; t++){
                if(th.checked == true){
                    var val = table.rows[t].cells[2].children[0];
                    val.checked = true;
                }else{
                    var val = table.rows[t].cells[2].children[0];
                    val.checked = false;
                }
                
            }
        }

        function changeCom(thi){
            var tr = thi.parentNode.parentNode;
            var ind = tr.rowIndex;
            var le = table.rows.length;
            console.log(le);
            //console.log(table.rows[ind+1].cells[0].innerHTML);
            //console.log(table.rows[ind].cells[0].innerHTML);
                if(thi.checked == true){
                    while(table.rows[ind+1].cells[0].innerHTML == ""){
                    var va = table.rows[ind+1].cells[2].children[0];
                    va.checked = true;
                    ind++;
                    if(ind == le-1){
                        break;
                    }
                    }
                    
                }
                else{
                    while(table.rows[ind+1].cells[0].innerHTML == ""){
                    var va = table.rows[ind+1].cells[2].children[0];
                    va.checked = false;
                    ind++;
                    if(ind == le-1){
                        break;
                    }
                }
                } 
            console.log(tr.rowIndex);
            //var com_name = tr.cell[0].innerHTML;

        }

        function gotuser(){
            //プロジェクトIDと会社名、ユーザ名を送信
            var p_id = <?php echo $project_id_now; ?>;
            var c_name;
            var u_name;
            var le = table.rows.length;
            for(var p = 1; p < le; p++){
                if(table.rows[p].cells[0].innerHTML != ""){
                    c_name = table.rows[p].cells[0].innerHTML;
                }else{
                    if(table.rows[p].cells[2].children[0].checked = true){
                        u_name = table.rows[p].cells[1].innerHTML;
                        fd = new FormData();
                        fd.append('id', p_id);
                        fd.append('company',c_name);
                        fd.append('user', u_name);
                        xhttpreq = new XMLHttpRequest();
                        xhttpreq.onreadystatechange = function() {
                        if (xhttpreq.readyState == 4 && xhttpreq.status == 200) {
                        alert(xhttpreq.responseText);
                        }
                        };
                        xhttpreq.open("POST", "insert_assign_com.php", true);
                        xhttpreq.send(fd);
                    }else{

                    } 
                }
                p++;
            }
        }
    </script>
    </body>

</html>