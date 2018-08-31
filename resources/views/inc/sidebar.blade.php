<div class="col-lg-3 col-md-3">
    <div class="sidebar-right">
        @if(count($continents) > 0)
        <div class="widget mb-3">
            <div class="widget-header">Continents</div>
            <div class="widget-body">
                <ul class="continent-list">
                    @foreach($continents as $continent)
                        @if($continent->posts->count() > 0)
                        <li>
                            <a href="/posts/continent/{{$continent->id}}">{{$continent->name}}
                                <span class="badge badge-warning float-right">{{$continent->posts->count()}}</span>
                            </a>
                        </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
        @endif
    </div>
</div>