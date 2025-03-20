<html>
    <head>
        <link rel='stylesheet' type='text/css' href='/public/styles/creazione-progetto/upload.style.css'>
    </head>
   
        <div class="file-drop-area">
            <span class="fake-btn">Scegli un file</span>
            <span class="file-msg">o alternativamente trascinane uno qui</span>
            <input class="file-input" name='foto' type="file" accept="image/png, image/jpeg, image/jpg, image/webp, image/avif" required>
        </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
        const fileDropArea = document.querySelector('.file-drop-area');
        const fileInput = fileDropArea.querySelector('.file-input');
        const fileMsg = fileDropArea.querySelector('.file-msg');
        
        // Evidenzia la drag area quando un file è trascinato sopra essa
        ['dragenter', 'dragover'].forEach(event => {
            fileDropArea.addEventListener(event, e => {
            e.preventDefault();
            highlight();
            });
        });
        
        ['dragleave', 'drop'].forEach(event => {
            fileDropArea.addEventListener(event, e => {
            e.preventDefault();
            unhighlight();
            });
        });
        
        // Gestione file droppato
        fileDropArea.addEventListener('drop', handleDrop);
        
        // Festione file inserito
        fileInput.addEventListener('change', function() {
            if (this.files.length > 0) {
            fileMsg.textContent = this.files[0].name;
            }
        });
        
        function highlight() {
            fileDropArea.classList.add('is-active');
        }
        
        function unhighlight() {
            fileDropArea.classList.remove('is-active');
        }
        
        function handleDrop(e) {
            e.preventDefault();
            const file = e.dataTransfer.files[0]; // Ottengo solo il primo file
            
            if (file) {
            fileMsg.textContent = file.name;
            
            // Aggiorno il file di input
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            fileInput.files = dataTransfer.files;
            
            // Triggera un change event
            const event = new Event('change');
            fileInput.dispatchEvent(event);
            }
        }
        });
    </script>
</html>