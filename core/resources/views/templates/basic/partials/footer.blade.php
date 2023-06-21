@php
    $footer    = getContent('footer.content', true);
    if($footer)
    $footer    =$footer->data_values
@endphp

  <!-- Footer Section Starts Here -->
  <footer class="bg-3">
    <div class="container">
        <div class="footer-bottom">
            <div class="footer-widget widget-about">
                <div class="logo">
                    <a href="{{ route('home') }}">
                        <img class="w-100 h-auto" src="{{getImage(imagePath()['logoIcon']['path'] .'/logo_2.png')}}" alt="@lang('logo')">
                    </a>
                </div>
                <p>@lang(@$footer->footer_note)</p>

            </div>
            <div class="footer-widget widget-link">
                <h5 class="title cl-white">@lang('Pages')</h5>
                <ul>
                    @if($pages->count() > 0)
                        @foreach ($pages as $item)
                            <li><a href="{{route('pages', ['id' => $item->id, 'slug'=> slug($item->data_values->page_title) ])}}">@php echo __($item->data_values->page_title) @endphp</a></li>
                        @endforeach
                    @endif
                </ul>
            </div>
            <div class="footer-widget widget-link">
                <h5 class="title cl-white">@lang('Useful link')</h5>
                <ul>
                    <li><a href="{{route('about_us')}}">@lang('About Us')</a></li>
                    <li><a href="{{route('contact')}}">@lang('Contact Us')</a></li>
                    <li><a href="{{route('faqs')}}">@lang('FAQ')</a></li>
                    <li><a href="{{route('order-track')}}">@lang('Track Your Order')</a></li>
                </ul>
            </div>

            <div class="footer-widget widget-link widget-contact">
                <h5 class="title cl-white">@lang('Contact Us')</h5>
                <ul>
                    <li>
                        <i class="las la-map-marker"></i>
                        {{ __(@$footer->contact_address) }}
                    </li>
                    <li>
                        <a href="Tel:{{ @$footer->cell_number }}"><i class="las la-phone"></i>{{ @$footer->cell_number }}</a>
                    </li>
                    <li>
                        <a href="mailto:{{ @$footer->email }}"><i class="las la-envelope"></i>{{ @$footer->email }}</a>
                    </li>
                </ul>
            </div>


        </div>
        <div class="footer-copyright">
            <div class="copyright-area d-flex flex-wrap align-items-center justify-content-between">
                <div class="left">
                    <p>{{ __(@$footer->copyright_text) }}</p>
                </div>
                <ul class="social-icons">
                    @php
                        $socials    = getContent('social_icon.element');
                    @endphp

                    @if($socials->count() >0)
                        @foreach ($socials as $item)
                        <li>
                            <a href="{{ $item->data_values->url }}">
                                @php
                                    echo $item->data_values->social_icon
                                @endphp
                            </a>
                        </li>
                        @endforeach
                    @endif
                </ul>
                <div class="right">
                    @isset($footer->payment_methods)
                    <img src="{{ getImage('assets/images/frontend/footer/'.@$footer->payment_methods, "250x30")}}" alt="@lang('footer')">
                    @endisset
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- Footer Section Ends Here -->

<div class="modal fade" id="quickView">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <button type="button" class="close modal-close-btn" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="modal-body">
                <div class="ajax-loader-wrapper d-flex align-items-center justify-content-center">
                    <div class="spinner-border" role="status">
                      <span class="sr-only">@lang('Loading')...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
