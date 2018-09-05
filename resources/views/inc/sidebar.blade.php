<div class="col-lg-3 col-md-3">
    <div class="sidebar-right">
        @if(count($continents) > 0)
        <div class="widget mb-3">
            <div class="widget-header"><span>Continents</span></div>
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

        @if(count($popular_posts) > 0)
        <div class="widget mb-3">
            <div class="widget-header">
                <span>Popular posts</span>
                <ul class="raiting mt-2 float-right">
                    @for ($i = 0; $i < 5; $i++)
                        <li class="colored"></li>
                    @endfor
                </ul>
            </div>
            <div class="widget-body">
                <ul class="continent-list">
                    @foreach($popular_posts as $popular_post)
                        <li><a href="/posts/{{$popular_post->id}}">{{$popular_post->title}}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        @if(count($author_posts) > 0)
        <div class="widget mb-3">
            <div class="widget-header">
                <span>Author post count</span>
            </div>
            <div class="widget-body">
                <ul class="continent-list">
                    @foreach($author_posts as $author_post)
                    <li>
                        <a href="/user/{{$author_post->id}}/user-posts">{{$author_post->name}}
                            <span class="badge badge-warning float-right">{{$author_post->posts->count()}}</span>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif
    </div>
</div>