var Task = {
    list : document.querySelector('.list__tasks'),
    modalDel : document.querySelector('#task_delete'),
    modalDetail : {
        status : document.querySelector('#task_detail #status'),
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
            Task.renderModal(data.title, data.status, data.id, data.title, data.description, data.expiration_time);
        })
    },

    renderModal : function (head, status = 0,id = '', title = '', description = '', expiration = '') {
        this.modalDetail.status.checked = status != 0 ? true : false;
        this.modalDetail.heading.innerHTML = head;
        this.modalDetail.idInput.value = id;
        this.modalDetail.titleInput.value = title != '' ? $.parseHTML(title)[0].data : '';
        this.modalDetail.descriptionInput.innerHTML = description != '' ? $.parseHTML(description)[0].data : '';
        this.modalDetail.expirationInput.value = expiration.slice(0, 10);
    },

    saveTask : function(e){
        var id = this.modalDetail.idInput.value;
        var data = {
            title : this.modalDetail.titleInput.value,
            status : this.modalDetail.status.checked ? 1 : 0,
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
            dataType: 'json',
            data: data
        }).done(function (response){
            if(response == "success"){
                Task.renderList();
                e.previousElementSibling.click();
            }
        }).fail(function (response){
            alert(JSON.parse(response.responseText).message);
        })
    },

    updateTask : function (id, data, e){
        $.ajax({
            url: '\\tasks\\'+id,
            type: 'PUT',
            dataType: 'json',
            data: data
        }).done(function (response){
            if(response){
                document.querySelector(`#task_${response.id}`).innerHTML = response.title;
                document.querySelector(`#status__${response.id}`).checked = response.status != 0 ? true : false;
                e.previousElementSibling.click();
            }
        }).fail(function (response) {
            alert(JSON.parse(response.responseText).message);
        })
    },

    updateStatus : function (e)
    {
        var id = e.getAttribute('data-id');
        var data = {
            status : e.checked ? 1 : 0,
        }
        $.ajax({
            url: '\\tasks\\'+id,
            type: 'PATCH',
            dataType: 'json',
            data: data
        }).fail(function (response){
            alert(response.message);
        })
    },

    renderList : function (){
        $.ajax({
            url: '\\tasks\\',
            type: 'GET',
            dataType: 'json',
        }).done(function (data){
            if(data){
                Task.list.innerHTML = '';
                for(var i = data.length - 1; i >= 0; i--){
                    Task.renderItem(data[i]);
                }
            }else{
                Task.list.innerHTML = `<h2 class="text-info text-center">Empty</h2>`;
            }
        }).fail(function (data){
            alert(data.responseText.message);
        })
    },

    renderItem: function (data){
        var checked = data.status != 0 ? 'checked' : '';
        var item =  
        `<div class="item__task" id="item_${data.id}">
        <div class="status__checkbox">
            <input type="checkbox" id="status__${data.id}" data-id = "${data.id}" class="form-check-input me-0" ${checked} onclick="Task.updateStatus(this)" value = "1">
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
        this.list.innerHTML = item + this.list.innerHTML;
    },

    delete : function (e){
        var id = e.getAttribute('data-id');
        $.ajax({
            url: '\\tasks\\'+id,
            type: 'GET',
            dataType: 'json',
        }).done(function (data){
            Task.renderModalDel(data);
        })
    },

    renderModalDel : function (data){
        this.modalDel.querySelector('#message_confirm').innerHTML = `Delete: ${data.title}`;
        this.modalDel.querySelector('#delete_id').value = data.id;
    },

    deleteTask : function (e){
        var id = this.modalDel.querySelector('#delete_id').value;
        $.ajax({
            url: '\\tasks\\'+id,
            type: 'DELETE',
            dataType: 'json',
        }).done(function (data){
            if(data === "success"){
                Task.renderList();
                e.previousElementSibling.click();
            }
        }).fail(function (response){
            alert(JSON.parse(response.responseText).message);
        })
    }
}
