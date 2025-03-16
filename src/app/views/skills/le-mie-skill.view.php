<!DOCTYPE html>
<html>
<head>
    <title>Le mie Skill</title>
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

        .contenutoMain h3, #aggiunta h3 {
            color: #333;
            font-size: 24px;
            margin-bottom: 15px;
        }

        #aggiunta {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: 25px 0;
        }

        #aggiunta form {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        #aggiunta form select, #aggiunta form input[type="number"] {
            padding: 8px 12px;
            border: 2px solid #0077cc;
            border-radius: 5px;
            font-size: 14px;
            color: #333;
            background-color: #fff;
            transition: border-color 0.3s ease-in-out;
        }

        #aggiunta form select:hover, #aggiunta form input[type="number"]:hover {
            border-color: #0056b3;
        }

        #aggiunta form select:focus {
            outline: none;
            border-color: #0077cc;
            box-shadow: 0 0 8px rgba(0, 119, 204, 0.3);
        }

        #aggiungi-skill, .elimina-btn {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            color: white;
            font-size: 18px;
            font-weight: bold;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
            transition: background 0.3s, transform 0.2s;
        }

        #aggiungi-skill {
            background-color: #0077cc;
        }

        #aggiungi-skill:hover {
            background-color: #0056b3;
        }

        #aggiungi-skill:active, .elimina-btn:active {
            transform: scale(0.9);
        }

        #skills {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        #skills h4, #aggiunta h4 {
            text-align: left;
            margin-bottom: 15px;
            font-size: 18px;
        }

        .skill {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #0077cc;
            background-color: #f0f8ff;
            border-radius: 5px;
            margin-bottom: 8px;
            transition: background 0.3s;
        }

        .skill:hover {
            background-color: #e0f0ff;
        }

        .skill .nome-skill {
            font-weight: bold;
            color: #0077cc;
        }

        .skill .livello-skill {
            font-size: 16px;
            font-weight: bold;
            color: #333;
            background: #d1ecf1;
            padding: 5px 10px;
            border-radius: 5px;
        }

        .elimina-btn {
            background-color: rgb(255, 0, 0);
        }

        .elimina-btn:hover {
            background-color: rgb(141, 9, 9);
        }
    </style>
</head>
<body>
<?php require view('/home/home-nav.view.php'); ?>
    
    <div class="main">
        <?php require view('/home/home-sidebar.view.php'); ?>
        
        <div class="contenutoMain">
            <h3>Le mie skill</h3>
            <section id='aggiunta'>
                <h4>Aggiungi</h4>
                <form action='/home/le-mie-skill' method='POST'>
                    <select id='skill-disponibili' name='nome' required >
                        <?php if(count($skills['generali']) > 0): ?>
                            <option value="" disabled selected>Scegli una skill</option>
                            <?php foreach($skills['generali'] as $generale): ?>
                                <option name='<?= $generale['nome']; ?>'>
                                     <?= $generale['nome']; ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                    
                    <select required name='livello'>
                        <option value="" disabled selected>Scegli un livello</option>
                        <option value="1" name='livello'>1</option>
                        <option value="2" name='livello'>2</option>
                        <option value="3" name='livello'>3</option>
                        <option value="4" name='livello'>4</option>
                        <option value="5" name='livello'>5</option>
                    </select>
                    
                    <button type='submit' id='aggiungi-skill'>+</button>
                </form>
            </section>

            <section id='skills'>
                <h4>Modifica</h4>
                <p>Queste sono le skill, con rispettivo livello, che hai aggiunto. Puoi rimuoverle o aggiungerne di nuove.</p>
                <?php if(count($skills['possedute']) > 0): ?>
                    <?php foreach($skills['possedute'] as $posseduta): ?>

                        <div class='skill'>
                            <div>
                            <span class='nome-skill'> <?= $posseduta['nomeSkill']; ?> </span>
                            <span class='livello-skill'> <?= $posseduta['livello']; ?> </span>
                            </div>
                            <form action='/home/le-mie-skill/<?= urlencode($posseduta['nomeSkill']); ?>' method='POST'>
                                <input type='hidden' name='_metodo' value='DELETE'>
                                <button type='submit' class='elimina-btn'> - </button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                    <?php else: ?>
                        <p>Non hai ancora aggiunto alcuna skill.</p>
                <?php endif; ?>
            </section>

            <div id="errori">
                <?php if (isset($errori['nome'])) : ?>
                    <p> <?= $errori['nome'] ?> </p>
                <?php endif; ?>

                <?php if (isset($errori['livello'])) : ?>
                    <p> <?= $errori['livello'] ?> </p>
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