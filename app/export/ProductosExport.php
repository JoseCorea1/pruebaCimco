<?php
namespace App\export;

use App\Models\Productos;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ProductosExport implements FromView
{
    public function view(): View
    {
        return view('Productos.exportCSV', [
            'Productos' => Productos::all()
        ]);
    }
}

?>