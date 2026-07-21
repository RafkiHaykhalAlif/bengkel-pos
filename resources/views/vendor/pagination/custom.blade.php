@if ($paginator->hasPages())
<div style="display:flex;align-items:center;gap:4px;flex-wrap:wrap;width:100%;">
    {{-- Prev --}}
    @if ($paginator->onFirstPage())
        <span style="padding:6px 10px;border-radius:6px;border:1.5px solid #E5E7EB;background:#F9FAFB;color:#9CA3AF;font-size:12px;font-weight:600;cursor:not-allowed;white-space:nowrap;">‹ Prev</span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}" style="padding:6px 10px;border-radius:6px;border:1.5px solid #C7D4F0;background:#fff;color:#111827;font-size:12px;font-weight:600;text-decoration:none;white-space:nowrap;" onmouseover="this.style.background='#1E429F';this.style.color='#fff'" onmouseout="this.style.background='#fff';this.style.color='#111827'">‹ Prev</a>
    @endif

    {{-- Page numbers --}}
    @foreach ($elements as $element)
        @if (is_string($element))
            <span style="padding:6px 6px;font-size:12px;color:#6B7280;">…</span>
        @endif
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <span style="padding:6px 10px;border-radius:6px;border:1.5px solid #1E429F;background:#1E429F;color:#fff;font-size:12px;font-weight:700;">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" style="padding:6px 10px;border-radius:6px;border:1.5px solid #C7D4F0;background:#fff;color:#111827;font-size:12px;font-weight:600;text-decoration:none;" onmouseover="this.style.background='#1E429F';this.style.color='#fff';this.style.borderColor='#1E429F'" onmouseout="this.style.background='#fff';this.style.color='#111827';this.style.borderColor='#C7D4F0'">{{ $page }}</a>
                @endif
            @endforeach
        @endif
    @endforeach

    {{-- Next --}}
    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" style="padding:6px 10px;border-radius:6px;border:1.5px solid #C7D4F0;background:#fff;color:#111827;font-size:12px;font-weight:600;text-decoration:none;white-space:nowrap;" onmouseover="this.style.background='#1E429F';this.style.color='#fff'" onmouseout="this.style.background='#fff';this.style.color='#111827'">Next ›</a>
    @else
        <span style="padding:6px 10px;border-radius:6px;border:1.5px solid #E5E7EB;background:#F9FAFB;color:#9CA3AF;font-size:12px;font-weight:600;cursor:not-allowed;white-space:nowrap;">Next ›</span>
    @endif
</div>
@endif