@extends('layouts.app')

@section('title', __('messages.contact.page_title'))

@section('content')
<x-page-hero 
    title="{{ __('messages.contact.page_title') }}"
    description="{{ __('messages.contact.page_subtitle') }}"
    :breadcrumbs="[
        ['label' => __('messages.nav.home'), 'url' => locale_route('home')],
        ['label' => __('messages.nav.contact')]
    ]"
    height="400px"
/>

<div class="container page-wrapper">
    <div class="contact-layout">
        <!-- Contact Form -->
        <div class="contact-form-wrapper">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">{{ __('messages.contact.form_title') }}</h2>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ locale_route('contact.submit') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="name" class="form-label required">{{ __('messages.contact.name') }}</label>
                            <input type="text" id="name" name="name" 
                                   value="{{ old('name') }}" 
                                   class="form-input @error('name') error @enderror" required>
                            @error('name')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-grid">
                            <div class="form-group">
                                <label for="phone" class="form-label required">{{ __('messages.contact.phone') }}</label>
                                <input type="tel" id="phone" name="phone" 
                                       value="{{ old('phone') }}" 
                                       class="form-input @error('phone') error @enderror" required>
                                @error('phone')
                                    <span class="form-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email" class="form-label">{{ __('messages.contact.email_optional') }}</label>
                                <input type="email" id="email" name="email" 
                                       value="{{ old('email') }}" 
                                       class="form-input @error('email') error @enderror">
                                @error('email')
                                    <span class="form-error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="zalo_id" class="form-label">{{ __('messages.contact.zalo_id') }}</label>
                            <input type="text" id="zalo_id" name="zalo_id" 
                                   value="{{ old('zalo_id') }}" 
                                   class="form-input @error('zalo_id') error @enderror"
                                   placeholder="{{ __('messages.contact.zalo_placeholder') }}">
                            @error('zalo_id')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="message" class="form-label required">{{ __('messages.contact.message') }}</label>
                            <textarea id="message" name="message" rows="6" 
                                      class="form-input @error('message') error @enderror" 
                                      required placeholder="{{ __('messages.contact.message_placeholder') }}">{{ old('message') }}</textarea>
                            @error('message')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg btn-block">
                            {{ __('messages.contact.send') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="contact-info-wrapper">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">{{ __('messages.contact.info_title') }}</h2>
                </div>
                <div class="card-body">
                    <p class="contact-intro">
                        {{ __('messages.contact.intro') }}
                    </p>

                    <div class="contact-methods">
                        @if($siteInfo['phone'] ?? null)
                            <div class="contact-method">
                                <div class="contact-icon">
                                    <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3>{{ __('messages.contact.phone_label') }}</h3>
                                    <p>{{ $siteInfo['phone'] }}</p>
                                </div>
                            </div>
                        @endif

                        @if($siteInfo['email'] ?? null)
                            <div class="contact-method">
                                <div class="contact-icon">
                                    <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3>{{ __('messages.contact.email_label') }}</h3>
                                    <p>{{ $siteInfo['email'] }}</p>
                                </div>
                            </div>
                        @endif

                        @if($siteInfo['address'] ?? null)
                            <div class="contact-method">
                                <div class="contact-icon">
                                    <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3>{{ __('messages.contact.address_label') }}</h3>
                                    <p>{{ $siteInfo['address'] }}</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    @if($siteInfo['zalo_qr'])
                        <div class="zalo-section">
                            <h3>{{ __('messages.contact.zalo_title') }}</h3>
                            <div class="zalo-qr">
                                <img src="{{ asset('storage/' . $siteInfo['zalo_qr']) }}" alt="Mã QR Zalo">
                                <p>{{ __('messages.contact.zalo_scan') }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

