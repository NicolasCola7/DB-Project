const proseguiBtn = document.getElementById('prosegui');
const form = document.getElementById('prosegui-form');
const budget = document.getElementById('budget');

form.addEventListener('submit', event => {
    event.preventDefault();

    if(budget.value) {
        if(normalizza(budget.value) > 999999999.99) {
            AlertManager.error('Il budget deve essere <= 999.999.999,99!');
        } else {
            form.submit();
        }
    }
});


    