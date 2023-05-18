<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container px-4 px-lg-5">
        <a class="navbar-brand" href="#!">Online Shop with Midtrans</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                <li class="nav-item"><a class="nav-link active" aria-current="page" href="{{ route('home') }}">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('orders') }}">All Orders</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Shop</a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#!">All Products</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="#!">Popular Items</a></li>
                        <li><a class="dropdown-item" href="#!">New Arrivals</a></li>
                    </ul>
                </li>
            </ul>
            <?php 
                 $cart = \App\Models\Cart::where('user_id', \App\Models\User::first()->id)->first();
                 $total_cart = isset($cart) ? count($cart->item) : 0;
            ?>
            <form class="d-flex">
                <a href="{{ route('cart') }}" class="btn btn-outline-dark" type="submit">
                    <i class="bi-cart-fill me-1"></i>
                    Cart
                    <span id="total_cart" class="badge bg-dark text-white ms-1 rounded-pill">{{ isset($total_cart) ? $total_cart : 0  }}</span>
                </a>
            </form>
            <form action="{{ route('logout') }}" method="POST" style="padding-left: 10px">
                @csrf
                <button type="submit" class="btn btn-primary" style="background-color: black">Logout</button>
            </form>
        </div>
    </div>
</nav>