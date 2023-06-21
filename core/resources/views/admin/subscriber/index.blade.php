@extends('admin.layouts.app')

@section('panel')

    <div class="row">

        <div class="col-lg-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive table-responsive--sm">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th>@lang('S.N.')</th>
                                <th>@lang('Email')</th>
                                <th>@lang('Subscribed At')</th>
                                <th>@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($subscribers as $subscriber)
                                <tr>
                                    <td data-label="@lang('S.N.')">{{ ($subscribers->currentPage()-1) * $subscribers->perPage() + $loop->iteration }}</td>
                                    <td data-label="@lang('Email')">{{ $subscriber->email }}</td>
                                    <td data-label="@lang('Subscribed At')">{{ showDateTime($subscriber->created_at) }}</td>
                                    <td data-label="@lang('Action')">

                                        <a href="{{ route('admin.subscriber.sendEmail', $subscriber->id) }}" class="icon-btn btn--primary box--shadow1 text--small" ><i class="la la-envelope-open-text" data-toggle="tooltip" data-title="@lang('Send Email')"></i></a>

                                        <a href="javascript:void(0)"
                                           data-id="{{ $subscriber->id }}"
                                           data-email="{{ $subscriber->email }}"
                                           class="icon-btn btn--danger removeBtn" data-toggle="tooltip"
                                           data-original-title="@lang('Remove')">
                                            <i class="las la-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ trans($empty_message) }}</td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                <div class="card-footer py-4">
                    {{ $subscribers->links('admin.partials.paginate') }}
                </div>
            </div><!-- card end -->
        </div>


    </div>

    {{-- Remove Subscriber MODAL --}}
    <div id="removeModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Delete Subscriber ')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.subscriber.remove') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="subscriber">
                        <p>@lang('Are you sure to remove') <span class="font-weight-bold subscriber-email"></span> @lang('from subscribers')?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn--dark" data-dismiss="modal">@lang('No')</button>
                        <button type="submit" class="btn btn-sm btn--danger">@lang('Yes')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <a href="{{ route('admin.subscriber.sendEmail') }}" class="btn btn-sm btn--primary box--shadow1 text--small" ><i class="la la-envelope-open-text"></i>@lang('Send Email To All')</a>
@endpush

@push('script')
    <script>
        'use strict';
        (function($){
            $('.removeBtn').on('click', function() {
                $('#removeModal').find('input[name=subscriber]').val($(this).data('id'));
                $('#removeModal').find('.subscriber-email').text($(this).data('email'));
                $('#removeModal').modal('show');
            });
        })(jQuery)

    </script>
@endpush
