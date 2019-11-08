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
            <div class="col-xs-6">
                <img src="img/logo.jpg" alt="logo" class="img-responsive">
                <h1>Generator Protokołu Odbiorczego</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-3">
                <form action="generate.php" method="post">
                    <div class="form-group">
                        <label for="name" class="control-label">Imię i nazwisko</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                        <label for="add_validate">Dodać potwierdzenie?</label>
                        <input type="checkbox" id="add_validate" name="add_validate">
                        <label for="ticket_id" class="control-label">Numer zgłoszenia</label>
                        <input type="text" class="form-control" id="ticket_id" name="ticket_id" disabled>
                    </div>
                    <button type="submit" class="btn btn-primary">Generuj</button>
                </form>
            </div> 
        </div>      
    </div>
</body>

</html>
