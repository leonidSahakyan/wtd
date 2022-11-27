@extends('emails.layout')
@section('content')
<p><h2>New order</h2></p>
<p>Order {{$sku}} successfully paid.</p>
<table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
    <tbody>
    <tr>
        <td align="left">
        <table role="presentation" border="0" cellpadding="0" cellspacing="0">
            <tbody>
            <tr>
                <td> <a href="{{ route('order', ['hash'=>$hash])}}" target="_blank">View order</a> </td>
            </tr>
            </tbody>
        </table>
        </td>
    </tr>
    </tbody>
</table>
@endsection