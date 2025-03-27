<?php 
use core\AlertManager; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Bostarter</title>
    <link rel='stylesheet' type='text/css' href='/public/styles/candidature/ottieni-candidature.style.css'>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <?php require view('/home/home-nav.view.php'); ?>
    
    <div class="main">
        <?php require view('/home/home-sidebar.view.php'); ?>
        
        <div class="contenutoMain">
            <h3>Le mie candidature</h3>
            <div class="filter-container">
                <label for="filtroCandidature">Filtra per stato: </label>
                <select id="filtroCandidature">
                    <option value="tutte">Tutte</option>
                    <option value="pending">Aperta</option>
                    <option value="accepted">Accettata</option>
                    <option value="rejected">Rifiutata</option>
                </select>
            </div>

            <div id="candidature">
                <?php if (!empty($candidature)): ?>
                    <?php foreach ($candidature as $candidatura): ?>
                        <?php
                            $status = 'pending'; // Valore predefinito

                            if ($candidatura['stato'] === 'chiusa' && $candidatura['accettata'] == 1) {
                                $status = 'accepted';
                            } elseif ($candidatura['stato'] === 'chiusa' && $candidatura['accettata'] == 0) {
                                $status = 'rejected';
                            }
                            ?>
                            <div class="candidatura" data-status="<?= htmlspecialchars($status) ?>">
                            <div class="divImg">
                            <img src="/<?= htmlspecialchars(urldecode($candidatura['logoProgetto'])); ?>">
                            </div>
                            <div class="divInfo">
                                <div class="info-row">
                                    <strong>Progetto:</strong>
                                    <a href="/home/progetti/<?= urlencode($candidatura['nomeProgetto']) ?>"><p><?= htmlspecialchars($candidatura['nomeProgetto']) ?></p></a>
                                </div>
                                <div class="info-row">
                                    <strong>Profilo:</strong>
                                    <a href="/home/progetti/<?= urlencode($candidatura['nomeProgetto']) ?>/profili/<?= urlencode($candidatura['nomeProfilo']) ?>/skills-richieste"><p><?= htmlspecialchars($candidatura['nomeProfilo']) ?></p></a>
                                </div>
                                <div class="status-badge 
                                    <?php 
                                        if ($candidatura['stato'] === 'chiusa' && $candidatura['accettata'] == 1) echo 'accepted';
                                        elseif ($candidatura['stato'] === 'chiusa' && $candidatura['accettata'] == 0) echo 'rejected';
                                        else echo 'pending';
                                    ?>">
                                    <?php 
                                        if ($candidatura['stato'] === 'chiusa' && $candidatura['accettata'] == 1) echo 'ACCETTATA';
                                        elseif ($candidatura['stato'] === 'chiusa' && $candidatura['accettata'] == 0) echo 'RIFIUTATA';
                                        else echo 'APERTA';
                                    ?>
                                </div>
                            </div>

                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Non hai ancora inviato nessuna candidatura.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?= AlertManager::show() ?>
    <?php require view('/home/home-footer.view.php'); ?>
</body>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filtroSelect = document.getElementById('filtroCandidature');
        const candidature = document.querySelectorAll('.candidatura');

        function filtraCandidature() {
            const statoSelezionato = filtroSelect.value.trim().toLowerCase();

            candidature.forEach(card => {
                const statoCard = card.getAttribute('data-status')?.trim().toLowerCase() || 'pending';
                if (statoSelezionato === 'tutte' || statoCard === statoSelezionato) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // Applichiamo subito il filtro all'avvio
        filtraCandidature();

        // Aggiungiamo l'evento di cambio selezione
        filtroSelect.addEventListener('change', filtraCandidature);
    });
</script>

</html>