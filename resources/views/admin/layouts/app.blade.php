<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <title>EURODOOR</title>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/favicon.png') }}" />
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('assets/css/perfect-scrollbar.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/css/highlight.min.css') }}" />
        <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('assets/css/style.css') }}" />
        <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('assets/css/cmn_style.css') }}" />
        <link defer rel="stylesheet" type="text/css" media="screen" href="{{ asset('assets/css/animate.css') }}" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" />
       
        
      
        
        <script src="{{ asset('assets/js/perfect-scrollbar.min.js') }}"></script>
        <script defer src="{{ asset('assets/js/popper.min.js') }}"></script>
        <script defer src="{{ asset('assets/js/tippy-bundle.umd.min.js') }}"></script>
        <script defer src="{{ asset('assets/js/sweetalert.min.js') }}"></script>

        <!-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script> -->


  <!-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script> -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

       <!-- Select2  -->
       <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

         <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>


    </head>

    <body
        x-data="main"
        class="relative overflow-x-hidden font-nunito text-sm font-normal antialiased"
        :class="[ $store.app.sidebar ? 'toggle-sidebar' : '', $store.app.theme, $store.app.menu, $store.app.layout,$store.app.rtlClass]"
    >
        <!-- sidebar menu overlay -->
        <div x-cloak class="fixed inset-0 z-50 bg-[black]/60 lg:hidden" :class="{'hidden' : !$store.app.sidebar}" @click="$store.app.toggleSidebar()"></div>

        <!-- screen loader -->
        <div class="screen_loader animate__animated fixed inset-0 z-[60] grid place-content-center bg-[#fafafa] dark:bg-[#060818]">
            <svg width="64" height="64" viewBox="0 0 135 135" xmlns="http://www.w3.org/2000/svg" fill="#4361ee">
                <path
                    d="M67.447 58c5.523 0 10-4.477 10-10s-4.477-10-10-10-10 4.477-10 10 4.477 10 10 10zm9.448 9.447c0 5.523 4.477 10 10 10 5.522 0 10-4.477 10-10s-4.478-10-10-10c-5.523 0-10 4.477-10 10zm-9.448 9.448c-5.523 0-10 4.477-10 10 0 5.522 4.477 10 10 10s10-4.478 10-10c0-5.523-4.477-10-10-10zM58 67.447c0-5.523-4.477-10-10-10s-10 4.477-10 10 4.477 10 10 10 10-4.477 10-10z"
                >
                    <animateTransform attributeName="transform" type="rotate" from="0 67 67" to="-360 67 67" dur="2.5s" repeatCount="indefinite" />
                </path>
                <path
                    d="M28.19 40.31c6.627 0 12-5.374 12-12 0-6.628-5.373-12-12-12-6.628 0-12 5.372-12 12 0 6.626 5.372 12 12 12zm30.72-19.825c4.686 4.687 12.284 4.687 16.97 0 4.686-4.686 4.686-12.284 0-16.97-4.686-4.687-12.284-4.687-16.97 0-4.687 4.686-4.687 12.284 0 16.97zm35.74 7.705c0 6.627 5.37 12 12 12 6.626 0 12-5.373 12-12 0-6.628-5.374-12-12-12-6.63 0-12 5.372-12 12zm19.822 30.72c-4.686 4.686-4.686 12.284 0 16.97 4.687 4.686 12.285 4.686 16.97 0 4.687-4.686 4.687-12.284 0-16.97-4.685-4.687-12.283-4.687-16.97 0zm-7.704 35.74c-6.627 0-12 5.37-12 12 0 6.626 5.373 12 12 12s12-5.374 12-12c0-6.63-5.373-12-12-12zm-30.72 19.822c-4.686-4.686-12.284-4.686-16.97 0-4.686 4.687-4.686 12.285 0 16.97 4.686 4.687 12.284 4.687 16.97 0 4.687-4.685 4.687-12.283 0-16.97zm-35.74-7.704c0-6.627-5.372-12-12-12-6.626 0-12 5.373-12 12s5.374 12 12 12c6.628 0 12-5.373 12-12zm-19.823-30.72c4.687-4.686 4.687-12.284 0-16.97-4.686-4.686-12.284-4.686-16.97 0-4.687 4.686-4.687 12.284 0 16.97 4.686 4.687 12.284 4.687 16.97 0z"
                >
                    <animateTransform attributeName="transform" type="rotate" from="0 67 67" to="360 67 67" dur="8s" repeatCount="indefinite" />
                </path>
            </svg>
        </div>

        <!-- scroll to top button -->
        <div class="fixed bottom-6 z-50 ltr:right-6 rtl:left-6" x-data="scrollToTop">
            <template x-if="showTopButton">
                <button
                    type="button"
                    class="btn btn-outline-primary animate-pulse rounded-full bg-[#fafafa] p-2 dark:bg-[#060818] dark:hover:bg-primary"
                    @click="goToTop"
                >
                    <svg width="24" height="24" class="h-4 w-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            opacity="0.5"
                            fill-rule="evenodd"
                            clip-rule="evenodd"
                            d="M12 20.75C12.4142 20.75 12.75 20.4142 12.75 20L12.75 10.75L11.25 10.75L11.25 20C11.25 20.4142 11.5858 20.75 12 20.75Z"
                            fill="currentColor"
                        />
                        <path
                            d="M6.00002 10.75C5.69667 10.75 5.4232 10.5673 5.30711 10.287C5.19103 10.0068 5.25519 9.68417 5.46969 9.46967L11.4697 3.46967C11.6103 3.32902 11.8011 3.25 12 3.25C12.1989 3.25 12.3897 3.32902 12.5304 3.46967L18.5304 9.46967C18.7449 9.68417 18.809 10.0068 18.6929 10.287C18.5768 10.5673 18.3034 10.75 18 10.75L6.00002 10.75Z"
                            fill="currentColor"
                        />
                    </svg>
                </button>
            </template>
        </div>

      

        <div class="main-container min-h-screen text-black dark:text-white-dark" :class="[$store.app.navbar]">
            <!-- start sidebar section -->
            <div :class="{'dark text-white-dark' : $store.app.semidark}">
                <nav
                    x-data="sidebar"
                    class="sidebar fixed top-0 bottom-0 z-50 h-full min-h-screen w-[260px] shadow-[5px_0_25px_0_rgba(94,92,154,0.1)] transition-all duration-300"
                >
                    <div class="h-full bg-white dark:bg-[#0e1726]">
                        <div class="flex items-center justify-between px-4 py-3">
                            <a href="{{ url('home') }}" class="main-logo flex shrink-0 items-center">
                                <img class="ml-[18px] w-44 flex-none" src="{{ asset('assets/images/logo.svg') }}" alt="image" />
                                <!-- <span class="align-middle text-2xl font-semibold ltr:ml-1.5 rtl:mr-1.5 dark:text-white-light lg:inline">SPECTRUM</span> -->
                            </a>
                            <a
                                href="javascript:;"
                                class="collapse-icon flex h-8 w-8 items-center rounded-full transition duration-300 hover:bg-gray-500/10 rtl:rotate-180 dark:text-white-light dark:hover:bg-dark-light/10"
                                @click="$store.app.toggleSidebar()"
                            >
                                <svg class="m-auto h-5 w-5" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M13 19L7 12L13 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    <path
                                        opacity="0.5"
                                        d="M16.9998 19L10.9998 12L16.9998 5"
                                        stroke="currentColor"
                                        stroke-width="1.5"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    />
                                </svg>
                            </a>
                        </div>
                        <ul
                            class="perfect-scrollbar relative h-[calc(100vh-80px)] space-y-0.5 overflow-y-auto overflow-x-hidden p-4 py-0 font-semibold"
                            x-data="{ activeDropdown: 'datatables' }"
                        >
                            

                            <h2 class="-mx-4 mb-1 flex items-center bg-white-light/30 py-3 px-7 font-extrabold uppercase dark:bg-dark dark:bg-opacity-[0.08]">
                                <svg
                                    class="hidden h-5 w-4 flex-none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.5"
                                    fill="none"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                                <span>MENUS</span>
                            </h2>

                            <li class="nav-item">
                                <ul>
                                    <li class="nav-item">
                                        <a href="{{ url('home') }}" class="group">
                                            <div class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
  <path opacity="0.5" d="M10.8468 21.9342C5.86713 21.3624 2 17.1328 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.1565 18.7173 16.7325 15.9135 16.3703C14.2964 16.1614 12.8386 15.9731 12.2619 16.888C11.8674 17.5136 12.2938 18.2938 12.8168 18.8168C13.4703 19.4703 13.4703 20.5297 12.8168 21.1832C12.2938 21.7062 11.5816 22.0186 10.8468 21.9342Z" fill="#1C274C"/>
  <path d="M11.085 7C11.085 7.82843 10.4134 8.5 9.585 8.5C8.75658 8.5 8.085 7.82843 8.085 7C8.085 6.17157 8.75658 5.5 9.585 5.5C10.4134 5.5 11.085 6.17157 11.085 7Z" fill="#1C274C"/>
  <path d="M6.5 13.0002C7.32843 13.0002 8 12.3287 8 11.5002C8 10.6718 7.32843 10.0002 6.5 10.0002C5.67157 10.0002 5 10.6718 5 11.5002C5 12.3287 5.67157 13.0002 6.5 13.0002Z" fill="#1C274C"/>
  <path d="M17.5 13.0002C18.3284 13.0002 19 12.3287 19 11.5002C19 10.6718 18.3284 10.0002 17.5 10.0002C16.6716 10.0002 16 10.6718 16 11.5002C16 12.3287 16.6716 13.0002 17.5 13.0002Z" fill="#1C274C"/>
  <path d="M14.5 8.50023C15.3284 8.50023 16 7.82866 16 7.00023C16 6.1718 15.3284 5.50023 14.5 5.50023C13.6716 5.50023 13 6.1718 13 7.00023C13 7.82866 13.6716 8.50023 14.5 8.50023Z" fill="#1C274C"/>
</svg>
                                                <span class="text-black ltr:pl-3 rtl:pr-3 dark:text-[#506690] dark:group-hover:text-white-dark">Home</span>
                                            </div>
                                        </a>
                                    </li>
                                    
                                   
                                    <li class="menu nav-item">
                                        <button
                                            type="button"
                                            class="nav-link group"
                                            :class="{'active' : activeDropdown === 'invoice'}"
                                            @click="activeDropdown === 'invoice' ? activeDropdown = null : activeDropdown = 'invoice'"
                                        >
                                            <div class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
  <path fill-rule="evenodd" clip-rule="evenodd" d="M9.87763 4.24993C10.1869 3.37503 11.0213 2.75 11.9998 2.75C12.9783 2.75 13.8127 3.37503 14.122 4.24993C14.26 4.64047 14.6885 4.84517 15.079 4.70713C15.4696 4.56909 15.6742 4.1406 15.5362 3.75007C15.0218 2.29459 13.6337 1.25 11.9998 1.25C10.3658 1.25 8.9778 2.29459 8.46337 3.75007C8.32533 4.1406 8.53002 4.56909 8.92056 4.70713C9.3111 4.84517 9.73959 4.64047 9.87763 4.24993ZM2.74709 8.09098C2.69375 8.05631 2.63765 8.02929 2.58008 8.00965C2.73322 7.69204 2.92679 7.41623 3.17145 7.17157C4.34303 6 6.22864 6 9.99988 6H13.9999C17.7711 6 19.6567 6 20.8283 7.17157C21.073 7.41626 21.2666 7.6921 21.4197 8.00975C21.3623 8.02939 21.3063 8.05637 21.253 8.09098C19.1526 9.45626 17.833 10.3102 16.7364 10.858C16.6701 10.5117 16.3655 10.25 15.9999 10.25C15.5857 10.25 15.2499 10.5858 15.2499 11V11.4581C13.1304 12.0976 10.8693 12.0976 8.74988 11.458V11C8.74988 10.5858 8.41409 10.25 7.99988 10.25C7.63428 10.25 7.32978 10.5116 7.26334 10.8578C6.1669 10.31 4.84732 9.45613 2.74709 8.09098Z" fill="#1C274C"/>
  <path opacity="0.5" d="M2 13.9998C2 12.0494 2 10.6033 2.16208 9.49951C4.43876 10.9794 5.89798 11.9231 7.25 12.5044V12.9998C7.25 13.414 7.58579 13.7498 8 13.7498C8.40872 13.7498 8.74109 13.4229 8.74982 13.0163C10.8801 13.5779 13.1199 13.5779 15.2502 13.0163C15.259 13.4229 15.5913 13.7498 16 13.7498C16.4142 13.7498 16.75 13.414 16.75 12.9998V12.5045C18.1021 11.9233 19.5613 10.9796 21.8379 9.49971C22 10.6035 22 12.0495 22 13.9998C22 17.7711 22 19.6567 20.8284 20.8283C19.6569 21.9998 17.7712 21.9998 14 21.9998H10C6.22876 21.9998 4.34315 21.9998 3.17157 20.8283C2 19.6567 2 17.7711 2 13.9998Z" fill="#1C274D"/>
