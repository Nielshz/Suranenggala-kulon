@extends('layouts.app')
@section('title', 'Detail Laporan')
@section('content')
<div class="pg-header">
    <h1><i class="bi bi-chat-square-text"></i> Detail Laporan #{{ str_pad($laporan->id, 4, '0', STR_PAD_LEFT) }}</h1>
    <a href="{{ route('laporan.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i> Kembali</a>
</div>

<div class="row g-4">
    <div class="col-lg-7">
        <div class="sec">
            <div class="sec-head" style="border-left:3px solid var(--primary)"><i class="bi bi-person" style="color:var(--primary)"></i><h5>Data Pelapor</h5></div>
            <div class="sec-body">
                <div class="row g-2">
                    <div class="col-sm-6"><small class="text-muted d-block">Nama</small><strong>{{ $laporan->nama_pelapor }}</strong></div>
                    <div class="col-sm-6"><small class="text-muted d-block">No. HP</small><strong>{{ $laporan->no_hp }}</strong></div>
                    <div class="col-12"><small class="text-muted d-block">Alamat</small>{{ $laporan->alamat_pelapor ?? '—' }}</div>
                </div>
            </div>
        </div>

        <div class="sec">
            <div class="sec-head" style="border-left:3px solid var(--warning)"><i class="bi bi-chat-dots" style="color:var(--warning)"></i><h5>Isi Laporan</h5></div>
            <div class="sec-body">
                <div class="mb-2">
                    <span class="badge bg-light text-dark border">{{ $laporan->kategori }}</span>
                    @php $sc = match($laporan->status) { 'Masuk' => 'warning', 'Dibaca' => 'info', 'Diproses' => 'primary', 'Selesai' => 'success', 'Ditolak' => 'danger', default => 'secondary' }; @endphp
                    <span class="badge bg-{{ $sc }} bg-opacity-10 text-{{ $sc }} border border-{{ $sc }} border-opacity-25">{{ $laporan->status }}</span>
                </div>
                <h6 class="fw-bold mb-2">{{ $laporan->subjek }}</h6>
                <p style="font-size:13.5px;line-height:1.7;white-space:pre-line">{{ $laporan->isi_laporan }}</p>
                <div class="text-muted mt-3" style="font-size:12px"><i class="bi bi-clock"></i> {{ $laporan->created_at->format('d M Y, H:i') }}</div>
            </div>
        </div>

        @if($laporan->tanggapan)
        <div class="sec">
            <div class="sec-head" style="border-left:3px solid var(--success)"><i class="bi bi-reply" style="color:var(--success)"></i><h5>Tanggapan</h5></div>
            <div class="sec-body">
                <p style="font-size:13.5px;line-height:1.7;white-space:pre-line">{{ $laporan->tanggapan }}</p>
                <div class="text-muted mt-2" style="font-size:12px">
                    <i class="bi bi-person"></i> {{ $laporan->responder->nama ?? '—' }} ({{ $laporan->responder->status ?? '' }})
                    · {{ $laporan->responded_at?->format('d M Y, H:i') }}
                </div>
            </div>
        </div>
        @endif
    </div>

    <div class="col-lg-5">
        {{-- Update status form --}}
        <div class="sec">
            <div class="sec-head" style="border-left:3px solid var(--info)"><i class="bi bi-gear" style="color:var(--info)"></i><h5>Ubah Status & Tanggapi</h5></div>
            <div class="sec-body">
                <form action="{{ route('laporan.respond', $laporan) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label class="form-label" style="font-size:12.5px;font-weight:600">Status</label>
                        <select class="form-select" name="status" required>
                            @foreach(['Dibaca','Diproses','Selesai','Ditolak'] as $s)
                            <option value="{{ $s }}" {{ $laporan->status==$s?'selected':'' }}>{{ $s }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" style="font-size:12.5px;font-weight:600">Tanggapan</label>
                        <textarea class="form-control" name="tanggapan" rows="4" placeholder="Tulis tanggapan...">{{ old('tanggapan', $laporan->tanggapan) }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mb-2"><i class="bi bi-check-lg"></i> Simpan</button>
                </form>
                <a href="{{ $laporan->wa_reply_link }}" target="_blank" class="btn w-100" style="background:#25d366;color:#fff;font-weight:600"><i class="bi bi-whatsapp"></i> Balas via WhatsApp</a>
            </div>
        </div>
    </div>
</div>
@endsection
