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
   $Time = date("H:i:s",$datenow);
   $sqlshop = "select * from shop;";
   $resultshop = mysqli_query($link,$sqlshop);
   $rowshop = mysqli_fetch_array($resultshop,MYSQLI_ASSOC);
   $emp_id = $_SESSION['emp_id'];
?>
<!Doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>ຂາຍສິນຄ້າ</title>
    <link rel="icon" href="../../image/<?php echo $rowshop['img_title']; ?>">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  </head>
  <body >
    <!-- head -->
      <div class="header">
        <div class="container">
                <a href="sale.php" class="tapbar" align="left">
                    <img src="../../icon/back.ico" width="30px">
                </a>
            <div align="center" class="tapbar fonthead">
                <b>ຂາຍສິນຄ້າ</b>
            </div>
            <div class="tapbar" align="right">
              <a href="../../Check/Logout.php">
                  <img src="../../icon/close.ico" width="30px">
              </a>
            </div>
          </div>
      </div>
     <!-- head -->

      <div class="clearfix"></div><br>
      <!-- body -->
    <?php 
        if(isset($_POST['btnSave'])){
            $cupon_key = $_POST['cupon_key'];
            if(trim($cupon_key) === ""){
                $cupon_key = "0";
            }
            $cupon_price2 = $_POST['cupon_price'];
            if(trim($cupon_price2) === ""){
                $cupon_price2 = "0";
            }
            $newamount2 = $_POST['newamount2'];
            $sqlcus = "select * from customers where cus_name='ລູກຄ້າທົ່ວໄປ';";
            $resultcus = mysqli_query($link,$sqlcus);
            $rowcus = mysqli_fetch_array($resultcus,MYSQLI_ASSOC);
            $cus_id = $rowcus['cus_id'];echo"<br>";
            $sqlbillno = "select max(sell_id) as bill from sell;";
            $resultbillno = mysqli_query($link,$sqlbillno);
            $rowbillno = mysqli_fetch_array($resultbillno,MYSQLI_ASSOC);
            $billno = $rowbillno['bill'] + 1;echo"<br>";
            if($_FILES['img_path']['name'] == ''){
                $sqlsave = "insert into sell(sell_id,emp_id,cus_id,sell_date,sell_time,amount,status,status_cash,img_path,sell_type,seen1,seen2,cupon_key,cupon_price,delivery,place_deli,note) values('$billno','$emp_id','$cus_id','$Date','$Time','$newamount2','ສັ່ງຊື້ສຳເລັດ','ເງິນສົດ','0','ໜ້າຮ້ານ','SEEN','SEEN','$cupon_key','$cupon_price2','0','ໜ໊າຮ້ານ','-');";
                $resultsave = mysqli_query($link,$sqlsave);
                if(!$resultsave){
                    echo"<script>";
                    echo"window.location.href='sale.php?save1=false1';";
                    echo"</script>";
                }
                else{
                    $sqlsave2 = "insert into selldetail(pro_id,qty,price,promotion,color_id,sell_id) select d.pro_id,d.qty,p.price - p.promotion as newprice,p.promotion,'0',$billno from listselldetail2 d left join product p on d.pro_id=p.pro_id left join categorydetail i  on p.cated_id=i.cated_id left join category c on i.cate_id=c.cate_id left join brand b on p.brand_id=b.brand_id left join unit u on p.unit_id=u.unit_id where emp_id='$emp_id';";
                    $resultsave2 = mysqli_query($link,$sqlsave2);
                    if(!$resultsave2){
                        echo"<script>";
                        echo"window.location.href='sale.php?save2=false2';";
                        echo"</script>";
                    }
                    else{
                        $sqlcupon2 = "update cupon set qty=qty-1 where cupon_key='$cupon_key';";
                        $resultcupon2 = mysqli_query($link,$sqlcupon2);
                        $sqlclear = "delete from listselldetail2 where emp_id='$emp_id';";
                        $resultclear = mysqli_query($link,$sqlclear);
                        echo"<script>";
                        echo"window.location.href='bill.php';";
                        echo"</script>";
                    }
                }
            }
            else{
                $ext = pathinfo(basename($_FILES["img_path"]["name"]), PATHINFO_EXTENSION);
                $new_image_name = "img_".uniqid().".".$ext;
                $image_path = "../../image/";
                $upload_path = $image_path.$new_image_name;
                move_uploaded_file($_FILES["img_path"]["tmp_name"], $upload_path);
                $pro_img = $new_image_name;
                $sqlsave = "insert into sell(sell_id,emp_id,cus_id,sell_date,sell_time,amount,status,status_cash,img_path,sell_type,seen1,seen2,cupon_key,cupon_price,delivery,place_deli,note) values('$billno','$emp_id','$cus_id','$Date','$Time','$newamount2','ສັ່ງຊື້ສຳເລັດ','ເງິນໂອນ','$pro_img','ໜ້າຮ້ານ','SEEN','SEEN','$cupon_key','$cupon_price2','0','ໜ໊າຮ້ານ','-');";
                $resultsave = mysqli_query($link,$sqlsave);
                if(!$resultsave){
                    echo"<script>";
                    echo"window.location.href='sale.php?save1=false1';";
                    echo"</script>";
                }
                else{
                    $sqlsave2 = "insert into selldetail(pro_id,qty,price,promotion,color_id,sell_id) select d.pro_id,d.qty,p.price - p.promotion as newprice,p.promotion,'0',$billno from listselldetail2 d left join product p on d.pro_id=p.pro_id left join categorydetail i  on p.cated_id=i.cated_id left join category c on i.cate_id=c.cate_id left join brand b on p.brand_id=b.brand_id left join unit u on p.unit_id=u.unit_id where emp_id='$emp_id';";
                    $resultsave2 = mysqli_query($link,$sqlsave2);
                    if(!$resultsave2){
                        echo"<script>";
                        echo"window.location.href='sale.php?save2=false2';";
                        echo"</script>";
                    }
                    else{
                        $sqlcupon2 = "update cupon set qty=qty-1 where cupon_key='$cupon_key';";
                        $resultcupon2 = mysqli_query($link,$sqlcupon2);
                        $sqlclear = "delete from listselldetail2 where emp_id='$emp_id';";
                        $resultclear = mysqli_query($link,$sqlclear);
                        echo"<script>";
                        echo"window.location.href='bill.php';";
                        echo"</script>";
                    }
                }
            }
          
        }
        if(isset($_POST['btnSale'])){
        $amount = $_POST['amount'];
        $cupon = $_POST['cupon'];
        if(trim($cupon) == ""){
            $cupon = "0";
        }
        if($amount == "" or $amount == 0){
            echo"<script>";
            echo"window.location.href='sale.php?amount=null';";
            echo"</script>";
        }
        $sqlsell = "select sum((p.price - p.promotion)*d.qty) as amount,count(d.pro_id) as countorder from listselldetail2 d left join product p on d.pro_id=p.pro_id  where d.emp_id='$emp_id';";
        $resultsell = mysqli_query($link,$sqlsell);
        $rowsell = mysqli_fetch_array($resultsell,MYSQLI_ASSOC);
        $sqlcupon = "select * from cupon where cupon_key='$cupon' and qty > 0;";
        $resultcupon = mysqli_query($link,$sqlcupon);
        $rowcupon = mysqli_fetch_array($resultcupon,MYSQLI_ASSOC);
        $cupon_price = $rowcupon['price'];
        $newamount = $rowsell['amount'] - $cupon_price;
    ?>   
    <div class="container font14">
		<div class="row">
            <div class="col-md-8 font12">
                <div class="row row-cols-1 row-cols-md-1">
                    <div class="col mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 align="center" class="card-title"></h5>
                                <p class="card-text">
                                    <div class="row">
                                        <div class="col-md-12" align="center">
                                            <h6>ລາຍການຊື້ສິນຄ້າ</h6><br>
                                        </div>
                                        <div class="col-md-12 ">
                                            <?php 
                                                $sqlbill = "select max(sell_id) as bill from sell;";
                                                $resultbill = mysqli_query($link,$sqlbill);
                                                $rowbill = mysqli_fetch_array($resultbill,MYSQLI_ASSOC);
                                                $bill = $rowbill['bill'] + 1;
                                            ?>
                                            <div>
                                                <label>ເລກທີບິນ: <?php echo $bill; ?></label><br>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table" style="width:700px;">
                                                    <tr>
                                                        <th style="width: 300px;" scope="col">ສິນຄ້າ</th>
                                                        <th scope="col">ຈຳນວນ</th>
                                                        <th scope="col">ລາຄາ</th>
                                                        <th scope="col">ລວມ</th>
                                                    </tr>
                                                    <?php
                                                        $sqllistfb = "select detail_id,d.pro_id,pro_name,cate_name,cated_name,brand_name,unit_name,p.img_path,d.qty,p.price,p.price - p.promotion as newprice,p.promotion,(p.promotion/p.price) * 100 as perzen,d.qty*(p.price - p.promotion) as total from listselldetail2 d left join product p on d.pro_id=p.pro_id left join categorydetail i  on p.cated_id=i.cated_id left join category c on i.cate_id=c.cate_id left join brand b on p.brand_id=b.brand_id left join unit u on p.unit_id=u.unit_id where d.emp_id='$emp_id';";
                                                        $resultlistfb = mysqli_query($link,$sqllistfb);               
                                                        while($rowlistfb = mysqli_fetch_array($resultlistfb,MYSQLI_ASSOC)){
                                                    ?>
                                                    <tr>
                                                        <td> <?php echo $rowlistfb['cate_name']; ?>  <?php echo $rowlistfb['brand_name']; ?>  <?php echo $rowlistfb['pro_name']; ?> <?php echo $rowlistfb['cated_name']; ?></td>
                                                        <td> 
                                                            <?php echo $rowlistfb['qty']; ?> <?php echo $rowlistfb['unit_name']; ?>
                                                        </td>
                                                        <td >
                                                            <?php echo number_format($rowlistfb['newprice'],2); ?>
                                                        </td>
                                                        <td >
                                                            <?php echo number_format($rowlistfb['total'],2); ?>
                                                        </td>
                                                    </tr>
                                                    <?php 
                                                    }
                                                    ?>
                                                </table>
                                            </div>
                                        </div>
                                        <hr size="3" align="center" width="100%">
                                        <div class="col-md-12 " align="right">
                                            ລວມລາຍການ: <?php echo $rowsell['countorder']; ?> (<?php echo number_format($rowsell['amount'],2); ?> ກີບ)
                                        </div><br><br>
                                        <div class="col-md-12 " align="right">
                                            ຍອມລວມ (ລວມພາສີມູນຄ່າເພີ່ມ)
                                        </div><br>
                                        <div class="col-md-12" align="right">
                                            <br><h4 style="color: #CE3131;"> <?php echo number_format($newamount,2); ?> ກີບ</h4>
                                            <?php 
                                                if($cupon_price == 0 or $cupon_price == ""){
                                                    echo"<label style='color: #7E7C7C;font-size: 12px;'>* ບໍ່ມີຄູປ໋ອງສ່ວນລົດ</label>";
                                                }
                                                else{
                                                    echo"<label style='color: #7E7C7C;font-size: 12px;'>ຄູປ໋ອງສ່ວນລົດ:".number_format($cupon_price,2)." ກີຍ</label>";
                                                }
                                            ?>         
                                        </div>
                                    </div>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
			</div>
            <div class="col-lg-3 font12">
                <div class="row row-cols-1 row-cols-md-1">
                    <div class="col mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h6 align="center" class="card-title">ດຳເນີນການຊື້ສິນຄ້າ</h6>
                                <p class="card-text" align="center">
                                    <form action="sale2.php" id="formsave" method="POST" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-md-12 form-group">
                                                <label>ພາບຫຼັກຖານການໂອນເງິນ</label>
                                                <input type="file" name="img_path" class="form-control">
                                            </div>
                                            <div class="col-md-12 form-group">
                                                <input type="hidden" name="cupon_key" value="<?php echo $rowcupon['cupon_key']; ?>">
                                                <input type="hidden" name="cupon_price" value="<?php echo $cupon_price ?>">
                                                <input type="hidden" name="newamount2" value="<?php echo $newamount; ?>">
                                               <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#staticBackdrop" style="width: 100%;">
                                                    ບັນທຶກການຂາຍ
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade" id="staticBackdrop" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="staticBackdropLabel">ຢືນຢັນ</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body" align="center">
                                                                ທ່ານຕ້ອງການບັນທຶນການຂາຍ ຫຼື ບໍ່ ?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">ຍົກເລີກ</button>
                                                                <button type="submint" name="btnSave" class="btn btn-outline-success">ບັນທຶກ</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <hr size="3" align="center" width="100%"><br>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php 
        }
    ?>
      <!-- body -->
  </body>
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</html>
