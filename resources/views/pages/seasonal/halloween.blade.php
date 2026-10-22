@extends('layouts.app')

@section('title', __('pages.season_halloween_title'))

@include('pages.seasonal._content', ['seasonView' => 'halloween'])
