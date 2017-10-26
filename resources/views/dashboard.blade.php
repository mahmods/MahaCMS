<div class="uk-container uk-container-large">
<div uk-grid>
    @foreach ($widgets as $widget)
                <div class="uk-width-1-1@m uk-width-1-2@l">
                    <div class="uk-card uk-card-default uk-card-body uk-height-1-1">
                        {!! $widget['view'] !!}
                    </div>
                </div>
    @endforeach
</div>
</div>