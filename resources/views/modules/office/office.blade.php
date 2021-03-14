@extends('app')

@section('content')

<!--begin::Card-->
<div class="card card-custom">
    <div class="card-header flex-wrap border-0 pt-6 pb-0">
        <div class="card-title">
            <h3 class="card-label">Sucursales
                <span class="d-block text-muted pt-2 font-size-sm"></span></h3>
        </div>
        <div class="card-toolbar">
            <!--begin::Button-->
            <a href="" class="btn btn-primary font-weight-bolder">
                <span class="svg-icon svg-icon-md">
                    <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo3\dist/../src/media/svg/icons\Code\Plus.svg-->
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                        height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <rect x="0" y="0" width="24" height="24" />
                            <circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10" />
                            <path
                                d="M11,11 L11,7 C11,6.44771525 11.4477153,6 12,6 C12.5522847,6 13,6.44771525 13,7 L13,11 L17,11 C17.5522847,11 18,11.4477153 18,12 C18,12.5522847 17.5522847,13 17,13 L13,13 L13,17 C13,17.5522847 12.5522847,18 12,18 C11.4477153,18 11,17.5522847 11,17 L11,13 L7,13 C6.44771525,13 6,12.5522847 6,12 C6,11.4477153 6.44771525,11 7,11 L11,11 Z"
                                fill="#000000" />
                        </g>
                    </svg>
                    <!--end::Svg Icon-->
                </span>Crear</a>
            <!--end::Button-->
        </div>
    </div>
    <div class="card-body">
        <!--begin: Search Form-->
        <!--begin::Search Form-->
        <div class="mb-7">
            <div class="row align-items-center">
                <div class="col-lg-9 col-xl-8">
                    <div class="row align-items-center">
                        <div class="col-md-4 my-2 my-md-0">
                            <div class="input-icon">
                                <input type="text" class="form-control" placeholder="Search..."
                                    id="kt_datatable_search_query">
                                <span>
                                    <i class="flaticon2-search-1 text-muted"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-4 my-2 my-md-0">
                            <div class="d-flex align-items-center">
                                <label class="mr-3 mb-0 d-none d-md-block">Status:</label>
                                <div class="dropdown bootstrap-select form-control"><select class="form-control"
                                        id="kt_datatable_search_status">
                                        <option value="">All</option>
                                        <option value="1">Pending</option>
                                        <option value="2">Delivered</option>
                                        <option value="3">Canceled</option>
                                        <option value="4">Success</option>
                                        <option value="5">Info</option>
                                        <option value="6">Danger</option>
                                    </select><button type="button" tabindex="-1"
                                        class="btn dropdown-toggle btn-light bs-placeholder" data-toggle="dropdown"
                                        role="combobox" aria-owns="bs-select-1" aria-haspopup="listbox"
                                        aria-expanded="false" data-id="kt_datatable_search_status" title="All">
                                        <div class="filter-option">
                                            <div class="filter-option-inner">
                                                <div class="filter-option-inner-inner">All</div>
                                            </div>
                                        </div>
                                    </button>
                                    <div class="dropdown-menu ">
                                        <div class="inner show" role="listbox" id="bs-select-1" tabindex="-1">
                                            <ul class="dropdown-menu inner show" role="presentation"></ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 my-2 my-md-0">
                            <div class="d-flex align-items-center">
                                <label class="mr-3 mb-0 d-none d-md-block">Type:</label>
                                <div class="dropdown bootstrap-select form-control"><select class="form-control"
                                        id="kt_datatable_search_type">
                                        <option value="">All</option>
                                        <option value="1">Online</option>
                                        <option value="2">Retail</option>
                                        <option value="3">Direct</option>
                                    </select><button type="button" tabindex="-1"
                                        class="btn dropdown-toggle btn-light bs-placeholder" data-toggle="dropdown"
                                        role="combobox" aria-owns="bs-select-2" aria-haspopup="listbox"
                                        aria-expanded="false" data-id="kt_datatable_search_type" title="All">
                                        <div class="filter-option">
                                            <div class="filter-option-inner">
                                                <div class="filter-option-inner-inner">All</div>
                                            </div>
                                        </div>
                                    </button>
                                    <div class="dropdown-menu ">
                                        <div class="inner show" role="listbox" id="bs-select-2" tabindex="-1">
                                            <ul class="dropdown-menu inner show" role="presentation"></ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-xl-4 mt-5 mt-lg-0">
                    <a href="#" class="btn btn-light-primary px-6 font-weight-bold">Search</a>
                </div>
            </div>
        </div>
        <!--end::Search Form-->
        <!--end: Search Form-->
        <!--begin: Datatable-->
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th class="datatable-cell">Order ID</th>
                        <th class="datatable-cell">Car Make</th>
                        <th class="datatable-cell">Car ModelD</th>
                    </tr>
                </thead>
            </table>


            <div class="datatable-pager datatable-paging-loaded">
                <ul class="datatable-pager-nav my-2 mb-sm-0">
                    <li><a title="First"
                            class="datatable-pager-link datatable-pager-link-first datatable-pager-link-disabled"
                            data-page="1" disabled="disabled"><i class="flaticon2-fast-back"></i></a></li>
                    <li><a title="Previous"
                            class="datatable-pager-link datatable-pager-link-prev datatable-pager-link-disabled"
                            data-page="1" disabled="disabled"><i class="flaticon2-back"></i></a></li>
                    <li style="display: none;"><input type="text" class="datatable-pager-input form-control"
                            title="Page number"></li>
                    <li><a class="datatable-pager-link datatable-pager-link-number datatable-pager-link-active"
                            data-page="1" title="1">1</a></li>
                    <li><a class="datatable-pager-link datatable-pager-link-number" data-page="2" title="2">2</a></li>
                    <li><a class="datatable-pager-link datatable-pager-link-number" data-page="3" title="3">3</a></li>
                    <li><a class="datatable-pager-link datatable-pager-link-number" data-page="4" title="4">4</a></li>
                    <li><a class="datatable-pager-link datatable-pager-link-number" data-page="5" title="5">5</a></li>
                    <li><a title="Next" class="datatable-pager-link datatable-pager-link-next" data-page="2"><i
                                class="flaticon2-next"></i></a></li>
                    <li><a title="Last" class="datatable-pager-link datatable-pager-link-last" data-page="15"><i
                                class="flaticon2-fast-next"></i></a></li>
                </ul>
            </div>
        </div>
        <!--end: Datatable-->
    </div>
</div>
<!--end::Card-->

@endsection

@section('script')

@endsection
