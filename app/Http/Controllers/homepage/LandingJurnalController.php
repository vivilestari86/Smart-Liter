<?php

namespace App\Http\Controllers\homepage;

use App\Http\Controllers\Controller;
use App\Models\Journal;
use Illuminate\Support\Facades\Storage;

class LandingJurnalController extends Controller
{
    public function download(Journal $journal)
    {
        // route-model binding will automatically fetch or 404
        $path = $journal->pdf_path;

        if (!$path || !Storage::disk('public')->exists($path)) {
            abort(404, 'File PDF tidak ditemukan.');
        }

        $safeTitle = preg_replace('/[^A-Za-z0-9\-_ ]/', '', $journal->title ?? 'jurnal');
        $filename = trim(preg_replace('/\s+/', ' ', $safeTitle));
        if ($filename === '') $filename = 'jurnal';
        $filename .= '.pdf';

         $fullPath = Storage::disk('public')->path($path);
         return response()->download($fullPath, $filename, [
        'Content-Type' => 'application/pdf',
        ]);
    }

    public function view(Journal $journal)
    {
        $path = $journal->pdf_path;

        if (!$path || !Storage::disk('public')->exists($path)) {
            abort(404, 'File PDF tidak ditemukan.');
        }

        $fullPath = Storage::disk('public')->path($path);
        $safeTitle = preg_replace('/[^A-Za-z0-9\-_ ]/', '', $journal->title ?? 'jurnal');
        $filename = trim(preg_replace('/\s+/', ' ', $safeTitle));
        if ($filename === '') $filename = 'jurnal';
        $filename .= '.pdf';

        return response()->file($fullPath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$filename.'"',
        ]);
    }
}
