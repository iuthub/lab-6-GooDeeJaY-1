<?php
$name    = $email   = $uname = $pwd    = $c_pwd  = $date = "";
$gender  = $marital = $addr  = $city   = $postal = $web  = "";
$h_phone = $m_phone = $card  = $card_e = $salary = $gpa  = "";

$mapping = [
    "name"    => ["Name",                    "([^0-9.@]){2,50}"                                     ],
    "email"   => ["Email",                   "[\w\-+]+([.][\w]+)?@[\w\-+]+([.][a-z]{2,})+"          ],
    "uname"   => ["Username",                "[a-z][^ !@#$%^&*()=\[\]]{4,}"                         ],
    "pwd"     => ["Password",                "[^\n]{8,}"                                            ],
    "c_pwd"   => ["Confirm Password",        "[^\n]{8,}"                                            ],
    "date"    => ["Date of Birth",           "[0-3][0-9]\.[0-1][0-2]\.[1-9][0-9]{3}"                ],
    "gender"  => ["Gender",                  "([Ff]e)?[Mm]ale"                                      ],
    "marital" => ["Marital Status",          "[Ss]ingle|[Mm]arried|[Dd]ivorced|[Ww]idowed"          ],
    "addr"    => ["Address",                 ".{10,}"                                               ],
    "city"    => ["City",                    ".+"                                                   ],
    "postal"  => ["Postal Code",             "(?(?=.*[1-9])[0-9]|[1-9])[0-9]{5}"                    ],
    "h_phone" => ["Home Phone",              "[0-9]{9}"                                             ],
    "m_phone" => ["Mobile Phone",            "[0-9]{9}"                                             ],
    "card"    => ["Credit Card Number",      "[0-9]{16}"                                            ],
    "card_e"  => ["Credit Card Expiry Date", "[0-3][0-9].[0-1][0-2].[1-9][0-9]{3}"                  ],
    "salary"  => ["Monthly Salary",          "UZS [1-9][0-9]*(\.[0-9]{2})?"                         ],
    "web"     => ["Web Site URL",            "(?:(?:https?|ftp):\/\/)?[\w\/\-?=%.]+\.[\w\/\-&?=%.]+"],
    "gpa"     => ["Overall GPA",             "(?(?=..[0-5])[0-4]|[0-3])\.[0-9]"                     ]
];

$pwd_validation = "\A(?=\w{6,10}\z)(?=[^a-z]*[a-z])(?=(?:[^A-Z]*[A-Z]){3})\D*\d.*\z";

$msg = "";
$color = "red";

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $match = True;
    foreach ($mapping as $key => $value) ${$key} = $_POST[$key];

    foreach ($mapping as $key => $value){
        if ($_POST[$key] == ""){
            $msg = "Not all fields are filled!";
            $match = False;
            break;
        }

        if (!preg_match("/^$value[1]$/", $_POST[$key])){
            $msg = "Field '$value[0]' filled incorrectly!";
            $match = False;
            break;
        }
    }
    if ($match){
        if ($pwd != $c_pwd){
            $msg = "Passwords don't match!";
            $match = False;
        } elseif (!preg_match($pwd_validation, $pwd)){
            $msg = "Password validation failed!";
            $match = False;
        }
    }

    if ($match){
        $msg = "Registration Successful!";
        $color = "green";
    }
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
    <title>Validating Forms</title>
    <link href="style.css" type="text/css" rel="stylesheet" />
</head>
	
<body>
    <div class="form">
        <h1>Registration Form</h1>

        <p>This form validates user input and then displays "Thank You" page.</p>
        <hr/>

        <h2>Please, fill below fields correctly</h2>
        <form action="index.php" method="post">
        <dl>
            <?php
            foreach($mapping as $var => $title){
                echo "<dt>$title[0]</dt>\n";
                echo "<dd><label><input name=$var value='${$var}'></label></dd>\n";
            }
            ?>
        </dl>
        <div class="status" style="color: <?=$color?>"><?=$msg?></div>
        <div>
            <input type="submit" value="Register">
        </div>
        </form>
    </div>
</body>
</html>