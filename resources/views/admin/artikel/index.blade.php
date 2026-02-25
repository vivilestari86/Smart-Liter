@extends('admin.layouts.app')
@section('title', 'Kelola Jurnal')

@section('content')
<div class="journal-management">
  {{-- Header Section --}}
  <div class="header-wrapper">
    <div class="header-content">
      <h1 class="page-title">Kelola Jurnal & Publikasi</h1>
      <p class="page-subtitle">Atur card jurnal yang tampil di menu Jurnal pada halaman user.</p>
    </div>
    
    <div class="header-actions">
      <a href="#" class="btn btn-primary">
        <svg class="icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M12 5v14M5 12h14"/>
        </svg>
        Tambah Jurnal Baru
      </a>
    </div>
  </div>

  {{-- Stats Cards --}}
  <div class="stats-grid">
    <div class="stat-card">
      <div class="stat-icon" style="background: #e3f2fd; color: #1976d2;">📊</div>
      <div class="stat-info">
        <span class="stat-value">12</span>
        <span class="stat-label">Total Jurnal</span>
      </div>
    </div>
    <div class="stat-card">
      <div class="stat-icon" style="background: #e8f5e8; color: #2e7d32;">📄</div>
      <div class="stat-info">
        <span class="stat-value">8</span>
        <span class="stat-label">Published</span>
      </div>
    </div>
    <div class="stat-card">
      <div class="stat-icon" style="background: #fff3e0; color: #ed6c02;">✏️</div>
      <div class="stat-info">
        <span class="stat-value">4</span>
        <span class="stat-label">Draft</span>
      </div>
    </div>
  </div>

  {{-- Filter & Search Bar --}}
  <div class="filter-section">
    <div class="search-wrapper">
      <svg class="search-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#666">
        <circle cx="11" cy="11" r="8"/>
        <path d="M21 21l-4.35-4.35"/>
      </svg>
      <input type="text" class="search-input" placeholder="Cari jurnal...">
    </div>
    
    <div class="filter-actions">
      <select class="filter-select">
        <option>Semua Status</option>
        <option>Published</option>
        <option>Draft</option>
      </select>
      <button class="btn btn-light">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor">
          <path d="M22 3H2l8 9.46V19l4 2v-8.54L22 3z"/>
        </svg>
        Filter
      </button>
    </div>
  </div>

  {{-- Journal List --}}
  <div class="journal-list">
    <div class="list-header">
      <h2 class="list-title">Daftar Jurnal</h2>
      <span class="item-count">Menampilkan 2 dari 12 jurnal</span>
    </div>

    {{-- Journal Cards View (Alternative to table for better mobile experience) --}}
    @php
      $items = [
        [
          'id'=>1,
          'title'=>'Evaluasi Sistem Irigasi Cerdas',
          'author'=>'Dr. Ahmad Santoso, M.Sc',
          'desc'=>'Analisis efisiensi irigasi tetes pada tanaman cabai menggunakan sensor kelembaban tanah.',
          'version'=>'Vol. 1',
        
          'status'=>'Publish',
          'cover'=>null,
          'date'=>'2024-01-15',
        ],
        [
          'id'=>2,
          'title'=>'Pertanian Hidroponik Modern',
          'author'=>'Prof. Sinta Dewi',
          'desc'=>'Studi kasus pengembangan hidroponik untuk lahan sempit.',
          'version'=>'Vol. 2',
          'tags'=>['PDF'],
          'status'=>'Draft',
          'cover'=>null,
          'date'=>'2024-02-20',
        ],
      ];
    @endphp

    @foreach($items as $it)
    <div class="journal-card">
      <div class="journal-card-left">
        <div class="journal-cover">
          @if($it['cover'])
            <img src="{{ $it['cover'] }}" alt="Cover">
          @else
            <div class="cover-placeholder">
              <span class="placeholder-icon">📰</span>
            </div>
          @endif
        </div>
        
        <div class="journal-info">
          <div class="journal-header">
            <h3 class="journal-title">{{ $it['title'] }}</h3>
            <span class="status-badge {{ $it['status'] === 'Publish' ? 'status-published' : 'status-draft' }}">
              {{ $it['status'] }}
            </span>
          </div>
          
          <p class="journal-description">{{ $it['desc'] }}</p>
          
          <div class="journal-meta">
            <span class="meta-item">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                <circle cx="12" cy="7" r="4"/>
              </svg>
              {{ $it['author'] }}
            </span>
            <span class="meta-item">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                <line x1="16" y1="2" x2="16" y2="6"/>
                <line x1="8" y1="2" x2="8" y2="6"/>
                <line x1="3" y1="10" x2="21" y2="10"/>
              </svg>
              {{ $it['date'] }}
            </span>
          </div>
          
        </div>
      </div>
      
      <div class="journal-card-right">
        <div class="action-buttons">
          <button class="action-btn preview-btn js-preview" 
                  data-title="{{ $it['title'] }}"
                  data-author="{{ $it['author'] }}"
                  data-desc='{{ $it["desc"] }}'
                 
                  title="Preview">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <circle cx="12" cy="12" r="2"/>
              <path d="M22 12c-2.667 4.667-6 7-10 7s-7.333-2.333-10-7c2.667-4.667 6-7 10-7s7.333 2.333 10 7z"/>
            </svg>
          </button>
          
          <a href="#" class="action-btn edit-btn" title="Edit">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <path d="M20 14.66V20a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h5.34"/>
              <polygon points="18 2 22 6 12 16 8 16 8 12 18 2"/>
            </svg>
          </a>
          
          <button class="action-btn delete-btn" onclick="return confirm('Hapus jurnal ini?')" title="Hapus">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <polyline points="3 6 5 6 21 6"/>
              <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0h10"/>
              <line x1="10" y1="11" x2="10" y2="17"/>
              <line x1="14" y1="11" x2="14" y2="17"/>
            </svg>
          </button>
        </div>
      </div>
    </div>
    @endforeach

    {{-- Pagination --}}
    <div class="pagination">
      <button class="page-btn" disabled>‹</button>
      <button class="page-btn active">1</button>
      <button class="page-btn">2</button>
      <button class="page-btn">3</button>
      <span class="page-dots">...</span>
      <button class="page-btn">8</button>
      <button class="page-btn">›</button>
    </div>
  </div>
