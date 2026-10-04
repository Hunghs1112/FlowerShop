@extends('layouts.app')

@section('title', $mysteryContent['hero_title'])

@section('content')
<x-page-hero
    title="{{ $mysteryContent['hero_title'] }}"
    description="{{ $mysteryContent['hero_description'] }}"
    :breadcrumbs="[['label' => $mysteryContent['breadcrumb_home'], 'url' => route('home')], ['label' => $mysteryContent['breadcrumb_mystery']]]"
    :image="$siteBanners['mystery-box'] ?? null"
    :hideOverlay="$siteBannerHideOverlay['mystery-box'] ?? false"
    height="350px"
/>

<div class="container page-wrapper">
    <div class="mystery-box-container">
        <div class="mystery-box-content">
            <div class="mystery-box-intro">
                <h2>{{ $mysteryContent['intro_title'] }}</h2>
                <p>{{ $mysteryContent['intro_description'] }}</p>
            </div>

            <form id="mysteryBoxForm" action="{{ route('mystery-box.store') }}" method="POST">
                @csrf
                <div class="step-indicator">
                    @foreach($mysteryContent['step_labels'] as $index => $label)
                        <div class="step-item {{ $index === 0 ? 'active' : '' }}" data-step="{{ $index + 1 }}">
                            <div class="step-number">{{ $index + 1 }}</div>
                            <div class="step-label">{{ $label }}</div>
                        </div>
                    @endforeach
                </div>

                <div class="step-content active" data-step="1">
                    <h3 class="step-title">{{ $mysteryContent['style_title'] }}</h3>
                    <div class="selection-grid">
                        @foreach($mysteryContent['styles'] as $style)
                            <label class="selection-card"><input type="radio" name="style" value="{{ $style }}" {{ old('style') === $style ? 'checked' : '' }} required><div class="card-content"><div class="card-title">{{ $style }}</div></div></label>
                        @endforeach
                    </div>
                    @error('style')<span class="form-error">{{ $message }}</span>@enderror
                </div>

                <div class="step-content" data-step="2">
                    <h3 class="step-title">{{ $mysteryContent['color_title'] }}</h3>
                    <div class="selection-grid">
                        @foreach($mysteryContent['colors'] as $color)
                            <label class="selection-card"><input type="checkbox" name="colors[]" value="{{ $color }}" {{ in_array($color, old('colors', [])) ? 'checked' : '' }}><div class="card-content"><div class="card-title">{{ $color }}</div></div></label>
                        @endforeach
                    </div>
                    @error('colors')<span class="form-error">{{ $message }}</span>@enderror
                </div>

                <div class="step-content" data-step="3">
                    <h3 class="step-title">{{ $mysteryContent['preference_title'] }}</h3>
                    <div class="selection-grid">
                        @foreach($mysteryContent['preferences'] as $preference)
                            <label class="selection-card"><input type="checkbox" name="preferences[]" value="{{ $preference }}" {{ in_array($preference, old('preferences', [])) ? 'checked' : '' }}><div class="card-content"><div class="card-title">{{ $preference }}</div></div></label>
                        @endforeach
                    </div>
                    @error('preferences')<span class="form-error">{{ $message }}</span>@enderror
                </div>

                <div class="step-content" data-step="4">
                    <h3 class="step-title">{{ $mysteryContent['budget_title'] }}</h3>
                    <div class="selection-grid">
                        @foreach($mysteryContent['budgets'] as $budget)
                            <label class="selection-card"><input type="radio" name="budget_range" value="{{ $budget['value'] }}" {{ old('budget_range') === $budget['value'] ? 'checked' : '' }} required><div class="card-content"><div class="card-title">{{ $budget['label'] }}</div></div></label>
                        @endforeach
                    </div>
                    @error('budget_range')<span class="form-error">{{ $message }}</span>@enderror
                </div>

                <div class="step-content" data-step="5">
                    <h3 class="step-title">{{ $mysteryContent['surprise_title'] }}</h3>
                    <div class="selection-grid">
                        @foreach($mysteryContent['surprise_levels'] as $level)
                            <label class="selection-card"><input type="radio" name="surprise_level" value="{{ $level }}" {{ old('surprise_level') === $level ? 'checked' : '' }} required><div class="card-content"><div class="card-title">{{ $level }}</div></div></label>
                        @endforeach
                    </div>
                    @error('surprise_level')<span class="form-error">{{ $message }}</span>@enderror
                </div>

                <div class="step-content" data-step="6">
                    <h3 class="step-title">{{ $mysteryContent['note_title'] }}</h3>
                    <div class="form-group"><label for="name" class="form-label required">{{ $mysteryContent['name_label'] }}</label><input id="name" type="text" name="name" value="{{ old('name', $user?->name) }}" class="form-input" required></div>
                    <div class="form-group"><label for="phone" class="form-label required">{{ $mysteryContent['phone_label'] }}</label><input id="phone" type="tel" name="phone" value="{{ old('phone', $user?->phone) }}" class="form-input" required></div>
                    <div class="form-group"><label for="email" class="form-label">{{ $mysteryContent['email_label'] }}</label><input id="email" type="email" name="email" value="{{ old('email', $user?->email) }}" class="form-input"></div>
                    <div class="form-group"><label for="note" class="form-label">{{ $mysteryContent['request_label'] }}</label><textarea id="note" name="note" rows="4" class="form-input form-textarea" placeholder="{{ $mysteryContent['request_placeholder'] }}">{{ old('note') }}</textarea></div>
                </div>

                <div class="step-content" data-step="7">
                    <h3 class="step-title">{{ $mysteryContent['confirm_title'] }}</h3>
                    <div class="summary-box">
                        <div class="summary-section"><h4>{{ $mysteryContent['selected_info_title'] }}</h4>
                            <div class="summary-item"><span class="summary-label">{{ $mysteryContent['style_summary_label'] }}</span><span class="summary-value" id="summary-style">-</span></div>
                            <div class="summary-item"><span class="summary-label">{{ $mysteryContent['color_summary_label'] }}</span><span class="summary-value" id="summary-colors">-</span></div>
                            <div class="summary-item"><span class="summary-label">{{ $mysteryContent['preference_summary_label'] }}</span><span class="summary-value" id="summary-preferences">-</span></div>
                            <div class="summary-item"><span class="summary-label">{{ $mysteryContent['budget_summary_label'] }}</span><span class="summary-value" id="summary-budget">-</span></div>
                            <div class="summary-item"><span class="summary-label">{{ $mysteryContent['surprise_summary_label'] }}</span><span class="summary-value" id="summary-surprise">-</span></div>
                        </div>
                        <div class="disclaimer"><p>{{ $mysteryContent['disclaimer'] }}</p></div>
                    </div>
                </div>

                <div class="step-navigation">
                    <button type="button" class="btn btn-outline btn-lg" id="prevBtn" style="display:none;">{{ $mysteryContent['previous_label'] }}</button>
                    <button type="button" class="btn btn-primary btn-lg" id="nextBtn">{{ $mysteryContent['next_label'] }}</button>
                    <button type="submit" class="btn btn-primary btn-lg" id="submitBtn" style="display:none;">{{ $mysteryContent['submit_label'] }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
<link rel="stylesheet" href="{{ asset('css/mystery-box.css') }}">
<script src="{{ asset('js/mystery-box.js') }}"></script>
@endsection
