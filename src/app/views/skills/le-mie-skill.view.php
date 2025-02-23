<!DOCTYPE html>
<html>
<head>
    <title>Le mie Skill</title>
    <style>
        /* Stile generale */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f4f4f4;
            color: #333;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Header */
        header {
            background: #0077cc;
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }

        header h2 {
            margin: 0;
        }

        header div {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        header p {
            font-weight: bold;
            font-size: 16px;
        }


        header form input {
            background: #ff4d4d;
            color: white;
            border: none;
            padding: 7px 12px;
            cursor: pointer;
            border-radius: 5px;
            transition: background 0.3s;
            width: 100%;
        }

        header form input:hover {
            background: #cc0000;
        }


        /* Layout principale */
        .main {
            display: flex;
            flex: 1;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background: #1e1e2d;
            color: white;
            padding: 20px;
            min-height: 100vh;
        }

        .sidebar ul {
            list-style: none;
        }

        .sidebar li {
            margin-bottom: 10px;
        }

        .sidebar a {
            color: #f8f9fa;
            text-decoration: none;
            display: block;
            padding: 10px;
            border-radius: 5px;
            transition: all 0.3s ease-in-out;
            font-weight: bold;
        }

        .sidebar a:hover {
            background: #0077cc;
            color: white;
            transform: scale(1.05);
        }

       
        .card {
            width: 250px;
            border: 1px solid #ccc;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            text-align: center;
            background: #fff;
            margin-top: 15px;
        }

        .card .img {
            width: 100%;
            height: 150px;
            background: #f0f0f0;
        }

        .card .img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .card .info {
            padding: 10px;
            font-size: 14px;
            font-weight: bold;
            color: #333;
        }

        .card .azioni {
            display: flex;
            justify-content: space-around;
            padding: 10px;
        }

        .card .azioni button {
            background: #007bff;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .card .azioni button:hover {
            background: #0056b3;
        }

         .contenutoMain {
            flex: 1;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            margin: 20px 10%;
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
            align-items: center;
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

        #errori {
            color: #d93025 !important;
        }

        /* Footer */
        footer {
            background: #0077cc;
            color: white;
            text-align: center;
            padding: 10px;
            margin-top: auto;
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

        #aggiunta form select:focus,
        #aggiunta form input[type="number"]:focus {
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
               <h2> Le mie Skill </h2>
            </header>
            <section id='skills'>

            </section>

            <section id='aggiunta'>
                <form action='/home/le-mie-skill/aggiungi' method='POST'>
                    <select id='skill-disponibili' name='nome' required >

                    </select>
                        
                    <input type='number' min='1' max='5' name='livello' required>
                    
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
    
    <footer>
        <p>BOSTARTER - Copyright &copy;, 2025</p>
    </footer>
</body>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    let disponibili = document.getElementById('skill-disponibili');
    let contenitoreSkills = document.getElementById('skills');
    getSkillDisponibili();
    getMieSkills();

    async function getSkillDisponibili() {
        try {
            const risposta = await axios.get("/ottieni-skills");
            let skills = risposta.data;
            
            if(skills) {
                popolaDisponibili(skills);
            }
        } catch(error) {
            console.log(error);
        }
    }

    async function getMieSkills() {
        try {
            const risposta = await axios.get("/ottieni-mie-skills");
            let skills = risposta.data;
            
            if(skills) {
                popolaMie(skills);
            }
        } catch(error) {
            console.log(error);
        }
    }
    
    function popolaMie(skills) {
        contenitoreSkills.innerHTML = '';
        
        skills.forEach(skill => {
            let card = document.createElement('div');
            card.className = 'skill';
            let nome  = document.createElement('span');
            nome.className = 'nome-skill';
            let  livello = document.createElement('span');
            livello.className = 'livello-skill';
            nome.textContent = skill.nomeSkill;
            livello.textContent = skill.livello;
            let rimozioneBtn = document.createElement('button');
            rimozioneBtn.textContent = ' - ';
            rimozioneBtn.className = 'elimina-btn';
            rimozioneBtn.addEventListener('click', event => {
                rimuoviSkill(nome.textContent);
                
            });
            card.appendChild(nome);
            card.appendChild(livello);
            card.appendChild(rimozioneBtn);
            contenitoreSkills.appendChild(card);
        });
    }

    async function rimuoviSkill(nomeSkill){
        try {
            let risultato = await axios.delete(`/rimuovi-skill?nomeSkill=${encodeURIComponent(nomeSkill)}`);
            getSkillDisponibili();
            getMieSkills();
        } catch(error) {
            console.log(error);
        }
    }

    function popolaDisponibili(skills) {
        disponibili.innerHTML = '';
        skills.forEach(skill => {
            
            let option = document.createElement('option');
            option.name = skill.nome;
            option.textContent = skill.nome;

            disponibili.appendChild(option);
        });
    }
    
</script>
</html>