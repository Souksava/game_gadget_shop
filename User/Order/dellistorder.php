<?php 
    require '../../ConnectDB/connectDB.php';
    $detail_id = $_GET['id'];
    $sqldel2 = "delete from listorderdetail where detail_id='$detail_id'";
    $resultdel2 = mysqli_query($link, $sqldel2);
    if(!$resultdel2)
    {
        echo"<script>";
        echo"alert('ລົບຂໍ້ມູນບໍ່ສຳເລັດ');";
        echo"window.location.href='frmorder2.php';";
        echo"</script>";
    }
    else{
        echo"<script>";
        echo"alert('ລົບຂໍ້ມູນສຳເລັດ');";
        echo"window.location.href='frmorder2.php';";
        echo"</script>";
    }

?>
