@extends('emails.layout')
@section('content')
<p><h2>Master invantatoin</h2></p>
<p>Username: {{ $email }},</p>
<p>Temporary password: {{ $password }}</p>
<table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
    <tbody>
    <tr>
        <td align="left">
        <table role="presentation" border="0" cellpadding="0" cellspacing="0">
            <tbody>
            <tr>
                <td> <a href="{{ url('/admin') }}" target="_blank">Go to admin panel</a> </td>
            </tr>
            </tbody>
        </table>
        </td>
    </tr>
    </tbody>
</table>
@endsection