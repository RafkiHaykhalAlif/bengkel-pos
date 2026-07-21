@extends('layouts.app')
@section('title', 'Akses Terbatas')

@section('content')
{{-- Konten blur di belakang --}}
<div style="filter:blur(4px);pointer-events:none;user-select:none;opacity:0.6;">
  <div style="background:#fff;border-radius:14px;padding:24px 28px;margin-bottom:20px;box-shadow:0 8px 24px rgba(26,86,219,0.28);background:linear-gradient(135deg,#1E429F,#2563EB);height:120px;"></div>
  <div style="background:#fff;border-radius:12px;border:1px solid #C7D4F0;padding:20px 24px;margin-bottom:20px;height:100px;"></div>
  <div style="background:#fff;border-radius:12px;border:1px solid #C7D4F0;overflow:hidden;">
    <div style="background:#1E2A4A;height:44px;"></div>
    <div style="padding:16px;">
      @for($i=0;$i<6;$i++)
        <div style="height:40px;border-bottom:1px solid #EEF2FF;display:flex;align-items:center;gap:16px;padding:0 8px;">
          <div style="width:30px;height:14px;background:#E5E7EB;border-radius:4px;"></div>
          <div style="width:80px;height:14px;background:#E5E7EB;border-radius:4px;"></div>
          <div style="width:120px;height:14px;background:#E5E7EB;border-radius:4px;"></div>
          <div style="width:60px;height:14px;background:#E5E7EB;border-radius:4px;margin-left:auto;"></div>
        </div>
      @endfor
    </div>
  </div>
</div>

{{-- Overlay --}}
<div style="position:fixed;inset:0;background:rgba(15,25,60,0.72);backdrop-filter:blur(6px);z-index:9999;display:flex;align-items:center;justify-content:center;padding:24px;">
  <div style="background:#fff;border-radius:20px;padding:44px 48px;max-width:440px;width:100%;text-align:center;box-shadow:0 24px 64px rgba(0,0,0,0.25);animation:fadeUp 0.3s ease both;">
    <style>@keyframes fadeUp{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:translateY(0)}}</style>

    <div style="width:72px;height:72px;background:#FEF2F2;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:32px;margin:0 auto 20px;">🔒</div>

    <div style="font-size:22px;font-weight:800;color:#111827;margin-bottom:10px;">Akses Terbatas</div>

    <div style="font-size:13.5px;color:#6B7280;line-height:1.7;margin-bottom:10px;">
      Halaman ini hanya dapat diakses oleh <strong style="color:#1E429F;">Owner</strong>.
    </div>

    <div style="font-size:13px;color:#DC2626;background:#FEF2F2;padding:10px 16px;border-radius:8px;font-weight:600;margin-bottom:28px;border:1px solid #FECACA;">
      Akun <strong>{{ Auth::user()->name }}</strong> tidak memiliki izin untuk melihat laporan ini.
    </div>

    <a href="{{ route('dashboard') }}"
      style="display:block;width:100%;padding:12px 32px;background:#1E429F;color:#fff;font-size:14px;font-weight:700;font-family:inherit;border:none;border-radius:10px;cursor:pointer;text-decoration:none;text-align:center;transition:background 0.2s;"
      onmouseover="this.style.background='#1A56DB'" onmouseout="this.style.background='#1E429F'">
      Kembali ke Dashboard
    </a>
  </div>
</div>
@endsection