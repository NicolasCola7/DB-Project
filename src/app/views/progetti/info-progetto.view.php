<?php use \core\AlertManager; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Bostarter</title>
    <link rel='stylesheet' type='text/css' href='/public/styles/progetti/info-progetto.style.css'>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <?php require view('/home/home-nav.view.php'); ?>
    
    <div class="main">
        <?php require view('/home/home-sidebar.view.php'); ?>
        
        <div class="contenutoMain">
            <h3>Dettagli del progetto <?= htmlspecialchars($progetto['nome']); ?> </h3>
            <div class='infoContainer'>
                <h4> Informazioni </h4>
                <p> Data di inserimento: <?= htmlspecialchars($progetto['data_inserimento']); ?> </p>
                <p> Data di fine: <?= htmlspecialchars($progetto['data_limite']); ?> </p>
                <div class='descrizione-container'>
                    <p> Descrizione: </p>
                    <textarea readonly> <?= htmlspecialchars($progetto['descrizione']); ?> </textarea>
                </div>
                <p> Stato: <?= htmlspecialchars($progetto['stato']) ?> </p>
                <p> Tipo: <?= htmlspecialchars($progetto['tipo']) ?> </p>
                <p> Budget d'avvio: <?= htmlspecialchars($progetto['budget']) ?> EUR </p>
                <p> Finaziamenti ricevuti: <?= htmlspecialchars($progetto['finanziamenti']) ?> EUR </p>
            </div>
            <div class='immaginiContainerWrapper'>
                <h4> Immagini del progetto </h4>
                <div class='immaginiContainer'>
                    <?php foreach($progetto['foto'] as $foto): ?>
                        <div>
                            <img src="/<?= htmlspecialchars(urldecode($foto['urlImmagine'])); ?>">
                            <p> <?= htmlspecialchars($foto['descrizione']); ?> </p>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php if(urldecode(explode('/', $_SERVER['REQUEST_URI'])[2]) === 'i-miei-progetti'): ?>
                    <div class="aggiungi" onclick="aggiungiFoto()">
                        <div class="plus-icon">+</div>
                        <p>Aggiungi Nuova Foto</p>
                    </div>  
                <?php endif; ?>
            </div>

            <div class='rewardsContainerWrapper'>
                <h4> Rewards del progetto </h4>
                <div class='rewardsContainer'>
                    <?php foreach($progetto['rewards'] as $reward): ?>
                        <div>
                            <img src="/<?= htmlspecialchars($reward['urlFoto']); ?>" alt="Reward">
                            <p> <?= htmlspecialchars($reward['descr']); ?> </p>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php if(urldecode(explode('/', $_SERVER['REQUEST_URI'])[2]) === 'i-miei-progetti'): ?>
                        <div class="aggiungi" onclick="aggiungiReward()">
                            <div class="plus-icon">+</div>
                            <p>Aggiungi Nuova Reward</p>
                        </div>  
                <?php endif; ?>
            </div>

            <?php if($progetto['tipo'] === 'Hardware'): ?>
                <div class='componentiContainer'>
                    <h4> Componenti </h4>
                    <table>
                        <thead>
                            <tr>
                                <th> Nome </th>
                                <th> Prezzo (&euro;)</th>
                                <th> Descrizione </th>
                                <th> Quantità </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($progetto['componenti'] as $componente): ?>
                                <tr>
                                    <td> <?= htmlspecialchars($componente['nome']); ?> </td>
                                    <td> <?= htmlspecialchars($componente['prezzo']); ?> </td>
                                    <td> <?= htmlspecialchars($componente['descr']); ?> </td>
                                    <td> <?= htmlspecialchars($componente['quantita']); ?> </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php if(urldecode(explode('/', $_SERVER['REQUEST_URI'])[2]) === 'i-miei-progetti'): ?>
                        <div class="aggiungi" onclick="aggiungiComponente()">
                            <div class="plus-icon">+</div>
                            <p>Aggiungi Nuova Componente</p>
                        </div>  
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <div class='contenitoreProfili'>
                    <h4> Profili richiesti </h4>
                    <a href='/home/<?= explode('/', $_SERVER['REQUEST_URI'])[2] ?>/<?= urlencode($progetto['nome']) ?>/profili'>
                        Profili richiesti per questo progetto
                    </a>
                </div>
            <?php endif; ?>
            <div class='contenitoreCommenti'>
                <h4> Commenti pubblicati </h4>
                <a href='/home/<?= explode('/', $_SERVER['REQUEST_URI'])[2] ?>/<?= urlencode($progetto['nome']) ?>/commenti'>
                    Visualizza i commenti pubblicati per questo progetto
                </a>
            </div>
        </div>
    </div>
    
    <?php require view('/home/home-footer.view.php'); ?>
    <?= AlertManager::show($errori ?? []) ?>
</body>

<script>
    const nomeProgetto = '<?= explode('/', $_SERVER['REQUEST_URI'])[3]; ?>';
    
     function aggiungiComponente() {
        window.location.href = `/home/i-miei-progetti/${nomeProgetto}/aggiungi-componente`;
    }

    function aggiungiReward() {
        window.location.href = `/home/i-miei-progetti/${nomeProgetto}/aggiungi-reward`;
    }

    function aggiungiFoto() {
        window.location.href = `/home/i-miei-progetti/${nomeProgetto}/aggiungi-foto`;
    }
</script>

</html>