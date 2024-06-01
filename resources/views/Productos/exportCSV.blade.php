<table>
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
        </tr>
    </thead>
    <tbody>
        @foreach ($Productos as $producto)
            <tr>
                <td>
                    {{$producto->id}}
                </td>
                <td>
                    {{$producto->nombre}}
                </td>
                <td>
                    {{$producto->cantidad}}
                </td>
                <td>
                    {{$producto->existencias_bodega}}
                </td>
                <td>
                    {{$producto->disponible_bodega=='S'?'Si':'No'}}
                </td>
                <td>
                    {{$producto->costo}}
                </td>
                <td>
                    {{$producto->precio_venta}}
                </td>
                <td>
                    {{$producto->created_at}}
                </td>
                <td>
                    {{$producto->updated_at}}
                </td>
            </tr>    
        @endforeach
    </tbody>
</table>