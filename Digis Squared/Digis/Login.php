<?php
    session_start();

    $conn = mysqli_connect('localhost', 'root', '', 'Digis');
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $uname = $_POST['username'];
        $pwd = $_POST['password'];
        $role = $_POST['role'];

        if ($role == 'Manager') {
            $sql = "SELECT managerID, password FROM manager WHERE username=?";
        } elseif ($role == 'Employee') {
            $sql = "SELECT employeeID, password FROM employee WHERE username=?";
        } else {
            $sql = "SELECT hrID, password FROM hr WHERE username=?";
        }

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $uname);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) == 0) {
            $error = "Account not found!";
        } else {
            $user = mysqli_fetch_assoc($result);
            if ($pwd === $user['password']) {
                if ($role == 'Manager') {
                    $_SESSION['managerID'] = $user['managerID'];
                    $_SESSION['employeeID'] = null;
                    $_SESSION['hrID'] = null;
                    $redirectPage = "Manager.php";
                } elseif ($role == 'Employee') {
                    $_SESSION['employeeID'] = $user['employeeID'];
                    $_SESSION['managerID'] = null;
                    $_SESSION['hrID'] = null;
                    $redirectPage = "Emp.php";
                } else {
                    $_SESSION['hrID'] = $user['hrID'];
                    $_SESSION['managerID'] = null;
                    $_SESSION['employeeID'] = null;
                    $redirectPage = "Hr.php";
                }
                
                echo "<script>window.location='" . $redirectPage . "';</script>";
                exit();
            } else {
                $error = "Wrong password!";
            }
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var submitButton = document.getElementById("submitButton");
            var form = document.getElementById('login-form');
            var subscribeText = document.getElementById('subscription-message');
    
            submitButton.addEventListener('click', function() {
                var userInput = document.getElementById('username');
                var passwordInput = document.getElementById('password');
    
                if (userInput.value !== "" && passwordInput.value !== "") {
                    form.removeEventListener('submit', preventSubmit);
                } else {
                    form.addEventListener('submit', preventSubmit);
                    showErrorMessage();
                }
            });
    
            function preventSubmit(event) {
                event.preventDefault();
            }
    
            function showErrorMessage() {
                subscribeText.textContent = "Error! Invalid input";
            }
        });
    </script>
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

    section {
        text-align: center;
        padding: 50px 0;
    }

    .inputs {
        width: 300px;
        height: 40px;
        margin: 10px 0;
        padding: 5px 10px;
        border: 2px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
    }

    #login-form {
        border: 2px solid black;
        border-radius: 2rem;
        padding: 50px;
        margin: 0 auto;
        max-width: 600px;
        position: relative;
        min-height: 400px;
        background: rgba(255, 255, 255, 0.3);
        backdrop-filter: blur(10px);
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }

    #password, #role, #submitButton {
        margin-top: 20px;
    }

    #submitButton {
        height: 40px;
        width: 22.5%;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s ease;
        margin-top: 30px;
    }

    #submitButton:hover {
        background-color: #45a049;
    }

    #subscription-message {
        font-size: 30px;
        color: red;
        padding-top: 15px;
        text-align: center;
    }

    body {
        background-image: url(../Digis/images/shutterstock_1351101422-1.jpg);
        background-size: cover;
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-position: center center;
        margin: 0;
        font-family: "Poppins", sans-serif;
    }

    #role {
        width: 320px;
        height: 50px;
        margin: 10px 0;
        padding: 5px 10px;
        border: 2px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
    }

    #role_div {
        margin-left: 40px;
        margin-top: 10px;
    }

    #inp {
        transform: translateX(-5%);
    }
    </style>
    
    <section>
        <form id="login-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <h2>Login to Work Manager</h2>

            <div id= "inp">
                <div>
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Enter your username" class="inputs">
                </div>

                <div>
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" class="inputs">
                </div>

                <div id='role_div'>
                    <label for="role">Role</label>
                    <select id="role" name="role">
                        <option value="Employee">Employee</option>
                        <option value="Manager">Manager</option>
                        <option value="HR">HR</option>
                    </select>
                </div>
            </div>

            <button type="submit" id="submitButton" value="Submit">Login</button>
            <div id="subscription-message"><?php if(isset($error)) echo $error; ?></div>
        </form>
    </section>
</body>
</html>
