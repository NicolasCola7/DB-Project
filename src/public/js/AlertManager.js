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
}