</div>

{{-- Preview Modal --}}
<div class="modal" id="prevModal">
  <div class="modal-overlay" id="prevClose"></div>
  <div class="modal-container">
    <div class="modal-header">
      <h3 class="modal-title">Preview Jurnal</h3>
      <button class="modal-close" id="prevX">×</button>
    </div>
    
    <div class="modal-content">
      <div class="preview-card-detailed">
        <div class="preview-cover">
          <div class="preview-cover-icon">📄</div>
        </div>
        
        <div class="preview-details">
          <h4 class="preview-title" id="pTitle"></h4>
          
          <div class="preview-metadata">
            <div class="preview-meta-item">
              <span class="meta-label">Penulis:</span>
              <span class="meta-value" id="pAuthor"></span>
            </div>
            <div class="preview-meta-item">
              <span class="meta-value" id="pVer"></span>
            </div>
          </div>
          
          <div class="preview-abstract">
            <h5>Abstrak</h5>
            <p id="pDesc"></p>
          </div>
          
         
          
          <div class="preview-actions">
            <button class="btn btn-primary">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                <polyline points="7 10 12 15 17 10"/>
                <line x1="12" y1="15" x2="12" y2="3"/>
              </svg>
              Download PDF
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
.journal-management {
  max-width: 1200px;
  margin: 0 auto;
  padding: 24px;
  font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

/* Header Styles */
.header-wrapper {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 32px;
  flex-wrap: wrap;
  gap: 16px;
}

.page-title {
  font-size: 28px;
  font-weight: 700;
  color: #1a1a1a;
  margin: 0 0 8px 0;
}

.page-subtitle {
  font-size: 15px;
  color: #666;
  margin: 0;
}

/* Button Styles */
.btn {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 10px 20px;
  border-radius: 12px;
  font-weight: 600;
  font-size: 14px;
  transition: all 0.2s ease;
  cursor: pointer;
  border: none;
  text-decoration: none;
}

.btn-primary {
  background: #2e7d32;
  color: white;
}

.btn-primary:hover {
  background: #1b5e20;
  transform: translateY(-2px);
  box-shadow: 0 8px 16px rgba(46, 125, 50, 0.2);
}

.btn-light {
  background: #f5f5f5;
  color: #333;
  border: 1px solid #e0e0e0;
}

.btn-light:hover {
  background: #eeeeee;
}

/* Stats Cards */
.stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
  gap: 20px;
  margin-bottom: 32px;
}

.stat-card {
  background: white;
  border-radius: 20px;
  padding: 24px;
  display: flex;
  align-items: center;
  gap: 16px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
  border: 1px solid #f0f0f0;
  transition: transform 0.2s ease;
}

.stat-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.06);
}

.stat-icon {
  width: 52px;
  height: 52px;
  border-radius: 18px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 24px;
}

.stat-info {
  display: flex;
  flex-direction: column;
}

.stat-value {
  font-size: 28px;
  font-weight: 700;
  color: #1a1a1a;
  line-height: 1.2;
}

.stat-label {
  font-size: 14px;
  color: #666;
}

/* Filter Section */
.filter-section {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 24px;
  flex-wrap: wrap;
  gap: 16px;
  background: white;
  padding: 16px 20px;
  border-radius: 16px;
  border: 1px solid #f0f0f0;
}

