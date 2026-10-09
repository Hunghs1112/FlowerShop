@section('skip-main-wrapper', true)

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/seasonal.css') }}?v={{ filemtime(public_path('css/seasonal.css')) }}">
@endpush

@section('content')
    <main class="seasonal-page" data-site-theme="light" data-season-theme="{{ $seasonView === 'hub' ? 'hub' : $seasonConfig['seasons'][0]['theme'] }}">
        <div id="seasonalApp"></div>
    </main>
@endsection

@push('scripts')
    <script>
        window.LNT_SEASON_CONFIG = @json($seasonConfig);
        window.LNT_SEASON_VIEW = @json($seasonView);
    </script>
    <script src="{{ asset('js/seasonal.js') }}?v={{ filemtime(public_path('js/seasonal.js')) }}"></script>
@endpush
