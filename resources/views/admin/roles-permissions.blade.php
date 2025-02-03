@extends('layouts.dashboard')

@section('title', 'Roles & Permissions')

@section('content')
<div class="">
    <div class="max-w-7xl mx-auto sm:px-2 lg:px-4">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-4 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-2">
                    <h2 class="text-lg font-bold mb-2">Role & Permissions Management</h2>

                    <div class="ml-auto flex items-center gap-4">
                        <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none" aria-haspopup="dialog" aria-expanded="false" aria-controls="add-permission-modal" data-hs-overlay="#add-permission-modal">
                            Add Permission
                        </button>
                        <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none" aria-haspopup="dialog" aria-expanded="false" aria-controls="add-role-modal" data-hs-overlay="#add-role-modal">
                            Add Role
                        </button>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Available Permissions -->
                    <div class="space-y-4">
                        <div class="border rounded-md p-2 max-h-[calc(100vh-280px)] overflow-y-auto">
                            <h3 class="text-md font-semibold mb-3">Available Permissions</h3>
                            <div id="available-permissions" class="flex gap-1 flex-wrap">
                                @foreach($allPermissions as $permission)
                                <div class="permission-item bg-gray-50 p-1 text-xs rounded border cursor-move flex items-center gap-1"
                                    data-permission-id="{{ $permission->id }}"
                                    draggable="true">
                                    <svg class="hs-handle cursor-grab shrink-0 size-4 text-gray-500 dark:text-neutral-500" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="5 9 2 12 5 15"></polyline>
                                        <polyline points="9 5 12 2 15 5"></polyline>
                                        <polyline points="15 19 12 22 9 19"></polyline>
                                        <polyline points="19 9 22 12 19 15"></polyline>
                                        <line x1="2" x2="22" y1="12" y2="12"></line>
                                        <line x1="12" x2="12" y1="2" y2="22"></line>
                                    </svg>
                                    {{ $permission->name }}
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <!-- Trash Zone -->
                        <div id="trash-zone" class="border-2 border-dashed border-red-300 rounded-md p-4 bg-red-50">
                            <div class="flex items-center justify-center space-x-2 text-red-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                <span>Drop here to delete</span>
                            </div>
                        </div>
                    </div>

                    <!-- Roles and their permissions -->
                    <div class="space-y-6 max-h-[calc(100vh-180px)] overflow-y-auto">
                        @foreach($roles as $role)
                        <div class="border rounded-md p-2">
                            <h3 class="text-md font-semibold mb-3">{{ $role->name }}</h3>
                            <div class="role-permissions flex gap-1 flex-wrap"
                                data-role-id="{{ $role->id }}">
                                @foreach($role->permissions as $permission)
                                <div class="permission-item bg-blue-50 p-1 text-xs rounded border cursor-move flex items-center gap-1"
                                    data-permission-id="{{ $permission->id }}"
                                    draggable="true">
                                    <svg class="hs-handle cursor-grab shrink-0 size-4 text-gray-500 dark:text-neutral-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="5 9 2 12 5 15"></polyline>
                                        <polyline points="9 5 12 2 15 5"></polyline>
                                        <polyline points="15 19 12 22 9 19"></polyline>
                                        <polyline points="19 9 22 12 19 15"></polyline>
                                        <line x1="2" x2="22" y1="12" y2="12"></line>
                                        <line x1="12" x2="12" y1="2" y2="22"></line>
                                    </svg>
                                    {{ $permission->name }}
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="add-permission-modal" class="hs-overlay hidden size-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto pointer-events-none" role="dialog" tabindex="-1" aria-labelledby="add-permission-modal-label">
        <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto">
            <div class="flex flex-col bg-white border shadow-sm rounded-xl pointer-events-auto">
                <div class="flex justify-between items-center py-3 px-4 border-b">
                    <h3 id="add-permission-modal-label" class="font-bold text-gray-800">
                        Add Permission
                    </h3>
                    <button type="button" class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none" aria-label="Close" data-hs-overlay="#add-permission-modal">
                        <span class="sr-only">Close</span>
                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 6 6 18"></path>
                            <path d="m6 6 12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="p-4 overflow-y-auto">
                    <label for="input-label" class="block text-sm font-medium mb-2">Permission (Three words)</label>
                    <input type="text" id="input-label" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-500" placeholder="Enter permission name" />
                </div>
                <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t">
                    <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none" data-hs-overlay="#add-permission-modal">
                        Close
                    </button>
                    <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none" id="add-permission-button">
                        Add Permission
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div id="add-role-modal" class="hs-overlay hidden size-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto pointer-events-none" role="dialog" tabindex="-1" aria-labelledby="add-role-modal-label">
        <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto">
            <div class="flex flex-col bg-white border shadow-sm rounded-xl pointer-events-auto">
                <div class="flex justify-between items-center py-3 px-4 border-b">
                    <h3 id="add-role-modal-label" class="font-bold text-gray-800">
                        Add Role
                    </h3>
                    <button type="button" class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none" aria-label="Close" data-hs-overlay="#add-role-modal">
                        <span class="sr-only">Close</span>
                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 6 6 18"></path>
                            <path d="m6 6 12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="p-4 overflow-y-auto">
                    <label for="input-label" class="block text-sm font-medium mb-2">Role (Three words)</label>
                    <input type="text" id="input-label" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-500" placeholder="Enter role name" />
                </div>
                <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t">
                    <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none" data-hs-overlay="#add-role-modal">
                        Close
                    </button>
                    <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none" id="add-role-button">
                        Add Role
                    </button>
                </div>
            </div>
        </div>
    </div>
    
