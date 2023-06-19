<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="./../../css/app.css">
    <title>Login</title>
</head>
<body>

    <div class="container login-container">
        <div class="wrapper d-flex flex-col align-items-center justify-content-center h-100 w-100">
            <div class="card login-form">
                <div class="card-body">
                    <div >
                        <img src="data:image/png;base64,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" alt="">
                    </div>
                    <h5 class="card-title text-center">Login Form</h5>
                    @if(session('error'))
                    <div class="alert alert-danger">
                        <b>Opps!</b> {{session('error')}}
                    </div>
                    @endif
                    <form action="{{route('login')}}" method="post">
                    @csrf
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" id="exampleInputPassword1">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    







<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>