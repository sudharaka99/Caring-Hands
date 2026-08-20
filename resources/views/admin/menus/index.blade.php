@extends('layouts.admin')

@section('title', 'Menu Management')

@section('content')

<div class="dashboard-page">

    <div class="dashboard-heading">

        <div>
            <h1>Menu Management</h1>

            <p class="dashboard-subtitle">
                Create and manage system navigation menus.
            </p>
        </div>

        <a href="{{ route('admin.menus.create') }}"
           class="btn btn-primary">

            <i class="fa-solid fa-plus"></i>
            Add Menu

        </a>

    </div>


    @if(session('success'))

        <div class="alert alert-success">
            <i class="fa-solid fa-circle-check"></i>
            {{ session('success') }}
        </div>

    @endif


    <div class="dashboard-card">

        <div class="dashboard-table-wrapper">

            <table class="dashboard-table">

                <thead>

                    <tr>
                        <th>#</th>
                        <th>Menu</th>
                        <th>Route</th>
                        <th>Parent</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>

                </thead>


                <tbody>

                    @forelse($Getmenus as $menu)

                        <tr>

                            <td>
                                {{ $loop->iteration }}
                            </td>


                            <td>

                                <div class="menu-name">

                                    @if($menu->icon)

                                        <i class="{{ $menu->icon }}"></i>

                                    @endif

                                    <strong>

                                        @if($menu->parent_id)
                                            └─
                                        @endif

                                        {{ $menu->name }}

                                    </strong>

                                </div>

                            </td>


                            <td>

                                @if($menu->route)

                                    <code>
                                        {{ $menu->route }}
                                    </code>

                                @else

                                    -
                                    
                                @endif

                            </td>


                            <td>

                                {{ $menu->parent->name ?? 'Main Menu' }}

                            </td>


                            <td>

                                {{ $menu->sort_order }}

                            </td>


                            <td>

                                <span class="status-badge {{ $menu->status }}">

                                    {{ ucfirst($menu->status) }}

                                </span>

                            </td>


                            <td>

                                <div class="elder-actions">

                                    <a href="{{ route('admin.menus.edit', $menu->id) }}"
                                       class="action-btn edit"
                                       title="Edit">

                                        <i class="fa-solid fa-pen"></i>

                                    </a>


                                    <form
                                        action="{{ route('admin.menus.destroy', $menu->id) }}"
                                        method="POST"
                                        style="display:inline"
                                        onsubmit="return confirm('Delete this menu?')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="action-btn delete">

                                            <i class="fa-solid fa-trash"></i>

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="7">

                                <div class="empty-state">

                                    <i class="fa-solid fa-bars"></i>

                                    <h4>
                                        No Menus Found
                                    </h4>

                                    <p>
                                        Create your first system menu.
                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection