
function toggleSkills(index) {
    const skillsContainer = document.getElementById('skills-container-' + index);
    const arrow = document.getElementById('arrow-' + index);
    
    skillsContainer.classList.toggle('hidden');
    arrow.classList.toggle('up');
}