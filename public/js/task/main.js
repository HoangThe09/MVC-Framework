var Task = {
    modalDel : document.querySelector('#task_delete'),
    modalDetail : {
        heading : document.querySelector('#task_detail h5'),
        idInput : document.querySelector('#task_detail #id-task'),
        titleInput : document.querySelector('#task_detail #title'),
        descriptionInput : document.querySelector('#task_detail #description'),
        expirationInput : document.querySelector('#task_detail #expiration'),
    },


    add : function (){
        this.renderModal('Add new task')
    },

    edit : function (e) {
        var id = e.getAttribute('data-id');
        $.ajax({
            url: '\\tasks\\'+id,
            type: 'GET',
            dataType: 'html',
        }).done(function (data){
            data = JSON.parse(data);
            Task.renderModal(data.title, data.id, data.title, data.description, data.expiration_time);
        })
    },

    renderModal : function (head, id = '', title = '', description = '', expiration = '') {
        this.modalDetail.heading.innerHTML = head;
        this.modalDetail.idInput.value = id;
        this.modalDetail.titleInput.value = title;
        this.modalDetail.descriptionInput.value = description;
        this.modalDetail.expirationInput.value = expiration.slice(0, 10);
    },

    saveTask : function(e){
        var id = this.modalDetail.idInput.value;
        var data = {
            title : this.modalDetail.titleInput.value,
            description : this.modalDetail.descriptionInput.value,
            expiration : this.modalDetail.expirationInput.value
        }
        if(id){
            Task.updateTask(id, data, e)
        }else{
            Task.createTask(data, e)
        }
    },

    createTask : function (data, e){
        $.ajax({
            url: '\\tasks',
            type: 'POST',
            dataType: 'html',
            data: data
        }).done(function (data){
            if(data != 0){
                document.querySelector('.list__tasks').innerHTML = data;
                e.previousElementSibling.click();
            }else{
                alert('failed');
            }
        })
    },

    updateTask : function (id, data, e){
        $.ajax({
            url: '\\tasks\\'+id,
            type: 'POST',
            dataType: 'html',
            data: data
        }).done(function (data){
            if(data){
                data = JSON.parse(data);
                document.querySelector(`#task_${data.id}`).innerHTML = data.title;
                e.previousElementSibling.click();
            }
            
        })
    },

    renderItem: function (data){
        var list = document.querySelector('.list__tasks')
        var item =  
        `<div class="item__task" id="item_${data.id}">
        <div class="status__checkbox">
            <input type="checkbox" class="form-check-input me-0">
        </div>
        <div class="tasks__title">
            <p class="lead fw-normal mb-0" id = "task_${data.id}">${data.title}</p>
        </div>
        <div class="button">
            <button class="text-info border-0" data-id = "${data.id}" onclick="Task.edit(this)" id="button_edit_${data.id}" title="Edit todo" data-bs-toggle="modal" data-bs-target="#task_detail">
                <i class="fas fa-pencil-alt me-3"></i>
            </button>
            <button class="text-danger border-0" data-id = "${data.id}" onclick="Task.delete(this)" id = "button_del_${data.id}" title="Delete todo" data-bs-toggle="modal" data-bs-target="#task_delete">
                <i class="fas fa-trash-alt"></i>
            </button>
            <div class="text-end text-muted">
                <a href="#!" class="text-muted" title="Created date">
                    <p class="small mb-0">${data.created_time}</p>
                </a>
            </div>
        </div>
    </div>`
        list.innerHTML = item + list.innerHTML;
    },

    delete : function (e){
        var id = e.getAttribute('data-id');
        $.ajax({
            url: '\\tasks\\'+id,
            type: 'GET',
            dataType: 'html',
        }).done(function (data){
            data = JSON.parse(data);
            Task.renderModalDel(data);
        })
    },

    renderModalDel : function (data){
        this.modalDel.querySelector('#message_confirm').innerHTML = `Delete: ${data.title}`;
        this.modalDel.querySelector('#delete_id').value = data.id;
    },

    deleteTask : function (e){
        id = this.modalDel.querySelector('#delete_id').value;
        $.ajax({
            url: '\\tasks\\delete\\'+id,
            type: 'GET',
            dataType: 'html',
        }).done(function (data){
            if(data != 0){
                document.querySelector('.list__tasks').innerHTML = data;
                e.previousElementSibling.click();
            }else{
                alert('delete fail');
            }
        })
    }
}

