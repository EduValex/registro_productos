document.addEventListener("DOMContentLoaded", function () {
    const bodegaSelect = document.getElementById("bodega");
    const sucursalSelect = document.getElementById("sucursal");

    bodegaSelect.addEventListener("change", function () {
        let bodegaId = this.value;

        // Siempre agregar una opción vacía al inicio
        sucursalSelect.innerHTML = '<option value=""></option>';

        if (bodegaId) {
            fetch(`obtener_sucursales.php?bodega_id=${bodegaId}`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(sucursal => {
                        let option = document.createElement("option");
                        option.value = sucursal.id;
                        option.textContent = sucursal.nombre;
                        sucursalSelect.appendChild(option);
                    });
                })
                .catch(error => console.error("Error al cargar sucursales:", error));
        }
    });
});
