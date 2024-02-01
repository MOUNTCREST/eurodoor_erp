
@extends('superadmin.layouts.app')

@section('content')
<!-- start main content section -->
<div x-data="sales">
                        <ul class="flex space-x-2 rtl:space-x-reverse">
                            <li>
                                <a href="javascript:;" class="text-primary hover:underline">Loginfo</a>
                            </li>
                            <!-- <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
                                <span>Sales</span>
                            </li> -->
                        </ul>

                        <div class="pt-5">
                        <div x-data="basic">
                        <div class="panel">

						
						<table id="myTable" class="table-hover whitespace-nowrap">
											<thead>
												<tr>
												<th>Name</th>
												<th>Login Date Time</th>
												<th>Logout Date Time</th>
												<th>IP Address</th>
												<th>Location</th>
												</tr>
												</thead>
												<tbody>
													@foreach($info_lists as $info_list)
													<tr>
														<td>{{$info_list->name}}</td>
														<td>{{$info_list->login_date_time}}</td>
														<td>{{$info_list->logout_date_time}}</td>
														<td>{{$info_list->ipaddress}}</td>
														<td>{{$info_list->location}}</td>
													</tr>
													@endforeach
												</tbody>
											</table>
  
                                            </div>
                                            </div>
                        </div>
    </div>
                    <!-- end main content section -->


@endsection
@section('scripts')
<script>
            document.addEventListener('alpine:init', () => {
                // main section
                

                Alpine.data('basic', () => ({
                    datatable: null,
                    init() {
                        this.datatable = new simpleDatatables.DataTable('#myTable', {
                           
                            sortable: false,
                            searchable: false,
                            perPage: 10,
                            perPageSelect: [10, 20, 30, 50, 100],
                            firstLast: true,
                            firstText:
                                '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M13 19L7 12L13 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> <path opacity="0.5" d="M16.9998 19L10.9998 12L16.9998 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>',
                            lastText:
                                '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M11 19L17 12L11 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> <path opacity="0.5" d="M6.99976 19L12.9998 12L6.99976 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>',
                            prevText:
                                '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M15 5L9 12L15 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>',
                            nextText:
                                '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>',
                            labels: {
                                perPage: '{select}',
                            },
                            layout: {
                                top: '{search}',
                                bottom: '{info}{select}{pager}',
                            },
                        });
                    },
                }));
            });
        </script>
@endsection