<?php

require __DIR__.'/../vendor/autoload.php';

$domain = ((isset($_POST['domain'])) && ($_POST['domain'] != "")) ? $_POST['domain'] : "";

if($domain == ""){
    header("Location: index.php");
    exit;
}

$loop = React\EventLoop\Factory::create();
$factory = new React\Dns\Resolver\Factory();
$resolver = $factory->create('8.8.8.8', $loop);
$connFactory = new React\Whois\ConnectionFactory($loop);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Consult Whois - leonardorifeli.com</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-Frame-Options" content="sameorigin">
    <meta name="viewport" content="width=device-width">
    <meta name="Googlebot" content="all"/>
    <meta name="Robots" content="index,follow"/>
    <meta name="author" content=" Leonardo Rifeli "/>
    <meta name="reply-to" content=" leonardorifeli@gmail.com "/>
    <link rel="stylesheet" href="https://leonardorifeli.com/css/main.css">
    <link rel="stylesheet" href="https://leonardorifeli.com/css/custom.css">
    <link rel="shortcut icon" href="https://leonardorifeli.com/img/favicon.ico" type="image/x-icon">
</head>
<body>
    <div class="site-header" style="border: 0px;">
        <?php
        echo "Consulting the domain: <b>{$domain}</b> \n";

        $client = new React\Whois\Client($resolver, $connFactory);
        $client->query($domain)->then(function($result){
            echo utf8_encode(nl2br("\n".$result));
        });

        $loop->run();
        ?>
        <br/>
        <a href="index.php" class="button">Go back</a>
    </div>
</body>
</html>
