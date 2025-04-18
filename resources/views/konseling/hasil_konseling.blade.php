@extends('layouts.app')

@section('content')

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  @php
    use App\Models\RequestKonseling;
    use App\Models\HasilKonseling;

    $approvedMahasiswa = RequestKonseling::where('status', 'approved')->get();
    $mahasiswaDenganHasil = HasilKonseling::pluck('request_konseling_id')->toArray();
    $mahasiswa = $approvedMahasiswa->reject(fn($mhs) => in_array($mhs->id, $mahasiswaDenganHasil));
  @endphp

  @if(session('user.role') == 'kemahasiswaan')
    <form action="{{ route('kemahasiswaan_hasil_konseling.store') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
  @elseif(session('user.role') == 'konselor')
    <form action="{{ route('konselor_hasil_konseling.store') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
  @endif
    @csrf
    <div class="mb-3 col-md-4">
      <label class="form-label text-start">Cari Nama Mahasiswa</label>
      <select name="request_konseling_id" id="nama_mahasiswa" class="form-control" required>
        <option value="">Cari dan Pilih Mahasiswa</option>
        @foreach ($mahasiswa as $mhs)
          <option value="{{ $mhs->id }}" data-nama="{{ $mhs->nama_mahasiswa }}" data-nim="{{ $mhs->nim }}">
            {{ $mhs->nama_mahasiswa }} - {{ $mhs->tanggal_pengajuan }}
          </option>
        @endforeach
      </select>
    </div>

    <div class="mb-3 col-md-4">
      <label class="form-label text-start fw-bold">Nama Mahasiswa</label>
      <input type="text" class="form-control" name="nama" id="nama_mahasiswa_input" required readonly>
    </div>

    <div class="mb-3 col-md-4">
      <label class="form-label text-start fw-bold">NIM Mahasiswa</label>
      <input type="text" class="form-control" name="nim" id="nim_mahasiswa" required readonly>
    </div>

    <div class="mb-3">
      <label class="form-label text-start d-block fw-bold">Hasil Konseling</label>
      <input type="file" class="form-control" name="file" id="fileInput" required>
    </div>

    <div class="mb-3">
      <label class="form-label text-start fw-bold">Keterangan Konseling</label>
      <textarea class="form-control" name="keterangan" rows="3"></textarea>
    </div>

    <div class="d-flex justify-content-center">
      <button type="submit" class="btn btn-custom-blue">Buat</button>
      <button type="reset" class="btn btn-secondary">Batal</button>
    </div>
  </form>

  <!-- Script untuk Select2, Auto-fill NIM, dan Validasi Upload -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    $(document).ready(function () {
      // Inisialisasi Select2
      $('#nama_mahasiswa').select2({
        placeholder: "Cari Mahasiswa...",
        allowClear: true,
        width: '100%'
      });

      // Auto-fill Nama dan NIM
      $('#nama_mahasiswa').on('change', function () {
        const selectedOption = $(this).find('option:selected');
        const nama = selectedOption.data('nama');
        const nim = selectedOption.data('nim');

        $('#nama_mahasiswa_input').val(nama || '');
        $('#nim_mahasiswa').val(nim || '');
      });

      // Validasi ukuran file sebelum submit (client-side)
      $('#uploadForm').on('submit', function(e) {
        const fileInput = $('#fileInput')[0];
        if (fileInput.files.length > 0) {
          const fileSize = fileInput.files[0].size; // Ukuran dalam bytes
          const maxSize = 5 * 1024 * 1024; // Batas maksimal 2MB (sesuaikan dengan kebutuhan)

          if (fileSize > maxSize) {
            e.preventDefault(); 
            Swal.fire({
              icon: 'error',
              title: 'Gagal Upload',
              text: 'Ukuran file terlalu besar! Maksimal 2MB.',
            });
            return false;
          }
        }
      });
    });
  </script>

@endsection