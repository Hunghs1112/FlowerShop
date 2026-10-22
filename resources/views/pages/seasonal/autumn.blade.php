@extends('layouts.app')

@section('title', __('pages.season_autumn_title'))

@include('pages.seasonal._content', ['seasonView' => 'thu'])
