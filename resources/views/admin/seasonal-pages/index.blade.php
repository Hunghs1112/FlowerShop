@extends('layouts.admin')

@section('page-title', 'Trang Mùa Lễ Hội')

@section('content')
<div class="admin-page-header">
    <div class="admin-page-header-left">
        <h1 class="admin-page-title">Trang Mùa Lễ Hội</h1>
        <p class="admin-page-subtitle">Quản lý nội dung và sản phẩm cho 3 trang lễ hội</p>
    </div>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 24px;">
    @foreach($seasons as $id => $season)
    <a href="{{ route('admin.seasonal-pages.edit', $id) }}" class="season-card">
        <div class="season-card-icon">
            @switch($id)
                @case('thu')
                    <span style="font-size: 40px;">🍂</span>
                    @break
                @case('halloween')
                    <span style="font-size: 40px;">🎃</span>
                    @break
                @case('thong')
                    <span style="font-size: 40px;">🎄</span>
                    @break
            @endswitch
        </div>
        <div class="season-card-content">
            <h3>{{ $season['label'] }}</h3>
            <p>{{ ucfirst($season['name']) }}</p>
        </div>
        <div class="season-card-arrow">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </div>
    </a>
    @endforeach
</div>

<style>
.season-card {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 24px;
    background: var(--admin-bg);
    border: 1px solid var(--admin-border);
    border-radius: 12px;
    text-decoration: none;
    color: inherit;
    transition: all 0.2s ease;
}
.season-card:hover {
    border-color: var(--admin-primary);
    background: var(--admin-bg-subtle);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}
.season-card-icon {
    width: 64px;
    height: 64px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--admin-bg-subtle);
    border-radius: 12px;
    flex-shrink: 0;
}
.season-card-content {
    flex: 1;
}
.season-card-content h3 {
    margin: 0 0 4px;
    font-size: 16px;
    font-weight: 600;
}
.season-card-content p {
    margin: 0;
    font-size: 13px;
    color: var(--admin-text-muted);
}
.season-card-arrow {
    color: var(--admin-text-muted);
}
</style>
@endsection
