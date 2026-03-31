<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agenda Laravel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body class="bg-light">
    <div class="container mt-4">
        <h2 class="text-center mb-4">Agenda Telefónica</h2>

        <div class="card p-4 mb-3 shadow-sm">
            <h5>Nuevo Registro</h5>
            <form id="agendaForm">
               <div class="card p-4 mb-3 shadow-sm">
            <h5>Nuevo Registro</h5>
            <form id="agendaForm">
                
                <input type="hidden" id="contactoId" value="">
                <div class="row g-2">
                    <div class="col-md-4">
                        <input type="text" id="nombre" class="form-control" placeholder="Nombre (Solo letras)" required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" id="telefono" class="form-control" placeholder="Teléfono (Solo números)" required>
                    </div>
                    <div class="col-md-3">
                        <input type="date" id="fecha_nacimiento" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">Guardar</button>
                    </div>
                </div>
            </form>
            <div id="errorFormulario" class="text-danger mt-2 small"></div>
        </div>
            </form>
            <div id="errorFormulario" class="text-danger mt-2 small"></div>
        </div>

        <div class="card p-3 mb-4 shadow-sm bg-white border-primary border-opacity-25">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <h6 class="mb-0 text-primary">🔍 Consultar Contactos:</h6>
                </div>
                <div class="col-md-8">
                    <input type="text" id="buscador" class="form-control border-primary" placeholder="Buscar por Nombre, Teléfono o ID...">
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover bg-white shadow-sm text-center">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Teléfono</th>
                        <th>Nacimiento</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="listaContactos"></tbody>
            </table>
        </div>
    </div>

    <script>
    
const form = document.getElementById('agendaForm');
const buscador = document.getElementById('buscador');
const errorDiv = document.getElementById('errorFormulario');
const btnGuardar = form.querySelector('button[type="submit"]');

// Validaciones 
document.getElementById('nombre').addEventListener('input', (e) => {
    if (/\d/.test(e.target.value)) errorDiv.innerText = "El nombre no debe contener números.";
    else errorDiv.innerText = "";
});

document.getElementById('telefono').addEventListener('input', (e) => {
    if (/[a-zA-Z]/.test(e.target.value)) errorDiv.innerText = "El teléfono no debe contener letras.";
    else errorDiv.innerText = "";
});

// carga
function cargarContactos(query = '') {
    axios.get(`/api/contactos?buscar=${query}`).then(res => {
        let html = '';
        if(res.data.length === 0) {
            html = '<tr><td colspan="5">No se encontraron resultados</td></tr>';
        } else {
            res.data.forEach(c => {
                html += `<tr>
                    <td>${c.id}</td>
                    <td>${c.nombre}</td>
                    <td>${c.telefono}</td>
                    <td>${c.fecha_nacimiento}</td>
                    <td>
                        <button type="button" onclick="prepararEdicion(${c.id})" class="btn btn-warning btn-sm">Editar</button>
                        <button type="button" onclick="eliminar(${c.id})" class="btn btn-danger btn-sm">Borrar</button>
                    </td>
                </tr>`;
            });
        }
        document.getElementById('listaContactos').innerHTML = html;
    });
}

// edicion
function prepararEdicion(id) {
    axios.get(`/api/contactos/${id}`).then(res => {
        const c = res.data;
        document.getElementById('contactoId').value = c.id;
        document.getElementById('nombre').value = c.nombre;
        document.getElementById('telefono').value = c.telefono;
        document.getElementById('fecha_nacimiento').value = c.fecha_nacimiento;
        
        btnGuardar.innerText = "Actualizar";
        btnGuardar.classList.remove('btn-primary');
        btnGuardar.classList.add('btn-success');
    }).catch(err => {
        console.error(err);
        alert("Hubo un problema al intentar cargar el contacto.");
    });
}

//eliminar
function eliminar(id) {
    if(confirm('¿Seguro que deseas borrar este contacto?')) {
        axios.delete('/api/contactos/'+id)
            .then(() => cargarContactos(buscador ? buscador.value : ''))
            .catch(err => {
                console.error(err);
                alert("No se pudo eliminar el contacto.");
            });
    }
}

// guardar
form.onsubmit = (e) => {
    e.preventDefault();
    const id = document.getElementById('contactoId').value;
    const data = {
        nombre: document.getElementById('nombre').value,
        telefono: document.getElementById('telefono').value,
        fecha_nacimiento: document.getElementById('fecha_nacimiento').value
    };

    // para saber si guardo o edito
    const peticion = id ? axios.put(`/api/contactos/${id}`, data) : axios.post('/api/contactos', data);

    peticion.then(() => { 
        form.reset(); 
        document.getElementById('contactoId').value = "";
        btnGuardar.innerText = "Guardar";
        btnGuardar.classList.remove('btn-success');
        btnGuardar.classList.add('btn-primary');
        cargarContactos(buscador ? buscador.value : ''); 
    })
    
    .catch(err => {
        
        if (err.response && err.response.status === 422) {
            const errores = err.response.data.errors;
            let mensajeAlerta = "error:\n\n";
            
            
            for (let campo in errores) {
                mensajeAlerta += `❌ ${errores[campo][0]}\n`;
            }
            
            // ventanas emergente
            alert(mensajeAlerta);
        } else {
            // error que no contemple
            alert("Ocurrió un error inesperado al procesar la solicitud.");
            console.error(err);
        }
    });
};

// Buscador
if(buscador) {
    buscador.addEventListener('input', (e) => cargarContactos(e.target.value));
}

// Carga
cargarContactos();
</script>
</body>
</html>