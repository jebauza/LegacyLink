@extends('app')

@section('content')

<!-- Bread crumb and right sidebar toggle -->
@include('sections.breadcrumb', ['pages' => [
['name' => 'Centros', 'url' => '']
]
])

<office></office>

@endsection

@section('script')

@endsection
