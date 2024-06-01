/** utilizamos $(document).ready(function () para cargar automaticamente la funcion getProductos*/
$(document).ready(function (){
    getProductos();
});
/** La funcion AbrirModalCrearProducto vacia el formulario y abre el modal */
function abrirModalCrearProducto(){
    vaciarFormulario();
    $('#ModalCrearProducto').modal("show");
}
/**La funcion guardar producto nuevo realiza una validacion, si los campos requeridos estan vacios no deja avanzar
 * posteriormente utiliza una peticion de tipo fetch para enviar los datos del formulario al controlador
*/
async function guardarProductoNuevo() {
    var urlGuardarPublicacion = $('#urlGuardarPublicacion').val();
    if (!validarData()) {
        return false;
    }
    const response = await fetch(urlGuardarPublicacion, {
        method: 'POST',
        body: crearFormularioProducto()
    });
    var respuestaServicio = await response.json();
    if (respuestaServicio.STATUS == "FAIL") {
        console.log("Error");
    } else{
        getProductos();
        $('#ModalCrearProducto').modal("hide");
    }
}
/**La funcion async eliminar producto realiza una peticion tipo fetch para llevar el id y el token
 * hacia la funcion para eliminar el producto en el controlador
 */
async function eliminarProducto(id) {
    var formData = new FormData();
    formData.append('id', id);
    formData.append("_token", $('#_token').val());
    var urlEliminarProducto = $('#urlEliminarProducto').val();
    const response = await fetch(urlEliminarProducto, {
        method: 'POST',
        body: formData
    });
    var respuestaServicio = await response.json();
    if (respuestaServicio.STATUS == "FAIL") {
        console.log("Error");
    } else{
        getProductos();
    }
}
/**ValidarData valida que los campos en el formulario sean correctos s*/
function validarData() {
    var valido = true;
    var nombre = $('#txt_nombre_producto').val();
    var cantidad = $('#num_cantidad_producto').val();
    var existenciaBodega = $('#num_existencia_producto').val();
    var costo = $('#num_costo_producto').val();
    var precio = $('#num_precio_venta').val();
    $('#txt_nombre_producto_error').html('');
    $('#num_cantidad_producto_error').html('');
    $('#num_existencia_producto_error').html('');
    $('#num_costo_producto_error').html('');
    $('#num_precio_venta_error').html('');
    if (nombre.length < 1) {
        $('#txt_nombre_producto_error').html('Digite nombre de producto');
        valido = false;
    }
    if (nombre.length > 150) {
        $('#txt_nombre_producto_error').html('El nombre no debe ser mayor a 150 caracteres');
        valido = false;
    }
    if (cantidad.length < 1) {
        $('#num_cantidad_producto_error').html('Digite cantidad de productos');
        valido = false;
    }
    if (existenciaBodega.length < 1) {
        $('#num_existencia_producto_error').html('Digite existencia en bodega');
        valido = false;
    }
    if (costo.length < 1) {
        $('#num_costo_producto_error').html('Digite el costo del producto');
        valido = false;
    }
    if (precio.length < 1) {
        $('#num_precio_venta_error').html('Digite el precio de venta');
        valido = false;
    }
    return valido;
}
/**la funcion crearFormularioProducto crea un formulario utilizando formData y lo retorna*/
function crearFormularioProducto() {
    var form = new FormData();
    form.append('num_id_producto', document.getElementById('num_id_producto').value);
    form.append('txt_nombre_producto', document.getElementById('txt_nombre_producto').value);
    form.append('num_cantidad_producto', document.getElementById('num_cantidad_producto').value);
    form.append('num_existencia_producto', document.getElementById('num_existencia_producto').value);
    form.append('num_costo_producto', document.getElementById('num_costo_producto').value);
    form.append('num_precio_venta', document.getElementById('num_precio_venta').value);
    form.append('chk_disponible_bodega', document.getElementById('chk_disponible_bodega').checked ? 'S' : 'N');
    form.append('_token', document.querySelector('input[name="_token"]').value);
    return form;
}
/**La funcion validarTipoGuardado determina si el formulario posee un id 
 * en caso de tenerlo lo envia a la funcion para editar y en caso de no tenerlo 
 * lo envia a la funcion guardar formulario nuevo
 * luego de las validaciones vacia el formulario
*/
function validarTipoGuardado() {
    if ($('#num_id_producto').val() != '0' && $('#num_id_producto').val() != '' && parseInt($('#num_id_producto').val()) >0) {
        guardarEdicion();
    }else{
        guardarProductoNuevo();
    }
    vaciarFormulario();
}

