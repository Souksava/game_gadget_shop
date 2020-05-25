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
                    <a href="product_function.php">
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
            $sqlget = "select function_id,f.func_id,func_name,f.pro_id,pro_name,content from function_product f left join func_pro o on f.func_id=o.func_id left join product p on f.pro_id=p.pro_id where function_id='$id';";
            $resultget = mysqli_query($link,$sqlget);
            $row = mysqli_fetch_array($resultget, MYSQLI_ASSOC);

        ?>
        <div class="container font14">
            <form action="updatefunc.php" id="update" method="POST" enctype="multipart/form-data">
                <div class="row" align="left">
                    <div class="col-xs-12 col-sm-6 form-group">
                        <label>ຊື່ສິນຄ້າ</label><br>
                        <select name="pro_id" id="" class="form-control">
                            <option value="<?php echo $row['pro_id']; ?>" ><?php echo $row['pro_name']; ?> </option>
                            <?php
                                $pro_id2 = $row['pro_id'];
                                $sqlpro = "select * from product where pro_id!='$pro_id2';";
                                $resultpro = mysqli_query($link, $sqlpro);
                                while($rowpro = mysqli_fetch_array($resultpro, MYSQLI_NUM)){
                                    echo" <option value='$rowpro[0]'>$rowpro[1]</option>";
                                }
                            ?>
                        </select>
                        <input type="hidden" name="function_id" class="form-control" value="<?php echo $row['function_id']; ?>" >
                    </div>
                    <div class="col-xs-12 col-sm-6 form-group">
                        <label>ຊື່ຟັງຊັນສິນຄ້າ</label>
                        <select name="func_id" id="" class="form-control">
                            <option value="<?php echo $row['func_id']; ?>" ><?php echo $row['func_name']; ?> </option>
                            <?php
                                $func_id2 = $row['func_id'];
                                $sqlfunc = "select * from func_pro where func_id!='$func_id2';";
                                $resultfunc = mysqli_query($link, $sqlfunc);
                                while($rowfunc = mysqli_fetch_array($resultfunc, MYSQLI_NUM)){
                                    echo" <option value='$rowfunc[0]'>$rowfunc[1]</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="col-xs-12 col-sm-6 form-group">
                        <label>ຟັງຊັນສິນຄ້າ</label>
                        <input type="text" name="function" class="form-control" placeholder="ຟັງຊັນສິນຄ້າ" value="<?php echo $row['content']; ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-6 form-group">
                        <button type="submit" class="btn btn-outline-success" name="btnUpdate" style="width: 100%;">
                           ແກ້ໄຂຂໍ້ມູນ
                        </button>
                    </div>
                </div>
            </form>
        <?php
            if(isset($_POST['btnUpdate'])){
                $function_id = $_POST['function_id'];
                $pro_id = $_POST['pro_id'];
                $func_id = $_POST['func_id'];
                $functions = $_POST['function'];
                if(trim($pro_id) == ""){
                    echo"<script>";
                    echo"alert('ກະລຸນາເລືອກສິນຄ້າ');";
                    echo"window.location.href='product_function.php';";
                    echo"</script>";
                }
                elseif(trim($func_id) == ""){
                    echo"<script>";
                    echo"alert('ກະລຸນາເລືອກຊື່ຟັງຊັນ');";
                    echo"window.location.href='product_function.php';";
                    echo"</script>";
                }
                elseif(trim($functions) == ""){
                    echo"<script>";
                    echo"alert('ກະລຸນາໃສ່ຟັງຊັນ');";
                    echo"window.location.href='product_function.php';";
                    echo"</script>";
                }
                else {
                        $sqlupdate = "update function_product set pro_id='$pro_id',func_id='$func_id',content='$functions' where function_id='$function_id';";
                        $resultupdate = mysqli_query($link,$sqlupdate);
                        if(!$resultupdate){
                            echo"<script>";
                            echo"alert('ບໍ່ສາມາດແກ້ໄຂຂໍ້ມູນໄດ້');";
                            echo"window.location.href='product_function.php';";
                            echo"</script>";
                        }
                        else {
                            echo"<script>";
                            echo"alert('ແກ້ໄຂຂໍ້ມູນສຳເລັດ');";
                            echo"window.location.href='product_function.php';";
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
