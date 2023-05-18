@extends('layouts.app')
@section('content')
<section class="h-100 h-custom" style="background-color: #6d6d6d;">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12">
          <div class="card card-registration card-registration-2" style="border-radius: 15px;">
            <div class="card-body p-4 table-responsive">
                <table class="table">
                    <thead class="thead-dark">
                      <tr>
                        <th scope="col">order id</th>
                        <th scope="col">total amount</th>
                        <th scope="col">status</th>
                        <th scope="col">payment type</th>
                        <th scope="col">action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($orders as $order)
                      <tr>
                        <td>{{ $order->order_id }}</td>
                        <td>{{ $order->total_amount }}</td>
                        <td>
                            @if ($order->status == 'settlement' || $order->status == 'capture')
                                <button class="btn" style="background-color: green; color: white" disabled>
                                    {{ $order->status }}
                                </button>
                            @elseif($order->status == 'expire' || $order->status == 'dany' || $order->status == 'cancel')
                                <button class="btn" style="background-color: red; color: white" disabled>
                                    {{ $order->status }}
                                </button>
                            @elseif($order->status == 'pending')
                                <button class="btn" style="background-color: orange; color: white" disabled>
                                    {{ $order->status }}
                                </button>

                            @elseif($order->status == 'refund' || $order->status == 'partial_refund' )
                                <button class="btn" style="background-color: rgb(21, 151, 198); color: white" disabled>
                                    {{ $order->status }}
                                </button>
                            @else
                             <span class="text-bold">waiting for payment !</span>
                            @endif
                        </td>
                        <td>{{ $order->payment_type ?? '' }}</td>
                        <td>
                            @if($order->status == 'created')
                                <a href="{{ route('test.payment', ['id' => $order->id]) }}" class="btn btn-primary">Pay</a>
                            @else
                            <a  href="{{ route('test.payment', ['id' => $order->id]) }}"  class="btn" style="background-color: black; color: white">Detail</a>
                            @endif
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection