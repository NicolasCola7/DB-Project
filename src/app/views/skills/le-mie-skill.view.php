<!DOCTYPE html>
<html>
<head>
    <title>Le mie Skill</title>
    <style>
        
        .contenutoMain {
            margin: 20px;
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

        #aggiungi-skill {
            width: 30px;
            height: 30px;   
            border-radius: 50%;
            background-color: #007bff;
            color: white;
            font-size: 24px;
            font-weight: bold;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
            transition: background 0.3s, transform 0.2s;
        }

        #aggiungi-skill:hover {
            background-color: #0056b3;
        }

        #aggiungi-skill:active {
            transform: scale(0.9);
        }

        #skills {
            width: 100%;
            max-width: 800px; 
        }

        #skills > .skill {
            display: grid;
            grid-template-columns: minmax(120px, 1fr) 1fr auto;
            gap: 15px; 
            align-items: center;
            padding: 5%;
            border-bottom: 1px solid #0077cc;
            color: #0077cc;
        }

      
        #skills > .skill > span:first-child {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .elimina-btn{
            width: 30px;
            height: 30px;   
            border-radius: 50%;
            background-color:rgb(255, 0, 0);
            color: white;
            font-size: 24px;
            font-weight: bold;
            border: none;
            cursor: pointer;
            display: flex;
            align-content: center;
            justify-content: center;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
            transition: background 0.3s, transform 0.2s;
        }

        .elimina-btn:hover {
            background-color:rgb(141, 9, 9);
        }

        .elimina-btn:active {
            transform: scale(0.9);
        }


        #aggiunta > form {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            padding: 3% 5%;
            cursor: pointer;
        }

        #aggiunta > form > select, input {
            width: 20%;
            border: 1px solid  #0077cc
        }

        #aggiunta form select,
        #aggiunta form input[type="number"] {
            width: 20%;
            padding: 8px 12px;
            border: 2px solid #0077cc;
            border-radius: 5px;
            font-size: 14px;
            color: #333;
            background-color: #fff;
            transition: all 0.3s ease-in-out;
        }

        #aggiunta form select:hover,
        #aggiunta form input[type="number"]:hover {
            border-color: #0056b3;
        }

        #aggiunta form select:focus{
            outline: none;
            border-color: #0077cc;
            box-shadow: 0 0 8px rgba(0, 119, 204, 0.3);
        }

        #aggiungi-skill {
            width: 30px;
            height: 30px;   
            border-radius: 50%;
            background-color: #007bff;
            color: white;
            font-size: 24px;
            font-weight: bold;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
            transition: background 0.3s, transform 0.2s;
        }

        #aggiungi-skill:hover {
            background-color: #0056b3;
        }

        #aggiungi-skill:active {
            transform: scale(0.9);
        }

    </style>
</head>
<body>
<?php require view('/home/home-nav.view.php'); ?>
    
    <div class="main">
        <?php require view('/home/home-sidebar.view.php'); ?>
        
        <div class="contenutoMain">
            <header>
               <h2> Le mie Skill </h2>
            </header>
            <section id='skills'>
                <?php if(count($skills['possedute']) > 0): ?>
                    <?php foreach($skills['possedute'] as $posseduta): ?>
                        <div class='skill'>
                            <span class='nome-skill'> <?= $posseduta['nomeSkill']; ?> </span>
                            <span class='livello-skill'> <?= $posseduta['livello']; ?> </span>
                            <form action='/home/le-mie-skill/<?= urlencode($posseduta['nomeSkill']); ?>' method='POST'>
                                <input type='hidden' name='_metodo' value='DELETE'>
                                <button type='submit' class='elimina-btn'> - </button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </section>

            <section id='aggiunta'>
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
                    
                    <button type='submit' id='aggiungi-skill'> + </button>
                </form>
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