</svg>

                                                
                                                <span class="text-black ltr:pl-3 rtl:pr-3 dark:text-[#506690] dark:group-hover:text-white-dark">Finance Masters</span>
                                            </div>
                                            <div class="rtl:rotate-180" :class="{'!rotate-90' : activeDropdown === 'invoice'}">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M9 5L15 12L9 19"
                                                        stroke="currentColor"
                                                        stroke-width="1.5"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                    />
                                                </svg>
                                            </div>
                                        </button>
                                        <ul x-cloak x-show="activeDropdown === 'invoice'" x-collapse class="sub-menu text-gray-500">
                                            <li>
                                                <a href="{{ route('opening_balance_list')}}">Opening Balance</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('ledger_group_list') }}">Ledger Groups</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('ledger_list')}}">Ledgers</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('supplier_list')}}">Suppliers</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('customer_list')}}">Customers</a>
                                            </li>
                                            
                                        </ul>
                                    </li>
                                    
                                </ul>
                            </li>

                            <!-- <h2 class="-mx-4 mb-1 flex items-center bg-white-light/30 py-3 px-7 font-extrabold uppercase dark:bg-dark dark:bg-opacity-[0.08]">
                                <svg
                                    class="hidden h-5 w-4 flex-none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.5"
                                    fill="none"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                                <span>USER INTERFACE</span>
                            </h2> -->

                            <li class="menu nav-item">
                                <button
                                    type="button"
                                    class="nav-link group"
                                    :class="{'active' : activeDropdown === 'components'}"
                                    @click="activeDropdown === 'components' ? activeDropdown = null : activeDropdown = 'components'"
                                >
                                    <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
  <path d="M14.5 21.9913V18.5C14.5 17.5654 14.5 17.0981 14.299 16.75C14.1674 16.522 13.978 16.3326 13.75 16.201C13.4019 16 12.9346 16 12 16C11.0654 16 10.5981 16 10.25 16.201C10.022 16.3326 9.83261 16.522 9.70096 16.75C9.5 17.0981 9.5 17.5654 9.5 18.5V21.9913H14.5Z" fill="#1C274C"/>
  <path opacity="0.5" fill-rule="evenodd" clip-rule="evenodd" d="M5.73204 12C4.84126 12 4.05323 11.6239 3.5 11.0329V14C3.5 17.7712 3.5 19.6568 4.67157 20.8284C5.61466 21.7715 7.02043 21.9554 9.5 21.9913H14.5C16.9796 21.9554 18.3853 21.7715 19.3284 20.8284C20.5 19.6568 20.5 17.7712 20.5 14V11.034C19.9468 11.6244 19.1592 12 18.269 12C16.6973 12 15.3814 10.8091 15.225 9.24523L15.152 8.51733C15.3385 10.382 13.8742 12 12.0003 12C10.139 12 8.6819 10.4038 8.84499 8.55511L8.77598 9.24523C8.6196 10.8091 7.30367 12 5.73204 12ZM14.5 18.5V21.9913H9.5V18.5C9.5 17.5654 9.5 17.0981 9.70096 16.75C9.83261 16.522 10.022 16.3326 10.25 16.201C10.5981 16 11.0654 16 12 16C12.9346 16 13.4019 16 13.75 16.201C13.978 16.3326 14.1674 16.522 14.299 16.75C14.5 17.0981 14.5 17.5654 14.5 18.5Z" fill="#1C274C"/>
  <path d="M9.4998 2H14.4998L15.1515 8.51737C15.338 10.382 13.8737 12 11.9998 12C10.1259 12 8.6616 10.382 8.84806 8.51737L9.4998 2Z" fill="#1C274C"/>
  <path opacity="0.7" d="M3.33024 5.35133C3.50832 4.46093 3.59736 4.01573 3.7784 3.65484C4.15987 2.89439 4.84628 2.33168 5.66677 2.10675C6.05616 2 6.51017 2 7.4182 2H9.50051L8.77598 9.24527C8.6196 10.8091 7.30367 12 5.73204 12C3.80159 12 2.35373 10.2339 2.73232 8.34093L3.33024 5.35133Z" fill="#1C274C"/>
  <path opacity="0.7" d="M20.6703 5.35133C20.4922 4.46093 20.4031 4.01573 20.2221 3.65484C19.8406 2.89439 19.1542 2.33168 18.3337 2.10675C17.9443 2 17.4903 2 16.5823 2H14.5L15.2245 9.24527C15.3809 10.8091 16.6968 12 18.2685 12C20.1989 12 21.6468 10.2339 21.2682 8.34093L20.6703 5.35133Z" fill="#1C274C"/>
</svg>
                                        <span class="text-black ltr:pl-3 rtl:pr-3 dark:text-[#506690] dark:group-hover:text-white-dark">Inventory Masters</span>
                                    </div>
                                    <div class="rtl:rotate-180" :class="{'!rotate-90' : activeDropdown === 'components'}">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </div>
                                </button>
                                <ul x-cloak x-show="activeDropdown === 'components'" x-collapse class="sub-menu text-gray-500">
                                    <li>
                                        <a href="{{ route('product_category_list') }}">Product Category</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('unit_list') }}">Units</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('product_list') }}">Products</a>
                                    </li>
                                    
                                    
                                </ul>
                            </li>
                            <li class="menu nav-item">
                                <button
                                    type="button"
                                    class="nav-link group"
                                    :class="{'active' : activeDropdown === 'door_masters'}"
                                    @click="activeDropdown === 'door_masters' ? activeDropdown = null : activeDropdown = 'door_masters'"
                                >
                                    <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="8" height="15" viewBox="0 0 8 15" fill="none">
  <path d="M3 4.5C3 5.05228 2.55228 5.5 2 5.5C1.44772 5.5 1 5.05228 1 4.5C1 3.94772 1.44772 3.5 2 3.5C2.55228 3.5 3 3.94772 3 4.5Z" fill="#1C274C"/>
  <path d="M2 2C2.55228 2 3 1.55228 3 1C3 0.447715 2.55228 0 2 0C1.44772 0 1 0.447715 1 1C1 1.55228 1.44772 2 2 2Z" fill="#1C274C"/>
  <path d="M7 4.5C7 5.05228 6.55228 5.5 6 5.5C5.44771 5.5 5 5.05228 5 4.5C5 3.94772 5.44771 3.5 6 3.5C6.55228 3.5 7 3.94772 7 4.5Z" fill="#1C274C"/>
  <path d="M6 2C6.55228 2 7 1.55228 7 1C7 0.447715 6.55228 0 6 0C5.44771 0 5 0.447715 5 1C5 1.55228 5.44771 2 6 2Z" fill="#1C274C"/>
  <path fill-rule="evenodd" clip-rule="evenodd" d="M0.25 10.5C0.25 8.42893 1.92893 6.75 4 6.75C6.07107 6.75 7.75 8.42893 7.75 10.5C7.75 12.5711 6.07107 14.25 4 14.25C1.92893 14.25 0.25 12.5711 0.25 10.5ZM1.75 10.5C1.75 9.25736 2.75736 8.25 4 8.25C5.24264 8.25 6.25 9.25736 6.25 10.5C6.25 11.7426 5.24264 12.75 4 12.75C2.75736 12.75 1.75 11.7426 1.75 10.5Z" fill="#1C274C"/>
</svg>
                                        <span class="text-black ltr:pl-3 rtl:pr-3 dark:text-[#506690] dark:group-hover:text-white-dark">Door Masters</span>
                                    </div>
                                    <div class="rtl:rotate-180" :class="{'!rotate-90' : activeDropdown === 'door_masters'}">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </div>
                                </button>
                                <ul x-cloak x-show="activeDropdown === 'door_masters'" x-collapse class="sub-menu text-gray-500">
                                    <li>
                                        <a href="{{ route('door_clearance_list')}}">Door Clearance</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('door_thickness_list')}}">Door Thickness</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('color_list')}}">Color</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('door_model_list')}}">Model</a>
                                    </li>
                        
                                    <li>
                                        <a href="{{ route('door_root_list')}}">Root</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('glass_type_list')}}">Glass Type</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('door_lock_list')}}">Lock</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('die_list')}}">Die</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('production_unit_list')}}">Production Unit</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('door_brand_list')}}">Brands</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="menu nav-item">
                                        <button
                                            type="button"
                                            class="nav-link group"
                                            :class="{'active' : activeDropdown === 'measurement'}"
                                            @click="activeDropdown === 'measurement' ? activeDropdown = null : activeDropdown = 'measurement'"
                                        >
                                            <div class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
  <path opacity="0.5" d="M2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2C16.714 2 19.0711 2 20.5355 3.46447C22 4.92893 22 7.28595 22 12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12Z" fill="#1C274C"/>
  <path d="M17.5762 10.4802C17.8414 10.1619 17.7984 9.68903 17.4802 9.42385C17.1619 9.15868 16.689 9.20167 16.4239 9.51988L14.627 11.6761C14.2562 12.1211 14.0285 12.3915 13.8409 12.5609C13.7539 12.6395 13.7023 12.6708 13.6776 12.6827C13.6725 12.6852 13.6689 12.6866 13.6667 12.6875C13.6667 12.6875 13.6624 12.6858 13.659 12.6843L13.6558 12.6827C13.6311 12.6708 13.5795 12.6395 13.4925 12.5609C13.3049 12.3915 13.0772 12.1211 12.7064 11.6761L12.414 11.3253C12.0855 10.931 11.7894 10.5756 11.5128 10.3259C11.2119 10.0541 10.8328 9.81207 10.3334 9.81207C9.83386 9.81207 9.4548 10.0541 9.15386 10.3259C8.87727 10.5756 8.58115 10.931 8.25269 11.3253L6.42385 13.5199C6.15868 13.8381 6.20167 14.311 6.51988 14.5762C6.83809 14.8414 7.31101 14.7984 7.57619 14.4802L9.37308 12.3239C9.74387 11.8789 9.97157 11.6085 10.1592 11.4391C10.2461 11.3606 10.2978 11.3293 10.3225 11.3173L10.3292 11.3142L10.3334 11.3126C10.3356 11.3134 10.3392 11.3149 10.3442 11.3173C10.369 11.3293 10.4206 11.3606 10.5076 11.4391C10.6951 11.6085 10.9228 11.8789 11.2936 12.3239L11.586 12.6748L11.586 12.6748C11.9145 13.069 12.2106 13.4244 12.4872 13.6742C12.7881 13.9459 13.1672 14.188 13.6667 14.188C14.1662 14.188 14.5452 13.9459 14.8462 13.6742C15.1228 13.4244 15.4189 13.069 15.7473 12.6748L17.5762 10.4802Z" fill="#1C274C"/>
</svg>
                                                <span class="text-black ltr:pl-3 rtl:pr-3 dark:text-[#506690] dark:group-hover:text-white-dark">Measurement</span>
                                            </div>
                                            <div class="rtl:rotate-180" :class="{'!rotate-90' : activeDropdown === 'measurement'}">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M9 5L15 12L9 19"
                                                        stroke="currentColor"
                                                        stroke-width="1.5"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                    />
                                                </svg>
                                            </div>
                                        </button>
                                        <ul x-cloak x-show="activeDropdown === 'measurement'" x-collapse class="sub-menu text-gray-500">
                                            <li>
                                                <a href="{{ route('measurement_form_create')}}">Measurement Form</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('pending_order_list')}}">Pending Order</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('confirmed_order_list')}}">Confirmed Order</a>
                                            </li>
                                           
                                        </ul>
                                    </li>


                          
                            <li class="menu nav-item">
                                        <button
                                            type="button"
                                            class="nav-link group"
                                            :class="{'active' : activeDropdown === 'purchaseinvoice'}"
                                            @click="activeDropdown === 'purchaseinvoice' ? activeDropdown = null : activeDropdown = 'purchaseinvoice'"
                                        >
                                            <div class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
  <path fill-rule="evenodd" clip-rule="evenodd" d="M1.28869 2.76282C1.41968 2.36986 1.84442 2.15749 2.23737 2.28848L2.50229 2.37678C2.51549 2.38118 2.52864 2.38557 2.54176 2.38994C3.16813 2.59871 3.69746 2.77513 4.11369 2.96876C4.55613 3.17459 4.94002 3.42968 5.23112 3.83355C5.52221 4.23743 5.64282 4.68229 5.69817 5.16711C5.75025 5.62321 5.75023 6.18117 5.7502 6.84142L5.7502 9.49999C5.7502 10.9354 5.7518 11.9365 5.85335 12.6919C5.952 13.4256 6.13245 13.8142 6.40921 14.091C6.68598 14.3677 7.07455 14.5482 7.80832 14.6468C8.56367 14.7484 9.56479 14.75 11.0002 14.75H18.0002C18.4144 14.75 18.7502 15.0858 18.7502 15.5C18.7502 15.9142 18.4144 16.25 18.0002 16.25H10.9453C9.57774 16.25 8.47542 16.25 7.60845 16.1335C6.70834 16.0125 5.95047 15.7536 5.34855 15.1516C4.74664 14.5497 4.48774 13.7918 4.36673 12.8917C4.25017 12.0248 4.25018 10.9225 4.2502 9.55487L4.2502 6.88303C4.2502 6.17003 4.24907 5.69826 4.20785 5.33726C4.16883 4.99541 4.10068 4.83052 4.01426 4.71062C3.92784 4.59072 3.79296 4.47392 3.481 4.3288C3.15155 4.17554 2.70435 4.02527 2.02794 3.79981L1.76303 3.7115C1.37008 3.58052 1.15771 3.15578 1.28869 2.76282Z" fill="#1C274C"/>
  <path opacity="0.5" d="M5.74512 5.99997C5.75008 6.25909 5.75008 6.53954 5.75007 6.84137L5.75006 9.49997C5.75006 10.9354 5.75166 11.9365 5.85321 12.6918C5.86803 12.8021 5.8847 12.9045 5.90326 13H16.0221C16.9815 13 17.4612 13 17.8369 12.7522C18.2126 12.5045 18.4016 12.0636 18.7795 11.1817L19.2081 10.1817C20.0176 8.29291 20.4223 7.3485 19.9777 6.67423C19.5331 5.99997 18.5056 5.99997 16.4507 5.99997H5.74512Z" fill="#1C274C"/>
  <path d="M7.25 9C7.25 8.58579 7.58579 8.25 8 8.25H11C11.4142 8.25 11.75 8.58579 11.75 9C11.75 9.41421 11.4142 9.75 11 9.75H8C7.58579 9.75 7.25 9.41421 7.25 9Z" fill="#1C274C"/>
  <path d="M7.5 18C8.32843 18 9 18.6716 9 19.5C9 20.3284 8.32843 21 7.5 21C6.67157 21 6 20.3284 6 19.5C6 18.6716 6.67157 18 7.5 18Z" fill="#1C274C"/>
  <path d="M18 19.5001C18 18.6716 17.3284 18.0001 16.5 18.0001C15.6716 18.0001 15 18.6716 15 19.5001C15 20.3285 15.6716 21.0001 16.5 21.0001C17.3284 21.0001 18 20.3285 18 19.5001Z" fill="#1C274C"/>
