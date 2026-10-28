@if ($paginator->hasPages())
<div style="display:flex;justify-content:flex-end;align-items:center;gap:20px;font-size:.85rem;">
    @if ($paginator->onFirstPage())
        <span style="color:#555;opacity:.5">« Previous</span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}" style="color:#C9A84C;font-weight:600;transition:opacity .2s" onmouseover="this.style.opacity=0.7" onmouseout="this.style.opacity=1">« Previous</a>
    @endif

    <span style="color:#8888aa">Page {{ $paginator->currentPage() }} of {{ $paginator->lastPage() }}</span>

    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" style="color:#C9A84C;font-weight:600;transition:opacity .2s" onmouseover="this.style.opacity=0.7" onmouseout="this.style.opacity=1">Next »</a>
    @else
        <span style="color:#555;opacity:.5">Next »</span>
    @endif
</div>
@endif