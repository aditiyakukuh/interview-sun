@extends('layouts.app')
@section('content')
<section class="h-100 h-custom" style="background-color: #6d6d6d;">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12">
          <div class="card card-registration card-registration-2" style="border-radius: 15px;">
            <div class="card-body p-0">
              <div class="row g-0">
                <div class="col-lg-8">
                  <div class="p-5">
                    <div class="d-flex justify-content-between align-items-center mb-5">
                      <h1 class="fw-bold mb-0 text-black">Shopping Cart</h1>
                      <h6 class="mb-0 text-muted" id="total-item">{{ isset($cart) ? count($cart->item) : 0  }} items</h6>
                    </div>
                    
                    @if (isset($cart) &&count($cart->item) != 0)
                    @foreach ($cart->item as $key => $item)
                    <hr class="my-4">
  
                    <div class="row mb-4 d-flex justify-content-between align-items-center">
                      <div class="col-md-2 col-lg-2 col-xl-2">
                        <img
                          src="https://source.unsplash.com/random/200x200?sig={{ $key+1 }}"
                          class="img-fluid rounded-3" alt="Cotton T-shirt">
                      </div>
                      <div class="col-md-3 col-lg-3 col-xl-3">
                        <h6 class="text-muted">{{ $item->product_name }}</h6>
                        <h6 class="text-black mb-0">Cotton T-shirt</h6>
                      </div>
                      <div class="col-md-3 col-lg-3 col-xl-2 d-flex">
                        <button class="btn btn-link px-2"
                          onclick="this.parentNode.querySelector('input[type=number]').stepDown()">
                          <i class="fas fa-minus"></i>
                        </button>
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        <input id="qty{{ $item->id }}" min="1" name="quantity" value="{{ $item->qty }}" onchange="changeQty({{ $item }})" type="number"
                          class="form-control form-control-sm" />
  
                        <button class="btn btn-link px-2"
                          onclick="this.parentNode.querySelector('input[type=number]').stepUp()">
                          <i class="fas fa-plus"></i>
                        </button>
                      </div>
                      <div class="col-md-3 col-lg-2 col-xl-2 offset-lg-1">
                        <h6 class="mb-0">Rp.{{ $item->price }}</h6>
                      </div>
                      <div class="col-md-1 col-lg-1 col-xl-1 text-end">
                        <a href="#!" class="text-muted">
                          <button class="btn btn-danger" onclick="deleteItem({{ $item }})">delete</button>
                        </a>
                      </div>
                    </div>
                    @endforeach
                    @else
                      no data
                    @endif
  
                  </div>
                </div>
                <div class="col-lg-4 bg-grey">
                  <div class="p-5">
                    <h3 class="fw-bold mb-5 mt-2 pt-1">Summary</h3>
                    <hr class="my-4">
  
                    <div class="d-flex justify-content-between mb-4">
                      <h5 class="text-uppercase">items total</h5>
                      <h5 id="total">Rp.{{ isset($cart) ? $cart->getTotalAmount() : 0 }}</h5>
                    </div>
  
                    <h5 class="text-uppercase mb-3">Pick Your Location</h5>
  
                    <div class="mb-4 pb-2">
                      <select class="js-example-basic-single select" name="city" id="city" style="max-width: 200px">
                        <option value="">your city</option>
                        @foreach ($cities as $city)
                        <option value="{{ $city['city_id'] }}">{{ $city['city_name'] }}</option>
                        @endforeach
                      </select>
                      {{-- <select class="select">
                        @foreach ($cities as $city)
                        <option value="{{ $city['city_id'] }}">{{ $city['city_name'] }}</option>
                        @endforeach
                      </select> --}}
                    </div>

                    <h5 class="text-uppercase mb-3">Shipping</h5>
                    <div class="mb-4 pb-2">
                      <select class="select" id="shipping" disabled>
                        <option value=""></option>
                      </select>
                    </div>
  
                    <div class="d-flex justify-content-between mb-4">
                      <h5 class="text-uppercase">Shipping Cost</h5>
                      <h5 id="shipping_cost">Rp.0</h5>
                    </div>
  
                    <hr class="my-4">
  
                    <div class="d-flex justify-content-between mb-5">
                      <h5 class="text-uppercase">Total price</h5>
                      <h5 id="total-amount">Rp.{{ isset($cart) ? $cart->getTotalAmount() : 0 }}</h5>
                    </div>
           
                    @if(isset($cart) && count($cart->item) > 0)
                    <button onclick="checkoutkuy()" type="button" class="btn btn-dark btn-block btn-lg"
                    data-mdb-ripple-color="dark" id="checkout">Checkout</button>
                    {{-- href="{{ route('checkout') }}" --}}
                    @endif
  
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
@push('scripts')
  <script>
        var shipping_cost_total = 0;
        var total_amount = 0;
        
        function changeQty(value){
            var newQty = document.getElementById("qty"+ value.id).value;
            let url = "{{ env('APP_URL') }}/cart/"+value.id;
            $.ajaxSetup({
                headers: {
                  "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                  "X-Requested-With": "XMLHttpRequest"
                }
            });
            $.ajax({
                url:url,  
                method:"POST",  
                data:{
                    qty: newQty,
                },                        
                success: function( data ) {
                    console.log(data);
                    newTotal();
                }
            });
        }
        
        function newTotal() {
            let url = "{{ env('APP_URL') }}/cart/new-total";
            $.ajax({
                url:url,  
                method:"GET",  
                data:{
                },                              
                success: function( data ) {
                    total_amount = data.total_amount;
                    document.getElementById('total').innerHTML = total_amount;
                    document.getElementById('total-amount').innerHTML = total_amount;
                }
            });
        }

        function deleteItem(item) {
          Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            if (result.isConfirmed) {
              let url = "{{ env('APP_URL') }}/cart/delete/"+item.id;
            $.ajaxSetup({
                headers: {
                  "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                  "X-Requested-With": "XMLHttpRequest"
                }
            });
            $.ajax({
                url:url,  
                method:"DELETE",  
                data:{
                  
                },                              
                success: function( data ) {
                    console.log(data);
                    window.location.reload();
                }
            });
            }
          })
        }

        function checkoutkuy() {
          var shipping = document.getElementById('shipping').value;

          if (shipping === "") {
           alert('please select your shipping location');
          }else{
            var url_shipping = "{{ route('checkout', ':shipping_cost') }}"
            url_shipping = url_shipping.replace(':shipping_cost', shipping_cost_total);
            window.location.href = url_shipping;
          }
        }
  </script>
  <script>
    var city = document.getElementById('city');
    var shipping = document.getElementById('shipping');
    city.addEventListener('change', function() {
      if (city.value !== "") {
        shipping.disabled = false;
        getShippingCost(city.value);
        document.getElementById('shipping_cost').innerHTML = shipping.value;
      } else {
        shipping.disabled = true;
      }
    });

    function getShippingCost(city_id) {
      document.getElementById('checkout').disabled = true;
      let url = "{{ env('APP_URL') }}/shipping-cost/"+city_id;
            $.ajax({
              url:url,  
              method:"GET",  
              data:{
          
              },                        
              success: function(data) {
                  console.log(data);

                  var selectShipping = document.getElementById('shipping');
                  selectShipping.innerHTML = ""; // Menghapus opsi yang ada sebelumnya

                  for (var i = 0; i < data.length; i++) {
                    var option = document.createElement('option');
                    option.value = data[i].price;
                    option.text = data[i].text;

                    selectShipping.appendChild(option);
                  }

                  selectShipping.disabled = false; // Mengaktifkan elemen <select> setelah menambahkan opsi
                  document.getElementById('checkout').disabled = false;
              }
            });
    }
    shipping.addEventListener('click', function() {
      document.getElementById('shipping_cost').innerHTML = 'Rp.'+shipping.value+'.00';
      shipping_cost_total = shipping.value;
      var totalPrice = {!! json_encode(isset($cart) ? $cart->getTotalAmount() : 0) !!};
      totalPrice = parseFloat(totalPrice) + parseFloat(shipping_cost_total);
      document.getElementById('total-amount').innerHTML = 'Rp.'+ totalPrice+'.00';
    });
  </script>
@endpush