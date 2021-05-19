{{-- BREADCRUMBS --}}

<div class="row mb-5">
    <div class="col">
        <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold my-2 p-0">
            <li class="breadcrumb-item text-muted">
                <a href="{{ url()->route('admin.home') }}" class="text-muted">Home</a>
            </li>
            @foreach($pages as $p)
            <li class="breadcrumb-item {{ ($p == end($pages)) ? 'active' : 'text-muted' }}">
                @if($p['url'])
                <a class="text-muted" href="{{url($p['url'])}}">{{$p['name']}}</a>
                @else
                <span class="text-muted">{{$p['name']}}</span>
                @endif
            </li>
            @endforeach
        </ul>
    </div>
</div>

@include('sections.alerts')
