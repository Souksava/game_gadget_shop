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
        <title>ລີວິວສິນຄ້າ</title>
        <link rel="icon" href="../../image/<?php echo $rowshop['img_title']; ?>">
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
                    ລີວິວສິນຄ້າ
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
                    <b>ລີວິວສິນຄ້າ</b>&nbsp <img src="../../icon/hidemenu.ico" width="10px">
                </div>
                <div align="right" style="width: 48%;float: right;">
                    <form action="productdetail.php" id="form1" method="POST" enctype="multipart/form-data">
                        <a href="#" data-toggle="modal" data-target="#exampleModal">
                            <img src="../../icon/add.ico" alt="" width="30px">
                        </a>
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">ລິວິວສິນຄ້າ</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row" align="left">
                                            <div class="col-md-12 form-group">
                                                <label>ສິນຄ້າ</label><br>
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
                                                <label>ພາບລີວິວ</label><br>
                                                <input type="file" name="img_path" class="form-control">
                                            </div>
                                            <div class="col-md-12 form-group">
                                                <label>ວີດີໂອລີວິວ</label><br>
                                                <input type="text" name="review_youtube" class="form-control" placeholder="ວີດີໂອລີວິວ">
                                            </div>
                                            <div class="col-md-12 form-group">
                                                <label>ຫົວຂໍ້ລີວິວ</label><br>
                                                <select name="topic_id" id="" class="form-control">
                                                    <option value="">ເລືອກຫົວຂໍ້ລີວິວ</option>
                                                    <?php
                                                        $sqltopic = "select * from topic;";
                                                        $resulttopic = mysqli_query($link, $sqltopic);
                                                        while($rowtopic = mysqli_fetch_array($resulttopic, MYSQLI_NUM)){
                                                        echo" <option value='$rowtopic[0]'>$rowtopic[1]</option>";
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-md-12 form-group">
                                                <label>ເນື້ອຫາ</label><br>
                                                <!-- <input type="text" name="content" class="form-control" placeholder="ເນື້ອຫາ"> -->
                                                <textarea name="content" id="" cols="30" rows="10" placeholder="ເນື້ອຫາ" class="form-control"></textarea>
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
                $review_youtube = $_POST['review_youtube'];
                $topic_id = $_POST['topic_id'];
                $content = $_POST['content'];
                if(trim($pro_id) == ""){
                    echo"<script>";
                    echo"alert('ກະລຸນາເລືອກສິນຄ້າ');";
                    echo"window.location.href='productdetail.php';";
                    echo"</script>";
                }
                elseif(trim($topic_id) == ""){
                    echo"<script>";
                    echo"alert('ກະລຸນາເລືອກຫົວຂໍ້ລີວິວ');";
                    echo"window.location.href='productdetail.php';";
                    echo"</script>";
                }
                else {
                    $sqlckid = "select * from productdetail where pro_id='$pro_id' and topic='$topic';";
                    $resultckid = mysqli_query($link,$sqlckid);
                    if(mysqli_num_rows($resultckid) > 0){
                        echo"<script>";
                        echo"alert('ບໍ່ສາມາດບັນທຶກຂໍ້ມູນໄດ້ ເນື່ອງຈາກສິນຄ້າ ແລະ ຫົວຂໍ້ນີ້ມີຢູ່ແລ້ວ');";
                        echo"window.location.href='productdetail.php';";
                        echo"</script>";
                    }
                    else {
                        $ext = pathinfo(basename($_FILES["img_path"]["name"]), PATHINFO_EXTENSION);
                        $new_image_name = "img_".uniqid().".".$ext;
                        $image_path = "../../image/";
                        $upload_path = $image_path.$new_image_name;
                        move_uploaded_file($_FILES["img_path"]["tmp_name"], $upload_path);
                        $pro_img = $new_image_name;
                        $sqlinsert = "insert into productdetail(pro_id,img_path,review_youtube,topic_id,content) values('$pro_id','$pro_img','$review_youtube','$topic_id','$content');";
                        $resultinsert = mysqli_query($link, $sqlinsert);
                        if(!$resultinsert){
                            echo"<script>";
                            echo"alert('ບໍ່ສາມາດບັນທຶກຂໍ້ມູນໄດ້');";
                            echo"window.location.href='productdetail.php';";
                            echo"</script>";
                        }
                        else {
                            echo"<script>";
                            echo"alert('ບັນທຶກຂໍ້ມູນສຳເລັດ');";
                            echo"window.location.href='productdetail.php';";
                            echo"</script>";
                        }
                    }
                }
            }
        ?>
        <div class="clearfix"></div>
        <div class="container font14">
            <form action="productdetail.php" id="fomrsearch" method="POST">
                <div style="width: 100%">
                    <input type="text" class="form-control" name="search" style="float: left;width: 50%;" placeholder="ລະຫັດສິນຄ້າ, ຊື່ສິນຄ້າ, ປະເພດ, ຫົວໜ່ວຍ, ຍີ່ຫໍ້">
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
                    $sql = "select id,d.pro_id,pro_name,unit_name,cate_name,cated_name,brand_name,d.topic_id,topic_name,d.img_path as dimg_path,p.img_path as pimg_path,review_youtube,content from productdetail d left join product p on d.pro_id=p.pro_id left join categorydetail l on p.cated_id=l.cated_id left join category c on l.cate_id=c.cate_id left join unit u on p.unit_id=u.unit_id left join brand b on p.brand_id=b.brand_id left join topic t on d.topic_id=t.topic_id where d.pro_id like '$search' or pro_name like '$search' or unit_name like '$search' or cate_name like '$search' or brand_name like '$search';";
                    $result = mysqli_query($link,$sql);
                    $NO_ = 0;
                    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                ?>
                <div class="col mb-4">
                    <div class="card h-100">
                        <a href="../../image/<?php echo $row['dimg_path'] ?>">
                            <img src="../../image/<?php echo $row['dimg_path'] ?>" height="280px" class="card-img-top" alt="">
                        </a>
                        <?php 
                        if(trim($row['review_youtube']) == ""){
                            echo"";
                        }
                        else{
                        ?>
                            <iframe width="100%" height="315" src="<?php echo $row['review_youtube']; ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        <?php } ?>
                        <div class="card-body">
                            <h6 class="card-title"><?php echo $row['topic_name']; ?></h6>
                            <p class="card-text">
                                ລະຫັດ: <?php echo $row['pro_id']; ?><br>
                                ຊື່ສິນຄ້າ: <?php echo $row['pro_name']; ?><br> ຍີ່ຫໍ້: <?php echo $row['brand_name']; ?> <br>
                                ປະເພດ: <?php echo $row['cate_name']; ?>  <?php echo $row['cated_name']; ?><br>
                                ເນືອຫາ: <?php echo $row['content']; ?> <br>
                                <br><br>
                                <a href="updateprodetail.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-success" style="width: 100%;">ແກ້ໄຂ</a><br><br>
                                <a href="delprodetail.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-danger" style="width: 100%;" >ລົບ</a>
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
