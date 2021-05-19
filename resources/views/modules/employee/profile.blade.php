@extends('app')

@section('content')

<!-- Bread crumb and right sidebar toggle -->
@include('sections.breadcrumb', ['pages' => [
['name' => 'Perfil', 'url' => '']
]
])

<profile :employee="{{ json_encode(auth()->user()) }}"></profile>

@endsection

@section('script')

@endsection
