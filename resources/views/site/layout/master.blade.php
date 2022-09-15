{{-- can use: @extends('site.layout.master', ['header' => 'transparent']) for transparent(bg-image) header pages --}}
@include('site.layout.header')

@include('site.sections.fail-flash')

@yield('content')

@include('site.layout.footer')
