<?php
    if (!isset($_REQUEST['disablelogging'])) {
        if ($_REQUEST['disablelogging'] == 'true') {
            echo '<p class="advice">You'."'".'re safe! Enjoy your anonymous browsing.</p>';
            $yearexp = time() + (365 * 24 * 60 * 60);
            setcookie('safe', "true", "/", $yearexp, $_SERVER['SERVER_NAME']);
        } else {
            if (!isset($_COOKIE["uid"])) {
                    $sslbool = true;
                    $length = 24;
                    $token = openssl_random_pseudo_bytes($length, $sslbool);
                    $token = bin2hex($token);
                    $yearexp = time() + (365 * 24 * 60 * 60);
                    setcookie('uid', $token, "/", $yearexp, $_SERVER['SERVER_NAME']);
            } else {
                    $token = $_COOKIE["uid"];
            }
            $file = "visitokens.txt";
            $file = fopen($file, "a");
            $data = json_encode(array(
                    "token" => $token,
                    "IP" => $_SERVER['REMOTE_ADDR'],
                    "UA" => $_SERVER['HTTP_USER_AGENT'],
                    "Date" => date('Y/m/d'),
                    "Time" => date('G:i:s')
            )) . "\n";
            fwrite($file, $data);
            fclose($file);
        }
    }
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Nekes Web</title>
        <meta property="og:title" content="NK125 Website">
        <meta property="og:type" content="profile">
        <meta name="description" content="Welcome to my page">
        <meta property="og:description" content="Welcome!">
        <meta name="keywords" content="nekes, nekes.cf, NK125, mushka">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="./style.css">
        <link rel="icon" href="icon.png">
        <meta property="og:image" content="icon.png">
        <meta property="og:thumbnail" content="icon.png">
        <meta property="og:url" content="https://nekes.cf">
    </head>
    <body>
        <div class="void"></div>
        <main>
            <h2 class="text">
                <a href="https://discord.gg/4hgezARmav">
                    <span>Invite</span>
                </a>
            </h2>
            <p class="text">
                <span>Nekes Webpage, leave or something, there's nothing more interesting here.</span>
            </p>
            <ul class="navbar">
                <li>
                    <a onclick="location.assign('/')">Home</a>
                </li>
                <li>
                    <a onclick="location.assign('/somethingbadhappened?errorcode=')">Display Errors PHP</a>
                </li>
            </ul>
        </main>
        <div class="void"></div>
    </body>
</html>
