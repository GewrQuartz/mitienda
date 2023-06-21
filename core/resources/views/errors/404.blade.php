<!-- meta tags and other links -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $general->sitename(__(@$page_title) ?? __('404 | page not found')) }}</title>
  <link rel="shortcut icon" type="image/png" href="{{getImage(imagePath()['logoIcon']['path'] .'/favicon.png')}}">
  <!-- bootstrap 4  -->
  <link rel="stylesheet" href="{{ asset('assets/errors/css/bootstrap.min.css') }}">
  <!-- dashdoard main css -->
  <link rel="stylesheet" href="{{ asset('assets/errors/css/main.css') }}">
</head>
  <body>
  <!-- error-404 start -->
  <div class="error">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-7 text-center">
          <img src="{{ asset('assets/errors/images/error-404.png') }}" alt="@lang('image')">
          <h2 class="title"><b>@lang('Page Not Found')</b></h2>
          <p>@lang("The page you are looking for doesn't exist or temporarily unavailable.")</p>
          <a href="{{ route('home') }}" class="cmn-btn mt-4">@lang('Go To Home')</a>
        </div>
      </div>
    </div>
  </div>
  <!-- error-404 end -->
  </body>
</html>
