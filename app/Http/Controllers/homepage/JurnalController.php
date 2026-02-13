<?php

namespace App\Http\Controllers\homepage;

use App\Http\Controllers\Controller;
use App\Models\Journal;
use Illuminate\Support\Facades\Storage;

class JurnalController extends Controller
{
    public function download($id)
    {
        $jurnal = Journal::findOrFail($id);
        $path = $jurnal->pdf_path;

        if (!$path || !Storage::disk('public')->exists($path)) {
            abort(404, 'File PDF tidak ditemukan.');
        }

        $safeTitle = preg_replace('/[^A-Za-z0-9\-_ ]/', '', $jurnal->title ?? 'jurnal');
        $filename = trim(preg_replace('/\s+/', ' ', $safeTitle));
        if ($filename === '') $filename = 'jurnal';
        $filename .= '.pdf';

         $fullPath = Storage::disk('public')->path($path);
         return response()->download($fullPath, $filename, [
        'Content-Type' => 'application/pdf',
        ]);
    }
}
