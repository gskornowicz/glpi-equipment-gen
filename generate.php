<?php
include 'dbconnect.php';
include 'functions.php';

//creating connection to database
$connection = new mysqli($dbhost, $dbuser, $dbpassword, $dbdefault);
$connection->set_charset("utf8");

//BASIC ERROR HANDLING

//check if user is in DB and get his ID:)
if(!$userID = getUserID($_POST['name'], $connection))
{
    echo "Nie znaleziono użytkownika o podanym imieniu i nazwisku"; //TODO PROPER ERROR HANDLING :)
    exit();
}

// check if validation ticket is right if choose to validate
if (isset($_POST['add_validate']))
{

    if(!checkForTicketValidation($_POST['ticket_id'], $userID, $connection) && $_POST['add_validate'] == 'on' )
    {
        echo "Nie znaleziono zatwierdzenia dla takiego nr zgłoszenia"; //TODO PROPER ERROR HANDLING :)
        exit();
    }
}



?>

    <!doctype html>

    <html lang="pl">

    <head>
        <meta charset="utf-8">

        <title>Generator GLPI</title>
        <meta name="description" content="Generator protokołu">

        <meta name="viewport" content="width=device-width, initial-scale=1">

        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/scripts.js"></script>

        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css?v=1.0">


    <!--[if lt IE 9]>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
    <![endif]-->
    </head>

    <body>
        <div class="container">
            <div class="row">
                <div class="col-xs-12" style="height:25px;"></div>
                <div class="col-md-12">
                    <div class="pull-right date">
                        <?php
                            $date = date('j.m.Y');
                            echo "<p><b>Wrocław ".$date."</b></p>";
                        ?>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <img src="img/logo.jpg" alt="logo" class="img-responsive">
                </div>
                <div class="col-md-9">
                    <address class="pull-right address">
                        NAZWA FIRMY<br>
                        ADRES 1<br>
                        ADRES 2<br>
                        NIP
                    </address>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12" style="height:60px;"></div>
                <div class="col-md-12 text-center">
                    <h3>PROTOKÓŁ ODBIORCZY</h3>
                </div>
                <div class="col-xs-12" style="height:60px;"></div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?php
                        echo "<h4>Imię i nazwisko pracownika: ".$_POST['name']."<br>";
                        echo "Dział: ".getUserGroup($userID,$connection)."</h4>";
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-ls-12">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Sprzęt</th>
                                    <th>Typ</th>
                                    <th>Producent</th>
                                    <th>Model</th>
                                    <th>Numer seryjny</th>
                                    <th>Numer inwentaryzacyjny</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($userID)
                                {

                                    if ($computers = getUserComputers($userID, $connection))
                                    {
                                        foreach ($computers as $row)
                                        {
                                            echo "<tr><td>Komputer</td>";
                                            foreach($row as $value)
                                            {
                                                echo "<td>".$value."</td>";
                                            }
                                            echo"</tr>";
                                        }
                                    }

                                    if ($monitors = getUserMonitors($userID, $connection))
                                    foreach ($monitors as $row)
                                    {
                                        echo "<tr><td>Monitor</td>";
                                        foreach($row as $value)
                                        {
                                            echo "<td>".$value."</td>";
                                        }
                                        echo"</tr>";
                                    }

                                    if ($printers = getUserPrinters($userID, $connection))
                                    foreach ($printers as $row)
                                    {
                                        echo "<tr><td>Drukarka</td>";
                                        foreach($row as $value)
                                        {
                                            echo "<td>".$value."</td>";
                                        }
                                        echo"</tr>";
                                    }

                                    if ($phones = getUserPhones($userID, $connection))
                                    {
                                            foreach ($phones as $row)
                                            {
                                                echo "<tr><td>Telefon</td>";
                                                foreach($row as $value)
                                                {
                                                    echo "<td>".$value."</td>";
                                                }
                                                echo"</tr>";
                                            }
                                    }

                                    if ($devices = getUserNetworkDevices($userID, $connection))
                                    {
                                        foreach ($devices as $row)
                                        {
                                            echo "<tr><td>Urządzenie</td>";
                                            foreach($row as $value)
                                            {
                                                echo "<td>".$value."</td>";
                                            }
                                            echo"</tr>";
                                        }
                                    }

                                    if ($peripherals = getUserPeripherals($userID, $connection))
                                    {
                                        foreach ($peripherals as $row)
                                        {
                                            echo "<tr><td>Inne</td>";
                                            foreach($row as $value)
                                            {
                                                echo "<td>".$value."</td>";
                                            }
                                            echo"</tr>";
                                        }
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12" style="height:40px;"></div>
                <div><p class="col-md-12 text-justify footer-text">Zapoznałam/em się z danymi zawartymi w niniejszym protokole i potwierdzam ich zgodność. </p></div>
                <div class="col-md-12 text-justify footer-text">
                    <p>Potwierdzam odbiór oraz zobowiązuję się do zwrotu lub rozliczenia z przekazanych mi środków trwałych w przypadku ustania stosunku pracy lub uszkodzenia sprzętu.  Jednocześnie w razie nie dokonania zwrotu przekazanego mi do użytkowania środka trwałego, upoważniam Pracodawcę do dokonania potrącenia wartości niezwróconego środka trwałego z kwoty należnego mi wynagrodzenia lub innej wierzytelności przysługującej mi względem pracodawcy.</p>
                </div>

                <?php
                    if (isset($_POST['add_validate']))
                    {
                        if(checkForTicketValidation($_POST['ticket_id'], getUserID($_POST['name'],$connection), $connection))
                        {
                            echo('<div class="col-xs-12" style="height:40px;"></div>');
                            echo('<div class="col-md-12 footer-text">');
                            echo('<p class="pull-right">Zaakceptowane przez '.$_POST['name'].' dnia '.getTicketValidationDate($_POST['ticket_id'], $userID, $connection).' w zgłoszeniu nr '.$_POST['ticket_id'].'</p>');
                            echo('</div>');
                        }
                    }
                ?>

            </div>
        </div>
    </body>

    </html>

<?php

// Closing database connection
$connection->close();

//Debugging
//echo "<h2>Debugging</h2>";
//echo "UserID: ".$userID."<br>";
//echo "global_counter: ".$global_counter."<br>";

?>
