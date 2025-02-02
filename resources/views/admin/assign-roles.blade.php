@extends('layouts.dashboard')

@section('title', 'Assign Roles')

@section('content')

<div class="sm:px-2 lg:px-4">
    <div class="max-w-7xl mx-auto sm:px-2 lg:px-4 bg-white rounded-lg shadow">
        <div class="flex flex-col ">
            <div data-hs-datatable='{
                "pageLength": 10,
                "pagingOptions": {
                "pageBtnClasses": "min-w-[40px] flex justify-center items-center text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 py-2.5 text-sm rounded-full disabled:opacity-50 disabled:pointer-events-none"
                },
                "selecting": true,
                "rowSelectingOptions": {
                "selectAllSelector": "#hs-table-search-checkbox-all"
                },
                "language": {
                "zeroRecords": "<div class=\"py-10 px-5 flex flex-col justify-center items-center text-center\"><svg class=\"shrink-0 size-6 text-gray-500\" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><circle cx=\"11\" cy=\"11\" r=\"8\"/><path d=\"m21 21-4.3-4.3\"/></svg><div class=\"max-w-sm mx-auto\"><p class=\"mt-2 text-sm text-gray-600\">No search results</p></div></div>"
                }
            }'>

                <div class="py-3">
                    <div class="relative max-w-xs">
                        <label for="hs-table-input-search" class="sr-only">Search</label>
                        <input type="text" name="hs-table-search" id="hs-table-input-search" class="py-2 px-3 ps-9 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" placeholder="Search users" data-hs-datatable-search="">
                        <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-3">
                            <svg class="size-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"></circle>
                                <path d="m21 21-4.3-4.3"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="min-h-[521px] overflow-x-auto">
                    <div class="min-w-full inline-block align-middle">
                        <div class="overflow-hidden">
                            <div class="table-responsive">
                                <table class="min-w-full">
                                    <thead class="border-b border-gray-200">
                                        <tr>
                                            <th scope="col" class="py-1 group text-start font-normal focus:outline-none">
                                                <div class="py-1 px-2.5 inline-flex items-center border border-transparent text-sm text-gray-500 rounded-md hover:border-gray-200 ">
                                                    Name
                                                    <svg class="size-3.5 ms-1 -me-0.5 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <path class="hs-datatable-ordering-desc:text-blue-600" d="m7 15 5 5 5-5"></path>
                                                        <path class="hs-datatable-ordering-asc:text-blue-600" d="m7 9 5-5 5 5"></path>
                                                    </svg>
                                                </div>
                                            </th>
                                            <th scope="col" class="py-1 group text-start font-normal focus:outline-none">
                                                <div class="py-1 px-2.5 inline-flex items-center border border-transparent text-sm text-gray-500 rounded-md hover:border-gray-200">
                                                    Email
                                                    <svg class="size-3.5 ms-1 -me-0.5 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <path class="hs-datatable-ordering-desc:text-blue-600" d="m7 15 5 5 5-5"></path>
                                                        <path class="hs-datatable-ordering-asc:text-blue-600" d="m7 9 5-5 5 5"></path>
                                                    </svg>
                                                </div>
                                            </th>
                                            <th scope="col" class="py-1 group text-start font-normal focus:outline-none" width="600">
                                                <div class="py-1 px-2.5 inline-flex items-center border border-transparent text-sm text-gray-500 rounded-md hover:border-gray-200">
                                                    Role
                                                    <svg class="size-3.5 ms-1 -me-0.5 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <path class="hs-datatable-ordering-desc:text-blue-600" d="m7 15 5 5 5-5"></path>
                                                        <path class="hs-datatable-ordering-asc:text-blue-600" d="m7 9 5-5 5 5"></path>
                                                    </svg>
                                                </div>
                                            </th>
                                            <th scope="col" class="py-1 group text-start font-normal focus:outline-none">
                                                <div class="py-1 px-2.5 inline-flex items-center border border-transparent text-sm text-gray-500 rounded-md hover:border-gray-200">
                                                    School ID
                                                    <svg class="size-3.5 ms-1 -me-0.5 text-gray-400 " xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <path class="hs-datatable-ordering-desc:text-blue-600" d="m7 15 5 5 5-5"></path>
                                                        <path class="hs-datatable-ordering-asc:text-blue-600" d="m7 9 5-5 5 5"></path>
                                                    </svg>
                                                </div>
                                            </th>
                                        </tr>
                                    </thead>

                                    <tbody class="divide-y divide-gray-200">
                                        @foreach($users as $user)
                                        <tr>
                                            <td class="p-3 whitespace-nowrap text-sm font-medium text-gray-800">{{ $user->name }}</td>
                                            <td class="p-3 whitespace-nowrap text-sm text-gray-800">{{ $user->email }}</td>
                                            <td class="p-3 whitespace-nowrap text-sm text-gray-800">

                                                <div class="relative">
                                                    <select data-hs-select='{
                                                            "placeholder": "Select option...",
                                                            "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
                                                            "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-2 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-lg text-start text-sm focus:outline-none focus:ring-2 focus:ring-blue-500",
                                                            "dropdownClasses": "mt-2 z-50 w-full max-h-72 p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto",
                                                            "optionClasses": "py-1.5 px-3 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100",
                                                            "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"hidden hs-selected:block\"><svg class=\"shrink-0 size-3.5 text-blue-600 \" xmlns=\"http:.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"/></svg></span></div>"
                                                            }' multiple data-user-id="{{ $user->id }}">
                                                        <option value="">Choose</option>
                                                        @foreach($roles as $role)
                                                        <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>{{ $role->name }}</option>
                                                        @endforeach

                                                    </select>

                                                    <div class="absolute top-1/2 end-2.5 -translate-y-1/2">
                                                        <svg class="shrink-0 size-4 text-gray-500 dark:text-neutral-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                            <path d="m7 15 5 5 5-5"></path>
                                                            <path d="m7 9 5-5 5 5"></path>
                                                        </svg>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="p-3 whitespace-nowrap text-sm text-gray-800">{{ $user->school_id }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- End Body -->
                    </div>
                    <div class="flex items-center space-x-1 pt-4 border-t border-gray-200 hidden" data-hs-datatable-paging="">
                        <button type="button" class="p-2.5 min-w-[40px] inline-flex justify-center items-center gap-x-2 text-sm rounded-full text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none" data-hs-datatable-paging-prev="">
                            <span aria-hidden="true">«</span>
                            <span class="sr-only">Previous</span>
                        </button>
                        <div class="flex items-center space-x-1 [&>.active]:bg-gray-100 " data-hs-datatable-paging-pages=""></div>
                        <button type="button" class="p-2.5 min-w-[40px] inline-flex justify-center items-center gap-x-2 text-sm rounded-full text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none" data-hs-datatable-paging-next="">
                            <span class="sr-only">Next</span>
                            <span aria-hidden="true">»</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // asign roles on change event - ask for confirmation
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('[data-hs-select]').forEach(function(select) {
            select.addEventListener('change', function() {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You are about to assign roles to the selected user",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, assign!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // send fetch request to assign roles post /api/assign-role
                        const response = fetch('/api/assign-roles', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                user: select.getAttribute('data-user-id'),
                                roles: Array.from(select.selectedOptions).map(option => option.value)
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire(
                                    'Assigned!',
                                    'Roles have been assigned to the selected users',
                                    'success'
                                )
                            } else {
                                Swal.fire(
                                    'Error!',
                                    'Something went wrong',
                                    'error'
                                )
                            }
                        })
                    }
                })
            })
        })
    })

</script>
@endsection