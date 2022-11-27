@extends('app.layouts.app')
@section('content')
<div class="container orders">
    <div class="row">
        <div class="col-md-12 text-center">
            <h2 class="title font-weight-bolder mb-1">My orders</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            @if($orders)
                <table id="orders">
                    <thead>
                        <tr>
                            <th>Order Date</th>
                            <th>Gold Amount</th>
                            <th>Price</th>
                            <th>Username</th>
                            <th>Status</th>
                            <th>Game</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>{{$order->created_at}}</td>
                            <td>{{$order->amount}}</td>
                            <td>{{$order->price}} {{$order->currency_code}}</td>
                            <td>{{$order->rsn}}</td>
                            <td>{{$order->status == 'in_progress' ? 'in progress' : $order->status}}</td>
                            <td>{{$order->game == 'rune_scape_old' ? 'Rune Scape Old school' : 'Rune Scape'}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else

            @endif
        </div>
    </div>
</div>           
@endsection