/**la funcion vaciarFormulario vacia los inputs y coloca como false la propiedad checked del input type check
 * para evitar que al abrir un formulario este contenfa los datos del anterior producto
 */
function vaciarFormulario() {
    $('#num_id_producto').val('');
    $('#txt_nombre_producto').val('');
    $('#num_cantidad_producto').val('');
    $('#num_existencia_producto').val('');
    $('#num_costo_producto').val('');
    $('#num_precio_venta').val('');
    $('#chk_disponible_bodega').prop("checked", false);
}

/**la funcion guardarEdicion envia los datos a la funcion update del controlador atravez de fetch */
async function guardarEdicion() {
    var urlEditarProducto = $('#urlEditarProducto').val();
    if (!validarData()) {
        return false;
    }
    const response = await fetch(urlEditarProducto, {
        method: 'POST',
        body: crearFormularioProducto()
    });
    var respuestaServicio = await response.json();
    if (respuestaServicio.STATUS == "FAIL") {
        console.log("Error");
    } else{
        getProductos();
        $('#ModalCrearProducto').modal("hide");
    }
}
/**la funcion getProductos realiza una peticion ajax a la funcion getProductos del controlador
 * posteriormente en caso de que sea exitosa coloca los datos en la tabla con id bodyTablaProductos
 * ademas utiliza buscarNombre como datos adicionales para mostrar especificamente
 * aquellos campos en donde el nombre se coincida
*/
function getProductos(){
    var datosFiltro = buscarNombre();
    $.ajax({
        url: '/getProductos',
        method: 'POST',
        dataType: 'html',
        data: datosFiltro,
        success: function(data) {
            $('#bodyTablaProducto').html(data);
        },
        error: function(error) {
            console.error('Error en la solicitud AJAX:', error);
        }
    }); 
}
/**la funcion buscarNombre devuelve el campo del buscador*/
function buscarNombre() {
    return {
        nombre:$('#search_nombre').val(),
        _token:$('#_token').val()
    }
}

/**la funcion obtenerDataProducto realiza una peticion de tipo fetch y recibe como resultado
 * respuestaServicio.DATA la cual es utilizada para colocar los datos en el formulario de edicion
 */
async function obtenerDataProducto(id){
    vaciarFormulario();
    var urlObtenerProducto = $('#urlObtenerProducto').val();
    var formData = new FormData();
    formData.append('id' , id);
    formData.append('_token' , $('#_token').val());
    const response = await fetch(urlObtenerProducto, {
        method: 'POST',
        body: formData
    });
    var respuestaServicio = await response.json();
    if (respuestaServicio.STATUS == "FAIL") {
        return null;
    } else{
        $('#num_id_producto').val( respuestaServicio.DATA.id);
        $('#txt_nombre_producto').val( respuestaServicio.DATA.nombre);
        $('#num_cantidad_producto').val(respuestaServicio.DATA.cantidad);
        $('#num_existencia_producto').val(respuestaServicio.DATA.existencias_bodega);
        $('#num_costo_producto').val(respuestaServicio.DATA.costo);
        $('#num_precio_venta').val(respuestaServicio.DATA.precio_venta);
        $('#chk_disponible_bodega').prop("checked", respuestaServicio.DATA.disponible_bodega=='S'?true:false);
        $('#ModalCrearProducto').modal("show");
    }
}
