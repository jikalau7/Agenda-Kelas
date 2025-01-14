function updateJamAkhir() {
    var jamAwalSelected = document.querySelector('#jam_awal option:checked');
    var jamAwalValue = parseInt(jamAwalSelected ? jamAwalSelected.getAttribute('data-jam') : "0", 10);
    console.log("Jam Awal Value: ", jamAwalValue); 
    var jamAkhirSelect = document.getElementById('jam_akhir');

    if (isNaN(jamAwalValue) || jamAwalValue === 0) {
        jamAkhirSelect.disabled = true;  
    } else {
        jamAkhirSelect.disabled = false;  
    }
    var jamAkhirOptions = document.querySelectorAll("#jam_akhir option");
    jamAkhirOptions.forEach(function(option) {
        var jamAkhirValue = parseInt(option.getAttribute('data-jam'), 10);  
        console.log("Jam Akhir Value: ", jamAkhirValue); 
        if (!isNaN(jamAwalValue) && !isNaN(jamAkhirValue)) {
            if (jamAkhirValue >= jamAwalValue) {
                option.style.display = "block";  
            } else {
                option.style.display = "none"; 
            }
        }
    });
}
window.onload = updateJamAkhir;