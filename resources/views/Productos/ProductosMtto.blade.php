<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container-fluid">
        <div class="card mb-4">
            <div class="card-body">
                <div class="d-sm-flex align-items-center justify-content-between">
                    <h3 class="mb-0 bc-title">Mantenimiento de productos</h3>
                </div>
            </div>
        </div>
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="gd-resposive-table">
                    <button class="btn btn-success" onclick="abrirModalCrearProducto()">Agregar</button>
                    <a href="{{route('obtenerCSV')}}" class="btn btn-success">Exportar a CSV</a>
                    <div>
                        <input placeholder="Nombre" class="form-control" type="search"  id="search_nombre" onkeyup="getProductos();">
                    </div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Cantidad</th>
                                <th>Existencia en bodega</th>
                                <th>Disponible en bodega</th>
                                <th>Costo</th>
                                <th>Precio de venta</th>
                                <th>Fecha de creaci&oacute;n</th>
                                <th>Fecha de actualizaci&oacute;n</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody id="bodyTablaProducto">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="ModalCrearProducto" role="dialog" aria-labelledby="ModalCrearProductoLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalCrearProductoLabel">Agregar producto</h5>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="txt_nombre_producto">Nombre *</label>
                            <input type="text" class="form-control" id="txt_nombre_producto" name="txt_nombre_producto" placeholder="Producto xy">
                            <span class="text-danger" id="txt_nombre_producto_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="num_cantidad_producto">Cantidad *</label>
                            <input type="number" min="0" step="1" class="form-control" id="num_cantidad_producto" name="num_cantidad_producto" placeholder="1500">
                            <span class="text-danger" id="num_cantidad_producto_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="num_existencia_producto">Existencia en bodega *</label>
                            <input type="number"  min="0" step="1"class="form-control" id="num_existencia_producto" name="num_existencia_producto" placeholder="10">
                            <span class="text-danger" id="num_existencia_producto_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="num_costo_producto">Costo *</label>
                            <input type="number" min="0" step="0.01" class="form-control" id="num_costo_producto" name="num_costo_producto" placeholder="50.00">
                            <span class="text-danger" id="num_costo_producto_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="num_precio_venta">Precio de venta *</label>
                            <input type="number"  min="0" step="0.01"class="form-control" id="num_precio_venta" name="num_precio_venta" placeholder="50.00">
                            <span class="text-danger" id="num_precio_venta_error"></span>
                        </div>
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" name="chk_disponible_bodega" id="chk_disponible_bodega">
                            <label class="form-check-label" for="chk_disponible_bodega">Disponible en bodega</label>
                        </div>
                        <input type="hidden" name="" id="num_id_producto">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-success" onclick="validarTipoGuardado();">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</body>
<input type="hidden" id="urlEditarProducto" name="urlEditarProducto" value="{{route('editarProducto')}}">
<input type="hidden" id="urlGuardarPublicacion" name="urlGuardarPublicacion" value="{{route('guardarProductoNuevo')}}">
<input type="hidden" id="urlEliminarProducto" name="urlEliminarProducto" value="{{route('eliminarProducto')}}">
<input type="hidden" id="urlObtenerProducto" name="urlObtenerProducto" value="{{route('obtenerDataProducto')}}">
<input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="{{asset('js/Productos/ProductosMtto.js')}}"></script>
</html>