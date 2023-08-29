<?php

namespace App\Http\Controllers\Admin;

use Storage;
use App\Models\Archive;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ArchiveController extends Controller
{


    public function show(Request $request, $id)
    {

        try {
            $archive = Archive::find($id);
            return Storage::download($archive->path);
        } catch (\Exception $e) {
            abort(404);
        }
    }
}
