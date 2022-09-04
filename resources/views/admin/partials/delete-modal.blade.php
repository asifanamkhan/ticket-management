<!-- BEGIN: Delete Modal -->
<div id="delete-modal-preview" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="p-5 text-center">
                    <i data-feather="x-circle" class="w-16 h-16 text-theme-24 mx-auto mt-3"></i>
                    <div class="text-3xl mt-5">
                        Are you sure?
                    </div>
                    <div class="text-gray-600 mt-2" id="messageBeforeDelete"></div>

                    <div class="text-gray-600">
                        This process cannot be undone.
                    </div>
                </div>
                <div class="px-5 pb-8 text-center">
                    <button type="button" data-dismiss="modal" class="btn btn-outline-secondary w-24 dark:border-dark-5 dark:text-gray-300 mr-1">
                        Cancel
                    </button>
                    <button data-dismiss="modal" onclick="deleteConfirm()" type="button" class="btn btn-danger w-24">
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END: Delete Modal -->


<!-- BEGIN: Success modal -->

<div class="text-center">
    <a id="successAfterDelete" data-toggle="modal" data-target="#success-modal-preview" class="btn btn-primary" style="display: none">
        Show Modal
    </a>
</div>

<div id="success-modal-preview" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="p-5 text-center">
                    <i data-feather="check-circle" class="w-16 h-16 text-theme-10 mx-auto mt-3"></i>
                    <div class="text-3xl mt-5" id="successMessage"></div>
                </div>
            </div>
            <div class="px-5 pb-8 text-center">
                <button onclick="reloadAfterDelete()" type="button" data-dismiss="modal" class="btn btn-primary w-24">
                    Ok
                </button>
            </div>
        </div>
    </div>
</div>
<!-- END: Success modal -->

<!-- BEGIN: Error modal -->

<div class="text-center">
    <a id="errorAfterDelete" href="javascript:;" data-toggle="modal" data-target="#warning-modal-preview" class="btn btn-primary" style="display: none">
        Show Modal
    </a>
</div>

<div id="warning-modal-preview" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog"> <div class="modal-content">
            <div class="modal-body p-0">
                <div class="p-5 text-center">
                    <i data-feather="x-circle" class="w-16 h-16 text-theme-23 mx-auto mt-3"></i>
                    <div class="text-3xl mt-5">Oops...</div>
                    <div class="text-gray-600 mt-2" id="errorMessage"></div>
                </div> <div class="px-5 pb-8 text-center">
                    <button type="button" data-dismiss="modal" class="btn w-24 btn-primary">
                        Ok
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- END: Error modal -->