@extends('layouts.app')

@section('content')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    var options = {
        "key": "{{ env('RAZORPAY_KEY') }}",
        "amount": "{{ $amount }}", 
        "currency": "INR",
        "name": "Black Gold Lottery",
        "description": "Lottery Ticket Purchase",
        "order_id": "{{ $orderId }}", 
        "handler": function (response){
            window.location.href = "{{ route('payment.callback') }}?razorpay_payment_id=" + response.razorpay_payment_id;
        },
        "prefill": {
            "name": "{{ Auth::user()->name }}",
            "email": "{{ Auth::user()->email }}"
        },
        "theme": {
            "color": "#3399cc"
        }
    };
    var rzp1 = new Razorpay(options);
    rzp1.open();
</script>
@endsection
