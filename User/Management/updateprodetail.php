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
                    <a href="productdetail.php">
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
            $id2 = $_GET['id'];
            $sqlget = "select id,d.pro_id,pro_name,unit_name,cate_name,cated_name,brand_name,d.topic_id,topic_name,d.img_path as dimg_path,p.img_path as pimg_path,review_youtube,content from productdetail d left join product p on d.pro_id=p.pro_id left join categorydetail l on p.cated_id=l.cated_id left join category c on l.cate_id=c.cate_id left join unit u on p.unit_id=u.unit_id left join brand b on p.brand_id=b.brand_id left join topic t on d.topic_id=t.topic_id where id='$id2';";
            $resultget = mysqli_query($link,$sqlget);
            $row = mysqli_fetch_array($resultget, MYSQLI_ASSOC);

        ?>
        <div class="container font14">
            <form action="updateprodetail.php" id="update" method="POST" enctype="multipart/form-data">
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
                        <input type="hidden" name="id" class="form-control" value="<?php echo $row['id'] ?>" >
                    </div>
                    <div class="col-xs-12 col-sm-6 form-group">
                        <label>ຫົວຂໍ້ລີວິວ</label><br>
                        <select name="topic_id" id="" class="form-control">
                            <option value="<?php echo $row['topic_id']; ?>"><?php echo $row['topic_name']; ?></option>
                            <?php
                                $topic_id2 = $row['topic_id'];
                                $sqltopic = "select * from topic where topic_id!='$topic_id2'";
                                $resulttopic = mysqli_query($link, $sqltopic);
                                while($rowtopic = mysqli_fetch_array($resulttopic, MYSQLI_NUM)){
                                    echo" <option value='$rowtopic[0]'>$rowtopic[1]</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="col-xs-12 col-sm-6 form-group">
                        <label>ວິດີໂອລີວິວ</label><br>
                        <input type="text" name="review_youtube" class="form-control" value="<?php echo $row['review_youtube'] ?>"  placeholder="ວິດີໂອລີວິວ">
                    </div>
                    <div class="col-xs-12 col-sm-6 form-group">
                        <label>ພາບລີວິວ</label><br>
                        <input type="file" name="img_path" class="form-control">
                    </div>
                    <div class="col-xs-12 col-sm-6 form-group">
                        <!-- <label>ເນື້ອຫາ</label><br>
                        <input type="text" name="content" class="form-control" placeholder="ເນື້ອຫາ" value="<?php echo $row['content'] ?>" > -->
                        <label>ເນື້ອຫາ</label><br>
                        <textarea name="content" id="" cols="30" rows="10" placeholder="ເນື້ອຫາ" class="form-control"><?php echo $row['content'] ?></textarea>
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
                $id = $_POST['id'];
                $pro_id = $_POST['pro_id'];
                $topic_id = $_POST['topic_id'];
                $review_youtube = $_POST['review_youtube'];
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
                    if($_FILES['img_path']['name'] == ""){
                        $sqlupdate = "update productdetail set pro_id='$pro_id',topic_id='$topic_id',review_youtube='$review_youtube',content='$content' where id='$id';";
                        $resultupdate = mysqli_query($link,$sqlupdate);
                        if(!$resultupdate){
                            echo"<script>";
                            echo"alert('ບໍ່ສາມາດແກ້ໄຂຂໍ້ມູນໄດ້');";
                            echo"window.location.href='productdetail.php';";
                            echo"</script>";
                        }
                        else {
                            echo"<script>";
                            echo"alert('ແກ້ໄຂຂໍ້ມູນສຳເລັດ');";
                            echo"window.location.href='productdetail.php';";
                            echo"</script>";
                        }
                    }
                    else {
                        //ເມື່ອປ່ຽນຮູບພາບແລ້ວລົບພາບເກົ່າ
                        $sqlsec = "select img_path from productdetail where id='$id';";
                        $resultsec = mysqli_query($link, $sqlsec);
                        $data2 = mysqli_fetch_array($resultsec, MYSQLI_ASSOC);
                        $path = __DIR__.DIRECTORY_SEPARATOR.'../../image'.DIRECTORY_SEPARATOR.$data2['img_path'];
                        if(file_exists($path) && !empty($data2['img_path'])){
                            unlink($path);
                        }
                        //ສິ້ນສຸດ
                        //ຕັ້ງຊື່ຮູບພາບອັດຕະໂນມັດ
                        $ext = pathinfo(basename($_FILES['img_path']['name']), PATHINFO_EXTENSION);
                        $new_image_name = 'img_'.uniqid().".".$ext;
                        $image_path = "../../image/";
                        $upload_path = $image_path.$new_image_name;
                        move_uploaded_file($_FILES['img_path']['tmp_name'], $upload_path);
                        $pro_image = $new_image_name;
                        //ສິນສຸດການຕັ້ງຊື່
                        $sqlupdate = "update productdetail set pro_id='$pro_id',topic_id='$topic_id',review_youtube='$review_youtube',content='$content',img_path='$pro_image' where id='$id';";
                        $resultupdate = mysqli_query($link,$sqlupdate);
                        if(!$resultupdate){
                            echo"<script>";
                            echo"alert('ບໍ່ສາມາດແກ້ໄຂຂໍ້ມູນໄດ້');";
                            echo"window.location.href='productdetail.php';";
                            echo"</script>";
                        }
                        else {
                            echo"<script>";
                            echo"alert('ແກ້ໄຂຂໍ້ມູນສຳເລັດ');";
                            echo"window.location.href='productdetail.php';";
                            echo"</script>";
                        }
                    }
                }
            }
        ?>
    </body>
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</html>
