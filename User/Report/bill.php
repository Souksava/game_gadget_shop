
<?php
require_once __DIR__ . '../../../vendor/autoload.php';
function ShowData(){

    require '../../ConnectDB/connectDB.php';
    date_default_timezone_set("Asia/Bangkok");
    $datenow = time();
    $Date = date("Y-m-d",$datenow);
    $sell_id = $_POST['sell_id'];
    if(isset($_POST['btn'])){
        $sql = "select d.pro_id,pro_name,cate_name,cated_name,brand_name,unit_name,p.img_path,d.qty,d.price,p.price as pro_price,d.promotion,(d.promotion/p.price) * 100 as perzen,d.qty*d.price as total,color_name,p.qty as pro_qty from selldetail d left join product p on d.pro_id=p.pro_id left join categorydetail i  on p.cated_id=i.cated_id left join category c on i.cate_id=c.cate_id left join brand b on p.brand_id=b.brand_id left join unit u on p.unit_id=u.unit_id left join product_color o on d.color_id=o.color_id where d.sell_id='$sell_id';";
        $result = mysqli_query($link,$sql);
        $Bill = 0;
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
            $Bill = $Bill + 1 ;
            $output .='
                <tr align="left">
                    <td align="left">'.$Bill.'</td>
                    <td align="left">'.$row["cate_name"].' '.$row["brand_name"].' '.$row["pro_name"].' '.$row["cated_name"].'</td>
                    <td align="left">'.$row["qty"].'x '.number_format($row["price"]).'</td>
                    <td align="center">'.number_format($row["total"]).'</td>
                </tr>
            ';
        }
        return $output;
    }
}   
function ShowData2(){

    require '../../ConnectDB/connectDB.php';
    date_default_timezone_set("Asia/Bangkok");
    $datenow = time();
    $Date = date("Y-m-d",$datenow);
    $sell_id = $_POST['sell_id'];
    if(isset($_POST['btn'])){
        $sqlsum = "select sum(qty*price) as amount from selldetail where sell_id='$sell_id';";
        $resultsum = mysqli_query($link,$sqlsum);
        $rowsum = mysqli_fetch_array($resultsum, MYSQLI_ASSOC);
        $sqlsum2 = "select sum(cupon_price) as cupon_price from sell where sell_id='$sell_id';";
        $resultsum2 = mysqli_query($link,$sqlsum2);
        $rowsum2 = mysqli_fetch_array($resultsum2, MYSQLI_ASSOC);
        $cupon_price = $rowsum2['cupon_price'];
        $amount = $rowsum['amount'] - $cupon_price;
            $output .='
                <div align="right" style="font-size: 8px;">
                    <b style="font-size: 8px;">ຍອມລວມ (ລວມພາສີມູນຄ່າເພີ່ມ) </b><br>
                    <b align="right" style="font-size: 12px;">'.number_format($amount,2).' ກີບ</b><br>
                    <label style="font-size: 6px;">ຄູປ໋ອງສ່ວນລົດ: '.number_format($cupon_price,2).' ກີບ</label>                   
                </div>
                
            ';
        }
        return $output;
}   
$name = $_POST['name'];
$address = $_POST['address'];
$tel = $_POST['tel'];
$img_path = $_POST['img_path'];
$sell_id2 = $_POST['sell_id'];
$emp_name = $_POST['emp_name'];
$cus_name = $_POST['cus_name'];
$sell_date = $_POST['sell_date'];
$sell_time = $_POST['sell_time'];
$content = '
            <div align="center" >
                 <a href="frmsale.php"><img src="../../image/'.$img_path.'" width="60px"></a>
            </div>
            <div align="center" style="font-size: 6px;text-align: center;">
                <p>
                   <b> ຮ້ານ '.$name.'</b><br>
                    '.$address.'<br>
                    ເບີໂທ: '.$tel.'
                </P>
            </div>
            <div style="width: 100%;font-size: 8px;">
                <div style="width: 50%;float: left;">
                    ພະນັກງານຂາຍ: '.$emp_name.'<br>
                    ວັນທີ: '.$sell_date.'<br>
                    ເວລາ: '.$sell_time.'
                </div>
                <div align="right" style="float: right;width: 45%;">
                    ເລກທີບິນ: '.$sell_id2.'<br>
                    ລູກຄ້າ: '.$cus_name.'
                </div>
            </div>
            <hr size="3" align="center" width="100%" /> 
            <table style="font-size: 6px;">
                <tr>
                    <th align="left" style="width: 15px;">#</th>
                    <th align="left" style="width: 90px;">ສີນຄ້າ</th>
                    <th align="left" style="width: 40px;">ຈຳນວນ</th>
                    <th align="center" style="width: 50px;">ລວມ</th>
                </tr>
                '.ShowData().'
            </table>
            <hr size="3" align="center" width="100%" />  
            '.ShowData2().' 
';
$mpdf = new \Mpdf\Mpdf([
    'format'        => [58, 100],
    'mode'              => 'utf-8',      
    'tempDir'           => '/tmp',
    'default_font_size' => 8,
    'margin_left' => 1.5, 
    'margin_right' => 1.5, 
    'margin_top' => 3.5,
    'margin_bottom' => 0.5, 
    'margin_footer' => 0.5, 
	'default_font' => 'saysettha_ot'
]);
$mpdf->WriteHTML($content);
$mpdf->Output('ລາຍງານສິນຄ້າ.pdf','I');
?>