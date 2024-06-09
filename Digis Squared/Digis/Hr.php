<?php
    session_start();

    $isLoggedIn = isset($_SESSION['hrID']);

    function logout() {
        session_unset();
        session_destroy();

        header("Location: login.php");
        exit();
    }

    if (isset($_POST['logout'])) {
        logout();
    }

    $conn = mysqli_connect('localhost', 'root', '', 'Digis');
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    if (!isset($_SESSION['hrID'])) {
        echo "<script>alert('You should be logged in to view this page'); window.location='Login.php';</script>";
        exit();
    }

    $hrID = $_SESSION['hrID'];

    $search = isset($_GET['search']) ? $_GET['search'] : '';
    $search = $conn->real_escape_string($search);

    $hoursData = [];
    $query = "SELECT WH.*, E.employeeName, E.employeeID
              FROM work_hours WH
              JOIN employee E ON WH.empID = E.employeeID
              JOIN manager M ON E.mID = M.managerID
              WHERE WH.approved != 0
              AND E.employeeName LIKE '%$search%'
              ORDER BY WH.workID ASC;";

    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $hoursData[] = $row;
        }
    }

    mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            font-family: "Poppins", sans-serif;
            margin: 0;
            padding: 0;
        }

        p, button {
            font-family: "Poppins", sans-serif;
        }

        h1 {
            padding-left: 35px;
            padding-top: 30px;
            color: white;
        }

        .footer {
            margin-top: 50px;
        }

        #info {
            padding-top: 50px;
            padding-left: 30px;
            font-size: 27px;
        }

        .nav__links button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        .nav__logo a {
            color: black;
            text-decoration: none;
            font-weight: bold;
            font-size: 24px;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 40px;
            background-color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .nav__links {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .nav__links li {
            display: inline;
            margin-left: 20px;
        }
        .Hours {
            background-color: white;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin: 20px auto;
            width: 60%;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .Hours div {
            margin: 5px 0;
        }
        .Hours button {
            padding: 10px;
            border: none;
            cursor: pointer;
        }
        .clapprove {
            background-color: green;
            color: white;
            margin-right: 10px;
            margin-bottom: 5px;
            margin-top: 10px;
            border-radius: 5px;
        }
        .clremove {
            background-color: red;
            color: white;
            border-radius: 5px;
        }
        
        #remove{
            text-align: center;
            margin-top: 80px;
        }

        #none{
            text-align: center;
            margin-top: 200px;
            font-size: 24px;
            margin-bottom: 250px;
        }

        .search_result_container {
            position: relative;
            height: 110px;
            width: 100%;
            display: flex;
            justify-content: center;
        }

        .search_container {
            position: absolute;
            height: 100px;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .search_bar {
            height: 50px;
            width: 450px;
            display: flex;
            margin: 2px;
            position: relative;
            border-radius: 30px;
            border: solid black 2px;
        }

        i {
            position: relative;
            top: 6px;
            margin: 5px;
        }

        .search_bar input {
            font-size: large;
            width: 450px;
            border: none;
            border-radius: 30px;
            outline: none;
        }
    </style>
</head>

<body>
    <nav>
        <div class="nav__logo"><a href="Hr.php">Digis Squared</a></div>
        <ul class="nav__links">
            <li class="links"><form method="post"><button type="submit" name="logout">Logout</button></form></li>
        </ul>
    </nav>

    <div class="search_result_container">
        <div class="search_container">
            <form method="GET">
                <div class="search_bar">
                    <i class="fa fa-search" style="font-size:24px"></i>
                    <input id="searchBar" name="search" placeholder="Search" type="text" value="<?= htmlspecialchars($search) ?>">
                </div>
            </form>
        </div>
    </div>

    <?php if (!empty($hoursData)): ?>
        <h2 class="section__header" id="remove">Employees Working Hours</h2>
        <div id="allHours">
            <?php foreach ($hoursData as $hours): ?>
                <div class="Hours" data-hours-id="<?= htmlspecialchars($hours['workID']) ?>">
                    <div><strong>Work ID:</strong> <?= htmlspecialchars($hours['workID']) ?></div>
                    <div><strong>Employee Name:</strong> <?= htmlspecialchars($hours['employeeName']) ?></div>
                    <div><strong>Employee ID:</strong> <?= htmlspecialchars($hours['employeeID']) ?></div>
                    <div><strong>Month:</strong> <?= htmlspecialchars($hours['month']) ?></div>
                    <div><strong>Year:</strong> <?= htmlspecialchars($hours['year']) ?></div>
                    <?php 
                    $totalHours = 0;
                    for ($day = 1; $day <= 31; $day++): 
                        if (!empty($hours["day$day"])): 
                            $totalHours += $hours["day$day"];
                            ?>
                            <div><strong><?= $day ?> <?= htmlspecialchars($hours['month']) ?> <?= htmlspecialchars($hours['year']) ?>:</strong> <?= htmlspecialchars($hours["day$day"]) ?> hours</div>
                        <?php
                        endif; 
                    endfor;
                    $totalSalary = $totalHours * $hours["salary"];
                    ?>
                    <div><strong>Total Hours Worked:</strong> <?= htmlspecialchars($totalHours) ?> hours</div>
                    <div><strong>Salary/Hour:</strong> <?= htmlspecialchars($hours["salary"]) ?> EGP</div>
                    <div><strong>Total Required Salary:</strong> <?= htmlspecialchars($totalSalary) ?> EGP</div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div id="none">No work to show</div>
    <?php endif; ?>

    <footer class="footer">
        <div class="section__container footer__container">
            <div class="footer_col">
                <h3>Digis Squared</h3>
                <p>
                    Digis Squared was founded in 2016 to deliver independent expertise and tools, manage full end-to-end solutions, and to bridge the gap between clients’ objectives and vendor solutions. Today, our skilled team, share their deep domain expertise and experience, and use our independent AI-tools, to enable smarter networks.
                </p>
            </div>
            <div class="footer__col">
                <h4>Company</h4>
                <p>About Us</p>
                <p>Our Team</p>
                <p>Blog</p>
                <p>Book</p>
                <p>Contact Us</p>
            </div>
            <div class="footer__col">
                <h4>Legal</h4>
                <p>FAQs</p>
                <p>Terms & Conditions</p>
                <p>Privacy Policy</p>
            </div>
            <div class="footer__col">
                <h4>Resources</h4>
                <p>Social Media</p>
                <p>Help Center</p>
                <p>Partnerships</p>
            </div>
        </div>
        <div class="footer__bar">
            Copyright &copy; 2024 Digis Squared. All rights reserved.
        </div>
    </footer>
</body>
</html>
