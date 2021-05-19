@extends('app')

@section('content')

<!-- Bread crumb and right sidebar toggle -->
@include('sections.breadcrumb', ['pages' => [
['name' => 'Empleados', 'url' => '']
]
])

<employee></employee>

@endsection

@section('script')

@endsection
