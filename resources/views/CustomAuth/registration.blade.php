@extends('CustomAuth.main')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card  text-center">
                <div class="card-header">Registration</div>
                <div class="card-body">
                    <form action="{{route('validate_register') }}" method="post">
                        @csrf
                        <div class="form-group mb-3">
                            <input type="text" name="name" class="form-control" placeholder="name"
                                value="{{ old('name') }}" />
                            @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                        <div class="form-group mb-3">
                            <input type="email" name="email" class="form-control" placeholder="email"
                                value="{{ old('email') }}" />
                            @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                        <div class="form-group mb-3">
                            <input type="password" name="password" class="form-control" placeholder="Password" />
                            @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                        <div class="d-grid mx-auto">
                            <button type="submit" class="btn btn-dark btn-block">Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
