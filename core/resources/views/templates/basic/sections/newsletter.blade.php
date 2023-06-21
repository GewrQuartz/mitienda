    @php
        $subscribe = getContent('subscribe.content', true);
    @endphp

    @if($subscribe)
    <!-- Newsletter Section Starts Here -->
    <div class="newsletter-section bg-3">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-7 col-lg-6">
                    <div class="newsletter-header">
                        <h3 class="title">@lang(@$subscribe->data_values->text)</h3>
                    </div>
                </div>
                <div class="col-xl-5 col-lg-6">
                    <div class="subscribe-form">
                        <input type="email" placeholder="@lang('Your Email Address')..." name="email">
                        <button type="button" class="subscribe-btn">@lang('Subscribe')</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Newsletter Section Ends Here -->
    @endif
