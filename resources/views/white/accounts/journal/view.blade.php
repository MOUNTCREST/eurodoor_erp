
@extends('white.layouts.app')

@section('content')
<!-- start main content section -->
<div x-data="">
  
                        <div class="mb-6 flex flex-wrap items-center justify-center gap-4 lg:justify-end">
                            <button type="button" class="btn btn-info gap-2">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5">
                                    <path
                                        d="M17.4975 18.4851L20.6281 9.09373C21.8764 5.34874 22.5006 3.47624 21.5122 2.48782C20.5237 1.49939 18.6511 2.12356 14.906 3.37189L5.57477 6.48218C3.49295 7.1761 2.45203 7.52305 2.13608 8.28637C2.06182 8.46577 2.01692 8.65596 2.00311 8.84963C1.94433 9.67365 2.72018 10.4495 4.27188 12.0011L4.55451 12.2837C4.80921 12.5384 4.93655 12.6658 5.03282 12.8075C5.22269 13.0871 5.33046 13.4143 5.34393 13.7519C5.35076 13.9232 5.32403 14.1013 5.27057 14.4574C5.07488 15.7612 4.97703 16.4131 5.0923 16.9147C5.32205 17.9146 6.09599 18.6995 7.09257 18.9433C7.59255 19.0656 8.24576 18.977 9.5522 18.7997L9.62363 18.79C9.99191 18.74 10.1761 18.715 10.3529 18.7257C10.6738 18.745 10.9838 18.8496 11.251 19.0285C11.3981 19.1271 11.5295 19.2585 11.7923 19.5213L12.0436 19.7725C13.5539 21.2828 14.309 22.0379 15.1101 21.9985C15.3309 21.9877 15.5479 21.9365 15.7503 21.8474C16.4844 21.5244 16.8221 20.5113 17.4975 18.4851Z"
                                        stroke="currentColor"
                                        stroke-width="1.5"
                                    />
                                    <path opacity="0.5" d="M6 18L21 3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                </svg>
                                Send
                            </button>

                            <button type="button" class="btn btn-primary gap-2" @click="print">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5">
                                    <path
                                        d="M6 17.9827C4.44655 17.9359 3.51998 17.7626 2.87868 17.1213C2 16.2426 2 14.8284 2 12C2 9.17157 2 7.75736 2.87868 6.87868C3.75736 6 5.17157 6 8 6H16C18.8284 6 20.2426 6 21.1213 6.87868C22 7.75736 22 9.17157 22 12C22 14.8284 22 16.2426 21.1213 17.1213C20.48 17.7626 19.5535 17.9359 18 17.9827"
                                        stroke="currentColor"
                                        stroke-width="1.5"
                                    />
                                    <path opacity="0.5" d="M9 10H6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                    <path d="M19 14L5 14" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                    <path
                                        d="M18 14V16C18 18.8284 18 20.2426 17.1213 21.1213C16.2426 22 14.8284 22 12 22C9.17157 22 7.75736 22 6.87868 21.1213C6 20.2426 6 18.8284 6 16V14"
                                        stroke="currentColor"
                                        stroke-width="1.5"
                                        stroke-linecap="round"
                                    />
                                    <path
                                        opacity="0.5"
                                        d="M17.9827 6C17.9359 4.44655 17.7626 3.51998 17.1213 2.87868C16.2427 2 14.8284 2 12 2C9.17158 2 7.75737 2 6.87869 2.87868C6.23739 3.51998 6.06414 4.44655 6.01733 6"
                                        stroke="currentColor"
                                        stroke-width="1.5"
                                    />
                                    <circle opacity="0.5" cx="17" cy="10" r="1" fill="currentColor" />
                                    <path opacity="0.5" d="M15 16.5H9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                    <path opacity="0.5" d="M13 19H9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                </svg>
                                Print
                            </button>

                            <button type="button" class="btn btn-success gap-2">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5">
                                    <path
                                        opacity="0.5"
                                        d="M17 9.00195C19.175 9.01406 20.3529 9.11051 21.1213 9.8789C22 10.7576 22 12.1718 22 15.0002V16.0002C22 18.8286 22 20.2429 21.1213 21.1215C20.2426 22.0002 18.8284 22.0002 16 22.0002H8C5.17157 22.0002 3.75736 22.0002 2.87868 21.1215C2 20.2429 2 18.8286 2 16.0002L2 15.0002C2 12.1718 2 10.7576 2.87868 9.87889C3.64706 9.11051 4.82497 9.01406 7 9.00195"
                                        stroke="currentColor"
                                        stroke-width="1.5"
                                        stroke-linecap="round"
                                    ></path>
                                    <path
                                        d="M12 2L12 15M12 15L9 11.5M12 15L15 11.5"
                                        stroke="currentColor"
                                        stroke-width="1.5"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    ></path>
                                </svg>
                                Download
                            </button>

                            
                        </div>
                        <div class="panel">
                            <div class="flex flex-wrap justify-between gap-4 px-4">
                                <div class="text-2xl font-semibold uppercase">Journal</div>
                                <div class="shrink-0">
                                    <!-- <img src="assets/images/logo.svg" alt="image" class="w-14 ltr:ml-auto rtl:mr-auto" /> -->
                                </div>
                            </div>
                            <div class="px-4 ltr:text-right rtl:text-left">
                                <!-- <div class="mt-6 space-y-1 text-white-dark">
                                    <div>13 Tetrick Road, Cypress Gardens, Florida, 33884, US</div>
                                    <div>vristo@gmail.com</div>
                                    <div>+1 (070) 123-4567</div>
                                </div> -->
                            </div>

                            <hr class="my-6 border-[#e0e6ed] dark:border-[#1b2e4b]" />
                            <div class="flex flex-col flex-wrap justify-between gap-6 lg:flex-row">
                                <div class="flex-1">
                                    <div class="space-y-1 text-white-dark">
                                        <div>Reference No:</div>
                                        <div class="font-semibold text-black dark:text-white">{{$result->reference_no}}</div>
                                    </div>
                                </div>
                                <div class="flex flex-col justify-between gap-6 sm:flex-row lg:w-2/3">
                                    <div class="xl:1/3 sm:w-1/2 lg:w-2/5">
                                    <div class="mb-2 flex w-full items-center justify-between">
                                            <div class="text-white-dark">Date :</div>
                                            <div>{{ \Carbon\Carbon::parse($result->t_date)->format('d-m-Y') }}</div>
                                        </div>
                                        <div class="mb-2 flex w-full items-center justify-between">
                                            <div class="text-white-dark">Transaction No :</div>
                                            <div>{{$result->t_no;}}</div>
                                        </div>
                                       
                                    
                                    </div>
                                    <div class="xl:1/3 sm:w-1/2 lg:w-2/5">
                                    <div class="mb-2 flex w-full items-center justify-between">
                                            <div class="text-white-dark">Fitting/Packing</div>
                                            <div class="whitespace-nowrap">{{$result->fitting_or_packing}}</div>
                                        </div>
                                    <div class="mb-2 flex w-full items-center justify-between">
                                            <div class="text-white-dark">Narration</div>
                                            <div class="whitespace-nowrap">{{$result->narration}}</div>
                                        </div>
                                        <div class="mb-2 flex w-full items-center justify-between">
                                            <div class="text-white-dark">Status</div>
                                            <div class="whitespace-nowrap">
                                                @if($result->approved_or_not == 'no')
                                                    {{ 'Not Approved' }}
                                                @else
                                                    {{ 'Approved' }}
                                                @endif
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive mt-6">
                                <table>
                                <thead>
                                        <tr>
                                        <th width="100">SL NO</th>
                                            <th>LEDGER</th>
                                            <th>DR AMOUNT </th>
                                            <th>CR AMOUNT</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($t_details as $t_item)
                                    <tr>
                                        <td>{{$no++}}</td>
                                        <td>{{$t_item->ledger;}}</td>
                                        <td>{{$t_item->type == 'dr' ? '' : $t_item->amount}}</td>
                                        <td>{{$t_item->type == 'cr' ? '' : $t_item->amount}}</td>  
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                           
                        </div>
                    </div>
<!-- end main content section -->
@endsection
@section('scripts')

@endsection