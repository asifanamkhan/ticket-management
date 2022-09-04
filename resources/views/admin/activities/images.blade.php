@if (is_array($images) && count($images) > 0)
    <label class="form-label">Images</label>

    <div class="grid grid-cols-3 gap-2" id="image-preview">
        
        @foreach($images as $k => $image)
            <div class="grid grid-cols-2 gap-1">
                <div class="w-20 h-16 image-fit zoom-in @if($k > 0) ml-1 @endif">
                    <img src="{{ asset('uploads/activity/' . $image) }}" alt="Image activity" class="rounded-md " data-action="zoom">
                </div>
                <a style="cursor: pointer; justify-content: center;" data-toggle="modal" data-target="#delete-modal-preview" class="delete flex items-center text-theme-24" onclick="deleteItem('{{route('admin.activities.image.delete',[$id,$image])}}')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 w-4 h-4 mr-1"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                </a>
            </div>

        @endforeach
    </div>
@endif