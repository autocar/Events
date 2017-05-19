@extends('laralum::layouts.master')
@section('icon', 'ion-calendar')
@section('title', $event->title)
@section('subtitle', __('laralum_events::general.events_desc', ['event_id' => $event->id]))
@section('breadcrumb')
    <ul class="uk-breadcrumb">
        <li><a href="{{ route('laralum::index') }}">@lang('laralum_events::general.home')</a></li>
        <li><a href="{{ route('laralum::events.index') }}">@lang('laralum_events::general.events_list')</a></li>
        <li><span>{{ $event->title }}</span></li>
    </ul>
@endsection
@section('content')
    <div class="uk-container uk-container-large">
        <div uk-grid>
            <div class="uk-width-1-5@l uk-width-1-1@m"></div>
            <div class="uk-width-3-5@l uk-width-1-1@m">
                <div class="uk-card uk-card-default">
                    <div class="uk-card-header">
                        {{ $event->title }}
                    </div>

                    <ul class="uk-flex-center" uk-tab  uk-switcher>
                        <li class="{{isset($_GET['page']) ?:'uk-active'}}"><a href="#">@lang('laralum_events::general.information')</a></li>
                        <li class="{{!isset($_GET['page']) ?:'uk-active'}}"><a href="#">@lang('laralum_events::general.users')</a></li>
                    </ul>

                    <ul class="uk-switcher uk-margin">
                        <li>
                            <div class="uk-card-body">
                                <div class="uk-text-lead uk-text-center uk-margin-medium-bottom">
                                    @if(!$event->started())
                                        @lang('laralum_events::general.time_left_starts')
                                    @elseif (!$event->finished())
                                        @lang('laralum_events::general.time_left_ends')
                                    @else
                                        @lang('laralum_events::general.you_were_late')
                                    @endif
                                </div>
                                @if(!$event->finished())
                                <div id="countdown" class="uk-grid-small uk-child-width-auto uk-text-center uk-flex-center sticky {{ ($event->started()) ? 'uk-text-primary' : 'uk-text-success' }}" uk-grid uk-countdown="date: {{ !$event->started() ? $event->startDatetime()->toAtomString() : $event->endDatetime()->toAtomString() }}">
                                    <div>
                                        <div class="uk-countdown-number uk-countdown-days"></div>
                                        <div class="uk-countdown-label uk-margin-small uk-text-center uk-visible@s">@lang('laralum_events::general.days')</div>
                                    </div>
                                    <div class="uk-countdown-separator">:</div>
                                    <div>
                                        <div class="uk-countdown-number uk-countdown-hours"></div>
                                        <div class="uk-countdown-label uk-margin-small uk-text-center uk-visible@s">@lang('laralum_events::general.hours')</div>
                                    </div>
                                    <div class="uk-countdown-separator">:</div>
                                    <div>
                                        <div class="uk-countdown-number uk-countdown-minutes"></div>
                                        <div class="uk-countdown-label uk-margin-small uk-text-center uk-visible@s">@lang('laralum_events::general.minutes')</div>
                                    </div>
                                    <div class="uk-countdown-separator">:</div>
                                    <div>
                                        <div class="uk-countdown-number uk-countdown-seconds"></div>
                                        <div class="uk-countdown-label uk-margin-small uk-text-center uk-visible@s">@lang('laralum_events::general.seconds')</div>
                                    </div>
                                </div>
                                @else
                                <div class="uk-alert-danger uk-text-center" uk-alert>
                                    <p>@lang('laralum_events::general.event_celebrated')</p>
                                </div>
                                @endif
                                <br>
                                <hr class="uk-divider-icon">
                                <dl class="uk-description-list uk-description-list-divider">
                                    <dt>@lang('laralum_events::general.description')</dt>
                                    <dd class="uk-margin-small-top">{!! $event->description !!}</dd>
                                    <dt>@lang('laralum_events::general.duration')</dt>
                                    <dd class="uk-margin-small-top">{{ $event->endDatetime()->diffForHumans($event->startDatetime(), true) }}</dd>
                                    <dt>@lang('laralum_events::general.place')</dt>
                                    <dd class="uk-margin-small-top">{{ $event->place }}</dd>
                                    <dt>@lang('laralum_events::general.status')</dt>
                                    <dd class="uk-margin-small-top">
                                        @if ($event->public)
                                        <span class="uk-label uk-label-success">@lang('laralum_events::general.published')</span>
                                        @else
                                        <span class="uk-label uk-label-warning">@lang('laralum_events::general.unpublished')</span>
                                        @endif
                                    </dd>
                                    <dt>@lang('laralum_events::general.start_date')</dt>
                                    <dd class="uk-margin-small-top">{{ $event->startDatetime() }}</dd>
                                    <dt>@lang('laralum_events::general.end_date')</dt>
                                    <dd class="uk-margin-small-top">{{ $event->endDatetime() }}</dd>
                                    <dt>@lang('laralum_events::general.price')</dt>
                                    <dd class="uk-margin-small-top">{{ $event->price }}</dd>
                                </dl>
                            </div>
                        </li>
                        <li>
                            <div class="uk-card-body">
                                <table class="uk-table uk-table-striped">
                                    <thead>
                                        <tr>
                                            <th>@lang('laralum::general.user')</th>
                                            <th>@lang('laralum::general.email')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse( $users as $user )
                                            <tr>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td>-</td>
                                                <td>-</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            @include('laralum::layouts.pagination', ['paginator' => $users])
                            <br>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="uk-width-1-5@l uk-width-1-1@m"></div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $( function () {
            UIkit.countdown($('#countdown'));
        });
    </script>
@endsection
