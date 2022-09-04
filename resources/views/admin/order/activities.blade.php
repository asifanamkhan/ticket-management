<div class="form-group grid grid-cols-7 gap-2 mt-4">
    <label for="" class="form-label">Package Quantity: </label>
    <input type="number" class="form-control w-full" value="1" placeholder="Package quantity" name="package_qty[]"/>
</div>

<strong class="text-xl">Add ons</strong>
<div class="activities grid grid-cols-3 gap-2 mt-4">
    @foreach ($package->activities as $activity)
        @if ($activity->price < 1) @continue @endif
        <div class="w-full">
            @if(is_array($activity->images) && sizeof($activity->images) > 0)
                <div class="w-20 h-16 image-fit zoom-in">
                    <img src="{{ asset('uploads/activity/' . $activity->images[0]) }}" class="rounded-md " data-action="zoom" alt="Activity image" />
                </div>

            @endif
            <div class="flex flex-nowrap gap-2 mt-2">
                <div>
                    <label for="" class="form-label">Name: </label>
                </div>
                <div>
                    {{ $activity->name }}
                </div>

            </div>

            <div class="flex flex-nowrap gap-2">
                <div>
                    <label for="" class="form-label">Quantity: </label>
                </div>

                <input type="hidden" class="form-control"
                       name="package_activities[{{ $package->id }}][]"
                       value="{{ $activity->id }}"/>

                <input type="text" class="form-control"
                       name="package_activity_qty[{{ $package->id }}][{{$activity->id}}]"
                       value="0"/>

            </div>

        </div>
    @endforeach
</div>
