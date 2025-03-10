<html>
    <head>
        <style>
            .file-drop-area {
                position: relative;
                display: flex;
                align-items: center;
                width: 450px;
                max-width: 100%;
                padding: 25px;
                border: 2px dashed lightgrey;
                border-radius: 3px;
                transition: 0.2s;
                background-color:white;
                text-align: center;
                margin: 0 auto;
            }

            .file-drop-area.is-active {
                background-color: white;
                border-color: #4AA3EF;
            }

            .fake-btn {
                flex-shrink: 0;
                background-color: rgba(74, 163, 239, 0.1);
                border: 1px solid rgba(74, 163, 239, 0.2);
                border-radius: 3px;
                padding: 8px 15px;
                margin-right: 10px;
                font-size: 12px;
                cursor: pointer;
            }

            .file-msg {
                color: #777;
                font-size: 14px;
                font-weight: 300;
                line-height: 1.4;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
                flex: 1;
            }

            .file-input {
                position: absolute;
                left: 0;
                top: 0;
                height: 100%;
                width: 100%;
                cursor: pointer;
                opacity: 0;
            }

            .file-input:focus {
                outline: none;
            }
        </style>
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