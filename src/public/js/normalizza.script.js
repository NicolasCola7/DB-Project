function normalizza(input) {
    let valore = parseFloat(input);
    let valoreStr = valore.toString();

    // Divido la parte intera e decimale
    const parts = valoreStr.split('.');

    // Se ci sono più di 2 cifree decimali le tronco
    if (parts.length > 1) {
        const interi = parts[0];
        const decimali = parts[1].slice(0, 2);

        // Ricostruusco il numero con massimo 2 cifre decimali
        return parseFloat(`${interi}.${decimali.padEnd(2, '0')}`);
    } else {
        // Se non ci sono decimali aggiungo ".00"
        return parseFloat(`${parts[0]}.00`);
    }
}