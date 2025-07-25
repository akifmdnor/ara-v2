@extends('layouts.app')

@section('title', 'Agent Bookings')
@section('description', 'Agent Bookings - Manage your bookings')

@section('content')
    <x-affiliate-navbar :user="auth()->user()" headerText="Bookings">
        <x-booking-filters-stats :stats="$stats" />
        <x-booking-list />
        <x-booking-scripts />
    </x-affiliate-navbar>
@endsection
