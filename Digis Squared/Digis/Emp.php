<?php
    session_start();

    $isLoggedIn = isset($_SESSION['employeeID']);

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

    if (!isset($_SESSION['employeeID'])) {
        echo "<script>alert('You should be logged in to view this page'); window.location='Login.php';</script>";
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $month = $_POST['month'];
        $year = $_POST['year'];
        $salary = $_POST['salary'];
        $employeeID = $_SESSION['employeeID'];
        $days = [];
        for ($i = 1; $i <= 31; $i++) {
            $days[$i] = isset($_POST['day' . $i]) ? $_POST['day' . $i] : 0;
        }
    
        $sql = "INSERT INTO work_hours(empID, approved, salary, month, year, day1, day2, day3, day4, day5, day6, day7, day8, day9, day10, day11, day12, day13, day14, day15, day16, day17, day18, day19, day20, day21, day22, day23, day24, day25, day26, day27, day28, day29, day30, day31) 
                VALUES (?, 0, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
        $stmt = $conn->prepare($sql);
    
        $stmt->bind_param("iisiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiii", 
            $employeeID, $salary, $month, $year, $days[1], $days[2], $days[3], $days[4], $days[5], $days[6], $days[7], $days[8], $days[9], $days[10], $days[11], $days[12], $days[13], $days[14], $days[15], $days[16], $days[17], $days[18], $days[19], $days[20], $days[21], $days[22], $days[23], $days[24], $days[25], $days[26], $days[27], $days[28], $days[29], $days[30], $days[31]);
    
        if ($stmt->execute()) {
            echo "<script>alert('Hours sent successfully!');</script>";
        } else {
            echo "<script>alert('Error occurred');</script>";
        }
    
        $stmt->close();
    }    
    
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <script>
        var pageLoaded = false;

        function updateMonths() {
            var currentYear = new Date().getFullYear();
            var currentMonth = new Date().getMonth();
            var selectedYear = document.getElementById("year").value;
            var monthSelect = document.getElementById("month");
            var monthOptions = monthSelect.getElementsByTagName("option");
            var alerted = false;

            for (var i = 0; i < monthOptions.length; i++) {
                if (selectedYear == currentYear && i > currentMonth) {
                    monthOptions[i].disabled = true;
                    monthSelect.value = 'January';
                    alerted = true;
                } else {
                    monthOptions[i].disabled = false;
                }
            }

            if(alerted && pageLoaded){
                alert("Enter Month Again!");
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            var month = document.getElementById('month');
            var year = document.getElementById('year');
            var outputElements = document.getElementsByClassName('output');
            
            function updateOutputs() {
                var text = month.value + " " + year.value;
                for (var i = 0; i < outputElements.length; i++) {
                    outputElements[i].textContent = text;
                }
            }

            updateOutputs();

            year.addEventListener("input", updateOutputs);
            month.addEventListener("input", updateOutputs);
        });


        $(document).ready(function () {
            updateMonths();
            pageLoaded = true;

            var day29 = $('.day29');
            var day30 = $('.day30');
            var day31 = $('.day31');
            var month = $('#month');
            
            month.change(function () {
                if(month.val() == 'April' || month.val() == 'June' || month.val() == 'September' || month.val() == 'November') {
                    day31.val(0);
                    day31.hide();
                    day30.show();
                    day29.show();
                }
                else if(month.val() == 'February') {
                    day31.val(0);
                    day30.val(0);
                    day29.val(0);
                    day31.hide();
                    day30.hide();
                    day29.hide();
                }
                else {
                    day31.show();
                    day30.show();
                    day29.show();
                }
            });
        });
    </script>
    <style>
        #hoursForm div {
            margin-bottom: 15px;
            padding-bottom: 15px;
        }

        #hoursForm {
            padding-top: 100px;
            width: 300px;
            font-family: Arial, sans-serif;
            margin-left: 475px;
            text-align: center;
        }
        
        #hoursForm label {
            display: block;
            font-weight: bold;
        }
        
        #hoursForm input {
            width: 300px;
            height: 40px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        #hoursForm button {
            background-color: gray;
            color: white;
            padding: 10px 40px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin: 0 auto;
            display: block;
            border-radius: 7px;
        }

        #hoursForm button:hover {
            background-color: blue;
        }
        
        #paddingBottom {
            padding-bottom: 50px;
        }

        label{
            font-family: "Poppins", sans-serif;
            text-align: left;
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
            padding: 10px 20px;
            background-color: white;
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

        #month{
            width: 300px;
            height: 40px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        #year{
            width: 300px;
            height: 40px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .row {
            display: flex;
            justify-content: center;
            margin-bottom: 15px;
        }

        .row label {
            margin-right: 10px;
        }

        .row div {
            text-align: left;
        }
    </style>
    </head>
    
    <body>
    <nav>
        <div class="nav__logo"><a href="emp.php">Digis Squared</a></div>
        <ul class="nav__links">
            <li class="links"><form method="post"><button type="submit" name="logout">Logout</button></form></li>
        </ul>
    </nav>

        <div class="header__image__container">
            <h1>Submit Your Working Hours</h1>
            <form id="hoursForm" method="post" action="Emp.php">
            <div>
                <label for="month">&nbsp; &nbsp;<i class="fa fa-calendar"></i>&nbsp; &nbsp;Month</label>
                <select id="month" name="month">
                    <option value="January">January</option>
                    <option value="February">February</option>
                    <option value="March">March</option>
                    <option value="April">April</option>
                    <option value="May">May</option>
                    <option value="June">June</option>
                    <option value="July">July</option>
                    <option value="August">August</option>
                    <option value="September">September</option>
                    <option value="October">October</option>
                    <option value="November">November</option>
                    <option value="December">December</option>
                </select>
            </div>

            <div>
                <label for="year">&nbsp; &nbsp;<i class="fa fa-calendar"></i>&nbsp; &nbsp;Year</label>
                <select id="year" name="year" onchange="updateMonths()">
                    <script>
                        var currentYear = new Date().getFullYear();
                        for (var year = currentYear; year >= 2000; year--) {
                            document.write('<option value="' + year + '">' + year + '</option>');
                        }
                    </script>
                </select>
            </div>

            <div>
                <label for="salary">&nbsp; <i class="fa fa-gbp"></i> &nbsp;Salary/Hour</label>
                <input type="number" id="salary" name="salary" value= '0' oninput="if(parseInt(value) < 0 || value == '') value='0';">
            </div>

                <div>
                    <label for="day1">1 <span class="output"></span></label>
                    <input type="number" id="day1" name="day1" value= '0' oninput="if(parseInt(value) > 24) value='24'; else if(parseInt(value) < 0 || value == '') value='0';">
                </div>

                <div>
                    <label for="day2">2 <span class="output"></span></label>
                    <input type="number" id="day2" name="day2" value= '0' oninput="if(parseInt(value) > 24) value='24'; else if(parseInt(value) < 0 || value == '') value='0';">
                </div>

                <div>
                    <label for="day3">3 <span class="output"></span></label>
                    <input type="number" id="day3" name="day3" value= '0' oninput="if(parseInt(value) > 24) value='24'; else if(parseInt(value) < 0 || value == '') value='0';">
                </div>

                <div>
                    <label for="day4">4 <span class="output"></span></label>
                    <input type="number" id="day4" name="day4" value= '0' oninput="if(parseInt(value) > 24) value='24'; else if(parseInt(value) < 0 || value == '') value='0';">
                </div>

                <div>
                    <label for="day5">5 <span class="output"></span></label>
                    <input type="number" id="day5" name="day5" value= '0' oninput="if(parseInt(value) > 24) value='24'; else if(parseInt(value) < 0 || value == '') value='0';">
                </div>

                <div>
                    <label for="day6">6 <span class="output"></span></label>
                    <input type="number" id="day6" name="day6" value= '0' oninput="if(parseInt(value) > 24) value='24'; else if(parseInt(value) < 0 || value == '') value='0';">
                </div>

                <div>
                    <label for="day7">7 <span class="output"></span></label>
                    <input type="number" id="day7" name="day7" value= '0' oninput="if(parseInt(value) > 24) value='24'; else if(parseInt(value) < 0 || value == '') value='0';">
                </div>

                <div>
                    <label for="day8">8 <span class="output"></span></label>
                    <input type="number" id="day8" name="day8" value= '0' oninput="if(parseInt(value) > 24) value='24'; else if(parseInt(value) < 0 || value == '') value='0';">
                </div>

                <div>
                    <label for="day9">9 <span class="output"></span></label>
                    <input type="number" id="day9" name="day9" value= '0' oninput="if(parseInt(value) > 24) value='24'; else if(parseInt(value) < 0 || value == '') value='0';">
                </div>

                <div>
                    <label for="day10">10 <span class="output"></span></label>
                    <input type="number" id="day10" name="day10" value= '0' oninput="if(parseInt(value) > 24) value='24'; else if(parseInt(value) < 0 || value == '') value='0';">
                </div>

                <div>
                    <label for="day11">11 <span class="output"></span></label>
                    <input type="number" id="day11" name="day11" value= '0' oninput="if(parseInt(value) > 24) value='24'; else if(parseInt(value) < 0 || value == '') value='0';">
                </div>

                <div>
                    <label for="day12">12 <span class="output"></span></label>
                    <input type="number" id="day12" name="day12" value= '0' oninput="if(parseInt(value) > 24) value='24'; else if(parseInt(value) < 0 || value == '') value='0';">
                </div>

                <div>
                    <label for="day13">13 <span class="output"></span></label>
                    <input type="number" id="day13" name="day13" value= '0' oninput="if(parseInt(value) > 24) value='24'; else if(parseInt(value) < 0 || value == '') value='0';">
                </div>

                <div>
                    <label for="day14">14 <span class="output"></span></label>
                    <input type="number" id="day14" name="day14" value= '0' oninput="if(parseInt(value) > 24) value='24'; else if(parseInt(value) < 0 || value == '') value='0';">
                </div>

                <div>
                    <label for="day15">15 <span class="output"></span></label>
                    <input type="number" id="day15" name="day15" value= '0' oninput="if(parseInt(value) > 24) value='24'; else if(parseInt(value) < 0 || value == '') value='0';">
                </div>

                <div>
                    <label for="day16">16 <span class="output"></span></label>
                    <input type="number" id="day16" name="day16" value= '0' oninput="if(parseInt(value) > 24) value='24'; else if(parseInt(value) < 0 || value == '') value='0';">
                </div>

                <div>
                    <label for="day17">17 <span class="output"></span></label>
                    <input type="number" id="day17" name="day17" value= '0' oninput="if(parseInt(value) > 24) value='24'; else if(parseInt(value) < 0 || value == '') value='0';">
                </div>

                <div>
                    <label for="day18">18 <span class="output"></span></label>
                    <input type="number" id="day18" name="day18" value= '0' oninput="if(parseInt(value) > 24) value='24'; else if(parseInt(value) < 0 || value == '') value='0';">
                </div>

                <div>
                    <label for="day19">19 <span class="output"></span></label>
                    <input type="number" id="day19" name="day19" value= '0' oninput="if(parseInt(value) > 24) value='24'; else if(parseInt(value) < 0 || value == '') value='0';">
                </div>

                <div>
                    <label for="day20">20 <span class="output"></span></label>
                    <input type="number" id="day20" name="day20" value= '0' oninput="if(parseInt(value) > 24) value='24'; else if(parseInt(value) < 0 || value == '') value='0';">
                </div>

                <div>
                    <label for="day21">21 <span class="output"></span></label>
                    <input type="number" id="day21" name="day21" value= '0' oninput="if(parseInt(value) > 24) value='24'; else if(parseInt(value) < 0 || value == '') value='0';">
                </div>

                <div>
                    <label for="day22">22 <span class="output"></span></label>
                    <input type="number" id="day22" name="day22" value= '0' oninput="if(parseInt(value) > 24) value='24'; else if(parseInt(value) < 0 || value == '') value='0';">
                </div>

                <div>
                    <label for="day23">23 <span class="output"></span></label>
                    <input type="number" id="day23" name="day23" value= '0' oninput="if(parseInt(value) > 24) value='24'; else if(parseInt(value) < 0 || value == '') value='0';">
                </div>

                <div>
                    <label for="day24">24 <span class="output"></span></label>
                    <input type="number" id="day24" name="day24" value= '0' oninput="if(parseInt(value) > 24) value='24'; else if(parseInt(value) < 0 || value == '') value='0';">
                </div>


                <div>
                    <label for="day25">25 <span class="output"></span></label>
                    <input type="number" id="day25" name="day25" value= '0' oninput="if(parseInt(value) > 24) value='24'; else if(parseInt(value) < 0 || value == '') value='0';">
                </div>

                <div>
                    <label for="day26">26 <span class="output"></span></label>
                    <input type="number" id="day26" name="day26" value= '0' oninput="if(parseInt(value) > 24) value='24'; else if(parseInt(value) < 0 || value == '') value='0';">
                </div>

                <div>
                    <label for="day27">27 <span class="output"></span></label>
                    <input type="number" id="day27" name="day27" value= '0' oninput="if(parseInt(value) > 24) value='24'; else if(parseInt(value) < 0 || value == '') value='0';">
                </div>

                <div>
                    <label for="day28">28 <span class="output"></span></label>
                    <input type="number" id="day28" name="day28" value= '0' oninput="if(parseInt(value) > 24) value='24'; else if(parseInt(value) < 0 || value == '') value='0';">
                </div>

                <div>
                    <label for="day29" class="day29">29 <span class="output"></span></label>
                    <input type="number" class="day29" name="day29" value= '0' oninput="if(parseInt(value) > 24) value='24'; else if(parseInt(value) < 0 || value == '') value='0';">
                </div>

                <div>
                    <label for="day30" class="day30">30 <span class="output"></span></label>
                    <input type="number" class="day30" name="day30" value= '0' oninput="if(parseInt(value) > 24) value='24'; else if(parseInt(value) < 0 || value == '') value='0';">
                </div>

                <div>
                    <label for="day31" class="day31">31 <span class="output"></span></label>
                    <input type="number" class="day31" name="day31" value= '0' oninput="if(parseInt(value) > 24) value='24'; else if(parseInt(value) < 0 || value == '') value='0';">
                </div>

            <button type="submit">Submit</button>
        </form>
                <div id="paddingBottom">
                </div>
        </div>
        <div id="info">
            <i class="fa fa-phone"></i>&nbsp; Hotline: 19923
            <p></p>
            <i class="fa fa-envelope-o"></i>&nbsp;Email: Services@DigisSquared.com
            <p></p>
            <i class="fa fa-map-marker"></i>&nbsp;&nbsp;Location: Maadi - Street 9
        </div>

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
            Copyright @ 2024 Digis Squared. All rights reserved.
        </div>
    </footer>
</body>
</html>