@extends('layouts.app')
@include('layouts.navbar')
@section('content')
<div class="container">
    <h1>Cancellation/Refund Policy</h1>
    <p>We strive to provide a fair and transparent lottery experience. However, please note the following policy regarding cancellations and refunds:</p>
    <h2>Ticket Purchases</h2>
    <p>All ticket purchases are final and non-refundable. Once a ticket is purchased, it cannot be canceled or refunded under any circumstances.</p>
    <h2>Cancelled Events</h2>
    <p>In the unlikely event that a lottery drawing is canceled, we will refund the ticket price to all participants for the affected drawing.</p>
    <h2>Contact Us</h2>
    <p>If you have any questions about our cancellation or refund policy, please <a href="{{ route('contact') }}">contact us</a>.</p>
</div>
@endsection
