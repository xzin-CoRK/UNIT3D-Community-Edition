@extends('layout.with-main')

@section('title')
    <title>
        {{ __('common.user') }} {{ __('user.rsskeys') }} - {{ __('staff.staff-dashboard') }} -
        {{ config('other.title') }}
    </title>
@endsection

@section('meta')
    <meta
        name="description"
        content="{{ __('user.rsskeys') }} - {{ __('staff.staff-dashboard') }}"
    />
@endsection

@section('breadcrumbs')
    <li class="breadcrumbV2">
        <a href="{{ route('staff.dashboard.index') }}" class="breadcrumb__link">
            {{ __('staff.staff-dashboard') }}
        </a>
    </li>
    <li class="breadcrumb--active">
        {{ __('user.rsskeys') }}
    </li>
@endsection

@section('page', 'page__rsskey-log--index')

@section('main')
    @livewire('rsskey-search')
@endsection