</svg>
                                                <span class="text-black ltr:pl-3 rtl:pr-3 dark:text-[#506690] dark:group-hover:text-white-dark">Purchase Invoice</span>
                                            </div>
                                            <div class="rtl:rotate-180" :class="{'!rotate-90' : activeDropdown === 'purchaseinvoice'}">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M9 5L15 12L9 19"
                                                        stroke="currentColor"
                                                        stroke-width="1.5"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                    />
                                                </svg>
                                            </div>
                                        </button>
                                        <ul x-cloak x-show="activeDropdown === 'purchaseinvoice'" x-collapse class="sub-menu text-gray-500">
                                            <li>
                                                <a href="{{ route('purchase_invoice_list')}}">List</a>
                                            </li>
                                           
                                            <li>
                                                <a href="{{ route('purchase_invoice_create')}}">Add</a>
                                            </li>
                                           
                                        </ul>
                                    </li>
                            <li class="menu nav-item">
                                        <button
                                            type="button"
                                            class="nav-link group"
                                            :class="{'active' : activeDropdown === 'salesinvoice'}"
                                            @click="activeDropdown === 'salesinvoice' ? activeDropdown = null : activeDropdown = 'salesinvoice'"
                                        >
                                            <div class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
  <path opacity="0.5" d="M2.08368 2.7512C2.22106 2.36044 2.64921 2.15503 3.03998 2.29242L3.34138 2.39838C3.95791 2.61511 4.48154 2.79919 4.89363 3.00139C5.33426 3.21759 5.71211 3.48393 5.99629 3.89979C6.27827 4.31243 6.39468 4.76515 6.44841 5.26153C6.47247 5.48373 6.48515 5.72967 6.49184 6H17.1301C18.815 6 20.3318 6 20.7757 6.57708C21.2197 7.15417 21.0461 8.02369 20.699 9.76275L20.1992 12.1875C19.8841 13.7164 19.7266 14.4808 19.1748 14.9304C18.6231 15.38 17.8426 15.38 16.2816 15.38H10.9787C8.18979 15.38 6.79534 15.38 5.92894 14.4662C5.06254 13.5523 4.9993 12.5816 4.9993 9.64L4.9993 7.03832C4.9993 6.29837 4.99828 5.80316 4.95712 5.42295C4.91779 5.0596 4.84809 4.87818 4.75783 4.74609C4.66977 4.61723 4.5361 4.4968 4.23288 4.34802C3.91003 4.18961 3.47128 4.03406 2.80367 3.79934L2.54246 3.7075C2.1517 3.57012 1.94629 3.14197 2.08368 2.7512Z" fill="#1C274C"/>
  <path d="M7.5 18C8.32843 18 9 18.6716 9 19.5C9 20.3284 8.32843 21 7.5 21C6.67157 21 6 20.3284 6 19.5C6 18.6716 6.67157 18 7.5 18Z" fill="#1C274C"/>
  <path d="M16.5 18.0001C17.3284 18.0001 18 18.6716 18 19.5001C18 20.3285 17.3284 21.0001 16.5 21.0001C15.6716 21.0001 15 20.3285 15 19.5001C15 18.6716 15.6716 18.0001 16.5 18.0001Z" fill="#1C274C"/>
  <path d="M15.5421 9.51724C15.8278 9.2173 15.8162 8.74256 15.5163 8.4569C15.2163 8.17123 14.7416 8.18281 14.4559 8.48276L12.1419 10.9125L11.5421 10.2828C11.2565 9.98281 10.7817 9.97123 10.4818 10.2569C10.1818 10.5426 10.1703 11.0173 10.4559 11.3172L11.5988 12.5172C11.7403 12.6659 11.9366 12.75 12.1419 12.75C12.3471 12.75 12.5434 12.6659 12.685 12.5172L15.5421 9.51724Z" fill="#1C274C"/>
</svg>
                                                <span class="text-black ltr:pl-3 rtl:pr-3 dark:text-[#506690] dark:group-hover:text-white-dark">Sales Invoice</span>
                                            </div>
                                            <div class="rtl:rotate-180" :class="{'!rotate-90' : activeDropdown === 'salesinvoice'}">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M9 5L15 12L9 19"
                                                        stroke="currentColor"
                                                        stroke-width="1.5"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                    />
                                                </svg>
                                            </div>
                                        </button>
                                        <ul x-cloak x-show="activeDropdown === 'salesinvoice'" x-collapse class="sub-menu text-gray-500">
                                            <li>
                                                <a href="{{ route('sales_invoice_list')}}">List</a>
                                            </li>
                                           
                                            <li>
                                                <a href="{{ route('sales_invoice_create')}}">Add</a>
                                            </li>
                                           
                                        </ul>
                                    </li>
                            <li class="menu nav-item">
                                <button
                                    type="button"
                                    class="nav-link group"
                                    :class="{'active' : activeDropdown === 'elements'}"
                                    @click="activeDropdown === 'elements' ? activeDropdown = null : activeDropdown = 'elements'"
                                >
                                    <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
  <path d="M4.8916 9.61431C4.8916 9.21193 5.21525 8.88574 5.61449 8.88574H9.46991C9.86916 8.88574 10.1928 9.21193 10.1928 9.61431C10.1928 10.0167 9.86916 10.3429 9.46991 10.3429H5.61449C5.21525 10.3429 4.8916 10.0167 4.8916 9.61431Z" fill="#1C274C"/>
  <path fill-rule="evenodd" clip-rule="evenodd" d="M21.1884 10.0038C21.1262 9.99995 21.0584 9.99998 20.9881 10L20.9706 10H18.2149C15.9435 10 14 11.7361 14 14C14 16.2639 15.9435 18 18.2149 18H20.9706L20.9881 18C21.0584 18 21.1262 18 21.1884 17.9962C22.111 17.9397 22.927 17.2386 22.9956 16.2594C23.0001 16.1952 23 16.126 23 16.0619L23 16.0444V11.9556L23 11.9381C23 11.874 23.0001 11.8048 22.9956 11.7406C22.927 10.7614 22.111 10.0603 21.1884 10.0038ZM17.9706 15.0667C18.5554 15.0667 19.0294 14.5891 19.0294 14C19.0294 13.4109 18.5554 12.9333 17.9706 12.9333C17.3858 12.9333 16.9118 13.4109 16.9118 14C16.9118 14.5891 17.3858 15.0667 17.9706 15.0667Z" fill="#1C274C"/>
  <path opacity="0.5" d="M21.1394 10.0015C21.1394 8.82091 21.0965 7.55447 20.3418 6.64658C20.2689 6.55894 20.1914 6.47384 20.1088 6.39124C19.3604 5.64288 18.4114 5.31076 17.239 5.15314C16.0998 4.99997 14.6442 4.99999 12.8064 5H10.6936C8.85583 4.99999 7.40019 4.99997 6.26098 5.15314C5.08856 5.31076 4.13961 5.64288 3.39124 6.39124C2.64288 7.13961 2.31076 8.08856 2.15314 9.26098C1.99997 10.4002 1.99999 11.8558 2 13.6936V13.8064C1.99999 15.6442 1.99997 17.0998 2.15314 18.239C2.31076 19.4114 2.64288 20.3604 3.39124 21.1088C4.13961 21.8571 5.08856 22.1892 6.26098 22.3469C7.40018 22.5 8.8558 22.5 10.6935 22.5H12.8064C14.6442 22.5 16.0998 22.5 17.239 22.3469C18.4114 22.1892 19.3604 21.8571 20.1088 21.1088C20.3133 20.9042 20.487 20.6844 20.6346 20.4486C21.0851 19.7291 21.1394 18.8473 21.1394 17.9985C21.0912 18 21.0404 18 20.9882 18L18.2149 18C15.9435 18 14 16.2639 14 14C14 11.7361 15.9435 10 18.2149 10L20.9881 10C21.0403 9.99999 21.0912 9.99997 21.1394 10.0015Z" fill="#1C274C"/>
  <path d="M10.1013 2.57211L7.99988 3.99253L6.2666 5.15237C7.40496 4.99997 8.8588 4.99999 10.6935 5H12.8063C14.6441 4.99998 16.0997 4.99997 17.2389 5.15314C17.4681 5.18394 17.6887 5.22142 17.9009 5.26737L15.9999 4L13.8874 2.57211C12.7588 1.8093 11.2299 1.8093 10.1013 2.57211Z" fill="#1C274C"/>
</svg>
                                        <span class="text-black ltr:pl-3 rtl:pr-3 dark:text-[#506690] dark:group-hover:text-white-dark">Accounts</span>
                                    </div>
                                    <div class="rtl:rotate-180" :class="{'!rotate-90' : activeDropdown === 'elements'}">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </div>
                                </button>
                                <ul x-cloak x-show="activeDropdown === 'elements'" x-collapse class="sub-menu text-gray-500">
                                    <li>
                                        <a href="{{ route('payment_list')}}">Payment</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('receipt_list')}}">Receipt</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('journal_list')}}">Journal</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('contra_list')}}">Contra</a>
                                    </li>
                                    
                                </ul>
                            </li>

                            <!-- <li class="menu nav-item">
                                <a href="{{ route('multi_currency_list')}}" class="nav-link group">
                                    <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
  <path opacity="0.5" fill-rule="evenodd" clip-rule="evenodd" d="M22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12Z" fill="#1C274C"/>
  <path fill-rule="evenodd" clip-rule="evenodd" d="M12 5.25C12.4142 5.25 12.75 5.58579 12.75 6V6.31673C14.3804 6.60867 15.75 7.83361 15.75 9.5C15.75 9.91421 15.4142 10.25 15 10.25C14.5858 10.25 14.25 9.91421 14.25 9.5C14.25 8.82154 13.6859 8.10339 12.75 7.84748V11.3167C14.3804 11.6087 15.75 12.8336 15.75 14.5C15.75 16.1664 14.3804 17.3913 12.75 17.6833V18C12.75 18.4142 12.4142 18.75 12 18.75C11.5858 18.75 11.25 18.4142 11.25 18V17.6833C9.61957 17.3913 8.25 16.1664 8.25 14.5C8.25 14.0858 8.58579 13.75 9 13.75C9.41421 13.75 9.75 14.0858 9.75 14.5C9.75 15.1785 10.3141 15.8966 11.25 16.1525V12.6833C9.61957 12.3913 8.25 11.1664 8.25 9.5C8.25 7.83361 9.61957 6.60867 11.25 6.31673V6C11.25 5.58579 11.5858 5.25 12 5.25ZM11.25 7.84748C10.3141 8.10339 9.75 8.82154 9.75 9.5C9.75 10.1785 10.3141 10.8966 11.25 11.1525V7.84748ZM14.25 14.5C14.25 13.8215 13.6859 13.1034 12.75 12.8475V16.1525C13.6859 15.8966 14.25 15.1785 14.25 14.5Z" fill="#1C274C"/>
</svg>
                                        <span class="text-black ltr:pl-3 rtl:pr-3 dark:text-[#506690] dark:group-hover:text-white-dark">Multi Currency Transfer</span>
                                    </div>
                                </a>
                            </li> -->

                            <li class="menu nav-item">
                                <button
                                    type="button"
                                    class="nav-link group"
                                    :class="{'active' : activeDropdown === 'dailywages'}"
                                    @click="activeDropdown === 'dailywages' ? activeDropdown = null : activeDropdown = 'dailywages'"
                                >
                                    <div class="flex items-center">
                                
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
  <path fill-rule="evenodd" clip-rule="evenodd" d="M14.0137 17L14.0079 19.0029C14.0065 19.4731 14.0058 19.7081 13.8591 19.8541C13.7124 20 13.4767 20 13.0054 20H9.99502C6.21438 20 4.32407 20 3.14958 18.8284C2.34091 18.0218 2.08903 16.8766 2.01058 15.0105C1.99502 14.6405 1.98724 14.4554 2.05634 14.332C2.12545 14.2085 2.40133 14.0545 2.95308 13.7463C3.56586 13.4041 3.98007 12.7503 3.98007 12C3.98007 11.2497 3.56586 10.5959 2.95308 10.2537C2.40133 9.94554 2.12545 9.79147 2.05634 9.66802C1.98724 9.54458 1.99502 9.35954 2.01058 8.98947C2.08903 7.12339 2.34091 5.97823 3.14958 5.17157C4.32407 4 6.21439 4 9.99502 4H13.5052C13.7814 4 14.0056 4.22298 14.0064 4.49855L14.0137 7C14.0137 7.55228 14.4625 8 15.0162 8L15.0162 10C14.4625 10 14.0137 10.4477 14.0137 11V13C14.0137 13.5523 14.4625 14 15.0162 14V16C14.4625 16 14.0137 16.4477 14.0137 17Z" fill="#1C274C"/>
  <path opacity="0.5" d="M15.0166 15.9998C15.5703 15.9998 16.0191 16.4475 16.0191 16.9998V18.9763C16.0191 19.4578 16.0191 19.6986 16.1735 19.8462C16.3279 19.9939 16.5641 19.9839 17.0366 19.9639C18.8995 19.885 20.0441 19.633 20.8508 18.8282C21.6595 18.0216 21.9114 16.8764 21.9898 15.0104C22.0054 14.6403 22.0132 14.4552 21.9441 14.3318C21.875 14.2083 21.5991 14.0543 21.0473 13.7462C20.4346 13.404 20.0203 12.7501 20.0203 11.9998C20.0203 11.2495 20.4346 10.5957 21.0473 10.2535C21.5991 9.94536 21.875 9.7913 21.9441 9.66785C22.0132 9.5444 22.0054 9.35936 21.9898 8.98929C21.9114 7.12321 21.6595 5.97805 20.8508 5.17139C19.9731 4.29586 18.6956 4.07463 16.5282 4.01872C16.2486 4.01151 16.0191 4.237 16.0191 4.516V6.99982C16.0191 7.55211 15.5703 7.99982 15.0166 7.99982L15.0166 9.99982C15.5703 9.99982 16.0191 10.4475 16.0191 10.9998V12.9998C16.0191 13.5521 15.5703 13.9998 15.0166 13.9998V15.9998Z" fill="#1C274C"/>
