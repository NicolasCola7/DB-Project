class AlertManager {
    static success(msg) {
        Swal.fire({
            title: 'Successo!',
            text: msg,
            icon: 'success',
            confirmButtonText: 'OK'
        });
    }

    static warning(msg) {
        Swal.fire({
            title: 'Attenzione!',
            text: msg,
            icon: 'warning',
            confirmButtonText: 'OK'
        });
    }

    static error(msg) {
        Swal.fire({
            title: 'Errore!',
            text: msg,
            icon: 'error',
            confirmButtonText: 'OK'
        });
    }

    static confirmAction({ title, text, confirmText = 'Sì, procedi', cancelText = 'Annulla', onConfirm }) {
        Swal.fire({
            title: title,
            text: text,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: confirmText,
            cancelButtonText: cancelText,
            customClass: {
                confirmButton: "my-confirm-button",
                cancelButton: "my-cancel-button"
            }
        }).then(result => {
            if (result.isConfirmed && typeof onConfirm === 'function') {
                onConfirm();
            }
        });
    }
}
