@extends('layouts.app')

@section('content')
<div class="container my-4">
    <!-- Header with Back and Print Buttons -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('dosen.histori') }}" class="back-btn">
                <span class="arrow"><</span> Back
            </a>
            <h4 class="ms-3 d-inline-block">Detail Perwalian</h4>
        </div>
        <div>
            <a href="{{ route('berita_acara.print', $perwalian->ID_Perwalian) }}" class="btn btn-primary">
                <i class="fas fa-print"></i> Print Perwalian PDF
            </a>
        </div>
    </div>

    <!-- Perwalian Information -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Perwalian {{ $perwalian->kelas }}</h5>
            <p class="card-text">
                Tanggal: {{ \Carbon\Carbon::parse($perwalian->Tanggal)->translatedFormat('l, d F Y') }}
            </p>
            @if(isset($perwalian->agenda_perwalian))
                <p class="card-text"><strong>Agenda:</strong> {{ $perwalian->agenda_perwalian }}</p>
            @endif
        </div>
    </div>

    <div class="row">
        <!-- Left: Table of Students -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-light">
                    <strong>Daftar Mahasiswa</strong>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Status Perwalian</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($students as $student)
                                <tr>
                                    <td>{{ $student['nama'] }}</td>
                                    <td>
                                        @php
                                            $status = strtolower($student['status']);
                                        @endphp
                                        @if($status === 'hadir')
                                            <span class="badge bg-success">Hadir</span>
                                        @elseif($status === 'sakit')
                                            <span class="badge bg-warning">Sakit</span>
                                        @elseif($status === 'izin')
                                            <span class="badge bg-info">Izin</span>
                                        @else
                                            <span class="badge bg-danger">Belum</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center">Tidak ada data mahasiswa.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right: Catatan Section -->
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header bg-light">
                    <strong>Catatan (Dosen Wali)</strong>
                </div>
                <div class="card-body">
                    <p>{{ $catatan ?? 'Tidak ada catatan' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .back-btn {
        display: inline-flex;
        align-items: center;
        padding: 2px 8px;
        background-color: #68B8EA;
        color: #fff;
        font-size: 18px;
        font-weight: 500;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        text-decoration: none;
    }
    .back-btn:hover {
        background-color: #4A9CD6;
    }
    .back-btn .arrow {
        font-size: 40px;
        margin-right: 4px;
        line-height: 1;
    }
    .card {
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    .badge {
        font-size: 0.9rem;
        padding: 0.5em 0.75em;
    }
</style>
@endsection