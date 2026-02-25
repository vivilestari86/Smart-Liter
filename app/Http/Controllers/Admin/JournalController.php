<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Journal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JournalController extends Controller
{
    public function index()
    {
        $journals = Journal::orderBy('created_at', 'desc')->paginate(10);
        $total = Journal::count();
        $publishedCount = Journal::where('status', 'Publish')->count();
        $draftCount = Journal::where('status', 'Draft')->count();

        return view('admin.jurnal.index', compact('journals', 'total', 'publishedCount', 'draftCount'));
    }

    public function create()
    {
        $journal = new Journal();

        return view('admin.jurnal.create', compact('journal'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'summary' => 'nullable|string',
            'status' => 'required|in:Draft,Publish',
            'published_at' => 'nullable|date',
            'pdf' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        if (isset($data['pdf'])) {
            $data['pdf_path'] = $request->file('pdf')->store('journals', 'public');
            unset($data['pdf']);
        }

        Journal::create($data);

        return redirect()->route('admin.jurnal.index')->with('success', 'Jurnal berhasil ditambahkan.');
    }

    public function edit(Journal $journal)
    {
        return view('admin.jurnal.edit', compact('journal'));
    }

    public function update(Request $request, Journal $journal)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'summary' => 'nullable|string',
            'status' => 'required|in:Draft,Publish',
            'published_at' => 'nullable|date',
            'pdf' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        if ($request->hasFile('pdf')) {
            if ($journal->pdf_path) {
                Storage::disk('public')->delete($journal->pdf_path);
            }
            $data['pdf_path'] = $request->file('pdf')->store('journals', 'public');
        }

        $journal->update($data);

        return redirect()->route('admin.jurnal.index')->with('success', 'Jurnal berhasil diperbarui.');
    }

    public function destroy(Journal $journal)
    {
        if ($journal->pdf_path) {
            Storage::disk('public')->delete($journal->pdf_path);
        }
        $journal->delete();

        return redirect()->route('admin.jurnal.index')->with('success', 'Jurnal berhasil dihapus.');
    }
}