</div>

<!-- Add Sortable.js and SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize all sortable containers
        const containers = document.querySelectorAll('#available-permissions, .role-permissions');

        containers.forEach(container => {
            new Sortable(container, {
                group: {
                    name: 'permissions',
                    pull: 'clone',
                    put: true
                },
                animation: 150,
                ghostClass: 'bg-blue-100',
                chosenClass: 'bg-blue-200',
                dragClass: "shadow-lg",
                onEnd: async function(evt) {
                    const item = evt.item;
                    const permissionId = item.getAttribute('data-permission-id');
                    const newContainer = evt.to;
                    const oldContainer = evt.from;

                    const toRoleId = newContainer.getAttribute('data-role-id');
                    const fromRoleId = oldContainer.getAttribute('data-role-id');

                    // If dropping into a role container
                    if (toRoleId) {
                        const result = await Swal.fire({
                            title: 'Confirm Permission Assignment',
                            text: 'Are you sure you want to assign this permission to this role?',
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, assign it!'
                        });

                        if (result.isConfirmed) {
                            updatePermissionRole(permissionId, toRoleId, fromRoleId);
                        } else {
                            // Reset the UI
                            oldContainer.appendChild(item);
                        }
                    }

                    // If dropped back in available permissions from a role
                    if (!toRoleId && fromRoleId) {
                        const result = await Swal.fire({
                            title: 'Remove Permission',
                            text: 'Are you sure you want to remove this permission from the role?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, remove it!'
                        });

                        if (result.isConfirmed) {
                            updatePermissionRole(permissionId, null, fromRoleId, 'delete');
                            item.remove();
                        } else {
                            // Reset the UI
                            oldContainer.appendChild(item);
                        }
                    }
                }
            });
        });

        // Initialize trash zone
        new Sortable(document.getElementById('trash-zone'), {
            group: {
                name: 'permissions',
                put: true,
                pull: false
            },
            animation: 150,
            onAdd: async function(evt) {
                const item = evt.item;
                const permissionId = item.getAttribute('data-permission-id');
                const fromRoleId = evt.from.getAttribute('data-role-id');

                const result = await Swal.fire({
                    title: 'Delete Permission',
                    text: fromRoleId ?
                        'Are you sure you want to remove this permission from the role?' : 'Are you sure you want to delete this permission completely?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                });

                if (result.isConfirmed) {
                    if (fromRoleId) {
                        // Remove from role
                        await updatePermissionRole(permissionId, null, fromRoleId, 'delete');
                    } else {
                        // Delete permission completely
                        await deletePermission(permissionId);
                    }
                    item.remove();
                } else {
                    // Reset the UI
                    evt.from.appendChild(item);
                }
            }
        });

        async function updatePermissionRole(permissionId, roleId, fromRoleId = null, action = null) {
            const url = roleId ? `/api/roles/${roleId}/permissions` : '/api/roles/null/permissions';

            try {
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        permission_id: permissionId,
                        from_role_id: fromRoleId,
                        action: action
                    })
                });

                const data = await response.json();
                if (data.success) {
                    showNotification(data.message, 'success');
                } else {
                    throw new Error(data.message);
                }
            } catch (error) {
                showNotification(error.message, 'error');
            }
        }

        async function deletePermission(permissionId) {
            try {
                const response = await fetch(`/api/permissions/${permissionId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();
                if (data.success) {
                    showNotification(data.message, 'success');
                } else {
                    throw new Error(data.message);
                }
            } catch (error) {
                showNotification(error.message, 'error');
            }
        }

        function showNotification(message, type = 'success') {
            Swal.fire({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                icon: type,
                title: message
            });
        }

        // Add Permission or Role AJAX
        function addPermissionOrRole(type, name) {
            return fetch(`/api/${type}/store`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    name: name
                })
            });
        }

        // Add Permission
        document.getElementById('add-permission-button').addEventListener('click', async function() {
            const input = document.querySelector('#add-permission-modal input');
            const name = input.value.trim();

            if (!name) {
                showNotification('Please enter a permission name', 'error');
                return;
            }

            try {
                const response = await addPermissionOrRole('permission', name);
                const data = await response.json();

                if (data.success == true) {
                    showNotification(data.message, 'success');
                    input.value = '';
                    document.getElementById('available-permissions').insertAdjacentHTML('beforeend', `
                        <div class="permission-item bg-gray-50 p-1 text-xs rounded border cursor-move flex items-center gap-1"
                            data-permission-id="${data.permission.id}"
                            draggable="true">
                            <svg class="hs-handle cursor-grab shrink-0 size-4 text-gray-500 dark:text-neutral-500" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="5 9 2 12 5 15"></polyline>
                                <polyline points="9 5 12 2 15 5"></polyline>
                                <polyline points="15 19 12 22 9 19"></polyline>
                                <polyline points="19 9 22 12 19 15"></polyline>
                                <line x1="2" x2="22" y1="12" y2="12"></line>
                                <line x1="12" x2="12" y1="2" y2="22"></line>
                            </svg>
                            ${data.permission.name}
                        </div>
                    `);
                } else {
                    throw new Error(data.message);
                }
            } catch (error) {
                showNotification(error.message, 'error');
            }
        });

        // Add Role
        document.getElementById('add-role-button').addEventListener('click', async function() {
            const input = document.querySelector('#add-role-modal #input-label');
            const name = input.value.trim();

            if (!name) {
                showNotification('Please enter a role name', 'error');
                return;
            }

            try {
                const response = await addPermissionOrRole('role', name);
                const data = await response.json();

                if (data.success == true) {
                    showNotification(data.message, 'success');
                    input.value = '';
                    document.querySelector('.space-y-6').insertAdjacentHTML('beforeend', `
                        <div class="border rounded-md p-2">
                            <h3 class="text-md font-semibold mb-3">${data.role.name}</h3>
                            <div class="role-permissions flex gap-1 flex-wrap"
                                data-role-id="${data.role.id}">
                            </div>
                        </div>
                    `);
                } else {
                    throw new Error(data.message);
                }
            } catch (error) {
                showNotification(error.message, 'error');
            }
        });
    });
</script>

<style>
    .sortable-ghost {
        opacity: 0.4;
    }

    .sortable-drag {
        opacity: 0.8;
    }

    .permission-item {
        cursor: move;
        user-select: none;
    }

    #trash-zone {
        min-height: 80px;
        transition: all 0.3s ease;
    }

    #trash-zone.sortable-ghost {
        background-color: #fee2e2;
        border-color: #ef4444;
    }
</style>
@endsection