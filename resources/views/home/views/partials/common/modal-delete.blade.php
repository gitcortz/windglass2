<!-- Delete Modal Form HTML -->
<div class="modal fade" id="modal-delete">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="form-delete">
                <div class="modal-header">
                    <h4 class="modal-title" id="delete-title" name="title">
                        Delete Task
                    </h4>
                    <button aria-hidden="true" class="close" data-dismiss="modal" type="button">
                        ×
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                        Are you sure you want to delete this ?
                    </p>
                    <p class="text-warning">
                        <small>
                            
                        </small>
                    </p>
                </div>
                <div class="modal-footer">
                    <input id="delete_id" name="delete_id" type="hidden" value="0">
                        <input class="btn btn-default" data-dismiss="modal" type="button" value="Cancel">
                            <button class="btn btn-danger" id="btn-delete" type="button">
                                Delete
                            </button>
                        </input>
                    </input>
                </div>
            </form>
        </div>
    </div>
</div>