<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link rel="icon" type="images/png" href="images/favicon.ico" />

    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/"
        crossorigin="anonymous">
</head>

<body>
    <?php
        require_once 'config/config.php';
        require_once APP_ROOT . '/classes/Transaction.class.php';
        if(isset($_POST["valorReceber"])){
            $transaction = Transaction::newTransaction($_POST["valorReceber"], $_POST["dataReceber"], $_POST["descricaoReceber"], 0);

    ?>
    <!-- ADD MENSAGEM DE ADD -->
    <script>
        setTimeout(function() { alert('Operação realizada com sucesso'); }, 100);
    </script>
        <!-- <div class="alert-success">
            saldo adicionado!
        </div> -->
    <?php } ?>

    <header class="d-flex flex-column justify-content-between home-header">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-dollar-sign" style="font-size:3rem;"></i>
            </a>
            <button type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon" style="font-size:2rem;"></span>
            </button>
            <div class="collapse navbar-collapse mt-2" id="navbarNavAltMarkup">
                <div class="navbar-nav text-center">
                    <a class="nav-item nav-link" href="recieve.php">Receber</a>
                    <a class="nav-item nav-link" href="pay.php">Pagar</a>
                    <a class="nav-item nav-link" href="history.php">Histórico</a>
                    <a class="nav-item nav-link" href="balance.php">Saldo</a>
                </div>
            </div>
        </nav>
        <section class="text-center mb-4">
            <h2>R$ <?php echo number_format(Transaction::getCurrentMoney(), 2, ',', '.');?></h2>
            <span>SALDO</span>
        </section>
    </header>
    <main>
        <div class="container">
            <h2 class="mt-3">Receber valor</h2>
            <form class="mt-3" action="recieve.php" method="post">
                <div class="form-group">
                    <input type="date" class="form-control" name="dataReceber">
                </div>
                <div class="form-group">
                    <input class="form-control" type="number" name="valorReceber" id="valorReceberInput" placeholder="Valor">
                </div>
                <div class="form-group">
                    <input class="form-control" type="text" name="descricaoReceber" id="descricaoReceberInput" placeholder="Descrição">
                </div>
                <button class="btn btn-info" type="submit">Receber</button>
            </form>
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
</body>

</html>