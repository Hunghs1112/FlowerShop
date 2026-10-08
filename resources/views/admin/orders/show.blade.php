@extends('layouts.admin')

@section('content')
<div class="admin-page">
    <a href="{{ route('admin.orders.index') }}">← Đơn hàng</a>
    <h1>Đơn hàng #{{ $order->id }}</h1>
    <p><strong>{{ $order->customer_name }}</strong> · {{ $order->customer_phone }} · {{ $order->customer_email }}</p>
    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
    <p><strong>Trạng thái:</strong> {{ $order->status_label }}</p>
    @if(!in_array($order->status, ['completed', 'cancelled'], true))
        <form method="POST" action="{{ route('admin.orders.updateStatus', $order) }}" style="display:flex;gap:8px;align-items:center;margin:16px 0;">
            @csrf
            @method('PATCH')
            <select name="status">
                @foreach(\App\Models\Order::STATUSES as $value => $label)
                    @if($value !== 'new')<option value="{{ $value }}" @selected($order->status === $value)>{{ $label }}</option>@endif
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary">Cập nhật trạng thái</button>
        </form>
    @endif
    <table class="admin-table"><thead><tr><th>Sản phẩm</th><th>SKU</th><th>SL</th><th>Đơn giá</th><th>Thành tiền</th></tr></thead><tbody>
    @foreach($order->items as $item)
        <tr><td>{{ $item->product_name }}{{ $item->variant_name ? ' - '.$item->variant_name : '' }}</td><td>{{ $item->sku }}</td><td>{{ $item->quantity }}</td><td>{{ number_format($item->unit_price) }}đ</td><td>{{ number_format($item->subtotal) }}đ</td></tr>
    @endforeach
    </tbody></table>
    <p><strong>Tổng: {{ number_format($order->total) }}đ</strong></p>
</div>
@endsection
