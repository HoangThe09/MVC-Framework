var input = document.querySelector('#inputUrl');
var result = document.querySelector('.news__preview');
var saveButton = document.querySelector('#btn-save');
var newsList = document.querySelector('.news__list')
input.onchange = function (){
    result.setAttribute('style', 'opacity: 0;')
    var newsUrl = this.value;
    $.ajax({
        url: '/post/get-content',
        type: 'GET',
        dataType: 'html',
        data: {
            newsUrl: newsUrl,
        }
    }).done(function (data){
        if(data){
            result.innerHTML = data;
            result.setAttribute('style', 'opacity: 1;');
            saveButton.removeAttribute('disabled');
        }else{
            saveButton.setAttribute('disabled', true);
        }
    })
}
saveButton.onclick = function (e) {
    var newResult = document.querySelector('.news__result');
    
    $.ajax({
        url: '/post/add',
        type: 'GET',
        dataType: 'html',
        data: {
            save: 1,
        }
    }).done(function (data){
        console.log(data);
        if(data != 0){
            newResult.setAttribute('class', 'col-lg-3 col-md-3 news__item');
            newsList.insertBefore(newResult, newsList.firstChild);
            input.value = '';
            if(newsList.childElementCount > 12){
                newsList.lastElementChild.remove();
            }
            saveButton.setAttribute('disabled', true);
            alert('success');
        }else{
            alert('record exist');
        }
    })
}
