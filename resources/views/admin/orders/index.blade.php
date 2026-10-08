@extends('layouts.admin')

@section('content')
<div class="admin-page">
    <h1>Đơn hàng</h1>
    <form method="GET" class="admin-filter-form">
        <input name="search" value="{{ request('search') }}" placeholder="Tên hoặc số điện thoại">
        <select name="status"><option value="">Tất cả trạng thái</option>@foreach(\App\Models\Order::STATUSES as $value => $label)<option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>@endforeach</select>
        <button type="submit">Lọc</button>
    </form>
    <table class="admin-table"><thead><tr><th>Mã</th><th>Khách hàng</th><th>Điện thoại</th><th>Tổng</th><th>Trạng thái</th><th></th></tr></thead><tbody>
    @forelse($orders as $order)
        <tr><td>#{{ $order->id }}</td><td>{{ $order->customer_name }}</td><td>{{ $order->customer_phone }}</td><td>{{ number_format($order->total) }}đ</td><td>{{ $order->status_label }}</td><td><a href="{{ route('admin.orders.show', $order) }}">Xem</a></td></tr>
    @empty <tr><td colspan="6">Chưa có đơn hàng.</td></tr> @endforelse
    </tbody></table>
    {{ $orders->links() }}
</div>
@endsection