</svg>

                                        <span class="text-black ltr:pl-3 rtl:pr-3 dark:text-[#506690] dark:group-hover:text-white-dark">Daily Wages</span>
                                    </div>
                                    <div class="rtl:rotate-180" :class="{'!rotate-90' : activeDropdown === 'dailywages'}">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </div>
                                </button>
                                <ul x-cloak x-show="activeDropdown === 'dailywages'" x-collapse class="sub-menu text-gray-500">
                                    <li>
                                        <a href="{{route('employee_list')}}">Employee</a>
                                    </li>
                                    <li>
                                        <a href="{{route('attencence_list')}}">Attendance</a>
                                    </li>
                                    <li>
                                        <a href="{{route('employee_payment_list')}}">Payment</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="menu nav-item">
                                        <button
                                            type="button"
                                            class="nav-link group"
                                            :class="{'active' : activeDropdown === 'users'}"
                                            @click="activeDropdown === 'users' ? activeDropdown = null : activeDropdown = 'users'"
                                        >
                                            <div class="flex items-center">
                                             <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
  <circle opacity="0.5" cx="15" cy="6" r="3" fill="#1C274C"/>
  <ellipse opacity="0.5" cx="16" cy="17" rx="5" ry="3" fill="#1C274C"/>
  <circle cx="9.00098" cy="6" r="4" fill="#1C274C"/>
  <ellipse cx="9.00098" cy="17.001" rx="7" ry="4" fill="#1C274C"/>
</svg>
                                                <span class="text-black ltr:pl-3 rtl:pr-3 dark:text-[#506690] dark:group-hover:text-white-dark">Users</span>
                                            </div>
                                            <div class="rtl:rotate-180" :class="{'!rotate-90' : activeDropdown === 'users'}">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M9 5L15 12L9 19"
                                                        stroke="currentColor"
                                                        stroke-width="1.5"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                    />
                                                </svg>
                                            </div>
                                        </button>
                                        <ul x-cloak x-show="activeDropdown === 'users'" x-collapse class="sub-menu text-gray-500">
                                            <li>
                                                <a href="{{ route('admin_user_list')}}">List</a>
                                            </li>
                                           
                                            <li>
                                                <a href="{{ route('admin_user_create')}}">Add</a>
                                            </li>
                                           
                                        </ul>
                                    </li>
<!--                            

                            <h2 class="-mx-4 mb-1 flex items-center bg-white-light/30 py-3 px-7 font-extrabold uppercase dark:bg-dark dark:bg-opacity-[0.08]">
                                <svg
                                    class="hidden h-5 w-4 flex-none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.5"
                                    fill="none"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                                <span>TABLES AND FORMS</span>
                            </h2> -->

                            <li class="menu nav-item">
                                <button
                                    type="button"
                                    class="nav-link group"
                                    :class="{'active' : activeDropdown === 'production'}"
                                    @click="activeDropdown === 'production' ? activeDropdown = null : activeDropdown = 'production'"
                                >
                                    <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
  <path opacity="0.5" d="M2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2C16.714 2 19.0711 2 20.5355 3.46447C22 4.92893 22 7.28595 22 12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12Z" fill="#1C274C"/>
  <path d="M22 5C22 6.65685 20.6569 8 19 8C17.3431 8 16 6.65685 16 5C16 3.34315 17.3431 2 19 2C20.6569 2 22 3.34315 22 5Z" fill="#1C274C"/>
  <path d="M14.5 10.75C14.0858 10.75 13.75 10.4142 13.75 10C13.75 9.58579 14.0858 9.25 14.5 9.25H17C17.4142 9.25 17.75 9.58579 17.75 10V12.5C17.75 12.9142 17.4142 13.25 17 13.25C16.5858 13.25 16.25 12.9142 16.25 12.5V11.8107L14.2374 13.8232C13.554 14.5066 12.446 14.5066 11.7626 13.8232L10.1768 12.2374C10.0791 12.1398 9.92085 12.1398 9.82322 12.2374L7.53033 14.5303C7.23744 14.8232 6.76256 14.8232 6.46967 14.5303C6.17678 14.2374 6.17678 13.7626 6.46967 13.4697L8.76256 11.1768C9.44598 10.4934 10.554 10.4934 11.2374 11.1768L12.8232 12.7626C12.9209 12.8602 13.0791 12.8602 13.1768 12.7626L15.1893 10.75H14.5Z" fill="#1C274C"/>
</svg>
                                        <span class="text-black ltr:pl-3 rtl:pr-3 dark:text-[#506690] dark:group-hover:text-white-dark">Production</span>
                                    </div>
                                    <div class="rtl:rotate-180" :class="{'!rotate-90' : activeDropdown === 'production'}">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </div>
                                </button>
                                <ul x-cloak x-show="activeDropdown === 'production'" x-collapse class="sub-menu text-gray-500">
                                    <li>
                                        <a href="{{ route('production_pending_list')}}">Pending List</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('assigned_list')}}">Assigned List</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('pending_list')}}">Production Pending List</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('completed_list')}}">Completed List</a>
                                    </li>
                                   
                                </ul>
                            </li>

                            

                            <li class="menu nav-item">
                                <button
                                    type="button"
                                    class="nav-link group"
                                    :class="{'active' : activeDropdown === 'forms'}"
                                    @click="activeDropdown === 'forms' ? activeDropdown = null : activeDropdown = 'forms'"
                                >
                                    <div class="flex items-center">
                                        <svg
                                            class="group-hover:!text-primary"
                                            width="20"
                                            height="20"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            xmlns="http://www.w3.org/2000/svg"
                                        >
                                            <path
                                                opacity="0.5"
                                                d="M3 10C3 6.22876 3 4.34315 4.17157 3.17157C5.34315 2 7.22876 2 11 2H13C16.7712 2 18.6569 2 19.8284 3.17157C21 4.34315 21 6.22876 21 10V14C21 17.7712 21 19.6569 19.8284 20.8284C18.6569 22 16.7712 22 13 22H11C7.22876 22 5.34315 22 4.17157 20.8284C3 19.6569 3 17.7712 3 14V10Z"
                                                fill="currentColor"
                                            />
                                            <path
                                                d="M16.5189 16.5013C16.6939 16.3648 16.8526 16.2061 17.1701 15.8886L21.1275 11.9312C21.2231 11.8356 21.1793 11.6708 21.0515 11.6264C20.5844 11.4644 19.9767 11.1601 19.4083 10.5917C18.8399 10.0233 18.5356 9.41561 18.3736 8.94849C18.3292 8.82066 18.1644 8.77687 18.0688 8.87254L14.1114 12.8299C13.7939 13.1474 13.6352 13.3061 13.4987 13.4811C13.3377 13.6876 13.1996 13.9109 13.087 14.1473C12.9915 14.3476 12.9205 14.5606 12.7786 14.9865L12.5951 15.5368L12.3034 16.4118L12.0299 17.2323C11.9601 17.4419 12.0146 17.6729 12.1708 17.8292C12.3271 17.9854 12.5581 18.0399 12.7677 17.9701L13.5882 17.6966L14.4632 17.4049L15.0135 17.2214L15.0136 17.2214C15.4394 17.0795 15.6524 17.0085 15.8527 16.913C16.0891 16.8004 16.3124 16.6623 16.5189 16.5013Z"
                                                fill="currentColor"
                                            />
                                            <path
                                                d="M22.3665 10.6922C23.2112 9.84754 23.2112 8.47812 22.3665 7.63348C21.5219 6.78884 20.1525 6.78884 19.3078 7.63348L19.1806 7.76071C19.0578 7.88348 19.0022 8.05496 19.0329 8.22586C19.0522 8.33336 19.0879 8.49053 19.153 8.67807C19.2831 9.05314 19.5288 9.54549 19.9917 10.0083C20.4545 10.4712 20.9469 10.7169 21.3219 10.847C21.5095 10.9121 21.6666 10.9478 21.7741 10.9671C21.945 10.9978 22.1165 10.9422 22.2393 10.8194L22.3665 10.6922Z"
                                                fill="currentColor"
                                            />
                                            <path
                                                fill-rule="evenodd"
                                                clip-rule="evenodd"
                                                d="M7.25 9C7.25 8.58579 7.58579 8.25 8 8.25H14.5C14.9142 8.25 15.25 8.58579 15.25 9C15.25 9.41421 14.9142 9.75 14.5 9.75H8C7.58579 9.75 7.25 9.41421 7.25 9ZM7.25 13C7.25 12.5858 7.58579 12.25 8 12.25H11C11.4142 12.25 11.75 12.5858 11.75 13C11.75 13.4142 11.4142 13.75 11 13.75H8C7.58579 13.75 7.25 13.4142 7.25 13ZM7.25 17C7.25 16.5858 7.58579 16.25 8 16.25H9.5C9.91421 16.25 10.25 16.5858 10.25 17C10.25 17.4142 9.91421 17.75 9.5 17.75H8C7.58579 17.75 7.25 17.4142 7.25 17Z"
                                                fill="currentColor"
                                            />
                                        </svg>
                                        <span class="text-black ltr:pl-3 rtl:pr-3 dark:text-[#506690] dark:group-hover:text-white-dark">Reports</span>
                                    </div>
                                    <div class="rtl:rotate-180" :class="{'!rotate-90' : activeDropdown === 'forms'}">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </div>
                                </button>
                                <ul x-cloak x-show="activeDropdown === 'forms'" x-collapse class="sub-menu text-gray-500">
                                    <li>
                                    <a href="{{route('packing_list_report')}}">Packing List</a>
                                    </li>
                                    <li>
                                    <a href="{{route('production_list_report')}}">Production List</a>
                                    </li>
                                    <li>
                                    <a href="{{route('employee_report')}}">Employee Report</a>
                                    </li>
                                    <li>
                                        <a href="{{route('purchase_report')}}">Purchase Report</a>
                                    </li>
                                    <li>
                                        <a href="{{route('sales_report')}}">Sales Report</a>
                                    </li>
                                    <li>
                                        <a href="{{route('pending_sales_invoices')}}">Pending Sales Invoices</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('ledger_report')}}">Ledger Report</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('stock_report')}}">Stock Report</a>
                                    </li>
                                    <!-- <li>
                                        <a href="{{ route('ledger_group_summery')}}">Ledger Group Summery</a>
                                    </li> -->
                                    <!-- <li>
                                        <a href="{{ route('currency_balance')}}">Currency Balance</a>
                                    </li> -->
                                    
                                </ul>
                            </li>

                            <!-- <h2 class="-mx-4 mb-1 flex items-center bg-white-light/30 py-3 px-7 font-extrabold uppercase dark:bg-dark dark:bg-opacity-[0.08]">
                                <svg
                                    class="hidden h-5 w-4 flex-none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.5"
                                    fill="none"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                                <span>USER AND PAGES</span>
                            </h2> -->

                            
                            <li class="menu nav-item">
                                <button
                                    type="button"
                                    class="nav-link group"
                                    :class="{'active' : activeDropdown === 'pending_lists'}"
                                    @click="activeDropdown === 'pending_lists' ? activeDropdown = null : activeDropdown = 'pending_lists'"
                                >
                                    <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="8" viewBox="0 0 10 8" fill="none">
  <path d="M9.03033 2.03033C9.32322 1.73744 9.32322 1.26256 9.03033 0.96967C8.73744 0.676777 8.26256 0.676777 7.96967 0.96967L3.5 5.43934L2.03033 3.96967C1.73744 3.67678 1.26256 3.67678 0.96967 3.96967C0.676777 4.26256 0.676777 4.73744 0.96967 5.03033L2.96967 7.03033C3.26256 7.32322 3.73744 7.32322 4.03033 7.03033L9.03033 2.03033Z" fill="#1C274C"/>
</svg>
                                        <span class="text-black ltr:pl-3 rtl:pr-3 dark:text-[#506690] dark:group-hover:text-white-dark">Admin Approvel</span>
                                    </div>
                                    <div class="rtl:rotate-180" :class="{'!rotate-90' : activeDropdown === 'pending_lists'}">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </div>
                                </button>
                                <ul x-cloak x-show="activeDropdown === 'pending_lists'" x-collapse class="sub-menu text-gray-500">
                                    <li>
                                        <a href="{{ route('payment_pending')}}">Payment Pending</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('receipt_pending')}}">Receipt Pending</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('journal_pending')}}">Journal Pending</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('contra_pending')}}">Contra Pending</a>
                                    </li>
                                    
                                </ul>
                            </li>
                            

                            

                            <li class="menu nav-item">
                                <a href="{{ route('logout') }}" class="nav-link group">
                                    <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
  <path opacity="0.5" d="M8.7919 5.14712C9.17345 4.98591 9.35208 4.54591 9.19087 4.16435C9.02966 3.7828 8.58966 3.60417 8.2081 3.76538C4.70832 5.24406 2.25 8.70925 2.25 12.7503C2.25 18.1351 6.61522 22.5003 12 22.5003C17.3848 22.5003 21.75 18.1351 21.75 12.7503C21.75 8.70925 19.2917 5.24406 15.7919 3.76538C15.4103 3.60417 14.9703 3.7828 14.8091 4.16435C14.6479 4.54591 14.8265 4.98591 15.2081 5.14712C18.1722 6.39947 20.25 9.33312 20.25 12.7503C20.25 17.3067 16.5563 21.0003 12 21.0003C7.44365 21.0003 3.75 17.3067 3.75 12.7503C3.75 9.33312 5.82779 6.39947 8.7919 5.14712Z" fill="#1C274C"/>
  <path d="M12.75 2.75C12.75 2.33579 12.4142 2 12 2C11.5858 2 11.25 2.33579 11.25 2.75V6.75C11.25 7.16421 11.5858 7.5 12 7.5C12.4142 7.5 12.75 7.16421 12.75 6.75V2.75Z" fill="#1C274C"/>
