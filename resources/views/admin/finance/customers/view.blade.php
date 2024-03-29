
@extends('admin.layouts.app')

@section('content')
<!-- start main content section -->
<div x-data="invoicePreview">
                        <div class="mb-6 flex flex-wrap items-center justify-center gap-4 lg:justify-end">
                           

                            <a href="{{ route('customer_create')}}" class="btn btn-secondary gap-2">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="24px"
                                    height="24px"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.5"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="h-5 w-5"
                                >
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                                Create
                            </a>

                            <a href="{{ route('customer_edit',$result->id) }}" class="btn btn-warning gap-2">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5">
                                    <path
                                        opacity="0.5"
                                        d="M22 10.5V12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2H13.5"
                                        stroke="currentColor"
                                        stroke-width="1.5"
                                        stroke-linecap="round"
                                    ></path>
                                    <path
                                        d="M17.3009 2.80624L16.652 3.45506L10.6872 9.41993C10.2832 9.82394 10.0812 10.0259 9.90743 10.2487C9.70249 10.5114 9.52679 10.7957 9.38344 11.0965C9.26191 11.3515 9.17157 11.6225 8.99089 12.1646L8.41242 13.9L8.03811 15.0229C7.9492 15.2897 8.01862 15.5837 8.21744 15.7826C8.41626 15.9814 8.71035 16.0508 8.97709 15.9619L10.1 15.5876L11.8354 15.0091C12.3775 14.8284 12.6485 14.7381 12.9035 14.6166C13.2043 14.4732 13.4886 14.2975 13.7513 14.0926C13.9741 13.9188 14.1761 13.7168 14.5801 13.3128L20.5449 7.34795L21.1938 6.69914C22.2687 5.62415 22.2687 3.88124 21.1938 2.80624C20.1188 1.73125 18.3759 1.73125 17.3009 2.80624Z"
                                        stroke="currentColor"
                                        stroke-width="1.5"
                                    ></path>
                                    <path
                                        opacity="0.5"
                                        d="M16.6522 3.45508C16.6522 3.45508 16.7333 4.83381 17.9499 6.05034C19.1664 7.26687 20.5451 7.34797 20.5451 7.34797M10.1002 15.5876L8.4126 13.9"
                                        stroke="currentColor"
                                        stroke-width="1.5"
                                    ></path>
                                </svg>
                                Edit
                            </a>
                        </div>
                        <div class="panel">
                            <div class="flex flex-wrap justify-between gap-4 px-4">
                                <div class="text-2xl font-semibold uppercase">Customer</div>
                                <div class="shrink-0">
                                    <!-- <img src="assets/images/logo.svg" alt="image" class="w-14 ltr:ml-auto rtl:mr-auto" /> -->
                                </div>
                            </div>
                            <div class="px-4 ltr:text-right rtl:text-left">
                                <div class="mt-6 space-y-1 text-white-dark">
                                    <!-- <div>13 Tetrick Road, Cypress Gardens, Florida, 33884, US</div>
                                    <div>vristo@gmail.com</div>
                                    <div>+1 (070) 123-4567</div> -->
                                </div>
                            </div>

                            <hr class="my-6 border-[#e0e6ed] dark:border-[#1b2e4b]" />
                            <div class="flex flex-col flex-wrap justify-between gap-6 lg:flex-row">
                                <div class="flex-1">
                                    <div class="space-y-1 text-white-dark">
                                        <div>Customer Name:</div>
                                        <div class="font-semibold text-black dark:text-white">{{$result->customer_name;}}</div>
                                        <div>Contact Address:</div>
                                        <div class="font-semibold text-black dark:text-white">{{$result->contact_address;}}</div>
                                    </div>
                                </div>
                                <div class="flex flex-col justify-between gap-6 sm:flex-row lg:w-2/3">
                                    <div class="xl:1/3 sm:w-1/2 lg:w-2/5">
                                        <div class="mb-2 flex w-full items-center justify-between">
                                            <div class="text-white-dark">Code :</div>
                                            <div>{{$result->code;}}</div>
                                        </div>
                                       
                                        <div class="mb-2 flex w-full items-center justify-between">
                                            <div class="text-white-dark">Phone No:</div>
                                            <div>{{$result->mobile_no;}}</div>
                                        </div>
                                        <div class="mb-2 flex w-full items-center justify-between">
                                            <div class="text-white-dark">Email ID :</div>
                                            <div>{{$result->email_id;}}</div>
                                        </div>
                                   
                                    </div>
                                    <div class="xl:1/3 sm:w-1/2 lg:w-2/5">
                                        <div class="mb-2 flex w-full items-center justify-between">
                                            <div class="text-white-dark">Gst No:</div>
                                            <div class="whitespace-nowrap">{{$result->gst_no;}}</div>
                                        </div>
                                        <div class="mb-2 flex w-full items-center justify-between">
                                            <div class="text-white-dark">Credit Limit:</div>
                                            <div>{{$result->credit_limit;}}</div>
                                        </div>
                                        <div class="mb-2 flex w-full items-center justify-between">
                                            <div class="text-white-dark">Discount:</div>
                                            <div>{{$result->discount;}}</div>
                                        </div>
                                        <div class="mb-2 flex w-full items-center justify-between">
                                            <div class="text-white-dark">Permanent Address:</div>
                                            <div>{{$result->permenant_address;}}</div>
                                        </div>
                                        <div class="mb-2 flex w-full items-center justify-between">
                                            <div class="text-white-dark">Web Address:</div>
                                            <div>{{$result->web_address}}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            
                        </div>
                    </div>
<!-- end main content section -->
@endsection
@section('scripts')

@endsection