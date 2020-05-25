<?php
    session_start();
    if($_SESSION['ses_id'] == ''){
       echo"<meta http-equiv='refresh' content='1;URL=../index.php'>";        
    }
    else if($_SESSION['status'] != 2){
       echo"<meta http-equiv='refresh' content='1;URL=../Check/logout.php'>";
    }
    else{}
 require '../../ConnectDB/connectDB.php';
 date_default_timezone_set("Asia/Bangkok");
 $datenow = time();
 $Date = date("Y-m-d",$datenow);
 $sqlshop = "select * from shop;";
 $resultshop = mysqli_query($link,$sqlshop);
 $rowshop = mysqli_fetch_array($resultshop,MYSQLI_ASSOC);
?>
<!Doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>ແກ້ໄຂຂໍ້ມູນ</title>
        <link rel="icon" href="../../image/<?php echo $rowshop['img_title']; ?>">
        <link rel="stylesheet" href="../../css/style.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <body >
        <div class="header">
            <div class="container">
                <div class="tapbar">
                    <a href="categorydetail.php">
                        <img src="../../icon/back.ico" width="30px">
                    </a>
                </div>
                <div align="center" class="tapbar fonthead">
                    ແກ້ໄຂຂໍ້ມູນ
                </div>
                <div class="tapbar" align="right">
                    <a href="../../Check/Logout.php">
                        <img src="../../icon/close.ico" width="30px">
                    </a>
                </div>
            </div>
        </div>
        <br>
        <?php 
            $id = $_GET['id'];
            $sqlget = "select cated_id,cated_name,d.cate_id,cate_name from categorydetail d left join category c on d.cate_id=c.cate_id where cated_id='$id';";
            $resultget = mysqli_query($link,$sqlget);
            $row = mysqli_fetch_array($resultget, MYSQLI_ASSOC);

        ?>
        <div class="container font14">
            <form action="updatecatedetail.php" id="update" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 form-group">
                        <label>ຊື່ປະເພດສິນຄ້າ</label>
                        <input type="text" name="cate_name" class="form-control" value="<?php echo $row['cated_name']?>" placeholder="ຊື່ປະເພດສິນຄ້າ">
                        <input type="hidden" name="cated_id" class="form-control" value="<?php echo $row['cated_id']?>" >
                    </div>
                    <div class="col-xs-12 col-sm-6 form-group">
                        <label>ປະເພດສິນຄ້າ</label>
                        <select name="cate_id" id="" class="form-control">
                            <option value="<?php echo $row['cate_id'] ?>" ><?php echo $row['cate_name'] ?> </option>
                            <?php
                                $cate_id2 = $row['cate_id'];
                                $sqlcate = "select * from category where cate_id != '$cate_id2';";
                                $resultcate = mysqli_query($link, $sqlcate);
                                while($rowcate = mysqli_fetch_array($resultcate, MYSQLI_NUM)){
                                    echo" <option value='$rowcate[0]'>$rowcate[1]</option>";
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 form-group">
                        <button type="submit" class="btn btn-outline-success" name="btnUpdate" style="width: 100%;">
                           ແກ້ໄຂຂໍ້ມູນ
                        </button>
                    </div>
                </div>
            </form>
        <?php
            if(isset($_POST['btnUpdate'])){
                $cated_id = $_POST['cated_id'];
                $cate_name = $_POST['cate_name']; 
                $cate_id = $_POST['cate_id'];
                if(trim($cate_name) == ""){
                    echo"<script>";
                    echo"alert('ກະລຸນາໃສ່ຊື່ປະເພດສິນຄ້າ');";
                    echo"window.location.href='categorydetail.php';";
                    echo"</script>";
                }
                else if(trim($cate_id) == ""){
                    echo"<script>";
                    echo"alert('ກະລຸນາເລືອກປະເພດສິນຄ້າ');";
                    echo"window.location.href='categorydetail.php';";
                    echo"</script>";
                }
                else {
                
                        $sqlupdate = "update categorydetail set cated_name='$cate_name',cate_id='$cate_id' where cated_id='$cated_id';";
                        $resultupdate = mysqli_query($link,$sqlupdate);
                        if(!$resultupdate){
                            echo"<script>";
                            echo"alert('ບໍ່ສາມາດແກ້ໄຂຂໍ້ມູນໄດ້');";
                            echo"window.location.href='categorydetail.php';";
                            echo"</script>";
                        }
                        else {
                            echo"<script>";
                            echo"alert('ແກ້ໄຂຂໍ້ມູນສຳເລັດ');";
                            echo"window.location.href='categorydetail.php';";
                            echo"</script>";
                        }
                    
                }
            }
        ?>
    </body>
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</html>
