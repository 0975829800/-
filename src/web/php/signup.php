<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>註冊</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>

<body>
    <?php
    $Email = "";
    $password = "";
    $address = "";
    $ID = -1;
    if (isset($_POST["Email"]))
        $Email = $_POST["Email"];
    if (isset($_POST["password"]))
        $password = $_POST["password"];
    if (isset($_POST["address"]))
        $address = $_POST["address"];

    if ($Email != "" && $password != "" && $address != "") {
        $servername = "220.132.211.121";
        $username = "ZYS";
        $pass = "qwe12345";
        $dbname = "bookstore";
        $conn = mysqli_connect($servername, $username, $pass);
        if (empty($conn)) {
            print mysqli_error($conn);
            die("無法連結資料庫");
            exit;
        }
        if (!mysqli_select_db($conn, $dbname)) {
            die("無法選擇資料庫");
        }
        // 設定連線編碼
        mysqli_query($conn, "SET NAMES 'utf8'");
        if ($conn->connect_error) {
            die("連接失敗: " . $conn->connect_error);
        }
        $sql = "SELECT * FROM users WHERE Email = '$Email'";
        $result = mysqli_query($conn, $sql);
        $nums = mysqli_num_rows($result);
        if(!$nums){ //not have same email
            $rand = rand(1,9999999999);
            $sql = "INSERT INTO users(ID,Flag,Email,Password,Address,Reward_points) VALUES ($rand,1,'$Email','$password','$address',0)";
            while(!($conn->query($sql) === TRUE)) {
                $rand = rand(1,9999999999);
                $sql = "INSERT INTO users(ID,Flag,Email,Password,Address,Reward_points) VALUES ($rand,1,'$Email','$password','$address',0)";
            } 
            echo '<script language="javascript">';
            echo 'alert("註冊成功，請再去登入");';
            echo '</script>';
        }
        else{
            echo '<script language="javascript">';
            echo 'alert("註冊失敗，帳號已被註冊");';
            echo '</script>';
        }
        //送出UTF8編碼的MySQL指令
        
    }

    // 建立MySQL的資料庫連接 

    ?>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <div id="header" class="text-center">
        <a class="col-6" href=".\index.php" style="color: rgb(199, 255, 125); font-size: 1.2cm; font-weight: 500;"><img src="../image/web2.png"></a>
    </div>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href=".\index.php">首頁 <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href=".\category.php"> 商品列表 <span class="sr-only">(current)</span></a>
                </li>
                <?php
                session_start();
                if (isset($_SESSION['login_session'])) {
                    echo
                        '<li class="nav-item active">
                        <a class="nav-link" href=".\cart.php"> 購物車 <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href=".\donation.php"> 捐贈書籍 <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href=".\switch.php"> 以書換書 <span class="sr-only">(current)</span></a>
                    </li>';
                }
                ?>
                <li>
                    <form class="form-inline" action="search.php" method="GET">
                        <input class="form-control mr-sm-2" type="text" id="kw" name="kw" placeholder="Search" required>
                        <input type="submit" value="搜尋" class="btn btn-outline-success my-2 my-sm-0">
                    </form>
                </li>
            </ul>
            <?php
            if (isset($_SESSION["login_session"])) {
                if ($_SESSION["login_session"]) {
                    echo '<a href="member.php" style="color: rgb(255,255,255)">' . $_SESSION["email"] . '</a>';
                    echo '<form class="form-inline mt-2 mt-md-0">
                        <a class="btn btn-outline-success my-2 my-sm-0" href="index.php?logout=true" role="button">
                            登出</a>
                    </form>';
                } else {
                    echo '<form class="form-inline mt-2 mt-md-0">
                        <a class="btn btn-outline-success my-2 my-sm-0" href=".\signup.php" role="button">
                            註冊</a>
                    </form>
                    <form class="form-inline mt-2 mt-md-0">
                        <a class="btn btn-outline-success my-2 my-sm-0" href=".\login.php" role="button">
                            登入</a>
                    </form>';
                }
            } else {
                echo '<form class="form-inline mt-2 mt-md-0">
                    <a class="btn btn-outline-success my-2 my-sm-0" href=".\signup.php" role="button">
                        註冊</a>
                </form>
                <form class="form-inline mt-2 mt-md-0">
                    <a class="btn btn-outline-success my-2 my-sm-0" href=".\login.php" role="button">
                        登入</a>
                </form>';
            }
            ?>
        </div>
    </nav>
    <form action="signup.php" method="post">
        <div align="center" style="padding:10px;margin-bottom:5px;">
            <h1 style=font-weight:bold;> 註冊會員 </h1>
            <br>
            <label for="Email">Email:</label>
            <input type="email" name="Email" id="Email" required autofocus />
            <br>
            <br>
            <label for="password">密碼:</label>
            <input type="password" name="password" id="password" required />
            <br>
            <br>
            <label for="address">地址:</label>
            <input type="text"" name=" address" id="address" required />
            <br>

            <input type="submit" value="註冊" />
        </div>
    </form>
</body>

</html>