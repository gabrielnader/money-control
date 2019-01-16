<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/"
        crossorigin="anonymous">
</head>

<body>
    <header class="d-flex flex-column justify-content-between">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-dollar-sign" style="font-size:3rem;"></i>
            </a>
            <button class="bg-transparent border-0" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup"
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
        <?php
            require_once 'config/config.php';
            require_once APP_ROOT . "/classes/DB.class.php";
            require_once APP_ROOT . "/classes/Transaction.class.php";
        ?>
        <section class="text-center mb-4">
            <h2>R$ <?php echo number_format(Transaction::getCurrentMoney(), 2, ',', '.');?></h2>
            <span>SALDO</span>
        </section>
    </header>
    <main>
        <div class="container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Descrição</th>
                        <th>Valor</th>
                    </tr>
                </thead>
                <tbody id="extrato">
                    <?php    
                        $db = new DB();
                        $history = $db->query("SELECT `id` FROM `transaction` WHERE `at` BETWEEN DATE_SUB(NOW(), INTERVAL 30 DAY) AND NOW() ORDER BY `id` DESC");
                        while($row = $history->fetch()){
                            $transaction = new Transaction($row["id"]);
                            $date = $transaction->getDay();
                            $des = $transaction->getDescription();
                            $value = $transaction->getValue();
                            if(!$transaction->getType() == 0){
                                echo '<tr class="text-danger">';
                            }else{
                                echo '<tr>';
                            }
                            ?>
                                    <td><?php echo $transaction->getDay(); ?></td>
                                    <td><?php echo $transaction->getDescription(); ?></td>
                                    <td>R$<?php echo number_format($transaction->getValue(), 2, ',', '.'); ?></td>
                            </tr>
                        <?php 
                        }
                    ?>
                </tbody>
            </table>
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