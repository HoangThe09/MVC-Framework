@foreach($tasks as $task)
<div class="item__task" id = "item_{{$task['id']}}">
    <div class="status__checkbox">
        <input type="checkbox" class="form-check-input me-0">
    </div>
    <div class="tasks__title">
        <p class="lead fw-normal mb-0" id = "task_{{$task['id']}}" >{{$task['title']}}</p>
    </div>
    <div class="button">
        <button class="text-info border-0" data-id = "{{$task['id']}}" onclick="Task.edit(this)" id="button_edit_{{$task['id']}}" title="Edit todo" data-bs-toggle="modal" data-bs-target="#task_detail">
            <i class="fas fa-pencil-alt me-3"></i>
        </button>
        <button class="text-danger border-0" data-id = "{{$task['id']}}" onclick="Task.delete(this)" id = "button_del_{{$task['id']}}" title="Delete todo" data-bs-toggle="modal" data-bs-target="#task_delete">
            <i class="fas fa-trash-alt"></i>
        </button>
        <div class="text-end text-muted">
            <a href="#!" class="text-muted" title="Created date">
                <p class="small mb-0">{{$task['created_time']}}</p>
            </a>
        </div>
    </div>
</div>
@endforeach