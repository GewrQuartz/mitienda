<div class="user">
    <span class="side-sidebar-close-btn"><i class="las la-times"></i></span>
    <div class="thumb">
        <a href="{{ route('user.profile-setting') }}">
            <img src="{{ getAvatar(imagePath()['user_profile']['path'].'/'.auth()->user()->image) }}" alt="@lang('user')">
        </a>
    </div>
    <div class="content">
        <h6 class="title"><a href="{{ auth()->user()->fullname }}" class="cl-white">{{ auth()->user()->fullname }}</a></h6>
    </div>
</div>
