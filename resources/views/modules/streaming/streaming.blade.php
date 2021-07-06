@extends('app')

@section('content')

<!-- Bread crumb and right sidebar toggle -->
@include('sections.breadcrumb', ['pages' => [
['name' => 'Streamings', 'url' => '']
]
])

<streaming></streaming>

@endsection

@section('script')

@endsection
