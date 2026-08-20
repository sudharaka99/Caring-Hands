@extends('layouts.admin')

@section('title', 'Add Menu')

@section('content')

<div class="dashboard-page">

    <div class="dashboard-heading">

        <div>

            <h1>Add New Menu</h1>

            <p class="dashboard-subtitle">
                Create a new navigation menu item.
            </p>

        </div>

        <a href="{{ route('admin.menus.index') }}"
           class="btn btn-outline">

            <i class="fa-solid fa-arrow-left"></i>
            Back

        </a>

    </div>


    <form method="POST"
          action="{{ route('admin.menus.store') }}">

        @csrf


        <div class="dashboard-card">

            <h3 class="card-title">

                <i class="fa-solid fa-bars"></i>

                Menu Information

            </h3>


            <div class="form-grid">

                <!-- Menu Name -->

                <div class="form-group">

                    <label>Menu Name *</label>

                    <input type="text"
                           name="name"
                           class="form-control"
                           value="{{ old('name') }}"
                           placeholder="Example: Elders"
                           required>

                    @error('name')

                        <small class="text-danger">
                            {{ $message }}
                        </small>

                    @enderror

                </div>


                <!-- Route -->

                <div class="form-group">

                    <label>Route Name</label>

                    <input type="text"
                           name="route"
                           class="form-control"
                           value="{{ old('route') }}"
                           placeholder="Example: admin.elders.index">

                </div>


                <!-- Icon -->

                <div class="form-group">

                    <label>Font Awesome Icon</label>

                    <input type="text"
                           name="icon"
                           class="form-control"
                           value="{{ old('icon') }}"
                           placeholder="Example: fa-solid fa-person-cane">

                </div>


                <!-- Parent -->

                <div class="form-group">

                    <label>Parent Menu</label>

                    <select name="parent_id"
                            class="form-control">

                        <option value="">
                            Main Menu
                        </option>

                        @foreach($parentMenus as $parent)

                            <option value="{{ $parent->id }}"
                                {{ old('parent_id') == $parent->id ? 'selected' : '' }}>

                                {{ $parent->name }}

                            </option>

                        @endforeach

                    </select>

                </div>


                <!-- Order -->

                <div class="form-group">

                    <label>Sort Order *</label>

                    <input type="number"
                           name="sort_order"
                           class="form-control"
                           value="{{ old('sort_order', 0) }}"
                           min="0"
                           required>

                </div>


                <!-- Status -->

                <div class="form-group">

                    <label>Status *</label>

                    <select name="status"
                            class="form-control">

                        <option value="active">
                            Active
                        </option>

                        <option value="inactive">
                            Inactive
                        </option>

                    </select>

                </div>

            </div>

        </div>


        <div class="form-actions">

            <a href="{{ route('admin.menus.index') }}"
               class="btn btn-outline">

                Cancel

            </a>


            <button type="submit"
                    class="btn btn-primary">

                <i class="fa-solid fa-floppy-disk"></i>

                Save Menu

            </button>

        </div>

    </form>

</div>

@endsection