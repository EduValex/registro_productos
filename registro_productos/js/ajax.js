document.addEventListener("DOMContentLoaded", function () {
    // Obtener elementos del formulario
    const form = document.getElementById("formProducto");
    if (form) { // Verificar si el formulario existe
        form.addEventListener("submit", function (event) {
            event.preventDefault(); // Evita el envío tradicional del formulario

            let formData = new FormData(form); // Captura los datos del formulario

            fetch("procesar_producto.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("✅ Producto agregado correctamente.");
                    form.reset(); // Limpia el formulario
                    actualizarListaProductos(); // Refresca la tabla (lo haremos en el siguiente paso)
                } else {
                    alert("❌ Error: " + data.message);
                }
            })
            .catch(error => {
                alert("❌ Error en la solicitud AJAX.");
                console.error(error);
            });
        });
    } else {
        console.warn("⚠️ Advertencia: El formulario 'formProducto' no existe en esta página.");
    }

    // Validación de código
    const codigoInput = document.getElementById("codigo");
    const mensajeCodigo = document.getElementById("mensajeCodigo");

    if (codigoInput && mensajeCodigo) { // Verificar si los elementos existen
        codigoInput.addEventListener("input", function () {
            let codigo = codigoInput.value.trim();

            if (codigo.length >= 5) {
                fetch("validar_codigo.php?codigo=" + encodeURIComponent(codigo))
                    .then(response => response.json())
                    .then(data => {
                        if (data.existe) {
                            mensajeCodigo.innerHTML = "❌ El código ya está registrado.";
                            mensajeCodigo.style.color = "red";
                        } else {
                            mensajeCodigo.innerHTML = "✅ Código disponible.";
                            mensajeCodigo.style.color = "green";
                        }
                    })
                    .catch(error => console.error("Error en la validación del código:", error));
            } else {
                mensajeCodigo.innerHTML = "";
            }
        });
    } else {
        console.warn("⚠️ Advertencia: Elementos para la validación del código no encontrados.");
    }
});