</svg>
                                        <span class="text-black ltr:pl-3 rtl:pr-3 dark:text-[#506690] dark:group-hover:text-white-dark">Logout</span>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
            <!-- end sidebar section -->

            <div class="main-content">
                <!-- start header section -->
                <header :class="{'dark' : $store.app.semidark && $store.app.menu === 'horizontal'}">
                    <div class="shadow-sm">
                        <div class="relative flex w-full items-center bg-white px-5 py-2.5 dark:bg-[#0e1726]">
                            <div class="horizontal-logo flex items-center justify-between ltr:mr-2 rtl:ml-2 lg:hidden">
                                <a href="{{ url('home') }}" class="main-logo flex shrink-0 items-center">
                                    <img class="inline w-44 ltr:-ml-1 rtl:-mr-1" src="{{ asset('assets/images/logo.svg') }}" alt="image" />
                                    <!-- <span
                                        class="hidden align-middle text-2xl font-semibold transition-all duration-300 ltr:ml-1.5 rtl:mr-1.5 dark:text-white-light md:inline"
                                        >VRISTO</span
                                    > -->
                                </a>

                                <a
                                    href="javascript:;"
                                    class="collapse-icon flex flex-none rounded-full bg-white-light/40 p-2 hover:bg-white-light/90 hover:text-primary ltr:ml-2 rtl:mr-2 dark:bg-dark/40 dark:text-[#d0d2d6] dark:hover:bg-dark/60 dark:hover:text-primary lg:hidden"
                                    @click="$store.app.toggleSidebar()"
                                >
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M20 7L4 7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                        <path opacity="0.5" d="M20 12L4 12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                        <path d="M20 17L4 17" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                    </svg>
                                </a>
                            </div>
                            <div class="hidden ltr:mr-2 rtl:ml-2 sm:block">
                                <ul class="flex items-center space-x-2 rtl:space-x-reverse dark:text-[#d0d2d6]">
                                    <!-- <li>
                                        <a
                                            href="apps-calendar.html"
                                            class="block rounded-full bg-white-light/40 p-2 hover:bg-white-light/90 hover:text-primary dark:bg-dark/40 dark:hover:bg-dark/60"
                                        >
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M2 12C2 8.22876 2 6.34315 3.17157 5.17157C4.34315 4 6.22876 4 10 4H14C17.7712 4 19.6569 4 20.8284 5.17157C22 6.34315 22 8.22876 22 12V14C22 17.7712 22 19.6569 20.8284 20.8284C19.6569 22 17.7712 22 14 22H10C6.22876 22 4.34315 22 3.17157 20.8284C2 19.6569 2 17.7712 2 14V12Z"
                                                    stroke="currentColor"
                                                    stroke-width="1.5"
                                                />
                                                <path opacity="0.5" d="M7 4V2.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                                <path opacity="0.5" d="M17 4V2.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                                <path opacity="0.5" d="M2 9H22" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                            </svg>
                                        </a>
                                    </li>
                                    <li>
                                        <a
                                            href="apps-todolist.html"
                                            class="block rounded-full bg-white-light/40 p-2 hover:bg-white-light/90 hover:text-primary dark:bg-dark/40 dark:hover:bg-dark/60"
                                        >
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    opacity="0.5"
                                                    d="M22 10.5V12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2H13.5"
                                                    stroke="currentColor"
                                                    stroke-width="1.5"
                                                    stroke-linecap="round"
                                                />
                                                <path
                                                    d="M17.3009 2.80624L16.652 3.45506L10.6872 9.41993C10.2832 9.82394 10.0812 10.0259 9.90743 10.2487C9.70249 10.5114 9.52679 10.7957 9.38344 11.0965C9.26191 11.3515 9.17157 11.6225 8.99089 12.1646L8.41242 13.9L8.03811 15.0229C7.9492 15.2897 8.01862 15.5837 8.21744 15.7826C8.41626 15.9814 8.71035 16.0508 8.97709 15.9619L10.1 15.5876L11.8354 15.0091C12.3775 14.8284 12.6485 14.7381 12.9035 14.6166C13.2043 14.4732 13.4886 14.2975 13.7513 14.0926C13.9741 13.9188 14.1761 13.7168 14.5801 13.3128L20.5449 7.34795L21.1938 6.69914C22.2687 5.62415 22.2687 3.88124 21.1938 2.80624C20.1188 1.73125 18.3759 1.73125 17.3009 2.80624Z"
                                                    stroke="currentColor"
                                                    stroke-width="1.5"
                                                />
                                                <path
                                                    opacity="0.5"
                                                    d="M16.6522 3.45508C16.6522 3.45508 16.7333 4.83381 17.9499 6.05034C19.1664 7.26687 20.5451 7.34797 20.5451 7.34797M10.1002 15.5876L8.4126 13.9"
                                                    stroke="currentColor"
                                                    stroke-width="1.5"
                                                />
                                            </svg>
                                        </a>
                                    </li>-->
                                    <li>
                                        <a
                                            href="{{ url('chatscreen') }}"
                                            class="block rounded-full bg-white-light/40 p-2 hover:bg-white-light/90 hover:text-primary dark:bg-dark/40 dark:hover:bg-dark/60"
                                        >
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <circle r="3" transform="matrix(-1 0 0 1 19 5)" stroke="currentColor" stroke-width="1.5" />
                                                <path
                                                    opacity="0.5"
                                                    d="M14 2.20004C13.3538 2.06886 12.6849 2 12 2C6.47715 2 2 6.47715 2 12C2 13.5997 2.37562 15.1116 3.04346 16.4525C3.22094 16.8088 3.28001 17.2161 3.17712 17.6006L2.58151 19.8267C2.32295 20.793 3.20701 21.677 4.17335 21.4185L6.39939 20.8229C6.78393 20.72 7.19121 20.7791 7.54753 20.9565C8.88837 21.6244 10.4003 22 12 22C17.5228 22 22 17.5228 22 12C22 11.3151 21.9311 10.6462 21.8 10"
                                                    stroke="currentColor"
                                                    stroke-width="1.5"
                                                    stroke-linecap="round"
                                                />
                                            </svg>
                                        </a>
                                    </li> 
                                </ul>
                            </div>
                            <div
                                x-data="header"
                                class="flex items-center space-x-1.5 ltr:ml-auto rtl:mr-auto rtl:space-x-reverse dark:text-[#d0d2d6] sm:flex-1 ltr:sm:ml-0 sm:rtl:mr-0 lg:space-x-2"
                            >
                                <div class="sm:ltr:mr-auto sm:rtl:ml-auto" x-data="{ search: false }" @click.outside="search = false">
                                    <!-- <form
                                        class="absolute inset-x-0 top-1/2 z-10 mx-4 hidden -translate-y-1/2 sm:relative sm:top-0 sm:mx-0 sm:block sm:translate-y-0"
                                        :class="{'!block' : search}"
                                        @submit.prevent="search = false"
                                    >
                                        <div class="relative">
                                            <input
                                                type="text"
                                                class="peer form-input bg-gray-100 placeholder:tracking-widest ltr:pl-9 ltr:pr-9 rtl:pr-9 rtl:pl-9 sm:bg-transparent ltr:sm:pr-4 rtl:sm:pl-4"
                                                placeholder="Search..."
                                            />
                                            <button
                                                type="button"
                                                class="absolute inset-0 h-9 w-9 appearance-none peer-focus:text-primary ltr:right-auto rtl:left-auto"
                                            >
                                                <svg class="mx-auto" width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <circle cx="11.5" cy="11.5" r="9.5" stroke="currentColor" stroke-width="1.5" opacity="0.5" />
                                                    <path d="M18.5 18.5L22 22" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                                </svg>
                                            </button>
                                            <button
                                                type="button"
                                                class="absolute top-1/2 block -translate-y-1/2 hover:opacity-80 ltr:right-2 rtl:left-2 sm:hidden"
                                                @click="search = false"
                                            >
                                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <circle opacity="0.5" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.5" />
                                                    <path
                                                        d="M14.5 9.50002L9.5 14.5M9.49998 9.5L14.5 14.5"
                                                        stroke="currentColor"
                                                        stroke-width="1.5"
                                                        stroke-linecap="round"
                                                    />
                                                </svg>
                                            </button>
                                        </div>
                                    </form> -->
                                    <button
                                        type="button"
                                        class="search_btn rounded-full bg-white-light/40 p-2 hover:bg-white-light/90 dark:bg-dark/40 dark:hover:bg-dark/60 sm:hidden"
                                        @click="search = ! search"
                                    >
                                        <svg
                                            class="mx-auto h-4.5 w-4.5 dark:text-[#d0d2d6]"
                                            width="20"
                                            height="20"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            xmlns="http://www.w3.org/2000/svg"
                                        >
                                            <circle cx="11.5" cy="11.5" r="9.5" stroke="currentColor" stroke-width="1.5" opacity="0.5" />
                                            <path d="M18.5 18.5L22 22" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                        </svg>
                                    </button>
                                </div>
                                <div>
                                    <!-- <a
                                        href="javascript:;"
                                        x-cloak
                                        x-show="$store.app.theme === 'light'"
                                        href="javascript:;"
                                        class="flex items-center rounded-full bg-white-light/40 p-2 hover:bg-white-light/90 hover:text-primary dark:bg-dark/40 dark:hover:bg-dark/60"
                                        @click="$store.app.toggleTheme('dark')"
                                    >
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="12" cy="12" r="5" stroke="currentColor" stroke-width="1.5" />
                                            <path d="M12 2V4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                            <path d="M12 20V22" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                            <path d="M4 12L2 12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                            <path d="M22 12L20 12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                            <path
                                                opacity="0.5"
                                                d="M19.7778 4.22266L17.5558 6.25424"
                                                stroke="currentColor"
                                                stroke-width="1.5"
                                                stroke-linecap="round"
                                            />
                                            <path
                                                opacity="0.5"
                                                d="M4.22217 4.22266L6.44418 6.25424"
                                                stroke="currentColor"
                                                stroke-width="1.5"
                                                stroke-linecap="round"
                                            />
                                            <path
                                                opacity="0.5"
                                                d="M6.44434 17.5557L4.22211 19.7779"
                                                stroke="currentColor"
                                                stroke-width="1.5"
                                                stroke-linecap="round"
                                            />
                                            <path
                                                opacity="0.5"
                                                d="M19.7778 19.7773L17.5558 17.5551"
                                                stroke="currentColor"
                                                stroke-width="1.5"
                                                stroke-linecap="round"
                                            />
                                        </svg>
                                    </a> -->
                                    <!-- <a
                                        href="javascript:;"
                                        x-cloak
                                        x-show="$store.app.theme === 'dark'"
                                        href="javascript:;"
                                        class="flex items-center rounded-full bg-white-light/40 p-2 hover:bg-white-light/90 hover:text-primary dark:bg-dark/40 dark:hover:bg-dark/60"
                                        @click="$store.app.toggleTheme('system')"
                                    >
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M21.0672 11.8568L20.4253 11.469L21.0672 11.8568ZM12.1432 2.93276L11.7553 2.29085V2.29085L12.1432 2.93276ZM21.25 12C21.25 17.1086 17.1086 21.25 12 21.25V22.75C17.9371 22.75 22.75 17.9371 22.75 12H21.25ZM12 21.25C6.89137 21.25 2.75 17.1086 2.75 12H1.25C1.25 17.9371 6.06294 22.75 12 22.75V21.25ZM2.75 12C2.75 6.89137 6.89137 2.75 12 2.75V1.25C6.06294 1.25 1.25 6.06294 1.25 12H2.75ZM15.5 14.25C12.3244 14.25 9.75 11.6756 9.75 8.5H8.25C8.25 12.5041 11.4959 15.75 15.5 15.75V14.25ZM20.4253 11.469C19.4172 13.1373 17.5882 14.25 15.5 14.25V15.75C18.1349 15.75 20.4407 14.3439 21.7092 12.2447L20.4253 11.469ZM9.75 8.5C9.75 6.41182 10.8627 4.5828 12.531 3.57467L11.7553 2.29085C9.65609 3.5593 8.25 5.86509 8.25 8.5H9.75ZM12 2.75C11.9115 2.75 11.8077 2.71008 11.7324 2.63168C11.6686 2.56527 11.6538 2.50244 11.6503 2.47703C11.6461 2.44587 11.6482 2.35557 11.7553 2.29085L12.531 3.57467C13.0342 3.27065 13.196 2.71398 13.1368 2.27627C13.0754 1.82126 12.7166 1.25 12 1.25V2.75ZM21.7092 12.2447C21.6444 12.3518 21.5541 12.3539 21.523 12.3497C21.4976 12.3462 21.4347 12.3314 21.3683 12.2676C21.2899 12.1923 21.25 12.0885 21.25 12H22.75C22.75 11.2834 22.1787 10.9246 21.7237 10.8632C21.286 10.804 20.7293 10.9658 20.4253 11.469L21.7092 12.2447Z"
                                                fill="currentColor"
                                            />
                                        </svg>
                                    </a> -->
                                    <!-- <a
                                        href="javascript:;"
                                        x-cloak
                                        x-show="$store.app.theme === 'system'"
                                        href="javascript:;"
                                        class="flex items-center rounded-full bg-white-light/40 p-2 hover:bg-white-light/90 hover:text-primary dark:bg-dark/40 dark:hover:bg-dark/60"
                                        @click="$store.app.toggleTheme('light')"
                                    >
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M3 9C3 6.17157 3 4.75736 3.87868 3.87868C4.75736 3 6.17157 3 9 3H15C17.8284 3 19.2426 3 20.1213 3.87868C21 4.75736 21 6.17157 21 9V14C21 15.8856 21 16.8284 20.4142 17.4142C19.8284 18 18.8856 18 17 18H7C5.11438 18 4.17157 18 3.58579 17.4142C3 16.8284 3 15.8856 3 14V9Z"
                                                stroke="currentColor"
                                                stroke-width="1.5"
                                            />
                                            <path opacity="0.5" d="M22 21H2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                            <path opacity="0.5" d="M15 15H9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                        </svg>
                                    </a> -->
                                </div>

                                <div class="dropdown shrink-0" x-data="dropdown" @click.outside="open = false">
                                    <!-- <a
                                        href="javascript:;"
                                        class="block rounded-full bg-white-light/40 p-2 hover:bg-white-light/90 hover:text-primary dark:bg-dark/40 dark:hover:bg-dark/60"
                                        @click="toggle"
                                    >
                                        <img
                                            :src="`assets/images/flags/${$store.app.locale.toUpperCase()}.svg`"
                                            alt="image"
                                            class="h-5 w-5 rounded-full object-cover"
                                        />
                                    </a>
                                    <ul
                                        x-cloak
                                        x-show="open"
                                        x-transition
                                        x-transition.duration.300ms
                                        class="top-11 grid w-[280px] grid-cols-2 gap-y-2 !px-2 font-semibold text-dark ltr:-right-14 rtl:-left-14 dark:text-white-dark dark:text-white-light/90 sm:ltr:-right-2 sm:rtl:-left-2"
                                    >
                                        <template x-for="item in languages">
                                            <li>
                                                <a
                                                    href="javascript:;"
                                                    class="hover:text-primary"
                                                    @click="$store.app.toggleLocale(item.value),toggle()"
                                                    :class="{'bg-primary/10 text-primary' : $store.app.locale == item.value}"
                                                >
                                                    <img
                                                        class="h-5 w-5 rounded-full object-cover"
                                                        :src="`assets/images/flags/${item.value.toUpperCase()}.svg`"
                                                        alt="image"
                                                    />
                                                    <span class="ltr:ml-3 rtl:mr-3" x-text="item.key"></span>
                                                </a>
                                            </li>
                                        </template>
                                    </ul> -->
                                </div>

                                <div class="dropdown" x-data="dropdown" @click.outside="open = false">
                                    <!-- <a
                                        href="javascript:;"
                                        class="block rounded-full bg-white-light/40 p-2 hover:bg-white-light/90 hover:text-primary dark:bg-dark/40 dark:hover:bg-dark/60"
                                        @click="toggle"
                                    >
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M22 10C22.0185 10.7271 22 11.0542 22 12C22 15.7712 22 17.6569 20.8284 18.8284C19.6569 20 17.7712 20 14 20H10C6.22876 20 4.34315 20 3.17157 18.8284C2 17.6569 2 15.7712 2 12C2 8.22876 2 6.34315 3.17157 5.17157C4.34315 4 6.22876 4 10 4H13"
                                                stroke="currentColor"
                                                stroke-width="1.5"
                                                stroke-linecap="round"
                                            />
                                            <path
                                                d="M6 8L8.1589 9.79908C9.99553 11.3296 10.9139 12.0949 12 12.0949C13.0861 12.0949 14.0045 11.3296 15.8411 9.79908"
                                                stroke="currentColor"
                                                stroke-width="1.5"
                                                stroke-linecap="round"
                                            />
                                            <circle cx="19" cy="5" r="3" stroke="currentColor" stroke-width="1.5" />
                                        </svg>
                                    </a> -->
                                    <ul
                                        x-cloak
                                        x-show="open"
                                        x-transition
                                        x-transition.duration.300ms
                                        class="top-11 w-[300px] !py-0 text-xs text-dark ltr:-right-16 rtl:-left-16 dark:text-white-dark sm:w-[375px] sm:ltr:-right-2 sm:rtl:-left-2"
                                    >
                                        <li class="mb-5">
                                            <div class="relative overflow-hidden rounded-t-md !p-5 text-white">
                                                <div
                                                    class="absolute inset-0 h-full w-full bg-[url('../images/menu-heade.jpg')] bg-cover bg-center bg-no-repeat"
                                                ></div>
                                                <h4 class="relative z-10 text-lg font-semibold">Messages</h4>
                                            </div>
                                        </li>
                                        <template x-for="msg in messages">
                                            <li>
                                                <div class="flex items-center px-5 py-3" @click.self="toggle">
                                                    <div x-html="msg.image"></div>
                                                    <span class="px-3 dark:text-gray-500">
                                                        <div class="text-sm font-semibold dark:text-white-light/90" x-text="msg.title"></div>
                                                        <div x-text="msg.message"></div>
                                                    </span>
                                                    <span
                                                        class="whitespace-pre rounded bg-white-dark/20 px-1 font-semibold text-dark/60 ltr:ml-auto ltr:mr-2 rtl:mr-auto rtl:ml-2 dark:text-white-dark"
                                                        x-text="msg.time"
                                                    ></span>
                                                    <button type="button" class="text-neutral-300 hover:text-danger" @click="removeMessage(msg.id)">
                                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <circle opacity="0.5" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.5" />
                                                            <path
                                                                d="M14.5 9.50002L9.5 14.5M9.49998 9.5L14.5 14.5"
                                                                stroke="currentColor"
                                                                stroke-width="1.5"
                                                                stroke-linecap="round"
                                                            />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </li>
                                        </template>
                                        <template x-if="messages.length">
                                            <li class="mt-5 border-t border-white-light text-center dark:border-white/10">
                                                <div
                                                    class="group flex cursor-pointer items-center justify-center px-4 py-4 font-semibold text-primary dark:text-gray-400"
                                                    @click="toggle"
                                                >
                                                    <span class="group-hover:underline ltr:mr-1 rtl:ml-1">VIEW ALL ACTIVITIES</span>
                                                    <svg
                                                        class="h-4 w-4 transition duration-300 group-hover:translate-x-1 ltr:ml-1 rtl:mr-1"
                                                        viewBox="0 0 24 24"
                                                        fill="none"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                    >
                                                        <path
                                                            d="M4 12H20M20 12L14 6M20 12L14 18"
                                                            stroke="currentColor"
                                                            stroke-width="1.5"
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                        />
                                                    </svg>
                                                </div>
                                            </li>
                                        </template>
                                        <template x-if="!messages.length">
                                            <li class="mb-5">
                                                <div class="!grid min-h-[200px] place-content-center text-lg hover:!bg-transparent">
                                                    <div class="mx-auto mb-4 rounded-full text-primary ring-4 ring-primary/30">
                                                        <svg width="40" height="40" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                opacity="0.5"
                                                                d="M20 10C20 4.47715 15.5228 0 10 0C4.47715 0 0 4.47715 0 10C0 15.5228 4.47715 20 10 20C15.5228 20 20 15.5228 20 10Z"
                                                                fill="currentColor"
                                                            />
                                                            <path
                                                                d="M10 4.25C10.4142 4.25 10.75 4.58579 10.75 5V11C10.75 11.4142 10.4142 11.75 10 11.75C9.58579 11.75 9.25 11.4142 9.25 11V5C9.25 4.58579 9.58579 4.25 10 4.25Z"
                                                                fill="currentColor"
                                                            />
                                                            <path
                                                                d="M10 15C10.5523 15 11 14.5523 11 14C11 13.4477 10.5523 13 10 13C9.44772 13 9 13.4477 9 14C9 14.5523 9.44772 15 10 15Z"
                                                                fill="currentColor"
                                                            />
                                                        </svg>
                                                    </div>
                                                    No data available.
                                                </div>
                                            </li>
                                        </template>
                                    </ul>
                                </div>
                                <div class="dropdown" x-data="dropdown" @click.outside="open = false">
                                    <a
                                        href="javascript:;"
                                        class="relative block rounded-full bg-white-light/40 p-2 hover:bg-white-light/90 hover:text-primary dark:bg-dark/40 dark:hover:bg-dark/60"
                                        @click="toggle"
                                    >
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M19.0001 9.7041V9C19.0001 5.13401 15.8661 2 12.0001 2C8.13407 2 5.00006 5.13401 5.00006 9V9.7041C5.00006 10.5491 4.74995 11.3752 4.28123 12.0783L3.13263 13.8012C2.08349 15.3749 2.88442 17.5139 4.70913 18.0116C9.48258 19.3134 14.5175 19.3134 19.291 18.0116C21.1157 17.5139 21.9166 15.3749 20.8675 13.8012L19.7189 12.0783C19.2502 11.3752 19.0001 10.5491 19.0001 9.7041Z"
                                                stroke="currentColor"
                                                stroke-width="1.5"
                                            />
                                            <path
                                                d="M7.5 19C8.15503 20.7478 9.92246 22 12 22C14.0775 22 15.845 20.7478 16.5 19"
                                                stroke="currentColor"
                                                stroke-width="1.5"
                                                stroke-linecap="round"
                                            />
                                            <path d="M12 6V10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                        </svg>

                                        <span class="absolute top-0 flex h-3 w-3 ltr:right-0 rtl:left-0">
                                            <span
                                                class="absolute -top-[3px] inline-flex h-full w-full animate-ping rounded-full bg-success/50 opacity-75 ltr:-left-[3px] rtl:-right-[3px]"
                                            ></span>
                                            <span class="relative inline-flex h-[6px] w-[6px] rounded-full bg-success"></span>
                                        </span>
                                    </a>
                                    <ul
                                        x-cloak
                                        x-show="open"
                                        x-transition
                                        x-transition.duration.300ms
                                        class="top-11 w-[300px] divide-y !py-0 text-dark ltr:-right-2 rtl:-left-2 dark:divide-white/10 dark:text-white-dark sm:w-[350px]"
                                    >
                                        <li>
                                            <div class="flex items-center justify-between px-4 py-2 font-semibold hover:!bg-transparent">
                                                <h4 class="text-lg">Notification</h4>
                                                <template x-if="notifications.length">
                                                    <span class="badge bg-primary/80" x-text="notifications.length + 'New'"></span>
                                                </template>
                                            </div>
                                        </li>
                                        <template x-for="notification in notifications">
                                            <li class="dark:text-white-light/90">
                                                <div class="group flex items-center px-4 py-2" @click.self="toggle">
                                                    <div class="grid place-content-center rounded">
                                                        <div class="relative h-12 w-12">
                                                            <img
                                                                class="h-12 w-12 rounded-full object-cover"
                                                                :src="`assets/images/${notification.profile}`"
                                                                alt="image"
                                                            />
                                                            <span class="absolute right-[6px] bottom-0 block h-2 w-2 rounded-full bg-success"></span>
                                                        </div>
                                                    </div>
                                                    <div class="flex flex-auto ltr:pl-3 rtl:pr-3">
                                                        <div class="ltr:pr-3 rtl:pl-3">
                                                            <h6 x-html="notification.message"></h6>
                                                            <span class="block text-xs font-normal dark:text-gray-500" x-text="notification.time"></span>
                                                        </div>
                                                        <button
                                                            type="button"
                                                            class="text-neutral-300 opacity-0 hover:text-danger group-hover:opacity-100 ltr:ml-auto rtl:mr-auto"
                                                            @click="removeNotification(notification.id)"
                                                        >
                                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <circle opacity="0.5" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.5" />
                                                                <path
                                                                    d="M14.5 9.50002L9.5 14.5M9.49998 9.5L14.5 14.5"
                                                                    stroke="currentColor"
                                                                    stroke-width="1.5"
                                                                    stroke-linecap="round"
                                                                />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </li>
                                        </template>
                                        <template x-if="notifications.length">
                                            <li>
                                                <div class="p-4">
                                                    <button class="btn btn-primary btn-small block w-full" @click="toggle">Read All Notifications</button>
                                                </div>
                                            </li>
                                        </template>
                                        <template x-if="!notifications.length">
                                            <li>
                                                <div class="!grid min-h-[200px] place-content-center text-lg hover:!bg-transparent">
                                                    <div class="mx-auto mb-4 rounded-full text-primary ring-4 ring-primary/30">
                                                        <svg width="40" height="40" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                opacity="0.5"
                                                                d="M20 10C20 4.47715 15.5228 0 10 0C4.47715 0 0 4.47715 0 10C0 15.5228 4.47715 20 10 20C15.5228 20 20 15.5228 20 10Z"
                                                                fill="currentColor"
                                                            />
                                                            <path
                                                                d="M10 4.25C10.4142 4.25 10.75 4.58579 10.75 5V11C10.75 11.4142 10.4142 11.75 10 11.75C9.58579 11.75 9.25 11.4142 9.25 11V5C9.25 4.58579 9.58579 4.25 10 4.25Z"
                                                                fill="currentColor"
                                                            />
                                                            <path
                                                                d="M10 15C10.5523 15 11 14.5523 11 14C11 13.4477 10.5523 13 10 13C9.44772 13 9 13.4477 9 14C9 14.5523 9.44772 15 10 15Z"
                                                                fill="currentColor"
                                                            />
                                                        </svg>
                                                    </div>
                                                    No data available.
                                                </div>
                                            </li>
                                        </template>
                                    </ul>
                                </div>
                                <div class="dropdown flex-shrink-0" x-data="dropdown" @click.outside="open = false">
                                    <a href="javascript:;" class="group relative" @click="toggle()">
                                        <span
                                            ><img
                                                class="h-9 w-9 rounded-full object-cover saturate-50 group-hover:saturate-100"
                                                src="{{ asset('assets/images/user-profile.jpeg') }}"
                                                alt="image"
                                        /></span>
                                    </a>
                                    <ul
                                        x-cloak
                                        x-show="open"
                                        x-transition
                                        x-transition.duration.300ms
                                        class="top-11 w-[230px] !py-0 font-semibold text-dark ltr:right-0 rtl:left-0 dark:text-white-dark dark:text-white-light/90"
                                    >
                                        <li>
                                            <div class="flex items-center px-4 py-4">
                                                <div class="flex-none">
                                                    <img class="h-10 w-10 rounded-md object-cover" src="{{ asset('assets/images/user-profile.jpeg') }}" alt="image" />
                                                </div>
                                                <div class="ltr:pl-4 rtl:pr-4">
                                                    <h4 class="text-base">
                                                    {{ Auth::user()->name }}<span class="rounded bg-success-light px-1 text-xs text-success ltr:ml-2 rtl:ml-2">Pro</span>
                                                    </h4>
                                                    <a
                                                        class="text-black/60 hover:text-primary dark:text-dark-light/60 dark:hover:text-white"
                                                        href="javascript:;"
                                                        >{{ Auth::user()->email }}</a
                                                    >
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <a href="{{ route('admin_change_password') }}" class="dark:hover:text-white" @click="toggle">
                                                <svg
                                                    class="h-4.5 w-4.5 ltr:mr-2 rtl:ml-2"
                                                    width="18"
                                                    height="18"
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                >
                                                    <circle cx="12" cy="6" r="4" stroke="currentColor" stroke-width="1.5" />
                                                    <path
                                                        opacity="0.5"
                                                        d="M20 17.5C20 19.9853 20 22 12 22C4 22 4 19.9853 4 17.5C4 15.0147 7.58172 13 12 13C16.4183 13 20 15.0147 20 17.5Z"
                                                        stroke="currentColor"
                                                        stroke-width="1.5"
                                                    />
                                                </svg>
                                                Change Password</a
                                            >
                                        </li>
                                       
                                        <li class="border-t border-white-light dark:border-white-light/10">
                                            <a href="{{ route('logout') }}" class="!py-3 text-danger" @click="toggle">
                                                <svg
                                                    class="h-4.5 w-4.5 rotate-90 ltr:mr-2 rtl:ml-2"
                                                    width="18"
                                                    height="18"
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                >
                                                    <path
                                                        opacity="0.5"
                                                        d="M17 9.00195C19.175 9.01406 20.3529 9.11051 21.1213 9.8789C22 10.7576 22 12.1718 22 15.0002V16.0002C22 18.8286 22 20.2429 21.1213 21.1215C20.2426 22.0002 18.8284 22.0002 16 22.0002H8C5.17157 22.0002 3.75736 22.0002 2.87868 21.1215C2 20.2429 2 18.8286 2 16.0002L2 15.0002C2 12.1718 2 10.7576 2.87868 9.87889C3.64706 9.11051 4.82497 9.01406 7 9.00195"
                                                        stroke="currentColor"
                                                        stroke-width="1.5"
                                                        stroke-linecap="round"
                                                    />
                                                    <path
                                                        d="M12 15L12 2M12 2L15 5.5M12 2L9 5.5"
                                                        stroke="currentColor"
                                                        stroke-width="1.5"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                    />
                                                </svg>
                                                Sign Out
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                       

                <div class="animate__animated p-6" :class="[$store.app.animation]" style="min-height:80vh">
                    <!-- start main content section -->
                    @yield('content')
                    <!-- end main content section -->

                  
                </div>
                
            </div>
            <div>
                  <!-- start footer section -->
                  <p class="pt-6 text-right dark:text-white-dark ltr:sm:text-right rtl:sm:text-right">
                        © <span id="footer-year">2023</span>. Mountcrest Enterprises All rights reserved.
                    </p>
                    <!-- end footer section -->
            </div>
        </div>
        
        <script src="{{ asset('assets/js/highlight.min.js') }}"></script>
        <script src="{{ asset('assets/js/alpine-collaspe.min.js') }}"></script>
        <script src="{{ asset('assets/js/alpine-persist.min.js') }}"></script>
        <script defer src="{{ asset('assets/js/alpine-ui.min.js') }}"></script>
        <script defer src="{{ asset('assets/js/alpine-focus.min.js') }}"></script>
        <script defer src="{{ asset('assets/js/alpine.min.js') }}"></script>
        <script src="{{ asset('assets/js/custom.js') }}"></script>
       
        <script defer src="{{ asset('assets/js/apexcharts.js') }}"></script>
        <script src="{{ asset('assets/js/simple-datatables.js') }}"></script>
        <script>
            document.addEventListener('alpine:init', () => {
                // main section
                Alpine.data('scrollToTop', () => ({
                    showTopButton: false,
                    init() {
                        window.onscroll = () => {
                            this.scrollFunction();
                        };
                    },

                    scrollFunction() {
                        if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
                            this.showTopButton = true;
                        } else {
                            this.showTopButton = false;
                        }
                    },

                    goToTop() {
                        document.body.scrollTop = 0;
                        document.documentElement.scrollTop = 0;
                    },
                }));

                // theme customization
                Alpine.data('customizer', () => ({
                    showCustomizer: false,
                }));

                // sidebar section
                Alpine.data('sidebar', () => ({
                    init() {
                        const selector = document.querySelector('.sidebar ul a[href="' + window.location.pathname + '"]');
                        if (selector) {
                            selector.classList.add('active');
                            const ul = selector.closest('ul.sub-menu');
                            if (ul) {
                                let ele = ul.closest('li.menu').querySelectorAll('.nav-link');
                                if (ele) {
                                    ele = ele[0];
                                    setTimeout(() => {
                                        ele.click();
                                    });
                                }
                            }
                        }
                    },
                }));

                // header section
                Alpine.data('header', () => ({
                    init() {
                        const selector = document.querySelector('ul.horizontal-menu a[href="' + window.location.pathname + '"]');
                        if (selector) {
                            selector.classList.add('active');
                            const ul = selector.closest('ul.sub-menu');
                            if (ul) {
                                let ele = ul.closest('li.menu').querySelectorAll('.nav-link');
                                if (ele) {
                                    ele = ele[0];
                                    setTimeout(() => {
                                        ele.classList.add('active');
                                    });
                                }
                            }
                        }
                    },

                    notifications: [
                  
                    ],

                    messages: [
                        {
                            id: 1,
                            image: '<span class="grid place-content-center w-9 h-9 rounded-full bg-success-light dark:bg-success text-success dark:text-success-light"><svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg></span>',
                            title: 'Congratulations!',
                            message: 'Your OS has been updated.',
                            time: '1hr',
                        },
                        {
                            id: 2,
                            image: '<span class="grid place-content-center w-9 h-9 rounded-full bg-info-light dark:bg-info text-info dark:text-info-light"><svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg></span>',
                            title: 'Did you know?',
                            message: 'You can switch between artboards.',
                            time: '2hr',
                        },
                        {
                            id: 3,
                            image: '<span class="grid place-content-center w-9 h-9 rounded-full bg-danger-light dark:bg-danger text-danger dark:text-danger-light"><svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></span>',
                            title: 'Something went wrong!',
                            message: 'Send Reposrt',
                            time: '2days',
                        },
                        {
                            id: 4,
                            image: '<span class="grid place-content-center w-9 h-9 rounded-full bg-warning-light dark:bg-warning text-warning dark:text-warning-light"><svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">    <circle cx="12" cy="12" r="10"></circle>    <line x1="12" y1="8" x2="12" y2="12"></line>    <line x1="12" y1="16" x2="12.01" y2="16"></line></svg></span>',
                            title: 'Warning',
                            message: 'Your password strength is low.',
                            time: '5days',
                        },
                    ],

                    languages: [
                        {
                            id: 1,
                            key: 'Chinese',
                            value: 'zh',
                        },
                        {
                            id: 2,
                            key: 'Danish',
                            value: 'da',
                        },
                        {
                            id: 3,
                            key: 'English',
                            value: 'en',
                        },
                        {
                            id: 4,
                            key: 'French',
                            value: 'fr',
                        },
                        {
                            id: 5,
                            key: 'German',
                            value: 'de',
                        },
                        {
                            id: 6,
                            key: 'Greek',
                            value: 'el',
                        },
                        {
                            id: 7,
                            key: 'Hungarian',
                            value: 'hu',
                        },
                        {
                            id: 8,
                            key: 'Italian',
                            value: 'it',
                        },
                        {
                            id: 9,
                            key: 'Japanese',
                            value: 'ja',
                        },
                        {
                            id: 10,
                            key: 'Polish',
                            value: 'pl',
                        },
                        {
                            id: 11,
                            key: 'Portuguese',
                            value: 'pt',
                        },
                        {
                            id: 12,
                            key: 'Russian',
                            value: 'ru',
                        },
                        {
                            id: 13,
                            key: 'Spanish',
                            value: 'es',
                        },
                        {
                            id: 14,
                            key: 'Swedish',
                            value: 'sv',
                        },
                        {
                            id: 15,
                            key: 'Turkish',
                            value: 'tr',
                        },
                    ],

                    removeNotification(value) {
                        this.notifications = this.notifications.filter((d) => d.id !== value);
                    },

                    removeMessage(value) {
                        this.messages = this.messages.filter((d) => d.id !== value);
                    },
                }));

                Alpine.data('chart', () => ({
                    init() {
                        const revenueChart = null;
                        const salesByCategory = null;
                        const dailySales = null;
                        const totalOrders = null;
                        const totalVisit = null;
                        const paidVisit = null;
                        const uniqueVisitorSeries = null;
                        const followers = null;
                        const referral = null;
                        const engagement = null;

                        isDark = this.$store.app.theme === 'dark' ? true : false;
                        isRtl = this.$store.app.rtlClass === 'rtl' ? true : false;

                        setTimeout(() => {
                            // revenue
                            this.revenueChart = new ApexCharts(this.$refs.revenueChart, this.revenueChartOptions);
                            this.$refs.revenueChart.innerHTML = '';
                            this.revenueChart.render();

                            // sales by category
                            this.salesByCategory = new ApexCharts(this.$refs.salesByCategory, this.salesByCategoryOptions);
                            this.$refs.salesByCategory.innerHTML = '';
                            this.salesByCategory.render();

                            // daily sales
                            this.dailySales = new ApexCharts(this.$refs.dailySales, this.dailySalesOptions);
                            this.$refs.dailySales.innerHTML = '';
                            this.dailySales.render();

                            // total orders
                            this.totalOrders = new ApexCharts(this.$refs.totalOrders, this.totalOrdersOptions);
                            this.$refs.totalOrders.innerHTML = '';
                            this.totalOrders.render();

                            //total visit
                            this.totalVisit = new ApexCharts(this.$refs.totalVisit, this.totalVisitOptions);
                            this.totalVisit.render();

                            this.paidVisit = new ApexCharts(this.$refs.paidVisit, this.paidVisitOptions);
                            this.paidVisit.render();

                            // unique visitors
                            this.uniqueVisitorSeries = new ApexCharts(this.$refs.uniqueVisitorSeries, this.uniqueVisitorSeriesOptions);
                            this.$refs.uniqueVisitorSeries.innerHTML = '';
                            this.uniqueVisitorSeries.render();

                            // followers
                            this.followers = new ApexCharts(this.$refs.followers, this.followersOptions);
                            this.followers.render();

                            // referral
                            this.referral = new ApexCharts(this.$refs.referral, this.referralOptions);
                            this.referral.render();

                            // engagement
                            this.engagement = new ApexCharts(this.$refs.engagement, this.engagementOptions);
                            this.engagement.render();
                        }, 300);

                        this.$watch('$store.app.theme', () => {
                            isDark = this.$store.app.theme === 'dark' ? true : false;

                            this.revenueChart.updateOptions(this.revenueChartOptions);
                            this.salesByCategory.updateOptions(this.salesByCategoryOptions);
                            this.dailySales.updateOptions(this.dailySalesOptions);
                            this.totalOrders.updateOptions(this.totalOrdersOptions);
                            this.totalVisit.updateOptions(this.totalVisitOptions);
                            this.paidVisit.updateOptions(this.paidVisitOptions);
                            this.uniqueVisitorSeries.updateOptions(this.uniqueVisitorSeriesOptions);
                            this.followers.updateOptions(this.followersOptions);
                            this.referral.updateOptions(this.referralOptions);
                            this.engagement.updateOptions(this.engagementOptions);
                        });

                        this.$watch('$store.app.rtlClass', () => {
                            isRtl = this.$store.app.rtlClass === 'rtl' ? true : false;
                            this.revenueChart.updateOptions(this.revenueChartOptions);
                            this.uniqueVisitorSeries.updateOptions(this.uniqueVisitorSeriesOptions);
                        });
                    },

                    // revenue
                    get revenueChartOptions() {
                        return {
                            series: [
                                {
                                    name: 'Income',
                                    data: [16800, 16800, 15500, 17800, 15500, 17000, 19000, 16000, 15000, 17000, 14000, 17000],
                                },
                                {
                                    name: 'Expenses',
                                    data: [16500, 17500, 16200, 17300, 16000, 19500, 16000, 17000, 16000, 19000, 18000, 19000],
                                },
                            ],
                            chart: {
                                height: 325,
                                type: 'area',
                                fontFamily: 'Nunito, sans-serif',
                                zoom: {
                                    enabled: false,
                                },
                                toolbar: {
                                    show: false,
                                },
                            },
                            dataLabels: {
                                enabled: false,
                            },
                            stroke: {
                                show: true,
                                curve: 'smooth',
                                width: 2,
                                lineCap: 'square',
                            },
                            dropShadow: {
                                enabled: true,
                                opacity: 0.2,
                                blur: 10,
                                left: -7,
                                top: 22,
                            },
                            colors: isDark ? ['#2196f3', '#e7515a'] : ['#1b55e2', '#e7515a'],
                            markers: {
                                discrete: [
                                    {
                                        seriesIndex: 0,
                                        dataPointIndex: 6,
                                        fillColor: '#1b55e2',
                                        strokeColor: 'transparent',
                                        size: 7,
                                    },
                                    {
                                        seriesIndex: 1,
                                        dataPointIndex: 5,
                                        fillColor: '#e7515a',
                                        strokeColor: 'transparent',
                                        size: 7,
                                    },
                                ],
                            },
                            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                            xaxis: {
                                axisBorder: {
                                    show: false,
                                },
                                axisTicks: {
                                    show: false,
                                },
                                crosshairs: {
                                    show: true,
                                },
                                labels: {
                                    offsetX: isRtl ? 2 : 0,
                                    offsetY: 5,
                                    style: {
                                        fontSize: '12px',
                                        cssClass: 'apexcharts-xaxis-title',
                                    },
                                },
                            },
                            yaxis: {
                                tickAmount: 7,
                                labels: {
                                    formatter: (value) => {
                                        return value / 1000 + 'K';
                                    },
                                    offsetX: isRtl ? -30 : -10,
                                    offsetY: 0,
                                    style: {
                                        fontSize: '12px',
                                        cssClass: 'apexcharts-yaxis-title',
                                    },
                                },
                                opposite: isRtl ? true : false,
                            },
                            grid: {
                                borderColor: isDark ? '#191e3a' : '#e0e6ed',
                                strokeDashArray: 5,
                                xaxis: {
                                    lines: {
                                        show: true,
                                    },
                                },
                                yaxis: {
                                    lines: {
                                        show: false,
                                    },
                                },
                                padding: {
                                    top: 0,
                                    right: 0,
                                    bottom: 0,
                                    left: 0,
                                },
                            },
                            legend: {
                                position: 'top',
                                horizontalAlign: 'right',
                                fontSize: '16px',
                                markers: {
                                    width: 10,
                                    height: 10,
                                    offsetX: -2,
                                },
                                itemMargin: {
                                    horizontal: 10,
                                    vertical: 5,
                                },
                            },
                            tooltip: {
                                marker: {
                                    show: true,
                                },
                                x: {
                                    show: false,
                                },
                            },
                            fill: {
                                type: 'gradient',
                                gradient: {
                                    shadeIntensity: 1,
                                    inverseColors: !1,
                                    opacityFrom: isDark ? 0.19 : 0.28,
                                    opacityTo: 0.05,
                                    stops: isDark ? [100, 100] : [45, 100],
                                },
                            },
                        };
                    },

                    // sales by category
                    get salesByCategoryOptions() {
                        return {
                            series: [985, 737, 270],
                            chart: {
                                type: 'donut',
                                height: 460,
                                fontFamily: 'Nunito, sans-serif',
                            },
                            dataLabels: {
                                enabled: false,
                            },
                            stroke: {
                                show: true,
                                width: 25,
                                colors: isDark ? '#0e1726' : '#fff',
                            },
                            colors: isDark ? ['#5c1ac3', '#e2a03f', '#e7515a', '#e2a03f'] : ['#e2a03f', '#5c1ac3', '#e7515a'],
                            legend: {
                                position: 'bottom',
                                horizontalAlign: 'center',
                                fontSize: '14px',
                                markers: {
                                    width: 10,
                                    height: 10,
                                    offsetX: -2,
                                },
                                height: 50,
                                offsetY: 20,
                            },
                            plotOptions: {
                                pie: {
                                    donut: {
                                        size: '65%',
                                        background: 'transparent',
                                        labels: {
                                            show: true,
                                            name: {
                                                show: true,
                                                fontSize: '29px',
                                                offsetY: -10,
                                            },
                                            value: {
                                                show: true,
                                                fontSize: '26px',
                                                color: isDark ? '#bfc9d4' : undefined,
                                                offsetY: 16,
                                                formatter: (val) => {
                                                    return val;
                                                },
                                            },
                                            total: {
                                                show: true,
                                                label: 'Total',
                                                color: '#888ea8',
                                                fontSize: '29px',
                                                formatter: (w) => {
                                                    return w.globals.seriesTotals.reduce(function (a, b) {
                                                        return a + b;
                                                    }, 0);
                                                },
                                            },
                                        },
                                    },
                                },
                            },
                            labels: ['Apparel', 'Sports', 'Others'],
                            states: {
                                hover: {
                                    filter: {
                                        type: 'none',
                                        value: 0.15,
                                    },
                                },
                                active: {
                                    filter: {
                                        type: 'none',
                                        value: 0.15,
                                    },
                                },
                            },
                        };
                    },

                    // daily sales
                    get dailySalesOptions() {
                        return {
                            series: [
                                {
                                    name: 'Sales',
                                    data: [44, 55, 41, 67, 22, 43, 21],
                                },
                                {
                                    name: 'Last Week',
                                    data: [13, 23, 20, 8, 13, 27, 33],
                                },
                            ],
                            chart: {
                                height: 160,
                                type: 'bar',
                                fontFamily: 'Nunito, sans-serif',
                                toolbar: {
                                    show: false,
                                },
                                stacked: true,
                                stackType: '100%',
                            },
                            dataLabels: {
                                enabled: false,
                            },
                            stroke: {
                                show: true,
                                width: 1,
                            },
                            colors: ['#e2a03f', '#e0e6ed'],
                            responsive: [
                                {
                                    breakpoint: 480,
                                    options: {
                                        legend: {
                                            position: 'bottom',
                                            offsetX: -10,
                                            offsetY: 0,
                                        },
                                    },
                                },
                            ],
                            xaxis: {
                                labels: {
                                    show: false,
                                },
                                categories: ['Sun', 'Mon', 'Tue', 'Wed', 'Thur', 'Fri', 'Sat'],
                            },
                            yaxis: {
                                show: false,
                            },
                            fill: {
                                opacity: 1,
                            },
                            plotOptions: {
                                bar: {
                                    horizontal: false,
                                    columnWidth: '25%',
                                },
                            },
                            legend: {
                                show: false,
                            },
                            grid: {
                                show: false,
                                xaxis: {
                                    lines: {
                                        show: false,
                                    },
                                },
                                padding: {
                                    top: 10,
                                    right: -20,
                                    bottom: -20,
                                    left: -20,
                                },
                            },
                        };
                    },

                    // total orders
                    get totalOrdersOptions() {
                        return {
                            series: [
                                {
                                    name: 'Sales',
                                    data: [28, 40, 36, 52, 38, 60, 38, 52, 36, 40],
                                },
                            ],
                            chart: {
                                height: 290,
                                type: 'area',
                                fontFamily: 'Nunito, sans-serif',
                                sparkline: {
                                    enabled: true,
                                },
                            },
                            stroke: {
                                curve: 'smooth',
                                width: 2,
                            },
                            colors: isDark ? ['#00ab55'] : ['#00ab55'],
                            labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10'],
                            yaxis: {
                                min: 0,
                                show: false,
                            },
                            grid: {
                                padding: {
                                    top: 125,
                                    right: 0,
                                    bottom: 0,
                                    left: 0,
                                },
                            },
                            fill: {
                                opacity: 1,
                                type: 'gradient',
                                gradient: {
                                    type: 'vertical',
                                    shadeIntensity: 1,
                                    inverseColors: !1,
                                    opacityFrom: 0.3,
                                    opacityTo: 0.05,
                                    stops: [100, 100],
                                },
                            },
                            tooltip: {
                                x: {
                                    show: false,
                                },
                            },
                        };
                    },

                    // statistics
                    get totalVisitOptions() {
                        return {
                            series: [
                                {
                                    data: [21, 9, 36, 12, 44, 25, 59, 41, 66, 25],
                                },
                            ],
                            chart: {
                                height: 58,
                                type: 'line',
                                fontFamily: 'Nunito, sans-serif',
                                sparkline: {
                                    enabled: true,
                                },
                                dropShadow: {
                                    enabled: true,
                                    blur: 3,
                                    color: '#009688',
                                    opacity: 0.4,
                                },
                            },
                            stroke: {
                                curve: 'smooth',
                                width: 2,
                            },
                            colors: ['#009688'],
                            grid: {
                                padding: {
                                    top: 5,
                                    bottom: 5,
                                    left: 5,
                                    right: 5,
                                },
                            },
                            tooltip: {
                                x: {
                                    show: false,
                                },
                                y: {
                                    title: {
                                        formatter: (formatter = () => {
                                            return '';
                                        }),
                                    },
                                },
                            },
                        };
                    },

                    //paid visit
                    get paidVisitOptions() {
                        return {
                            series: [
                                {
                                    data: [22, 19, 30, 47, 32, 44, 34, 55, 41, 69],
                                },
                            ],
                            chart: {
                                height: 58,
                                type: 'line',
                                fontFamily: 'Nunito, sans-serif',
                                sparkline: {
                                    enabled: true,
                                },
                                dropShadow: {
                                    enabled: true,
                                    blur: 3,
                                    color: '#e2a03f',
                                    opacity: 0.4,
                                },
                            },
                            stroke: {
                                curve: 'smooth',
                                width: 2,
                            },
                            colors: ['#e2a03f'],
                            grid: {
                                padding: {
                                    top: 5,
                                    bottom: 5,
                                    left: 5,
                                    right: 5,
                                },
                            },
                            tooltip: {
                                x: {
                                    show: false,
                                },
                                y: {
                                    title: {
                                        formatter: (formatter = () => {
                                            return '';
                                        }),
                                    },
                                },
                            },
                        };
                    },

                    // unique visitors
                    get uniqueVisitorSeriesOptions() {
                        return {
                            series: [
                                {
                                    name: 'Direct',
                                    data: [58, 44, 55, 57, 56, 61, 58, 63, 60, 66, 56, 63],
                                },
                                {
                                    name: 'Organic',
                                    data: [91, 76, 85, 101, 98, 87, 105, 91, 114, 94, 66, 70],
                                },
                            ],
                            chart: {
                                height: 360,
                                type: 'bar',
                                fontFamily: 'Nunito, sans-serif',
                                toolbar: {
                                    show: false,
                                },
                            },
                            dataLabels: {
                                enabled: false,
                            },
                            stroke: {
                                width: 2,
                                colors: ['transparent'],
                            },
                            colors: ['#5c1ac3', '#ffbb44'],
                            dropShadow: {
                                enabled: true,
                                blur: 3,
                                color: '#515365',
                                opacity: 0.4,
                            },
                            plotOptions: {
                                bar: {
                                    horizontal: false,
                                    columnWidth: '55%',
                                    borderRadius: 10,
                                },
                            },
                            legend: {
                                position: 'bottom',
                                horizontalAlign: 'center',
                                fontSize: '14px',
                                itemMargin: {
                                    horizontal: 8,
                                    vertical: 8,
                                },
                            },
                            grid: {
                                borderColor: isDark ? '#191e3a' : '#e0e6ed',
                                padding: {
                                    left: 20,
                                    right: 20,
                                },
                            },
                            xaxis: {
                                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                                axisBorder: {
                                    show: true,
                                    color: isDark ? '#3b3f5c' : '#e0e6ed',
                                },
                            },
                            yaxis: {
                                tickAmount: 6,
                                opposite: isRtl ? true : false,
                                labels: {
                                    offsetX: isRtl ? -10 : 0,
                                },
                            },
                            fill: {
                                type: 'gradient',
                                gradient: {
                                    shade: isDark ? 'dark' : 'light',
                                    type: 'vertical',
                                    shadeIntensity: 0.3,
                                    inverseColors: false,
                                    opacityFrom: 1,
                                    opacityTo: 0.8,
                                    stops: [0, 100],
                                },
                            },
                            tooltip: {
                                marker: {
                                    show: true,
                                },
                                y: {
                                    formatter: (val) => {
                                        return val;
                                    },
                                },
                            },
                        };
                    },

                    // followers
                    get followersOptions() {
                        return {
                            series: [
                                {
                                    data: [38, 60, 38, 52, 36, 40, 28],
                                },
                            ],
                            chart: {
                                height: 160,
                                type: 'area',
                                fontFamily: 'Nunito, sans-serif',
                                sparkline: {
                                    enabled: true,
                                },
                            },
                            stroke: {
                                curve: 'smooth',
                                width: 2,
                            },
                            colors: ['#4361ee'],
                            grid: {
                                padding: {
                                    top: 5,
                                },
                            },
                            yaxis: {
                                show: false,
                            },
                            tooltip: {
                                x: {
                                    show: false,
                                },
                                y: {
                                    title: {
                                        formatter: (formatter = () => {
                                            return '';
                                        }),
                                    },
                                },
                            },

                            if(isDark) {
                                option['fill'] = {
                                    type: 'gradient',
                                    gradient: {
                                        type: 'vertical',
                                        shadeIntensity: 1,
                                        inverseColors: !1,
                                        opacityFrom: 0.3,
                                        opacityTo: 0.05,
                                        stops: [100, 100],
                                    },
                                };
                            },
                        };
                    },

                    // referral
                    get referralOptions() {
                        return {
                            series: [
                                {
                                    data: [60, 28, 52, 38, 40, 36, 38],
                                },
                            ],
                            chart: {
                                height: 160,
                                type: 'area',
                                fontFamily: 'Nunito, sans-serif',
                                sparkline: {
                                    enabled: true,
                                },
                            },
                            stroke: {
                                curve: 'smooth',
                                width: 2,
                            },
                            colors: ['#e7515a'],
                            grid: {
                                padding: {
                                    top: 5,
                                },
                            },
                            yaxis: {
                                show: false,
                            },
                            tooltip: {
                                x: {
                                    show: false,
                                },
                                y: {
                                    title: {
                                        formatter: (formatter = () => {
                                            return '';
                                        }),
                                    },
                                },
                            },

                            if(isDark) {
                                option['fill'] = {
                                    type: 'gradient',
                                    gradient: {
                                        type: 'vertical',
                                        shadeIntensity: 1,
                                        inverseColors: !1,
                                        opacityFrom: 0.3,
                                        opacityTo: 0.05,
                                        stops: [100, 100],
                                    },
                                };
                            },
                        };
                    },

                    // engagement
                    get engagementOptions() {
                        return {
                            series: [
                                {
                                    name: 'Sales',
                                    data: [28, 50, 36, 60, 38, 52, 38],
                                },
                            ],
                            chart: {
                                height: 160,
                                type: 'area',
                                fontFamily: 'Nunito, sans-serif',
                                sparkline: {
                                    enabled: true,
                                },
                            },
                            stroke: {
                                curve: 'smooth',
                                width: 2,
                            },
                            colors: ['#1abc9c'],
                            grid: {
                                padding: {
                                    top: 5,
                                },
                            },
                            yaxis: {
                                show: false,
                            },
                            tooltip: {
                                x: {
                                    show: false,
                                },
                                y: {
                                    title: {
                                        formatter: (formatter = () => {
                                            return '';
                                        }),
                                    },
                                },
                            },

                            if(isDark) {
                                option['fill'] = {
                                    type: 'gradient',
                                    gradient: {
                                        type: 'vertical',
                                        shadeIntensity: 1,
                                        inverseColors: !1,
                                        opacityFrom: 0.3,
                                        opacityTo: 0.05,
                                        stops: [100, 100],
                                    },
                                };
                            },
                        };
                    },
                }));
            });

            $(document).ready(function() {
               
                $('select').select2({
                    placeholder: "Select",
                    allowClear: true
                    });
            });


        </script>
           @yield('scripts')
    </body>
</html>
