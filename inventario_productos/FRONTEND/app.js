const API = 'http://127.0.0.1:8001';

function mostrarMensaje(msg) {
    const el = document.getElementById('mensaje');
    el.innerText = msg;
    setTimeout(() => el.innerText = '', 4000);
}

async function listar() {
    try {
        const res = await fetch(`${API}/productos`);
        const datos = await res.json();
        const cont = document.getElementById('lista');
        if (!Array.isArray(datos)) {
            cont.innerText = 'Error al obtener lista';
            return;
        }
        if (datos.length === 0) { cont.innerHTML = '<i>No hay productos</i>'; return; }

        let html = '<table><thead><tr><th>ID</th><th>Nombre</th><th>Precio</th><th>Cantidad</th><th>Acciones</th></tr></thead><tbody>';
        datos.forEach(p => {
            html += `<tr><td>${p.id}</td><td>${p.nombre}</td><td>${p.precio}</td><td>${p.cantidad}</td>` +
                `<td class="actions">` +
                `<button onclick="cargarEditar(${p.id}, '${escapeHtml(p.nombre)}', ${p.precio}, ${p.cantidad})">Editar</button>` +
                `<button class="delete" onclick="eliminar(${p.id})">Eliminar</button>` +
                `</td></tr>`;
        });
        html += '</tbody></table>';
        cont.innerHTML = html;
    } catch (e) {
        console.error(e);
        document.getElementById('lista').innerText = 'Error al listar productos';
    }
}

function escapeHtml(str) {
    return String(str).replace(/'/g, "\\'").replace(/"/g, '&quot;');
}

function cargarEditar(id, nombre, precio, cantidad) {
    document.getElementById('editarId').value = id;
    document.getElementById('editarNombre').value = nombre;
    document.getElementById('editarPrecio').value = precio;
    document.getElementById('editarCantidad').value = cantidad;
    window.scrollTo(0, document.body.scrollHeight);
}

document.getElementById('formCrear').addEventListener('submit', async function (e) {
    e.preventDefault();
    const nombre = document.getElementById('nombre').value;
    const precio = parseFloat(document.getElementById('precio').value);
    const cantidad = parseInt(document.getElementById('cantidad').value, 10);
    try {
        const res = await fetch(`${API}/productos`, {
            method: 'POST', headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ nombre, precio, cantidad })
        });
        const data = await res.json();
        mostrarMensaje(data.mensaje || 'Creado');
        listar();
    } catch (e) { console.error(e); mostrarMensaje('Error al crear'); }
});

document.getElementById('btnListar').addEventListener('click', listar);

document.getElementById('formEditar').addEventListener('submit', async function (e) {
    e.preventDefault();
    const id = parseInt(document.getElementById('editarId').value, 10);
    const nombre = document.getElementById('editarNombre').value;
    const precio = parseFloat(document.getElementById('editarPrecio').value);
    const cantidad = parseInt(document.getElementById('editarCantidad').value, 10);
    try {
        const res = await fetch(`${API}/productos/${id}`, {
            method: 'PUT', headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ nombre, precio, cantidad })
        });
        const data = await res.json();
        mostrarMensaje(data.mensaje || 'Actualizado');
        listar();
    } catch (e) { console.error(e); mostrarMensaje('Error al actualizar'); }
});

document.getElementById('formEliminar').addEventListener('submit', async function (e) {
    e.preventDefault();
    const id = parseInt(document.getElementById('eliminarId').value, 10);
    try {
        const res = await fetch(`${API}/productos/${id}`, { method: 'DELETE' });
        const data = await res.json();
        mostrarMensaje(data.mensaje || 'Eliminado');
        listar();
    } catch (e) { console.error(e); mostrarMensaje('Error al eliminar'); }
});

async function eliminar(id) {
    if (!confirm('Eliminar producto ID ' + id + '?')) return;
    try {
        const res = await fetch(`${API}/productos/${id}`, { method: 'DELETE' });
        const data = await res.json();
        mostrarMensaje(data.mensaje || 'Eliminado');
        listar();
    } catch (e) { console.error(e); mostrarMensaje('Error al eliminar'); }
}

// Iniciar listado al cargar
listar();
