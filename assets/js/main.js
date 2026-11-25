// La gestion complète des langues (FR / AR / EN) sera ajoutée dans une prochaine étape.
document.addEventListener('DOMContentLoaded', function () {
    const languageSelect = document.getElementById('languageSelect');
    if (languageSelect) {
        languageSelect.addEventListener('change', function () {
            // Le sélecteur est visuel dans cette première version.
            // La traduction et le passage RTL seront branchés ensuite.
            alert('La version ' + languageSelect.value.toUpperCase() + ' sera activée dans la prochaine étape.');
        });
    }
});
