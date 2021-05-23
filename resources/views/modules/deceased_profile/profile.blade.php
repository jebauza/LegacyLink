@extends('app')

@section('content')

<!-- Bread crumb and right sidebar toggle -->
@include('sections.breadcrumb', ['pages' => [
['name' => 'Webs', 'url' => '']
]
])

<deceased-profile></deceased-profile>

@endsection

@section('script')

@endsection
