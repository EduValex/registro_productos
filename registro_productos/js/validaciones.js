document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("formProducto");

    // Capturar campos
    const codigoInput = document.getElementById("codigo");
    const nombreInput = document.getElementById("nombre");
    const precioInput = document.getElementById("precio");
    const descripcionInput = document.getElementById("descripcion");
    const bodegaSelect = document.getElementById("bodega");
    const sucursalSelect = document.getElementById("sucursal");
    const monedaSelect = document.getElementById("moneda");
    const materialesCheckboxes = document.querySelectorAll('input[name="materiales[]"]');

    // Crear mensaje de error para el código
    const codigoError = document.createElement("span");
    codigoError.style.color = "red";
    codigoError.style.fontSize = "12px";
    codigoError.style.display = "block";
    codigoInput.parentNode.appendChild(codigoError);

    let timeout = null;

    // Validar Código en tiempo real con delay
    codigoInput.addEventListener("input", function () {
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            let regexCodigo = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{5,15}$/;
            if (!regexCodigo.test(codigoInput.value.trim())) {
                codigoError.textContent = "⚠ El código debe contener letras y números (5-15 caracteres).";
            } else {
                codigoError.textContent = "";
            }
        }, 500);
    });

    // Validar Precio (cambiado a `text` en el HTML)
    precioInput.addEventListener("input", function () {
        let valor = precioInput.value;

        // Permitir solo números, comas y puntos
        if (!/^[\d,.]*$/.test(valor)) {
            precioInput.value = valor.slice(0, -1); // Borra el último carácter inválido
        }

        // Reemplazar comas por puntos automáticamente
        precioInput.value = precioInput.value.replace(/,/g, ".");
    });

    // **Validaciones al enviar el formulario**
    form.addEventListener("submit", function (event) {
        let errores = [];

        // Código
        if (codigoInput.value.trim() === "") {
            errores.push("El código del producto no puede estar en blanco.");
        }

        // Nombre
        if (nombreInput.value.trim().length < 2 || nombreInput.value.trim().length > 50) {
            errores.push("El nombre del producto debe tener entre 2 y 50 caracteres.");
        }

        // Precio
        if (!/^\d+(\.\d{1,2})?$/.test(precioInput.value.trim()) || parseFloat(precioInput.value.trim()) <= 0) {
            errores.push("El precio debe ser un número positivo con hasta dos decimales.");
        }

        // Descripción
        if (descripcionInput.value.trim().length < 10 || descripcionInput.value.trim().length > 1000) {
            errores.push("La descripción del producto debe tener entre 10 y 1000 caracteres.");
        }

        // Bodega, Sucursal y Moneda (deben tener una opción vacía al inicio)
        if (bodegaSelect.value === "") errores.push("Debe seleccionar una bodega.");
        if (sucursalSelect.value === "") errores.push("Debe seleccionar una sucursal.");
        if (monedaSelect.value === "") errores.push("Debe seleccionar una moneda.");

        // Materiales (mínimo 2 seleccionados)
        let materialesSeleccionados = Array.from(materialesCheckboxes).filter(m => m.checked).length;
        if (materialesSeleccionados < 2) {
            errores.push("Debe seleccionar al menos dos materiales.");
        }

        // Mostrar errores
        if (errores.length > 0) {
            event.preventDefault();
            alert(errores.join("\n"));
        }
    });
});
