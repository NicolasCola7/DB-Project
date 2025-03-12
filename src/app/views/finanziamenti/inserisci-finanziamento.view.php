<!DOCTYPE html>
<html>
<head>
    <title>Finanzia Progetto</title>
    <style>
        html, body {
            height: 100vh;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }    

        .main {
            display: flex;
            flex-grow: 1;
            overflow: hidden;
        }

        .contenutoMain {
            flex-grow: 1;
            max-height: 100%;
            overflow-y: auto;
            padding: 20px;
            margin: 10px;
        }
        
        .contenutoMain > header {
            display: flex;
            flex-direction: row;
            background: white;
            color:  #0077cc;
            justify-content: center;
            padding-bottom: 2%;
            border-bottom: 2px solid   #0077cc;
        }

        section {
            display: flex;
            flex-direction: column;
            padding: 30px;
        }
        
        form {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
        }
        
        .container {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: bold;

        }
        
        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            transition: border 0.3s;
        }
        
        input:focus {
            outline: none;
            border-color: #0077cc;
            box-shadow: 0 0 5px rgba(0, 119, 204, 0.2);
        }
        
        button {
            background-color: #0077cc;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: background-color 0.3s;
        }
        
        button:hover {
            background-color: #005fa3;
        }

        #container-rewards {
            padding: 20px 30px;
        }

        #container-rewards header {
            margin-bottom: 15px;
            background-color: white;
        }

        #container-rewards h4 {
            color: black;
            font-size: 18px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        thead {
            background-color: #0077cc;
            color: white;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        tbody tr {
            cursor: pointer;
            transition: background-color 0.2s;
        }

        tbody tr:hover {
            background-color: #f0f7fc;
        }

        .codice-reward {
            font-weight: 600;
            color: #0077cc;
        }

        .descrizione-reward {
            max-width: 400px;
        }

        .immagine-reward img {
            max-width: 120px;
            max-height: 80px;
            border-radius: 4px;
            border: 1px solid #eee;
        }

        .reward-selezionata {
            background-color: #e1f0fa !important;
            border-left: 4px solid #0077cc;
        }
        
        .buttoni {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<?php require view('/home/home-nav.view.php'); ?>
    
    <div class="main">
        <?php require view('/home/home-sidebar.view.php'); ?>
        
        <div class="contenutoMain">
            <header>
               <h2>Finanzia il progetto <span> <?= urldecode(explode('/', $_SERVER['REQUEST_URI'])[3]); ?> </span></h2>
            </header>

            <section>
                <form id='form-finanziamento' action='/home/progetti/<?= urldecode(explode('/', $_SERVER['REQUEST_URI'])[3]); ?>/finanziamenti' method='POST'>
                    <div class='container'>
                        <label for='importo'>Importo (€)</label>
                        <input type='number' name='importo' id='importo' required min='1'>
                    </div>

                    <div class='container'>
                        <label for='tabella-rewards'> Seleziona una reward cliccando sulla riga corrispondente </label>
                        <table name="tabella-rewards">
                            <thead>
                                <tr>
                                    <th> Codice </th>
                                    <th> Descrizione </th>
                                    <th> Foto </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(count($rewards) > 0): ?>
                                    <?php foreach($rewards as $reward): ?>
                                        <tr class="reward" data-code="<?= $reward['codice']; ?>">
                                            <td class='codice-reward'> <?= $reward['codice']; ?> </td>
                                            <td class='descrizione-reward'> <?= $reward['descr']; ?> </td>
                                            <td class='immagine-reward'> 
                                                <img src='../../../../<?= $reward['urlFoto']; ?>' alt='immagine reward'>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan='3'> Non sono presenti rewards per questo progetto </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <input type="hidden" id="codice-reward" name="codice-reward" value="" required>
                    
                    <div class='container bottoni'>
                        <button type='submit'>Invia Finanziamento</button>
                    </div>
                </form>
            </section>
            
            <div id="errori">
                <?php if (isset($errori['importo'])) : ?>
                    <p> <?= $errori['importo'] ?> </p>
                <?php endif; ?>

                <?php if (isset($errori['codice-reward'])) : ?>
                    <p> <?= $errori['codice'] ?> </p>
                <?php endif; ?>

                <?php if (isset($errori['procedura'])) : ?>
                    <p> <?= $errori['procedura'] ?> </p>
                <?php endif; ?>
            </div>

            <div id='successo'>
                <?php if (isset($successo)) : ?>
                    <script>
                        alert("Progetto finanziato con successo");
                     </script>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <?php require view('/home/home-footer.view.php'); ?>

</body>


<script>
    const rewards = document.querySelectorAll('.reward');
    const codiceReward = document.getElementById('codice-reward');
    const form = document.getElementById('form-finanziamento');

    rewards.forEach(reward => {
        reward.addEventListener('click', function() {
            // Elimino il valore del codice reward selezionata
            codiceReward.value= "";

            // Rimuovo la marcatura di reward selezionata da tutte le righe dell atabella
            rewards.forEach(r => r.classList.remove('reward-selezionata'));
            
            // Marco come selezionata la reward 
            this.classList.add('reward-selezionata');
            
            // Imposta il valore dell'input nascosto
            codiceReward.value = this.getAttribute('data-code');
        });
    });

    form.addEventListener('submit', event => {
        if(codiceReward.value === "") {
            event.preventDefault();
            alert('Per finanziare il progetto devi selezionare una reward!');
        } 
    });
</script>
</html>