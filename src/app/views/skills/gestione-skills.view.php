<!DOCTYPE html>
<html>
<head>
    <title>Gestione Skills</title>
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
            display: flex;
            flex-direction: row;
            justify-content: space-between;
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

        #aggiunta form input {
            width: 20%;
            padding: 8px 12px;
            border: 2px solid #0077cc;
            border-radius: 5px;
            font-size: 14px;
            color: #333;
            background-color: #fff;
            transition: all 0.3s ease-in-out;
        }

        #aggiunta form input:hover {
            border-color: #0056b3;
        }

        #aggiunta form input:focus {
            outline: none;
            border-color: #0077cc;
            box-shadow: 0 0 8px rgba(0, 119, 204, 0.3);
        }
    </style>
</head>
<body>
    <?php require view('/home/home-nav.view.php'); ?>
    
    <div class="main">
        <?php require view('/home/home-sidebar.view.php'); ?>
    
        
        <div class="contenutoMain">
            <header>
               <h2> Gestione Skills </h2>
            </header>

            <section id='skills'>
                <?php if(count($skills) > 0): ?>
                    <?php foreach($skills as $skill): ?>
                        <div class='skill'>
                            <span class='nome-skill'> <?= $skill['nome']; ?> </span>
                            <form action='/admin/home/gestione-skills/<?= urlencode($skill['nome']); ?>' method='POST'>
                                <input type='hidden' name='_metodo' value='DELETE'>
                                <button type='submit' class='elimina-btn'> - </button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </section>

            <section id='aggiunta'>
                <form action='/admin/home/gestione-skills' method='POST'>
                    <input type="text" name='nome' id='aggiunta' required>
                    <button type='submit' id='aggiungi-skill'> + </button>
                </form>
            </section>

            <div id="errori">
                <?php if (isset($errori['nome'])) : ?>
                    <p> <?= $errori['nome'] ?> </p>
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