@extends('layouts.main')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">Overview</div>
                    <h2 class="page-title">orders</h2>
                </div>
                @can('add user')
                    <div class="col-auto ms-auto d-print-none">
                        <div class="btn-list">
                            {{-- <a href="{{ route('order.add') }}" class="btn btn-primary d-none d-sm-inline-block">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 5l0 14" />
                                    <path d="M5 12l14 0" />
                                </svg>
                                Add order
                            </a> --}}
                        </div>
                    </div>
                @endcan
                @if (Session::has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img"
                            aria-label="Success:">
                            <use xlink:href="#check-circle-fill" />
                        </svg>
                        <div>{{ Session::get('success') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="container-xl mt-3">
        <div class="card">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="orders-table">
                    <thead>
                        <tr>
                            <th>Order#</th>
                            <th>Date</th>
                            <th>Customer Name</th>
                            <th>Total</th>
                            <th>Payment Status</th>
                            <th>Order Status</th>
                            <th>Payment Method</th>
                            <th>Items</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                        <tr>
                            <td>#{{$order->id}}</td>
                            <td>{{$order->created_at}}</td>
                            <td>{{$order->customer->full_name}}</td>
                            <td>${{$order->payment->amount ? $order->payment->amount : 0}}</td>
                            <td>
                                @if ($order->payment->status === 'paid')
                                <span class="badge rounded-pill bg-success text-white">{{$order->payment->status}}</span>
                                @elseif ($order->payment->status === 'pending')
                                <span class="badge rounded-pill bg-warning text-white">{{$order->payment->status}}</span>
                                @else
                                <span class="badge rounded-pill bg-danger text-white">{{$order->payment->status}}</span>
                                @endif
                            </td>
                            <td>
                                @if ($order->status === 'completed')
                                <span class="badge rounded-pill bg-success text-white">{{$order->status}}</span>
                                @elseif ($order->status === 'pending')
                                <span class="badge rounded-pill bg-warning text-white">{{$order->status}}</span>
                                @elseif ($order->status === 'processing')
                                <span class="badge rounded-pill bg-primary text-white">{{$order->status}}</span>
                                @elseif ($order->status === 'shipped')
                                <span class="badge rounded-pill bg-secondary text-white">{{$order->status}}</span>
                                @else
                                <span class="badge rounded-pill bg-danger text-white">{{$order->status}}</span>
                                @endif
                            </td>
                            <td>{{$order->payment->payment_method}}</td>
                            <td>
                                {{count($order->orderItems)}} items
                            </td>
                            <td><a href="{{route('orders.detail',$order->id)}}"><i class="fa-solid fa fa-eye" style="cursor: pointer;"></i></a></td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-center mt-3">
                    {{-- pagination section --}}
                </div>
            </div>
        </div>
    </div>

@endsection
