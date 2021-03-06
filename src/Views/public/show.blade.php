<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>@lang('laralum_events::general.events_list') - {{ Laralum\Settings\Models\Settings::first()->appname }}</title>
        <link rel="stylesheet" href="{{ \Laralum\Laralum\Packages::css() }}">
    </head>
    <body>
        <h1>{{ $event->title }}</h1>


            <card>
                <center>
                    @if(!$event->started())
                        @lang('laralum_events::general.start_date')
                        <br>
                        {{ $event->startDatetime()->diffForHumans() }}
                    @elseif (!$event->finished())
                        @lang('laralum_events::general.end_date')
                        <br>
                        {{ $event->endDatetime()->diffForHumans() }}
                    @else
                        @lang('laralum_events::general.you_were_late')
                        <br>
                        @lang('laralum_events::general.event_celebrated')
                    @endif
                </center>
                <hr>
                <dl>
                    <dt>@lang('laralum_events::general.description')</dt>
                    <dd>{!! $event->description !!}</dd>
                    <dt>@lang('laralum_events::general.duration')</dt>
                    <dd>{{ $event->endDatetime()->diffForHumans($event->startDatetime(), true) }}</dd>
                    <dt>@lang('laralum_events::general.place')</dt>
                    <dd>{{ $event->place }}</dd>
                    <dt>@lang('laralum_events::general.start_date')</dt>
                    <dd>{{ $event->startDatetime() }}</dd>
                    <dt>@lang('laralum_events::general.end_date')</dt>
                    <dd>{{ $event->endDatetime() }}</dd>
                    <dt>@lang('laralum_events::general.price')</dt>
                    <dd>{{ $event->price }}</dd>
                </dl>
            </card>

            <table>
                <thead>
                    <tr>
                        <th>@lang('laralum::general.name')</th>
                        <th>@lang('laralum::general.email')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $user->name }}@if($event->hasResponsible($user))&emsp;<badge>@lang('laralum_events::general.responsible')</badge>@endif</td>
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
            {{ $users->links() }}
    </body>
</html>
