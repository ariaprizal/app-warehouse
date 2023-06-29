<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Warehouse App</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <link rel="stylesheet" href="./../../css/app.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>

<body>
    <div class="warehouse-container">
        <div class="menus d-flex">
            <div class="menu-head d-flex w-100 justify-content-between">
                <div>
                    <p>Welcome {{Auth::user()->name}}</p>
                </div>
                <div class="logout">
                    <a href="{{route('logout')}}">Logout</a>
                </div>
            </div>
            <div class="sidebar pt-5">
                <h3>Warehouse</h3>
                @if(Auth::user()->role == "warehouse")
                <div class="sidebar-menu d-flex flex-column text-center">
                    <ul class="nav nav-pills flex-column" id="menus">
                        <li class="nav-item my-1">
                            <a href="{{route('dashboard')}}" class="nav-link" aria-current="page">Dashboard</a>
                        </li>
                        <li class="nav-item my-1">
                            <a href="#inmenus" data-bs-toggle="collapse" class="nav-link">Inbound</a>
                            <ul class="nav nav-pills flex-column collapse" id="inmenus" data-bs-parent="#menus" >
                                <li class="nav-item item-collapse my-1">
                                    <a href="{{route('inbound')}}" class="nav-link" aria-current="page">On Devlivery</a>
                                </li>
                                <li class="nav-item item-collapse my-1">
                                    <a href="{{route('process')}}" class="nav-link">Process</a>
                                </li>
                                <li class="nav-item item-collapse my-1 mb-3">
                                    <a href="{{route('done')}}" class="nav-link">Done</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item my-1">
                            <a href="#outmenus" data-bs-toggle="collapse" class="nav-link">Outbound</a>
                            <ul class="nav nav-pills flex-column collapse" id="outmenus" data-bs-parent="#menus" >
                                <li class="nav-item item-collapse my-1">
                                    <a href="#" class="nav-link" aria-current="page">On Process</a>
                                </li>
                                <li class="nav-item item-collapse my-1">
                                    <a href="#" class="nav-link">On Delivery</a>
                                </li>
                                <li class="nav-item item-collapse my-1">
                                    <a href="#" class="nav-link">Done</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item my-1">
                            <a href="#mastermenus" data-bs-toggle="collapse" class="nav-link">Master</a>
                            <ul class="nav nav-pills flex-column collapse" id="mastermenus" data-bs-parent="#menus" >
                                <li class="nav-item item-collapse my-1">
                                    <a href="{{route('product')}}" class="nav-link" aria-current="page">Product</a>
                                </li>
                                <li class="nav-item item-collapse my-1">
                                    <a href="{{route('supplier')}}" class="nav-link">Suppliers</a>
                                </li>
                                <li class="nav-item item-collapse my-1">
                                    <a href="{{route('brand')}}" class="nav-link">Brands</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                @elseif(Auth::user()->role == "finance")
                <div class="sidebar-menu d-flex flex-column text-center">
                    <div class="active">
                        <a href="#">Invoice</a>
                    </div>
                </div>
                @elseif(Auth::user()->role == "purchasing")
                <div class="sidebar-menu d-flex flex-column text-center">
                    <div class="active">
                        <a href="{{route('purchase')}}">Purchasing</a>
                    </div>
                </div>
                @elseif(Auth::user()->role == "marketing")
                <div class="sidebar-menu d-flex flex-column text-center">
                    <div class="">
                        <a href="{{route('order')}}">Orders</a>
                    </div>
                    <div class="">
                        <a href="{{route('store')}}">Store</a>
                    </div>
                </div>
                @endif
            </div>
        </div>
        
    </div>

    <div class="main">
        @yield('main')
    </div>












    <script>
        // Hide submenus
        $('#body-row .collapse').collapse('hide');

        // Collapse/Expand icon
        $('#collapse-icon').addClass('fa-angle-double-left');

        // Collapse click
        $('[data-toggle=sidebar-colapse]').click(function() {
            SidebarCollapse();
        });

        function SidebarCollapse() {
            $('.menu-collapsed').toggleClass('d-none');
            $('.sidebar-submenu').toggleClass('d-none');
            $('.submenu-icon').toggleClass('d-none');
            $('#sidebar-container').toggleClass('sidebar-expanded sidebar-collapsed');

            // Treating d-flex/d-none on separators with title
            var SeparatorTitle = $('.sidebar-separator-title');
            if (SeparatorTitle.hasClass('d-flex')) {
                SeparatorTitle.removeClass('d-flex');
            } else {
                SeparatorTitle.addClass('d-flex');
            }

            // Collapse/Expand icon
            $('#collapse-icon').toggleClass('fa-angle-double-left fa-angle-double-right');
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>

</html>