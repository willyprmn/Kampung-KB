<?php

namespace App\Http\Controllers\Portal\Intervensi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\{
    Kampung,
    Intervensi,
};

class KategoriController extends Controller
{
    public function index(Request $request, $kampungId, $kategoriId)
    {
        $kampung = Kampung::find($kampungId);
        $intervensis = Intervensi::where('kampung_kb_id', $kampungId)
            ->where('kategori_id', $kategoriId)
            ->orderBy('tanggal')
            ->paginate();

        return view('portal.intervensi.index', compact('kampung', 'intervensis'));
    }
}
