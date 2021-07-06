@extends('app')

@section('content')

<!-- Bread crumb and right sidebar toggle -->
@include('sections.breadcrumb', ['pages' => [
['name' => 'Clientes', 'url' => '']
]
])

<user></user>

@endsection

@section('script')

@endsection
