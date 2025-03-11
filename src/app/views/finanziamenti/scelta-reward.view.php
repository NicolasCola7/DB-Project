<!DOCTYPE html>
<html>
<head>
    <title>Finanzia Progetto</title>
    <style>
        
        .contenutoMain > header {
            display: flex;
            flex-direction: row;
            background: white;
            color: #0077cc;
            justify-content: center;
            padding-bottom: 2%;
            border-bottom: 2px solid #0077cc;
            margin-bottom: 20px;
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
        
        input, select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            transition: border 0.3s;
        }
        
        input:focus, select:focus {
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

        #rewards {
            padding: 20px 30px;
        }

        #rewards header {
            margin-bottom: 15px;
        }

        #rewards h4 {
            color: #333;
            font-size: 18px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #333;
        }

        tr:hover {
            background-color: #f5f5f5;
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

        section header {
            margin-bottom: 20px;
        }

        section header h4 {
            color: #333;
            font-size: 18px;
            text-align: center;
        }

    </style>
</head>
<body>
<?php require view('/home/home-nav.view.php'); ?>
    
    <div class="main">
        <?php require view('/home/home-sidebar.view.php'); ?>
        
        <div class="contenutoMain">
            <header>
               <h2> Scelta Reward </h2>
            </header>

            <div id='rewards'>
                <header>
                    <h4> Rewards disponibili </h4>
                </header>
                <table>
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
                                <tr>
                                    <td class='codice-reward'> <?= $reward['codice']; ?> </td>
                                    <td class='descrizione-reward'> <?= $reward['descr']; ?> </td>
                                    <td class='immagine-reward'> 
                                        <img src='../../../<?= $reward['urlFoto']; ?>' alt='immagine reward'>
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

            <section>
                <header>
                    <h4> Scegli una reward selezionando il codice corrispondente </h4>
                </header>
                <form action='/home/progetti/<?= urldecode(explode('/', $_SERVER['REQUEST_URI'])[3]); ?>/finanziamenti/scelta-reward' method='POST'>
                    <div class='container'>
                        <label for='codice'> codice </label>
                        <select required='true' name='codice-reward'>
                            <option value="" disabled selected>Scegli una reward</option>
                            <?php if(count($rewards) > 0): ?>
                                <?php foreach($rewards as $reward): ?>
                                    <option value='<?= $reward['codice']; ?>'>
                                        <?= $reward['codice']; ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class='container'>
                        <button type='submit'> Scegli </button>
                    </div>
                </form>
            </section>
            
            <div id="errori">
                <?php if (isset($errori['codice-reward'])) : ?>
                    <p> <?= $errori['codice'] ?> </p>
                <?php endif; ?>

                <?php if (isset($errori['procedura'])) : ?>
                    <p> <?= $errori['procedura'] ?> </p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <?php require view('/home/home-footer.view.php'); ?>

</body>

</html>