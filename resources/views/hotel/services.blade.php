@extends('hotel.layouts.app')

@section('title', $page->seo_title ?: websiteTitle($page->name))
@section('description', $page->seo_description ?: general()->meta_description)
@if($page->seo_keyword)@section('keywords', $page->seo_keyword)@endif

@section('content')
@php
    // Admin > Services (type 21) and Admin > Packages (type 22) are placed where
    // the page content says [services] / [packages] (or appended at the end).
    $active = fn ($type) => \App\Models\Attribute::where('type', $type)->where('status', 'active')
        ->orderBy('view')->orderBy('id')->get();
    $services = $active(21)->load('imageFile');
    $packages = $active(22);

    $grids = [
        'services' => view('hotel.partials.servicesGrid', compact('services'))->render(),
        'packages' => view('hotel.partials.packagesGrid', compact('packages'))->render(),
    ];

    $html = (string) $page->description;
    foreach ($grids as $code => $grid) {
        $pattern = '#(<p>\s*)?\['.$code.'\](\s*</p>)?#i';
        if (preg_match($pattern, $html)) {
            $html = preg_replace($pattern, str_replace(['\\', '$'], ['\\\\', '\\$'], $grid), $html, 1);
        } else {
            $html .= $grid;
        }
    }
@endphp
{!! $html !!}
@endsection
