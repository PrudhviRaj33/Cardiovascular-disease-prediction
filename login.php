<?php 

session_start();

include("connection.php");
include("functions.php");

if($_SERVER['REQUEST_METHOD'] == "POST")
{
    //something was posted
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];

    if(!empty($user_name) && !empty($password) && !is_numeric($user_name))
    {
        //read from database
        $query = "select * from users where user_name = '$user_name' limit 1";
        $result = mysqli_query($con, $query);

        if($result)
        {
            if($result && mysqli_num_rows($result) > 0)
            {
                $user_data = mysqli_fetch_assoc($result);
                
                if($user_data['password'] === $password)
                {
                    $_SESSION['user_id'] = $user_data['user_id'];
                    header("Location: index.html");
                    die;
                }
            }
        }
        
        echo "Wrong username or password!";
    }
    else
    {
        echo "Wrong username or password!";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style type="text/css">
        #container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        #box {
            background-color: grey;
            width: 300px;
            padding: 20px;
            border-radius: 15px;
        }

        .input-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: white;
        }

        #text {
            height: 25px;
            border-radius: 5px;
            padding: 4px;
            border: solid thin #aaa;
            width: 100%;
        }

        #button, #signup-button {
            padding: 10px;
            width: 100%;
            color: white;
            background-color: lightblue;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        #signup-button {
            background-color: blue; /* Changed color to blue */
            margin-top: 10px; /* Added margin to separate from the Login button */
        }
    </style>
</head>
<body>

    <div id="container">
        <div id="box">
            <form method="post">
                <div style="font-size: 20px; margin-bottom: 20px; color: white;">Login</div>
                
                <div class="input-group">
                    <label for="user_name">Username:</label>
                    <input id="text" type="text" name="user_name" required>
                </div>
                
                <div class="input-group">
                    <label for="password">Password:</label>
                    <input id="text" type="password" name="password" required>
                </div>

                <input id="button" type="submit" value="Login">
                <a href="signup.php"><input id="signup-button" type="button" value="Signup"></a>
            </form>
        </div>
    </div>

</body>
</html>