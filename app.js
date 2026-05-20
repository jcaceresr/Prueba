document.addEventListener('DOMContentLoaded', () => {
    
    cargarBodegas();
    cargarMonedas();

    // Escuchamos el cambio en Bodega para cargar las Sucursales
    const selectBodega = document.getElementById('bodega');
    selectBodega.addEventListener('change', (e) => {
        const idBodegaSeleccionada = e.target.value;
        cargarSucursales(idBodegaSeleccionada);
    });

    // formulario
    const formulario = document.getElementById('formularioProducto');
    formulario.addEventListener('submit', function(evento) {
        
        // evitamos que la pagina se recargue
        evento.preventDefault(); 

        // codigo del producto
        const codigo = document.getElementById('codigo').value.trim();
        if (codigo === "") {
            alert("El código del producto no puede estar en blanco."); 
            return;
        }
        const regexCodigo = /^(?=.*[a-zA-Z])(?=.*[0-9])[a-zA-Z0-9]+$/;
        if (!regexCodigo.test(codigo)) {
            alert("El código del producto debe contener letras y números");
            return;
        }
        if (codigo.length < 5 || codigo.length > 15) {
            alert("El código del producto debe tener entre 5 y 15 caracteres."); 
            return;
        }

        // nombre del producto
        const nombre = document.getElementById('nombre').value.trim();
        if (nombre === "") {
            alert("El nombre del producto no puede estar en blanco."); 
            return;
        }
        if (nombre.length < 2 || nombre.length > 50) {
            alert("El nombre del producto debe tener entre 2 y 50 caracteres.");
            return;
        }

        // bodega
        const bodega = document.getElementById('bodega').value;
        if (bodega === "") {
            alert("Debe seleccionar una bodega.");
            return;
        }

        // sucursal
        const sucursal = document.getElementById('sucursal').value;
        if (sucursal === "") {
            alert("Debe seleccionar una sucursal para la bodega seleccionada.");
            return;
        }

        // moneda
        const moneda = document.getElementById('moneda').value;
        if (moneda === "") {
            alert("Debe seleccionar una moneda para el producto.");
            return;
        }

        // precio
        const precio = document.getElementById('precio').value.trim();
        if (precio === "") {
            alert("El precio del producto no puede estar en blanco.");
            return;
        }
        const regexPrecio = /^\d+(\.\d{1,2})?$/;
        if (!regexPrecio.test(precio) || parseFloat(precio) <= 0) {
            alert("El precio del producto debe ser un número positivo con hasta dos decimales.");
            return;
        }

        // materiales
        const materialesMarcados = document.querySelectorAll('input[name="materiales[]"]:checked');
        if (materialesMarcados.length < 2) {
            alert("Debe seleccionar al menos dos materiales para el producto.");
            return;
        }

        // descripcion
        const descripcion = document.getElementById('descripcion').value.trim();
        if (descripcion === "") {
            alert("La descripción del producto no puede estar en blanco."); 
            return;
        }
        if (descripcion.length < 10 || descripcion.length > 1000) {
            alert("La descripción del producto debe tener entre 10 y 1000 caracteres."); 
            return;
        }

        verificarCodigoYGuardar(codigo);
    });
});


// ==========================================
// Funciones para cargar datos 

function cargarBodegas() {
    fetch('api/obtener_bodegas.php')
        .then(respuesta => respuesta.json())
        .then(datos => {
            const selectBodega = document.getElementById('bodega');
            selectBodega.innerHTML = '<option value=""></option>';
            datos.forEach(bodega => {
                const option = document.createElement('option');
                option.value = bodega.id;
                option.text = bodega.nombre;
                selectBodega.appendChild(option);
            });
        })
        .catch(error => console.error('Error al poblar bodegas:', error));
}

function cargarMonedas() {
    fetch('api/obtener_monedas.php')
        .then(respuesta => respuesta.json())
        .then(datos => {
            const selectMoneda = document.getElementById('moneda');
            selectMoneda.innerHTML = '<option value=""></option>';
            datos.forEach(moneda => {
                const option = document.createElement('option');
                option.value = moneda.id;
                option.text = `${moneda.nombre} (${moneda.simbolo})`;
                selectMoneda.appendChild(option);
            });
        })
        .catch(error => console.error('Error al poblar monedas:', error));
}

function cargarSucursales(bodegaId) {
    const selectSucursal = document.getElementById('sucursal');
    selectSucursal.innerHTML = '<option value=""></option>';
    if (!bodegaId) return;

    fetch(`api/obtener_sucursales.php?bodega_id=${bodegaId}`)
        .then(respuesta => respuesta.json())
        .then(datos => {
            datos.forEach(sucursal => {
                const option = document.createElement('option');
                option.value = sucursal.id;
                option.text = sucursal.nombre;
                selectSucursal.appendChild(option);
            });
        })
        .catch(error => console.error('Error al poblar sucursales:', error));
}

// Función que verifica si el código existe
function verificarCodigoYGuardar(codigo) {
    fetch(`api/verificar_codigo.php?codigo=${codigo}`)
        .then(respuesta => respuesta.json())
        .then(datos => {
            if (datos.existe) {
                alert("El código del producto ya está registrado.");
            } else {
                guardarProductoFinal();
            }
        })
        .catch(error => console.error('Error al verificar código:', error));
}

// Función que empaqueta y guarda el producto
function guardarProductoFinal() {
    // Volvemos a capturar el formulario directamente para asegurar que existe
    const formulario = document.getElementById('formularioProducto');
    const datosFormulario = new FormData(formulario);

    fetch('api/guardar_producto.php', {
        method: 'POST',
        body: datosFormulario
    })
    .then(respuesta => respuesta.json())
    .then(resultado => {
        if (resultado.exito) {
            alert("¡Producto guardado exitosamente!");
            formulario.reset(); 
            document.getElementById('sucursal').innerHTML = '<option value=""></option>';
        } else {
            alert("Error al guardar: " + resultado.error);
        }
    })
    .catch(error => console.error('Error en el guardado:', error));
}