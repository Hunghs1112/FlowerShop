@extends('layouts.admin')

@section('page-title', 'Sửa popup')

@section('content')
    @include('admin.popups.form', [
        'formAction' => route('admin.popups.update', $popup),
        'formMethod' => 'PUT',
    ])
@endsection
