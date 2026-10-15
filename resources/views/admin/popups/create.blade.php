@extends('layouts.admin')

@section('page-title', 'Tạo popup mới')

@section('content')
    @include('admin.popups.form', [
        'popup' => null,
        'formAction' => route('admin.popups.store'),
        'formMethod' => 'POST',
    ])
@endsection
