<div class="btn-group" data-toggle="buttons">
    @foreach($options as $option => $label)
        <label class="btn btn-default btn-sm {{ \Request::get('article_status', '2') == $option ? 'active' : '' }}">
            <input type="radio" class="user-article_status" value="{{ $option }}">{{$label}}
        </label>
    @endforeach
</div>
<div style="display: inline; float: right;" class="btn-group">
    <button type="button" class="btn btn-info dropdown-toggle" id="dropdownMenu1" data-toggle="dropdown">
        我要发文
        <span class="caret"></span>
    </button>
    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
        <li role="presentation">
            @if($type == 1)
                <a role="menuitem" tabindex="-1" href="{{ route('article.add_pics') }}">发布图集</a>
            @else
                <a role="menuitem" tabindex="-1" href="#">发布图集</a>
            @endif
        </li>
        <li role="presentation">
            @if($type == 1)
                <a role="menuitem" tabindex="-1" href="{{ route('article.create_ablum') }}">发布专辑</a>
            @else
                <a role="menuitem" tabindex="-1" href="{{ route('toutiao.create_ablum') }}">发布专辑</a>
            @endif
        </li>
    </ul>
</div>