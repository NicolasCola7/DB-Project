const skillsContainer = document.getElementById('skills');
const disponibili = document.getElementById('skills-disponibili');
const livello = document.getElementById('livello-richiesto');
const form = document.getElementById('form-profilo');
let contatoreSkills = 0;
let profili = document.querySelectorAll('.profilo');

// Funzione per aggiungere una skill
function aggiungiSkill() {
    const nomeSkill = disponibili.value;
    const livelloSkill = livello.value;
    
    if (nomeSkill && livelloSkill) {
        // Verifica se la skill è già stata aggiunta
        const esistente = document.querySelectorAll('.nome-skill');
        for (let i = 0; i < esistente.length; i++) {
            if (esistente[i].value === nomeSkill) {
                AlertManager.error('Questa skill è già stata aggiunta!');
                return;
            }
        }
        
        const skill = document.createElement('div');
        skill.className = 'skill';
        skill.innerHTML = `
            <input type="hidden" name="skills[${contatoreSkills}][nome]" value="${nomeSkill}" class="nome-skill" required>
            <input type="hidden" name="skills[${contatoreSkills}][livello]" value="${livelloSkill}" required>
            <div>
            <span id="nome-skill">${nomeSkill}</span>
            <span> ${livelloSkill} </span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="elimina-skill"> - </button>
        `;
        
        skillsContainer.appendChild(skill);
        contatoreSkills++;
        
        // Reset della selezione
        disponibili.selectedIndex = 0;
        livello.selectedIndex = 0;
    }
}


// Validazione del form prima dell'invio
form.addEventListener('submit', function(e) {
    const skills = document.querySelectorAll('.skill');
    
    if (skills.length === 0) {
        e.preventDefault();
        AlertManager.error('Devi inserire almeno una skill richiesta.');
    }
});

function prosegui() {
    if(profili.length === 0) {
        AlertManager.error('Devi inserire almeno 1 profilo prima di proseguire!');
    } else {
        window.location.href = '/home/crea-progetto/foto';
    }
}