.search-wrapper {
  position: relative;
  flex: 1;
  min-width: 280px;
}

.search-icon {
  position: absolute;
  left: 14px;
  top: 50%;
  transform: translateY(-50%);
  color: #999;
}

.search-input {
  width: 100%;
  padding: 12px 16px 12px 44px;
  border: 2px solid #f0f0f0;
  border-radius: 12px;
  font-size: 14px;
  transition: all 0.2s ease;
  background: #fafafa;
}

.search-input:focus {
  outline: none;
  border-color: #2e7d32;
  background: white;
}

.filter-actions {
  display: flex;
  gap: 12px;
}

.filter-select {
  padding: 10px 16px;
  border: 2px solid #f0f0f0;
  border-radius: 12px;
  font-size: 14px;
  color: #333;
  background: #fafafa;
  cursor: pointer;
}

.filter-select:focus {
  outline: none;
  border-color: #2e7d32;
}

/* Journal List Header */
.list-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
}

.list-title {
  font-size: 20px;
  font-weight: 600;
  color: #333;
  margin: 0;
}

.item-count {
  font-size: 14px;
  color: #999;
  background: #f5f5f5;
  padding: 4px 12px;
  border-radius: 20px;
}

/* Journal Cards */
.journal-list {
  display: flex;
  flex-direction: column;
  gap: 16px;
}

.journal-card {
  background: white;
  border-radius: 24px;
  padding: 24px;
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  border: 1px solid #f0f0f0;
  transition: all 0.3s ease;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
}

.journal-card:hover {
  border-color: #2e7d32;
  box-shadow: 0 12px 32px rgba(46, 125, 50, 0.08);
  transform: translateY(-2px);
}

.journal-card-left {
  display: flex;
  gap: 24px;
  flex: 1;
}

.journal-cover {
  width: 100px;
  height: 120px;
  border-radius: 16px;
  overflow: hidden;
  background: #f8f9fa;
  flex-shrink: 0;
}

