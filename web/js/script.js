function searchByNumberKey(){
    var number = +document.getElementById('txt_number_key').value;
    var name = document.getElementById('txt_number_key').value;
    if (!isFinite(number)){
        $.ajax({
            url: 'site/search-by-name',
            type: 'post',
            data: {num: name},
            success: function (data) {
                if (data.guest == null) {
                    $('#result').html('' +
                        '   <div class="alert alert-info" role="alert">' +
                        '   <b>Не найден.</b> ' +
                        '   Гость еще не зарегестрирован' +
                        '</div>');
                }else {
                    var keys = '';
                    for(var i = 0; i < data.keys_count; i++){
                        keys += '<b>#' + data.keys[i].number + ', </b>';
                    }
                    $('#result').html('' +
                        '<div class="panel panel-success">' +
                        '   <div class="panel-heading"><h4>'+ data.guest.name +'</h4></div>' +
                        '   <div class="panel-body">' +
                        '       <h4>Должность:</h4>' +
                        '       <div class="well">'+ data.guest.post +'</div>' +
                        '       <h4>Ключи: <span class="badge">'+ data.keys_count +'</span></h4>' +
                        '       <div class="well">' +
                        '       '+ keys +'' +
                        '       </div>' +
                        '   </div>' +
                        '</div>');
                }
            }
        });
        return;
    }
    $.ajax({
        url: 'site/search-by-key',
        type: 'post',
        data: {num: number},
        success: function (data) {
            if (data.key_status == 40){
                $('#result').html('<div class="alert alert-info" role="alert"><b>На складе.</b> ' +
                    'Данный брелок находится у маркетолога</div>' + addRequestButton());
            }
            if (data.key_status == 0) {
                $('#result').html('<div class="alert alert-danger" role="alert"><b>Ошибка.</b> ' +
                    'Такого ключа не существует</div>');
            }
            if (data.key_status == 20){
                var keys = '';
                for(var i = 0; i < data.keys_count; i++){
                    keys += '<b>#' + data.keys[i].number + ', </b>';
                }
                $('#result').html('' +
                    '<div class="panel panel-success">' +
                    '   <div class="panel-heading"><h4>'+ data.guest.name +'</h4></div>' +
                    '   <div class="panel-body">' +
                    '       <h4>Должность:</h4>' +
                    '       <div class="well">'+ data.guest.post +'</div>' +
                    '       <h4>Ключи: <span class="badge">'+ data.keys_count +'</span></h4>' +
                    '       <div class="well">' +
                    '       '+ keys +'' +
                    '       </div>' +
                    '   </div>' +
                    '</div>');
            }
        }
    });
}

function addRequestButton() {
    var text = '<div class="text-right">' +
        '           <div class="btn-group">' +
        '               <a href="key/request-key" class="btn btn-primary">Заявка</a>' +
        '           </div>'
        '       </div>';

    return text;
}

function giveKey() {

    var number = +document.getElementById('txt_number_key').value;
    if (!isFinite(number) || number == 0){
        alert('Не правильный ключ');
        return;
    }

    var name = document.getElementById('txt_name').value;

    var post = '';

    if ($("#ch_newGuest").is(':checked')){
        post = document.getElementById('txt_post').value;
    }

    $.ajax({
        url: 'give-key',
        type: 'post',
        data: {number: number, name: name, post: post},
        success: function (data) {
            if (data.status == 'Not guest'){
                $('#result').html('<div class="alert alert-danger" role="alert"><b>Не найдено.</b> Гость не зарегестрирован</div>')
            }
            if (data.status == 'Not key'){
                $('#result').html('<div class="alert alert-danger" role="alert"><b>Не найдено.</b> Ключа не существует</div>')
            }
            if (data.status == 'OK'){
                $('#result').html('<div class="alert alert-success" role="alert"><b>Готово.</b> Ключ выдан</div>')
            }
            if (data.status == 'Key not free'){
                $('#result').html('<div class="alert alert-danger" role="alert"><b>Ошибка</b> Ключ уже выдан <b>'+ data.guest.name +'</b></div>')
            }
            if (data.status == 'Already guest'){
                $('#result').html('<div class="alert alert-danger" role="alert"><b>Ошибка</b> Гость уже зарегестрирован</div>')
            }

            document.getElementById('txt_number_key').value = '';
            document.getElementById('txt_name').value = '';
            document.getElementById('txt_post').value = '';
        }
    });
}

function btnSendRequest_Click() {

    var name = document.getElementById('txt_name').value;

    if (name == '') return;

    $.post("../site/search-by-name", {num: name}, function(data) {
        if (data.guest == null) {
            $('.bd-example-modal-sm').modal('show');
        }else{

        }
    });
}

function txt_name_onBlur() {
    var name = document.getElementById('txt_name').value;
    if (name == ''){
        return;
    }
    if ($("#post").hasClass('hidden')) {
        $.post("../site/search-by-name", {num: name}, function(data) {
            if (data.guest != null) {
                $("#guest_post").html(data.guest.post);
                $("#post").removeClass('hidden');
            }
        });
    }
}