<?php
    require 'ConnectDB/connectDB.php';
    $sql = "select * from shop;";
    $result = mysqli_query($link,$sql);
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
?>
<!Doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="image/<?php echo $row['img_title']; ?>">
    <title>ເຂົ້າສູ່ລະບົບ</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="css/Style.css" type="text/css" rel="stylesheet" />
  </head>
  <body>
        <div class="container font12" align="center" style="margin:0 auto;width:500px;height:480px;margin-top:120px;background-color: white;box-shadow: 5px 10px 8px 8px #9f9e9a;">
          <form action="Check/checklogin.php" id="form1" method="POST">
                <div class="row">
                    <div class="col-md-12">
                      <img src="image/<?php echo $row['img_path']; ?>" alt="" width="180px">
                    </div>
                    <div class="col-md-12">
                      <input type="email" name="email" placeholder="ທີ່ຢູ່ອີເມວ" class="form-control" style="width: 85%;">
                    </div>
                    <div class="col-md-12"><br>
                        <input type="password" name="pass" placeholder="ລະຫັດຜ່ານ" class="form-control" style="width: 85%;">
                    </div>
                    <div class="col-md-12"><br>
                        <button type="submit" class="btn btn-outline-danger" style="width: 85%">
                            ເຂົ້າສູ່ລະບົບ
                        </button>
                    </div>
                    <div class="col-md-12 font12" style="color: #bf1e2e;"><br>
                      <b>
                          <?php echo $row['name']; ?>
                      </b> <br>
                    </div>
                </div>
          </form>
        </div>
  </body>
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</html>
