@extends('layouts.app')

@section('content')
<main class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 py-12 px-4">
    <div class="mx-auto max-w-6xl">
        @include('partials.welcome.header')
        @include('partials.welcome.features')
        @include('partials.welcome.install')
        @include('partials.welcome.guide')
        @include('partials.welcome.development')
        @include('partials.welcome.structure')
        @include('partials.welcome.tips')
        @include('partials.welcome.bundling')
        @include('partials.welcome.note')
        @include('partials.welcome.footer')
    </div>
</main>
@endsection
