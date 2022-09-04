@extends('admin.layouts.master')

@section('content')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">Create Day</h2>
    </div>

    <div class="intro-y box mt-8">
        <div class="p-8" id="input">
            <form action="" method="post">
                <div class="grid grid-cols-2 gap-4 ">
                    <div class="grid grid-cols-1 ">
                        <div class="">
                            <label for="" class="form-label">Code</label>
                            <input type="text" name="code"
                                   class="form-control border-gray-300 @error('code') border-theme-24 @enderror"
                                   placeholder="FRI" value="{{ old('code') }}" required autocomplete="code"
                                   autofocus>
                            @error('code')
                            <span class="text-theme-24 mt-2">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                    </div>

                    <div class="grid grid-cols-1">
                        <div class="">
                            <label for="" class="form-label">Name</label>
                            <input type="text" name="name"
                                   class="form-control border-gray-300 @error('name') border-theme-24 @enderror"
                                   placeholder="Friday" value="{{ old('name') }}" required autocomplete="name"
                                   autofocus>
                            @error('name')
                            <span class="text-theme-24 mt-2">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="text-right mt-4">
                    <button class="btn btn-primary w-24">Save</button>
                </div>
            </form>
        </div>
    </div>
@endsection
