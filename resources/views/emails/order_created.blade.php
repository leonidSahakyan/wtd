@extends('emails.layout')
@section('content')
<p><h2>{{trans('emails.order_created_title')}}</h2></p>
<p>{{trans('emails.order_created_text', ['sku' => $sku])}}</p>
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