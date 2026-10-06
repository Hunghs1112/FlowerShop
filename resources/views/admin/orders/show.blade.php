@extends('layouts.admin')

@section('content')
<div class="admin-page">
    <a href="{{ route('admin.orders.index') }}">← Đơn hàng</a>
    <h1>Đơn hàng #{{ $order->id }}</h1>
    <p><strong>{{ $order->customer_name }}</strong> · {{ $order->customer_phone }} · {{ $order->customer_email }}</p>
    <table class="admin-table"><thead><tr><th>Sản phẩm</th><th>SKU</th><th>SL</th><th>Đơn giá</th><th>Thành tiền</th></tr></thead><tbody>
    @foreach($order->items as $item)
        <tr><td>{{ $item->product_name }}{{ $item->variant_name ? ' - '.$item->variant_name : '' }}</td><td>{{ $item->sku }}</td><td>{{ $item->quantity }}</td><td>{{ number_format($item->unit_price) }}đ</td><td>{{ number_format($item->subtotal) }}đ</td></tr>
    @endforeach
    </tbody></table>
    <p><strong>Tổng: {{ number_format($order->total) }}đ</strong></p>
</div>
@endsection
