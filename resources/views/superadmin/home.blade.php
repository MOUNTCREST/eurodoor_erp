@extends('superadmin.layouts.app')

@section('content')
<!-- start main content section -->
<div x-data="sales">
                        <ul class="flex space-x-2 rtl:space-x-reverse">
                            <li>
                                <a href="javascript:;" class="text-primary hover:underline">Dashboard</a>
                            </li>
                            <!-- <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
                                <span>Sales</span>
                            </li> -->
                        </ul>

                        <div class="pt-5">
                            

                            <div class="mb-6 grid gap-6 sm:grid-cols-2 xl:grid-cols-3">
                                <div class="panel h-full sm:col-span-2 xl:col-span-1">
                                    <div class="mb-5 flex items-center">
                                        <h5 class="text-lg font-semibold dark:text-white-light">
                                            Company
                                        </h5>
                                        
                                    </div>
                                  
                                </div>

                                <div class="panel h-full">
                                    <div class="mb-5 flex items-center dark:text-white-light">
                                        <h5 class="text-lg font-semibold">User</h5>
                                        
                                    </div>
                                    
                                </div>

                                <div class="panel h-full">
                                    <div class="mb-5 flex items-center dark:text-white-light">
                                        <h5 class="text-lg font-semibold">Loginfo</h5>
                                        
                                    </div>
                                    
                                </div>

                                
                            </div>

                      
                                

                                
                            </div>

                        </div>
                    </div>
                    <!-- end main content section -->


@endsection
