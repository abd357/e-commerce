@extends('layouts.master')
@section('content') 
<form action="/checkout" method="POST">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <button type="submit">Checkout</button>
</form>
@endsection