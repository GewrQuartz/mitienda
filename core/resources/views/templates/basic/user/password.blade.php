@extends($activeTemplate.'layouts.master')

@section('content')
    <div class="container">
        <div class="row justify-content-center mt-4">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form action="" method="post" class="register">
                            @csrf
                            <div class="form-group">
                                <label for="password">{{trans('Current Password')}}</label>
                                <input id="password" type="password" class="form-control" name="current_password" required
                                       autocomplete="current-password">
                            </div>

                            <div class="form-group">
                                <label for="password">{{trans('Password')}}</label>
                                <input id="password" type="password" class="form-control" name="password" required
                                       autocomplete="current-password">
                            </div>


                            <div class="form-group">
                                <label for="confirm_password">{{trans('Confirm Password')}}</label>
                                <input id="password_confirmation" type="password" class="form-control"
                                       name="password_confirmation" required autocomplete="current-password">
                            </div>


                            <div class="form-group">
                                <input type="submit" class="mt-4 btn btn-success" value="{{trans('Change Password')}}">
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
