@extends('affiliate.layouts.app')

@section('title', 'Agent Bookings')
@section('description', 'Agent Bookings - Manage your bookings')

@section('content')
    <x-affiliate.affiliate-navbar :user="auth()->user()" headerText="Bookings">
        <x-affiliate.booking-filters-stats :stats="$stats" />
        <x-affiliate.booking-list />
        <x-affiliate.booking-scripts />
    </x-affiliate.affiliate-navbar>
@endsection
