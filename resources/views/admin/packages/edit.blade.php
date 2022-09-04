@extends('admin.layouts.master')

@section('content')
    <div class="intro-y flex items-center mt-8">
        <div class="breadcrumb mr-auto custom-breadcrumb">
            <a href="{{ route('admin.packages.index') }}" class="breadcrumb-link">Packages</a>
            <i data-feather="chevron-right" class="breadcrumb__icon"></i>
            <span class="breadcrumb--active">   Edit - {{ $package->name }}</span>
        </div>
    </div>

    <div class="intro-y box mt-8">
        <div class="p-8" id="input">
            @if (session()->has('package-update'))
                <div class="alert alert-success-soft show flex items-center mb-2" role="alert">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                         class="feather feather-alert-triangle w-6 h-6 mr-2">
                        <path
                            d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                        <line x1="12" y1="9" x2="12" y2="13"></line>
                        <line x1="12" y1="17" x2="12.01" y2="17"></line>
                    </svg> {{ session('package-update') }} </div>
            @endif
            <form action="{{ route('admin.packages.update', ['package' => $package->id]) }}" method="post">
                @method('PUT')
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div class="grid grid-cols-1">
                        <div>
                            <label for="name" class="form-label">Name <i class="text-theme-24">*</i></label>
                            <input type="text" name="name"
                                   class="form-control border-gray-300 @error('name') border-theme-24 @enderror"
                                   id="name"
                                   placeholder="name"
                                   value="{{ $errors->has('name') ? old('name') : $package->name ?? '' }}"
                                   autocomplete="name" autofocus>

                            @error('name')
                            <span class="text-theme-24 mt-2">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                        </div>

                        <div class="mt-4">
                            <label for="day" class="form-label">Day <i class="text-theme-24">*</i></label>
                            <select id="day" name="day_id" data-placeholder="Select a day"
                                    class="tom-select w-full @error('day_id') border-theme-24 @enderror">
                                <option value="">Select a day</option>
                                @foreach($days as $day)
                                    @if($errors->has('day_id'))
                                        <option
                                            value="{{ $day->id }}" {{ $day->id == old('day_id') ? 'selected' : '' }}>{{ $day->name }}</option>
                                    @else
                                        <option
                                            value="{{ $day->id }}" {{ $day->id == $package->day_id ? 'selected' : '' }}>{{ $day->name }}</option>
                                    @endif

                                @endforeach

                            </select>

                            @error('day_id')
                            <span class="text-theme-24 mt-2">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                        </div>
                        
                        <div id="addon" class="mt-4 flex flex-wrap gap-2">
                            @php 
                                $old_activities = old('activities') ?? [];
                                $day_limit = old('day_limit') ?? [];
                                $limit_per_visitor = old('limit_per_visitor') ?? [];
                            @endphp
                            @if($errors->any() && count($old_activities) > 0)
       
                                @foreach($old_activities as $key => $activity_id)

                                    @if($activity_id == null) @continue; @endif
                                
                                <div class="flex flex-nowrap gap-2 addon">
                                    <div class="w-full">
                                        <label for="activities" class="form-label">Add on <i class="text-theme-24">*</i></label>
                                        <select id="activities" name="activities[]"
                                                data-placeholder="Select Activities"
                                                class="form-control w-full @error('activities') border-theme-24 @enderror"
                                                >

                                            <option value="">Select Add ons</option>
                                            @foreach($activities as $activity)
                                                <option value="{{ $activity->id }}"
                                                    {{  $activity->id ==  $activity_id ? 'selected' : '' }}>
                                                    {{ $activity->name }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @error('activities')
                                        <span class="text-theme-24 mt-2">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                    <div class="">
                                        <label for="" class="form-label">Day limit <i class="text-theme-24">*</i></label>
                                        <input type="text" name="day_limit[]" class="form-control border-gray-300 day_limit"
                                            placeholder="day limit" value="{{ !empty($day_limit) ? $day_limit[$key] : '' }}" autocomplete="day_limit"
                                            autofocus>

                                        @error('day_limit')
                                        <span class="text-theme-24 mt-2">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>

                                    <div class="">
                                        <label for="" class="form-label">Limit per visitor <i class="text-theme-24">*</i></label>
                                        <input type="text" name="limit_per_visitor[]" class="form-control border-gray-300 limit_per_visitor"
                                            placeholder="limit per visitor" value="{{ !empty($limit_per_visitor) ? $limit_per_visitor[$key] : '' }}" autocomplete="limit_per_visitor"
                                            autofocus>

                                        @error('limit_per_visitor')
                                        <span class="text-theme-24 mt-2">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>

                                    <div class="action">
                                        <label for="" class="form-label">.</label>
                                        <button class="btn btn-danger" id="minusAddOn">-</button>
                                    </div>
                                </div>
                                @endforeach
                            @else
                                @foreach($package->activities as $key => $p_activity)

                                    @if($p_activity == null) @continue; @endif

                                    <div class="flex flex-nowrap gap-2 addon">
                                    <div class="w-full">
                                        <label for="activities" class="form-label">Add on <i class="text-theme-24">*</i></label>
                                        <select id="activities" name="activities[]"
                                                data-placeholder="Select Activities"
                                                class="form-control w-full @error('activities') border-theme-24 @enderror"
                                                >

                                            <option value="">Select Add ons</option>
                                            @foreach($activities as $activity)
                                                <option value="{{ $activity->id }}"
                                                    {{  $activity->id ==  $p_activity->id ? 'selected' : '' }}>
                                                    {{ $activity->name }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @error('activities')
                                        <span class="text-theme-24 mt-2">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                    <div class="">
                                        <label for="" class="form-label">Day limit <i class="text-theme-24">*</i></label>
                                        <input type="text" name="day_limit[]" class="form-control border-gray-300 day_limit"
                                            placeholder="day limit" value="{{ $p_activity->pivot->day_limit }}" autocomplete="day_limit"
                                            autofocus>

                                        @error('day_limit')
                                        <span class="text-theme-24 mt-2">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="">
                                        <label for="" class="form-label">Limit per visitor <i class="text-theme-24">*</i></label>
                                        <input type="text" name="limit_per_visitor[]" class="form-control border-gray-300 limit_per_visitor"
                                            placeholder="limit per visitor" value="{{ $p_activity->pivot->limit_per_visitor }}" autocomplete="limit_per_visitor"
                                            autofocus>

                                        @error('limit_per_visitor')
                                        <span class="text-theme-24 mt-2">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="action">
                                        <label for="" class="form-label">.</label>
                                        <button class="btn btn-danger" id="minusAddOn">-</button>
                                    </div>
                                    </div>
                                @endforeach
                            @endif
                            <div id="addons" class="mt-4 flex flex-wrap gap-2"></div>
                            <div class="flex flex-nowrap gap-2 addon">
                                <div class="w-full">
                                    <label for="activities" class="form-label">Add on <i class="text-theme-24">*</i></label>
                                    <select id="activities" name="activities[]"
                                            data-placeholder="Select Activities"
                                            class="form-control w-full @error('activities') border-theme-24 @enderror"
                                            >

                                        <option value="">Select Add ons</option>
                                        @foreach($activities as $activity)
                                            <option value="{{ $activity->id }}">
                                                {{ $activity->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('activities')
                                    <span class="text-theme-24 mt-2">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                                <div class="">
                                    <label for="" class="form-label">Day limit <i class="text-theme-24">*</i></label>
                                    <input type="text" name="day_limit[]" class="form-control border-gray-300 day_limit"
                                           placeholder="day limit" autocomplete="day_limit"
                                           autofocus>

                                    @error('day_limit')
                                    <span class="text-theme-24 mt-2">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>

                                <div class="">
                                    <label for="" class="form-label">Limit per visitor <i class="text-theme-24">*</i></label>
                                    <input type="text" name="limit_per_visitor[]" class="form-control border-gray-300 limit_per_visitor"
                                           placeholder="limit per visitor" autocomplete="limit_per_visitor"
                                           autofocus>

                                    @error('limit_per_visitor')
                                    <span class="text-theme-24 mt-2">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>

                                <div class="action">
                                    <label for="" class="form-label">.</label>
                                    <button class="btn btn-primary" id="addAddOn">+</button>
                                </div>
                            </div>

                        </div>

                        <div class="mt-4">
                            <label for="" class="form-label">Price <i class="text-theme-24">*</i></label>
                            <input type="number" name="price" class="form-control border-gray-300 "
                                   placeholder="price"
                                   value="{{ $errors->has('price') ? old('price') : $package->price ?? '' }}"
                                   autocomplete="price"
                                   autofocus>

                            @error('price')
                            <span class="text-theme-24 mt-2">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                        </div>

                        <div class="mt-4">
                            <label for="type" class="form-label">Package Type <i class="text-theme-24">*</i></label>
                            <select id="type" type="text" name="package_type_id" data-placeholder="Select a day"
                                    class="tom-select w-full @error('package_type_id') border-theme-24 @enderror">
                                <option value="">Select a type</option>
                                @foreach($types as $type)
                                    @if($errors->has('package_type_id'))
                                        <option
                                            value="{{ $type->id }}" {{ $type->id == old('package_type_id') ? 'selected' : '' }}>{{ $type->name }}</option>
                                    @else
                                        <option
                                            value="{{ $type->id }}" {{ $type->id == $package->package_type_id ? 'selected' : '' }}>{{ $type->name }}</option>
                                    @endif
                                @endforeach

                            </select>

                            @error('package_type_id')
                            <span class="text-theme-24 mt-2">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                        </div>

                        <div class="mt-4">
                            <label for="" class="form-label">Gate access</label>
                            <input type="number" name="gate_access" placeholder="get access"
                                   class="form-control border-gray-300 @error('gate_access') border-theme-24 @enderror"
                                   value="{{ $errors->has('gate_access') ? old('gate_access') : $package->gate_access ?? '' }}"
                                   autocomplete="gate_access" autofocus>

                            @error('gate_access')
                            <span class="text-theme-24 mt-2">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                        </div>

                        <div class="mt-4">
                            <label for="" class="form-label">Quantity <i class="text-theme-24">*</i></label>
                            <input type="number" name="quantity" placeholder="quantity"
                                   class="form-control border-gray-300 @error('quantity') border-theme-24 @enderror"
                                   value="{{ $errors->has('quantity') ? old('quantity') : $package->quantity ?? '' }}"
                                   autocomplete="quantity" autofocus>

                            @error('quantity')
                            <span class="text-theme-24 mt-2">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                        </div>

                        <div class="mt-4">
                            <label for="" class="form-label">Fixed Quantity</label>
                            <input type="number" name="fixed_quantity"
                                   class="form-control border-gray-300 @error('fixed_quantity') border-theme-24 @enderror"
                                   placeholder="price"
                                   value="{{ $errors->has('fixed_quantity') ? old('fixed_quantity') : $package->fixed_quantity ?? '' }}"
                                   autocomplete="fixed_quantity" autofocus>

                            @error('fixed_quantity')
                            <span class="text-theme-24 mt-2">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                        </div>

                        <div class="grid grid-cols-2 mt-4">

                            <div class="">
                                <label for="" class="form-label">Status</label>
                                <div class="">
                                    @if(session()->has('update-package-status'))
                                        <input type="checkbox" name="status"
                                               class="form-check-switch" {{ session()->get('update-package-status') === true ? 'checked' : '' }} >
                                    @else
                                        <input type="checkbox" name="status"
                                               class="form-check-switch" {{ $package->status ? 'checked' : '' }} >
                                    @endif

                                </div>

                                @error('status')
                                <span class="text-theme-24 mt-2">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1">

                        <div>
                            <label for="arabic_name" class="form-label">Arabic Name <i
                                    class="text-theme-24">*</i></label>
                            <input type="text" name="arabic_name"
                                   class="form-control border-gray-300 @error('arabic_name') border-theme-24 @enderror"
                                   id="arabic_name"
                                   placeholder="arabic name"
                                   value="{{ $errors->has('arabic_name') ? old('arabic_name') : $package->arabic_name ?? '' }}"
                                   autocomplete="arabic_name" autofocus>

                            @error('arabic_name')
                            <span class="text-theme-24 mt-2">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                        </div>

                        <div class="mt-4">
                            <label for="" class="form-label">Description</label>
                            <textarea name="description" class="editor">
                                {{ $errors->has('description') ? old('description') : $package->description ?? '' }}
                            </textarea>

                            @error('description')
                            <span class="text-theme-24 mt-2">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                        </div>

                        <div class="mt-4">
                            <label for="" class="form-label">Arabic Description</label>
                            <textarea name="arabic_description" class="editor">
                                {{ $errors->has('arabic_description') ? old('arabic_description') : $package->arabic_description ?? '' }}
                            </textarea>

                            @error('arabic_description')
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

@push('scripts')
    <script>

        let x = 0;
        $('#addAddOn').on('click',function (e) {
            e.preventDefault();
            let parent = $(this).closest('.addon');
            let activity = parent.find('#activities')
            let day_limit = parent.find('.day_limit')
            let limit_per_visitor = parent.find('.limit_per_visitor')
            let child = parent.clone().appendTo('#addons')
            child.find('#activities').val(activity.val())
            child.find('.action').html('<div class="action"><label for="" class="form-label">.</label><button class="btn btn-danger" id="minusAddOn">-</button></div>')

            activity.val('')
            day_limit.val('')
            limit_per_visitor.val('')
        });

        $(document).on("click", "#minusAddOn", function (e) {
            e.preventDefault();
            $(this).closest('.addon').remove();
        });


        // $('select[name*="activities"]').change(function() {
        //     console.log('ok');
        //     var selectedOptions = $('select option:selected');
        //     $('select option').removeAttr('disabled');
        //     selectedOptions.each(function() {
        //         var value = this.value;
        //         if (value !== ''){
        //             var id = $(this).parent('select[name*="activities"]').prop('id');
        //             var options = $('select[name*="activities"]:not(#' + id + ') option[value=' + value + ']');
        //             options.prop('disabled', 'true');
        //         }
        //     });
        // });

    </script>
@endpush
