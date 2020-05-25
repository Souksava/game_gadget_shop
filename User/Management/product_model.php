<?php
    session_start();
    if($_SESSION['ses_id'] == ''){
        echo"<meta http-equiv='refresh' content='1;URL=../../index.php'>";        
    }
    else if($_SESSION['status'] != 2){
        echo"<meta http-equiv='refresh' content='1;URL=../../Check/logout.php'>";
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
        <title>ໂມເດວສິນຄ້າ</title>
        <link rel="icon" href="../../image/<?php echo $rowshop['img_title'];?>">
        <link rel="stylesheet" href="../../css/style.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <body >
        <div class="header">
            <div class="container">
                <div class="tapbar">
                    <a href="management.php">
                        <img src="../../icon/back.ico" width="30px">
                    </a>
                </div>
                <div align="center" class="tapbar fonthead">
                    ໂມເດວສິນຄ້າ
                </div>
                <div class="tapbar" align="right">
                    <a href="../../Check/Logout.php">
                        <img src="../../icon/close.ico" width="30px">
                    </a>
                </div>
            </div>
        </div>
        <br>
        <div class="container font14">
            <div class="row">
                <div style="float: left;width: 50%;padding-left: 10px;">
                    <b>ໂມເດວສິນຄ້າ</b>&nbsp <img src="../../icon/hidemenu.ico" width="10px">
                </div>
                <div align="right" style="width: 48%;float: right;">
                    <form action="product_model.php" id="form1" method="POST" enctype="multipart/form-data">
                        <a href="#" data-toggle="modal" data-target="#exampleModal">
                            <img src="../../icon/add.ico" alt="" width="30px">
                        </a>
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">ໂມເດວສິນຄ້າd</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row" align="left">
                                            <div class="col-md-12 form-group">
                                                <label>ສິນຄ້າ</label>
                                                <select name="pro_id" id="" class="form-control">
                                                    <option value="">ເລືອກສິນຄ້າ</option>
                                                    <?php
                                                        $sqlpro = "select * from product;";
                                                        $resultpro = mysqli_query($link, $sqlpro);
                                                        while($rowpro = mysqli_fetch_array($resultpro, MYSQLI_NUM)){
                                                        echo" <option value='$rowpro[0]'>$rowpro[1]</option>";
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-md-12 form-group">
                                                <label>ມຸມສິນຄ້າ</label>
                                                <select name="model_id" id="" class="form-control">
                                                    <option value="">ເລືອກມຸມສິນຄ້າ</option>
                                                    <?php
                                                        $sqlpro = "select * from model;";
                                                        $resultpro = mysqli_query($link, $sqlpro);
                                                        while($rowpro = mysqli_fetch_array($resultpro, MYSQLI_NUM)){
                                                        echo" <option value='$rowpro[0]'>$rowpro[1]</option>";
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-md-12 form-group">
                                                <label>ພາບສິນຄ້າ</label>
                                                <input type="file" name="img_path" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">ຍົກເລີກ</button>
                                        <button type="submit" name="btnSave" class="btn btn-outline-primary">ບັນທຶກ</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php
            if(isset($_POST['btnSave'])){
                $pro_id = $_POST['pro_id'];
                $model_id = $_POST['model_id'];
                if(trim($pro_id) == ""){
                    echo"<script>";
                    echo"alert('ກະລຸນາເລືອກສິນຄ້າ');";
                    echo"window.location.href='product_model.php';";
                    echo"</script>";
                }
                elseif(trim($model_id) == ""){
                    echo"<script>";
                    echo"alert('ກະລຸນາເລືອກມຸມສິນຄ້າ');";
                    echo"window.location.href='product_model.php';";
                    echo"</script>";
                }
                elseif(trim($_FILES['img_path']['name']) == ""){
                    echo"<script>";
                    echo"alert('ກະລຸນາໃສ່ຮູບພາບສິນຄ້າ');";
                    echo"window.location.href='product_model.php';";
                    echo"</script>";
                }
                else {
                    $sqlckid = "select * from product_model where pro_id='$pro_id' and model_id='$model_id';";
                    $resultckid = mysqli_query($link,$sqlckid);
                    if(mysqli_num_rows($resultckid) > 0){
                        echo"<script>";
                        echo"alert('ບໍ່ສາມາດບັນທຶກຂໍ້ມູນໄດ້ ເນື່ອງຈາກສິນຄ້າ ແລະ ມຸມນີ້ຂອງສິນຄ້າມີຢູ່ແລ້ວ');";
                        echo"window.location.href='product_model.php';";
                        echo"</script>";
                    }
                    else {
                        $ext = pathinfo(basename($_FILES["img_path"]["name"]), PATHINFO_EXTENSION);
                        $new_image_name = "img_".uniqid().".".$ext;
                        $image_path = "../../image/";
                        $upload_path = $image_path.$new_image_name;
                        move_uploaded_file($_FILES["img_path"]["tmp_name"], $upload_path);
                        $pro_img = $new_image_name;
                        $sqlinsert = "insert into product_model(pro_id,model_id,img_path) values('$pro_id','$model_id','$pro_img')";
                        $resultinsert = mysqli_query($link, $sqlinsert);
                        if(!$resultinsert){
                            echo"<script>";
                            echo"alert('ບໍ່ສາມາດບັນທຶກຂໍ້ມູນໄດ້');";
                            echo"window.location.href='product_model.php';";
                            echo"</script>";
                        }
                        else {
                            echo"<script>";
                            echo"alert('ບັນທຶກຂໍ້ມູນສຳເລັດ');";
                            echo"window.location.href='product_model.php';";
                            echo"</script>";
                        }
                    }
                }
            }
        ?>
        <div class="clearfix"></div>
        <div class="container font14">
            <form action="product_model.php" id="fomrsearch" method="POST">
                <div style="width: 100%">
                    <input type="text" class="form-control" name="search" style="float: left;width: 50%;" placeholder="ລະຫັດສິນຄ້າ, ຊື່ສິນຄ້າ">
                    <button class="btn btn-outline-primary" name="btnSearch" type="submit" style="float:left;margin-left: 10px">
                        ຄົ້ນຫາ
                    </button>
                </div>
            </form>
        </div>
        <div class="clearfix"></div><br>
        <?php
            if(isset($_POST['btnSearch'])){
            $search = "%".$_POST['search']."%";
            
        ?>
        <div class="container font12">
            <div>
                <?php
                    $s = $_POST['search'];
                    if($s != ""){
                        echo"ຄົ້ນຫາດ້ວຍ '$s'";
                    }
                ?>
            </div>
            <div class="row row-cols-1 row-cols-md-3">
                <?php
                    $sql = "select model_id,m.pro_id,pro_name,m.model,l.model as model2,m.img_path,name from product_model m left join model l on m.model_id=l.model left join product p on m.pro_id=p.pro_id where m.pro_id like '$search' or pro_name like '$search';";
                    $result = mysqli_query($link,$sql);
                    $NO_ = 0;
                    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                ?>
                <div class="col mb-4">
                    <div class="card h-100">
                        <a href="../../image/<?php echo $row['img_path'] ?>">
                            <img src="../../image/<?php echo $row['img_path'] ?>" height="280px" class="card-img-top" alt="">
                        </a>
                        <div class="card-body">
                            <h6 class="card-title">ລະຫັດສິນຄ້າ: <?php echo $row['pro_id']; ?></h6>
                            <p class="card-text">
                                ຊື່ສິນຄ້າ: <?php echo $row['pro_name']; ?><br>
                                ມຸມສິນຄ້າ: <?php echo $row['name']; ?> <br>
                                <br><br>
                                <a href="updatemodel.php?id=<?php echo $row['model_id']; ?>" class="btn btn-outline-success" style="width: 100%;">ແກ້ໄຂ</a><br><br>
                                <a href="delmodel.php?id=<?php echo $row['model_id']; ?>" class="btn btn-outline-danger" style="width: 100%;" >ລົບ</a>
                            </p>
                        </div>
                    </div>
                </div>
                <?php
                    }
                ?>
            </div>
        </div>
        <?php
            }
        ?>
    </body>
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</html>
