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
    <td>
        <button type="button" class="btn btn-primary btn-sm" onclick="obtenerDataProducto('{{$producto->id}}')">Editar</button>
        <button type="button" class="btn btn-danger btn-sm" onclick="eliminarProducto('{{ $producto->id}}')">Eliminar</button>
    </td>
</tr>    
@endforeach