.cover-placeholder {
  width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  background: linear-gradient(135deg, #f5f7fa 0%, #e4e7eb 100%);
}

.placeholder-icon {
  font-size: 32px;
  opacity: 0.5;
}

.journal-info {
  flex: 1;
}

.journal-header {
  display: flex;
  align-items: center;
  gap: 12px;
  margin-bottom: 8px;
  flex-wrap: wrap;
}

.journal-title {
  font-size: 18px;
  font-weight: 700;
  color: #1a1a1a;
  margin: 0;
}

.status-badge {
  padding: 4px 12px;
  border-radius: 100px;
  font-size: 12px;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.status-published {
  background: #e8f5e8;
  color: #2e7d32;
}

.status-draft {
  background: #fff3e0;
  color: #ed6c02;
}

.journal-description {
  font-size: 14px;
  color: #666;
  line-height: 1.6;
  margin: 8px 0 12px 0;
}

.journal-meta {
  display: flex;
  gap: 20px;
  margin-bottom: 12px;
  flex-wrap: wrap;
}

.meta-item {
  display: flex;
  align-items: center;
  gap: 6px;
  font-size: 13px;
  color: #666;
}

.meta-item svg {
  color: #999;
}

.journal-tags {
  display: flex;
  gap: 8px;
  flex-wrap: wrap;
}



.journal-card-right {
  display: flex;
  align-items: center;
  padding-left: 20px;
  border-left: 2px solid #f0f0f0;
}

.action-buttons {
  display: flex;
  gap: 8px;
}

.action-btn {
  width: 40px;
  height: 40px;
  border-radius: 12px;
  border: none;
  background: #f5f5f5;
  color: #555;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.2s ease;
  text-decoration: none;
}

.action-btn:hover {
  transform: translateY(-2px);
}

.preview-btn:hover {
  background: #e3f2fd;
  color: #1976d2;
}

.edit-btn:hover {
  background: #fff3e0;
  color: #ed6c02;
}

.delete-btn:hover {
  background: #ffebee;
  color: #c62828;
}

/* Pagination */
.pagination {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 8px;
  margin-top: 32px;
}

.page-btn {
  min-width: 40px;
  height: 40px;
  border-radius: 12px;
  border: 2px solid #f0f0f0;
  background: white;
  color: #555;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s ease;
  display: flex;
  align-items: center;
  justify-content: center;
}

.page-btn:hover:not(:disabled) {
  border-color: #2e7d32;
  color: #2e7d32;
}

.page-btn.active {
  background: #2e7d32;
  color: white;
  border-color: #2e7d32;
}

.page-btn:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.page-dots {
  color: #999;
  padding: 0 4px;
}

/* Modal Styles */
.modal {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 1000;
}

.modal.open {
  display: block;
}

.modal-overlay {
  position: absolute;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  backdrop-filter: blur(4px);
}

.modal-container {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background: white;
  border-radius: 32px;
  width: 90%;
  max-width: 700px;
  max-height: 90vh;
  overflow-y: auto;
  box-shadow: 0 32px 64px rgba(0, 0, 0, 0.2);
}

.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 24px 32px;
  border-bottom: 2px solid #f5f5f5;
}

.modal-title {
  font-size: 24px;
  font-weight: 700;
  color: #1a1a1a;
  margin: 0;
}

.modal-close {
  width: 40px;
  height: 40px;
  border-radius: 12px;
  border: none;
  background: #f5f5f5;
  color: #666;
  font-size: 20px;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.2s ease;
}

.modal-close:hover {
  background: #ffebee;
  color: #c62828;
}

.modal-content {
  padding: 32px;
}

/* Preview Card in Modal */
.preview-card-detailed {
  display: flex;
  gap: 32px;
}

.preview-cover {
  width: 160px;
  height: 200px;
  background: linear-gradient(135deg, #f5f7fa 0%, #e4e7eb 100%);
  border-radius: 24px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.preview-cover-icon {
  font-size: 48px;
}

.preview-details {
  flex: 1;
}

.preview-title {
  font-size: 24px;
  font-weight: 700;
  color: #1a1a1a;
  margin: 0 0 20px 0;
}

.preview-metadata {
  background: #f8f9fa;
  border-radius: 16px;
  padding: 16px;
  margin-bottom: 20px;
}

.preview-meta-item {
  display: flex;
  align-items: baseline;
  padding: 8px 0;
}

.meta-label {
  width: 80px;
  font-size: 14px;
  color: #666;
}

.meta-value {
  font-weight: 600;
  color: #1a1a1a;
}

.preview-abstract {
  margin-bottom: 20px;
}

.preview-abstract h5 {
  font-size: 16px;
  font-weight: 600;
  color: #333;
  margin: 0 0 8px 0;
}

.preview-abstract p {
  font-size: 14px;
  line-height: 1.6;
  color: #666;
  margin: 0;
}

.preview-tags {
  display: flex;
  gap: 12px;
  margin-bottom: 24px;
  flex-wrap: wrap;
}

.preview-actions {
  display: flex;
  gap: 12px;
}

/* Responsive Design */
@media (max-width: 768px) {
  .journal-management {
    padding: 16px;
  }

  .journal-card {
    flex-direction: column;
    gap: 16px;
  }

  .journal-card-left {
    flex-direction: column;
    gap: 16px;
  }

  .journal-cover {
    width: 100%;
    height: 160px;
  }

  .journal-card-right {
    padding-left: 0;
    border-left: none;
    width: 100%;
  }

  .action-buttons {
    width: 100%;
    justify-content: flex-end;
  }

  .preview-card-detailed {
    flex-direction: column;
    align-items: center;
    text-align: center;
  }

  .preview-cover {
    width: 120px;
    height: 150px;
  }

  .preview-meta-item {
    flex-direction: column;
    align-items: center;
    text-align: center;
  }

  .meta-label {
    width: auto;
    margin-bottom: 4px;
  }
}

@media (max-width: 480px) {
  .filter-section {
    flex-direction: column;
    align-items: stretch;
  }

  .filter-actions {
    justify-content: stretch;
  }

  .filter-select {
    flex: 1;
  }

  .journal-meta {
    flex-direction: column;
    gap: 8px;
  }

  .action-buttons {
    justify-content: space-around;
  }

  .modal-header {
    padding: 20px;
  }

  .modal-content {
    padding: 20px;
  }
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
  const modal = document.getElementById('prevModal');
  const closeBg = document.getElementById('prevClose');
  const closeX = document.getElementById('prevX');

  const pTitle = document.getElementById('pTitle');
  const pAuthor = document.getElementById('pAuthor');
  const pDesc = document.getElementById('pDesc');
  const pVer = document.getElementById('pVer');
  const pTags = document.getElementById('pTags');

  function openModal(btn) {
    pTitle.textContent = btn.dataset.title || '-';
    pAuthor.textContent = btn.dataset.author || '-';
    pDesc.textContent = btn.dataset.desc || '-';
    pVer.textContent = btn.dataset.version || '';

   

    modal.classList.add('open');
    document.body.style.overflow = 'hidden';
  }

  function closeModal() {
    modal.classList.remove('open');
    document.body.style.overflow = '';
  }

  document.addEventListener('click', (e) => {
    const btn = e.target.closest('.js-preview');
    if (btn) {
      e.preventDefault();
      return openModal(btn);
    }

    if (e.target === closeBg || e.target === closeX) {
      closeModal();
    }
  });

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && modal.classList.contains('open')) {
      closeModal();
    }
  });
});
</script>
@endpush
@endsection