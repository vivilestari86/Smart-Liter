<div class="form-group mb-3">
    <label for="title">Judul</label>
    <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $journal->title ?? '') }}" required>
</div>

<div class="form-group mb-3">
    <label for="author">Penulis</label>
    <input type="text" name="author" id="author" class="form-control" value="{{ old('author', $journal->author ?? '') }}">
</div>

<div class="form-group mb-3">
    <label for="summary">Ringkasan</label>
    <textarea name="summary" id="summary" class="form-control" rows="4">{{ old('summary', $journal->summary ?? '') }}</textarea>
</div>

<div class="form-group mb-3">
    <label for="status">Status</label>
    <select name="status" id="status" class="form-control">
        <option value="Draft" {{ old('status', $journal->status ?? '') === 'Draft' ? 'selected' : '' }}>Draft</option>
        <option value="Publish" {{ old('status', $journal->status ?? '') === 'Publish' ? 'selected' : '' }}>Publish</option>
    </select>
</div>

<div class="form-group mb-3">
    <label for="published_at">Tanggal Terbit</label>
    <input type="date" name="published_at" id="published_at" class="form-control" value="{{ old('published_at', optional($journal->published_at)->format('Y-m-d') ?? '') }}">
</div>

<div class="form-group mb-3">
    <label for="pdf">File PDF</label>
    @if(isset($journal) && $journal->pdf_path)
        <p><a href="{{ Storage::disk('public')->url($journal->pdf_path) }}" target="_blank">Lihat file saat ini</a></p>
    @endif
    <input type="file" name="pdf" id="pdf" class="form-control" accept="application/pdf">
</div>

@error('title')<div class="text-danger">{{ $message }}</div>@enderror
@error('pdf')<div class="text-danger">{{ $message }}</div>@enderror
