@extends('layouts.admin')

@section('page-title', 'Đăng ký nhận tin')

@section('content')
<div class="admin-page-header">
    <div class="admin-page-header-left">
        <h1 class="admin-page-title">Đăng ký nhận tin</h1>
        <p class="admin-page-subtitle">Danh sách email gửi từ biểu mẫu newsletter.</p>
    </div>
</div>

<div class="admin-card" style="margin-bottom:24px">
    <div class="admin-card-body" style="padding:16px 24px">
        <form method="GET" class="admin-filters">
            <input type="search" name="search" value="{{ request('search') }}" class="input-sm" placeholder="Tìm email">
            <button class="btn btn-secondary btn-sm">Tìm</button>
        </form>
    </div>
</div>

<div class="admin-card">
    <div class="admin-card-body" style="padding:0">
        <div class="admin-table-wrapper">
            <table class="admin-table">
                <thead><tr><th>ID</th><th>Email</th><th>Ngày đăng ký</th></tr></thead>
                <tbody>
                @forelse($subscriptions as $subscription)
                    <tr><td class="text-mono">#{{ $subscription->id }}</td><td><a href="mailto:{{ $subscription->email }}">{{ $subscription->email }}</a></td><td>{{ $subscription->created_at->format('d/m/Y H:i') }}</td></tr>
                @empty
                    <tr><td colspan="3"><div class="empty-state-sm"><p>Chưa có email đăng ký nhận tin.</p></div></td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div style="margin-top:20px">{{ $subscriptions->links() }}</div>
@endsection
