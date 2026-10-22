@extends('layouts.app')

@section('title', __('pages.season_hub_title'))

@include('pages.seasonal._content', ['seasonView' => 'hub'])
