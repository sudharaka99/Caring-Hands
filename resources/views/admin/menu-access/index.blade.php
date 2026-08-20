@extends('layouts.admin')

@section('title', 'Menu Access Control')

@section('content')

<div class="dashboard-page">

    <div class="dashboard-heading">

        <div>

            <h1>Menu Access Control</h1>

            <p class="dashboard-subtitle">
                Control menu permissions for each user role.
            </p>

        </div>

    </div>


    @if(session('success'))

        <div class="alert alert-success">

            <i class="fa-solid fa-circle-check"></i>

            {{ session('success') }}

        </div>

    @endif


    <form method="POST"
          action="{{ route('admin.menu-access.update') }}">

        @csrf


        <div class="dashboard-card">

            <div class="dashboard-table-wrapper">

                <table class="dashboard-table access-table">

                    <thead>

                        <tr>

                            <th rowspan="2">
                                Menu
                            </th>

                            @foreach($roles as $role)

                                <th colspan="4"
                                    class="role-header">

                                    {{ ucfirst($role) }}

                                </th>

                            @endforeach

                        </tr>


                        <tr>

                            @foreach($roles as $role)

                                <th>View</th>
                                <th>Add</th>
                                <th>Edit</th>
                                <th>Delete</th>

                            @endforeach

                        </tr>

                    </thead>


                    <tbody>

                        @foreach($Getmenus as $menu)

                            @php

                                $accesses = $menu->accesses
                                    ->keyBy('role');

                            @endphp


                            <tr>

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


                                @foreach($roles as $role)

                                    @php

                                        $access =
                                            $accesses[$role] ?? null;

                                    @endphp


                                    <!-- VIEW -->

                                    <td>

                                        <input
                                            type="checkbox"
                                            name="access[{{ $menu->id }}][{{ $role }}][view]"
                                            {{ $access?->can_view ? 'checked' : '' }}>

                                    </td>


                                    <!-- CREATE -->

                                    <td>

                                        <input
                                            type="checkbox"
                                            name="access[{{ $menu->id }}][{{ $role }}][create]"
                                            {{ $access?->can_create ? 'checked' : '' }}>

                                    </td>


                                    <!-- EDIT -->

                                    <td>

                                        <input
                                            type="checkbox"
                                            name="access[{{ $menu->id }}][{{ $role }}][edit]"
                                            {{ $access?->can_edit ? 'checked' : '' }}>

                                    </td>


                                    <!-- DELETE -->

                                    <td>

                                        <input
                                            type="checkbox"
                                            name="access[{{ $menu->id }}][{{ $role }}][delete]"
                                            {{ $access?->can_delete ? 'checked' : '' }}>

                                    </td>

                                @endforeach

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>


        <div class="form-actions">

            <button type="submit"
                    class="btn btn-primary">

                <i class="fa-solid fa-floppy-disk"></i>

                Save Access Permissions

            </button>

        </div>

    </form>

</div>

@endsection