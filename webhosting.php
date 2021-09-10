<!doctype html>
<html lang="nl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Kras design</title>
        <link rel="stylesheet" href="style/style.css">
        <style>
            header nav a:nth-of-type(6) {
                border-bottom: #ffffff 10px solid;
                font-weight: bold;
            }
            main {
                display: flex;
                flex-direction: column;
                align-items: center;
            }
            main > * {
                font-size: 3vw;
                margin: 20px;
            }
            p {
                margin-top: 100px;
                width: min(90%,20em);
            }
            h1 {
                width: 90%;
                text-align: center;
            }
            #form {
                width: min(90%,30em);
                display: flex;
                flex-direction: column;
                justify-content: center;
            }
            #form * {
                font-size: 2vw;
                text-align: center;
            }
        </style>
        <script src="style/javascript.js"></script>
    </head>
    <body>
        <header>
            <div id="logoDiv">
                <div id="circle"></div>
                <img src="content/LogoKras.png" alt="logo">
            </div>
            <nav>
                <a href="index.html">Homepage</a>
                <a href="contact.html">Contact</a>
                <a href="aboutUs.html">About us</a>
                <a href="tarieven.html">Tarieven</a>
                <a href="verhuizing.html">Verhuizing</a>
                <a href="webhosting.php">Webhosting</a>
            </nav>
        </header>
        <main>
            <div id="google_translate_element"></div>

            <script type="text/javascript">
                function googleTranslateElementInit() {
                    new google.translate.TranslateElement({pageLanguage: 'nl'}, 'google_translate_element');
                }
            </script>

            <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
            <h1>Domeinnaam-checker</h1>
            <div id="form">
                <h2>Controleer de beschikbaarheid van de domeinnaam</h2>
                <div class="container">
                    <form action="" method="GET">
                        <input id="searchBar" class="searchbar" type="text" name="domain" placeholder="Zoek domeinnaam ..." value="<?php if(isset($_GET['domain'])){ echo $_GET['domain']; } ?>">
                        <button type="submit" id="btnSearch" class="btn-search"><i class="fa fa-search"></i></button>
                    </form>
                </div>
                <?php
                error_reporting(0);
                if(isset($_GET['domain'])){
                    $domain = $_GET['domain'];
                    if ( gethostbyname($domain) != $domain ) {
                        echo "<h3 class='fail'>Domein al geregistreerd!</h3>";
                }
                else {
                echo "<h3 class='success'>Schiet op, uw domein is beschikbaar! U kunt het registreren.</h3>";
                }
                }
                ?>
            </div>

            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"/>
            <style type="text/css">
                #form h2 {
                    font-size: 26px;
                    text-align: center;
                }
                #form h3 {font-size: 24px; }
                #form h3.success {
                    color: #008000;
                    text-align: center;
                }
                #form h3.fail {
                    color: #ff0000;
                    text-align: center;
                }
                #form .container {
                    display: flex;
                    flex-direction: row;
                    justify-content: center;
                    align-items: center;
                }
                #form .searchbar {
                    padding: 6px 10px;
                    width: 400px;
                    max-width: 100%;
                    border: none;
                    margin-top: 1px;
                    margin-right: 8px;
                    font-size: 1em;
                    border-bottom: #333 solid 2px;
                    transition: 0.3s;
                }
                #form .searchbar::placeholder {
                    font-size: 1em;
                }
                #form .searchbar:focus {
                    outline: none;
                }
                #form .btn-search {
                    cursor: pointer;
                    text-decoration: none !important;
                    font-size: 1.5em;
                    padding-top: 5px;
                    padding-bottom: 5px;
                    background-color: transparent;
                    border: none;
                    outline: none;
                }
            </style>
        </main>
    </body>
</html>