    @php
        $user = \MahaCMS\Users\Models\User::findOrFail(Auth::id());
    @endphp
    <div class="uk-container uk-container-large">
        <div uk-grid>
            @foreach ($widgets as $widget)
                @if (array_key_exists('permission', $widget))
                    @if ($user->hasPermission($widget['permission']) or $user->superAdmin())
                        <div class="uk-width-1-1@m uk-width-1-2@l">
                            <div class="uk-card uk-card-default uk-card-body uk-height-1-1">
                                {!! view($widget['view']) !!}
                            </div>
                        </div>
                    @endif
                @else
                    <div class="uk-width-1-1@m uk-width-1-2@l">
                        <div class="uk-card uk-card-default uk-card-body uk-height-1-1">
                            {!! view($widget['view']) !!}
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>