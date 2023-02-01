<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->

    <link rel="stylesheet" href="{{ URL::asset('assets/styles.css') }}">
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="SB-Mid-client-Swk36bLl28xGVHxY"></script>
    </script>
    <title>Dashboard</title>
</head>

<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar-->
        <div class="border-end bg-white" id="sidebar-wrapper">
            <div class="sidebar-heading border-bottom bg-light">Guest Dashboard</div>
            <div class="list-group list-group-flush">
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="/guest/books">Book
                    Lists</a>
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="/guest/userBooks">Your
                    Books</a>
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="/guest/wishlist">Your
                    Wishlist</a>
                <form action="/logout" method="post">
                    @csrf
                    <button class="list-group-item list-group-item-action list-group-item-light p-3"
                        type="submit">Logout</button>
                </form>
            </div>
        </div>
        <!-- Page content wrapper-->
        <div id="page-content-wrapper">
            <!-- Top navigation-->
            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                <div class="container-fluid">
                    <button class="btn btn-primary" id="sidebarToggle">
                        Toggle Menu
                    </button>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                            <li class="nav-item active">
                                <a class="nav-link" href="#!">Welcome, {{ Auth::user()->name }}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- Page content-->
            <div class="container-fluid">
                <div class="card my-3 mx-auto" style="width: 30rem">
                    <div class="card-body">
                        <h5 class="card-title">Your order detail</h5>
                        <div class="row mx-auto">
                            <div class="col my-auto">
                                <p class="">Book Name</p>
                                <p class="card-text">{{$book[0]->bookName}}</p>
                            </div>
                            <div class="col my-auto">
                                <p class="text-center">Price</p>
                                <p class="card-text">{{ "Rp " . number_format($book[0]->price, 2, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                    <button id="pay-button" class="btn btn-primary">Pay</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"
        integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <script src="
        https://cdn.jsdelivr.net/npm/sweetalert2@11.7.1/dist/sweetalert2.all.min.js
        "></script>
    <script>
        window.addEventListener('DOMContentLoaded', event => {

            const sidebarToggle = document.body.querySelector('#sidebarToggle');
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', event => {
                    event.preventDefault();
                    document.body.classList.toggle('sb-sidenav-toggled');
                    localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains(
                        'sb-sidenav-toggled'));
                });
            }

        });
        document.getElementById('pay-button').onclick = function(){
        snap.pay('{{ $snapToken }}', {
        onSuccess: function(result){
        // console.log(result);
        $.ajax({
            type: "POST",
            url: "http://127.0.0.1:8000/guest/book/add",
            data: {_token:"{{csrf_token()}}", bookId : {{ $bookId }}},
            success: function(response) {
                Swal.fire(
                    'Success!',
                    'Success Buy Book!',
                    'success'
                    )
                .then(() => {
                    window.location = '../../'
                }) 
            }
        })
        console.log('asds')
        },
        onPending: function(result){
        console.log(result);
        },
        onError: function(result){
        console.log(result);
        }
        });
        }
    </script>
</body>

</html>