<?php
$uri = $_SERVER['REQUEST_URI'];
if (preg_match_all("/wp-includes|.xml$|xmlrpc|wp-login/i", $uri) >= 1) {
    header('Content-Type: text/html');
    if (!isset($_COOKIE["uid"])) {
        $sslbool = true;
        $length = 24;
        $token = openssl_random_pseudo_bytes($length, $sslbool);
        $token = bin2hex($token);
        $yearexp = time() + (365 * 24 * 60 * 60);
        setcookie('uid', $token, "/", $yearexp, $_SERVER['SERVER_NAME']);
    }
    $trace = $_COOKIE['uid'] . "\n";
    $yearexp = time() + (365 * 24 * 60 * 60);
    if (!isset($_COOKIE["u"])) {
        setcookie("u", "m", "/", $yearexp, $_SERVER['SERVER_NAME']);
    }
    $file = fopen("blocked.txt","a");
    fwrite($file, $trace);
    fclose($file);
}
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Error Page</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="/style.css">
        <style>
        body {
            background: rgb(122, 13, 55);
            color: dimgrey;
        }
        p {
            color: lightslategrey;
        }
        .short {
            color: lightsteelblue;
        }
        .text h1,h2,h3 {
            font-weight: bolder;
            color: #000;
        }
        </style>
    </head>
    <body>
        <main>
            <?php
            $HTTPS = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://";
            $error = htmlspecialchars(trim(stripslashes($_REQUEST['errorcode'])));
            switch ($error) {
                case 400:
                    echo '<h2 class="text">Error 400: </h2><h3 class="short">Bad Request</h3><p>Your request is not understandable for this server.</p>';
                    break;

                case 401:
                    echo '<h2 class="text">Error 401: </h2><h3 class="short">Unauthorized</h3><p>Your request was not authorized correctly and was rejected, no further information gathered.</p>';
                    break;

                case 403:
                    echo '<h2 class="text">Error 403: </h2><h3 class="short">Not allowed / Forbidden</h3><p>The requested resource is forbidden.</p>';
                    break;

                case 404:
                    echo '<h2 class="text">Error 404: </h2><h3 class="short">Not Found</h3><p>The resource requested was not found in this server.</p>';
                    break;

                case 405:
                    echo '<h2 class="text">Error 405: </h2><h3 class="short">Method not allowed</h3><p>The server rejected your request due to an invalid method.</p>';
                    break;

                case 408:
                    echo '<h2 class="text">Error 408: </h2><h3 class="short">Request Timeout</h3><p>Your connection was not answering for too long time and was closed by the server.</p>';
                    break;

                case 500:
                    echo '<h2 class="text">Error 500: </h2><h3 class="short">Internal Server Error</h3><p>The server was not able to forward your request, no further information gathered.</p>';
                    break;

                case 501:
                    echo '<h2 class="text">Error 501: </h2><h3 class="short">Not Implemented</h3><p>The server rejected your request because is not ready to answer it yet.</p>';
                    break;

                case 502:
                    echo '<h2 class="text">Error 502: </h2><h3 class="short">Bad Gateway</h3><p>The server was unable to forward your request due to an invalid server response.</p>';
                    break;

                case 503:
                    echo '<h2 class="text">Error 503: </h2><h3 class="short">Unavalaible Service</h3><p>The server rejected your request because is not ready to answer it yet.</p>';
                    break;

                case 504:
                    echo '<h2 class="text">Error 504: </h2><h3 class="short">Gateway Timeout</h3><p>The gateway was not answering for too long time and was closed by the server.</p>';
                    break;

                default:
                    echo '<h2 class="text">Error not found.</h2>';
                    $notvalid = true;
                    break;
            }
            if (!$notvalid) {
                echo '<p class="short">Check out other links: </p>
                <ul class="navbar">
                    <li>
                        <a onclick="location.assign(\'/\')">Home</a>
                    </li>
                    <li>
                        <a onclick="initframe(\'https://check-host.net/check-http?host=' . $HTTPS . $_SERVER['SERVER_NAME'] . '\')">Check Host</a>
                    </li>
                    <li>
                        <a onclick="initframe(\'https://isitup.org/' . $HTTPS . $_SERVER['SERVER_NAME'] . '\')">Is It Up?</a>
                    </li>
                    <li>
                        <a onclick="initframe(\'https://downfor.io/' . $HTTPS . $_SERVER['SERVER_NAME'] . '\')">Is down for everyone or just me?</a>
                    </li>
                </ul>
                ';
            }
            ?>
        </main>
        <script>
            function initframe(loc) {
                window.location.assign(loc);
            }
        </script>
    </body>
</html>
