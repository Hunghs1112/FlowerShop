@extends('layouts.app')

@section('title', __('pages.season_tree_title'))

@include('pages.seasonal._content', ['seasonView' => 'thong'])
