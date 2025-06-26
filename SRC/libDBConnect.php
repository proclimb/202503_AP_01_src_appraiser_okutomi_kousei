<?php

//
// ログイン
//
function fnSqlLogin($id)
{
    $id = addslashes($id);
    $sql = "SELECT USERNO,AUTHORITY,PASSWORD FROM TBLUSER";
    $sql .= " WHERE DEL = 1";
    $sql .= " AND ID = '$id'";

    return ($sql);
}

//
// ユーザー情報リスト
//
function fnSqlAdminUserList()
{
    $sql = "SELECT USERNO,NAME,ID,PASSWORD,AUTHORITY FROM TBLUSER";
    $sql .= " WHERE DEL = 1";
    $sql .= " ORDER BY AUTHORITY ASC,NAME ASC";

    return ($sql);
}

//
// ユーザー情報詳細
//
function fnSqlAdminUserEdit($userNo)
{
    $sql = "SELECT NAME,ID,PASSWORD,AUTHORITY FROM TBLUSER";
    $sql .= " WHERE USERNO = $userNo";

    return ($sql);
}

//
// ユーザー情報更新
//
function fnSqlAdminUserUpdate($userNo, $name, $id, $password, $authority)
{
    if ($password !== "") {
        $pass = password_hash($password, PASSWORD_DEFAULT);
    }
    $sql = "UPDATE TBLUSER";
    $sql .= " SET NAME = '$name'";
    $sql .= ",ID = '$id'";
    if ($password !== "") {
        $sql .= ",PASSWORD = '$pass'";
    }
    $sql .= ",AUTHORITY = '$authority'";
    $sql .= ",UPDT = CURRENT_TIMESTAMP";
    $sql .= " WHERE USERNO = '$userNo'";

    return ($sql);
}

//
// ユーザー情報登録
//
function fnSqlAdminUserInsert($userNo, $name, $id, $password, $authority)
{
    $pass = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO TBLUSER(";
    $sql .= "USERNO,NAME,ID,PASSWORD,AUTHORITY,INSDT,UPDT,DEL";
    $sql .= ")VALUES(";
    $sql .= "'$userNo','$name','$id','$pass','$authority',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,1)";

    return ($sql);
}

//
// ユーザー情報削除
//
function fnSqlAdminUserDelete($userNo)
{
    $sql = "UPDATE TBLUSER";
    $sql .= " SET DEL = 0";
    $sql .= ",UPDT = CURRENT_TIMESTAMP";
    $sql .= " WHERE USERNO = '$userNo'";

    return ($sql);
}

//
// 次の番号を得る
//
function fnNextNo($t)
{
    $conn = fnDbConnect();

    $sql = "SELECT MAX(" . $t . "NO) FROM TBL" . $t;
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($res);
    if ($row[0]) {
        $max = $row[0] + 1;
    } else {
        $max = 1;
    }

    return ($max);
}
