<!-- Modal detail -->
<div class="modal fade" id="task_detail" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="task_detail_content">
            <div class="modal-header">
                <h5 class="modal-title">Add new task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label" id="label_description">Status</label>
                    <input type="checkbox" id="status" name="status"></input>
                </div>
                <div class="mb-3">
                    <label class="form-label" id="label_title">Title</label>
                    <input type="hidden" id="id-task" class="form-control" name="id">
                    <input type="text" id="title" class="form-control" name="title">
                </div>
                <div class="mb-3">
                    <label class="form-label" id="label_description">Description</label>
                    <textarea class="form-control" id="description" name="description"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label" id="label_expiration">Expiration</label>
                    <input type="date" class="form-control" id="expiration" name="expiration">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btnAdd" onclick="Task.saveTask(this)">Save</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal delete -->
<div class="modal fade" id="task_delete" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-danger" id="message_confirm"></p>
                <input type="hidden" name="id" id="delete_id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" id="btnAdd" onclick="Task.deleteTask(this)">Delete</button>
            </div>
        </div>
    </div>
</div>