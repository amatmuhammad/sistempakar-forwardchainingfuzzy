@extends('partials.app-layout')

@section('title', 'Manajemen Rule Detail')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Manajemen Rule Detail</h4>
            <p class="text-muted mb-0">Kelola relasi rule, gejala, dan bobot secara terpisah.</p>
        </div>
        <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#modalRuleDetail">
            <i class="bx bx-plus me-1"></i> Tambah Rule Detail
        </button>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Rule</th>
                            <th>Gejala</th>
                            <th>Bobot</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ruleDetails as $detail)
                        <tr>
                            <td>{{ $loop->iteration + ($ruleDetails->currentPage() - 1) * $ruleDetails->perPage() }}</td>
                            <td>{{ $detail->rule->kode_rule ?? '-' }}</td>
                            <td>{{ $detail->gejala->nama_gejala ?? '-' }}</td>
                            <td>{{ number_format($detail->bobot, 2) }}</td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#modalEditRuleDetail{{ $detail->id }}">
                                    <i class="bx bx-edit"></i>
                                </button>
                                <form action="{{ route('rule-details.destroy', $detail->id) }}" method="POST" class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bx bx-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Belum ada data rule detail.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $ruleDetails->links() }}
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalRuleDetail" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Rule Detail</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('rule-details.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Rule</label>
                        <select name="rule_id" class="form-select" required>
                            <option value="">Pilih Rule</option>
                            @foreach($rules as $rule)
                                <option value="{{ $rule->id }}">{{ $rule->kode_rule }} - {{ $rule->penyakit->nama_penyakit ?? '-' }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Gejala</label>
                        <select name="gejala_id" class="form-select" required>
                            <option value="">Pilih Gejala</option>
                            @foreach($gejalas as $gejala)
                                <option value="{{ $gejala->id }}">{{ $gejala->kode_gejala }} - {{ $gejala->nama_gejala }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Bobot</label>
                        <input type="number" step="0.01" min="0" max="1" name="bobot" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-dark">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@foreach($ruleDetails as $detail)
<div class="modal fade" id="modalEditRuleDetail{{ $detail->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Rule Detail</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('rule-details.update', $detail->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Rule</label>
                        <select name="rule_id" class="form-select" required>
                            @foreach($rules as $rule)
                                <option value="{{ $rule->id }}" {{ $detail->rule_id == $rule->id ? 'selected' : '' }}>{{ $rule->kode_rule }} - {{ $rule->penyakit->nama_penyakit ?? '-' }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Gejala</label>
                        <select name="gejala_id" class="form-select" required>
                            @foreach($gejalas as $gejala)
                                <option value="{{ $gejala->id }}" {{ $detail->gejala_id == $gejala->id ? 'selected' : '' }}>{{ $gejala->kode_gejala }} - {{ $gejala->nama_gejala }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Bobot</label>
                        <input type="number" step="0.01" min="0" max="1" name="bobot" class="form-control" value="{{ $detail->bobot }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-dark">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.body.addEventListener('submit', function (e) {
            const form = e.target;
            if (form && form.classList.contains('delete-form')) {
                e.preventDefault();
                Swal.fire({
                    title: 'Hapus Data?',
                    text: 'Tindakan ini tidak dapat dibatalkan.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#94a3b8',
                    confirmButtonText: 'Ya, Hapus',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            }
        });
    });
</script>
@endsection
