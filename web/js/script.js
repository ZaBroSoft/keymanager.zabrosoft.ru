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
                        '</div>' + addRequestButton());
                }else {
                    var keys = '';
                    var keys_count = 0;
                    var loss_keys = '';
                    var loss_keys_count = 0;
                    for(var i = 0; i < data.keys_count; i++){
                        if (data.keys[i].status == 60) {
                            loss_keys_count++;
                            loss_keys += '<strike>#' + data.keys[i].number + ', </strike>';
                        }else{
                            keys += '<b>#' + data.keys[i].number + ', </b>';
                            keys_count++;
                        }
                    }
                    $('#result').html('' +
                        '<div class="panel panel-success">' +
                        '   <div class="panel-heading">' +

                        '       <div class="row">' +
                        '           <div class="col-md-8 col-xs-8">' +
                        '               <h4>'+ data.guest.name +'</h4>' +
                        '           </div>' +
                        '           <div class="col-md-4 col-xs-4 text-right">' +
                        '               <a href="key/request-key?number=&name='+ data.guest.name +'"'+
                        '                   class="btn btn-primary">' +
                        '                   <i class="glyphicon glyphicon-plus"></i>' +
                        '               </a>' +
                        '           </div>   ' +
                        '       </div>' +
                        '   </div>' +
                        '   <div class="panel-body">' +
                        '       <h4>Должность:</h4>' +
                        '       <div class="well">'+ data.guest.post +'</div>' +
                        '       <h4>Всего ключей:<span class="badge">'+ data.keys_count +'</span>' +
                        '            Активных: <span class="badge">'+ keys_count +'</span>' +
                        '               Утраченых: <span class="badge">'+ loss_keys_count +'</span></h4>' +
                        '       <div class="well">' +
                        '       '+ keys +'' + loss_keys +
                        '       </div>' +
                        '   </div>' +
                        '</div>');
                }
            }
        });
        return;
    }
    $.ajax({
        url: '../site/search-by-key',
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
            if (data.key_status == 20 || data.key_status == 60){
                if (data.guest != null){
                    var keys = '';
                    var keys_count = 0;
                    var loss_keys = '';
                    var loss_keys_count = 0;
                    for(var i = 0; i < data.keys_count; i++){
                        if (data.keys[i].status == 60) {
                            loss_keys_count++;
                            loss_keys += '<b>#' + data.keys[i].number + ', </b>';
                        }else{
                            keys += '<b>#' + data.keys[i].number + ', </b>';
                            keys_count++;
                        }
                    }
                    $('#result').html('' +
                        '<div class="panel panel-success">' +
                        '   <div class="panel-heading">' +
                        '       <div class="row">' +
                        '           <div class="col-md-8 col-xs-8">' +
                        '               <h4>'+ data.guest.name +'<span class="label label-primary">'+ data.key_status_name +'</span></h4>' +
                        '           </div>' +
                        '           <div class="col-md-4 col-xs-4 text-right">' +
                        '               <a href="key/request-key?number=&name='+ data.guest.name +'"'+
                        '                   class="btn btn-primary">' +
                        '                   <i class="glyphicon glyphicon-plus"></i>' +
                        '               </a>' +
                        '           </div>   ' +
                        '       </div>' +
                        '   </div>' +
                        '   <div class="panel-body">' +
                        '       <h4>Должность:</h4>' +
                        '       <div class="well">'+ data.guest.post +'</div>' +
                        '       <h4>Всего ключей:<span class="badge">'+ data.keys_count +'</span>' +
                        '            Активных: <span class="badge">'+ keys_count +'</span>' +
                        '               Утраченых: <span class="badge">'+ loss_keys_count +'</span></h4>' +
                        '       <div class="well">' +
                        '       '+ keys +'' +
                        '       </div>' +
                        '   </div>' +
                        '</div>');
                }else {
                    $('#result').html('<div class="alert alert-info" role="alert"><b>Утрачен.</b> ' +
                        'Данный брелок потеряли, сломали или еще что-то с ним сделали</div>');
                }
            }
            if (data.key_status == 10) {
                $('#result').html('<div class="alert alert-success" role="alert"><b>Свободен.</b> ' +
                    'Данный брелок находится у техника СКД</div>' + addRequestButton());
            }
            if (data.key_status == 50) {
                $('#result').html('<div class="alert alert-warning" role="alert"><b>Занят.</b> ' +
                    'Данный брелок находится в заявке на выдачу</div>');
            }
        }
    });
}

function addRequestButton() {
    var number = +document.getElementById("txt_number_key").value;
    var name = document.getElementById("txt_number_key").value;
    var text = '<div class="text-right">' +
        '           <div class="btn-group">' +
        '               <a href="key/request-key?number='+ number +'&name='+ (!isFinite(number) ? name : '') +'" ' +
        '                   class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i></a>' +
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

            document.getElementById('txt_number_key').value = data.nextKey;
            document.getElementById('txt_post').value = '';
        }
    });
}

function btnSendRequest_Click() {

    var name = document.getElementById('txt_name').value;
    var number = +document.getElementById('txt_number_key').value;

    if (name == '') return;

    if (!$("#ch_bracelet").is(':checked')){
        if (number == 0 || !isFinite(number)) {
            alert('Номер не может быть пустым или нулем!');
            return;
        }
    }

    var type = 0;

    if ($("#type_0").is(':checked')){
        type = 0;
    }else if ($("#type_1").is(':checked')) {
        type = 10;
    }else if ($("#type_2").is(':checked')) {
        type = 20;
    }else if ($("#type_3").is(':checked')) {
        type = 30;
    }else if ($("#type_4").is(':checked')) {
        type = 40;
    }

    var bracelet = $("#ch_bracelet").is(':checked') ? '10' : 0;

    var access = 0;

    if ($("#access_0").is(':checked')){
        access = 0;
    }else if ($("#access_1").is(':checked')) {
        access = 10;
    }else if ($("#access_2").is(':checked')) {
        access = 20;
    }else if ($("#access_3").is(':checked')) {
        access = 30;
    }else if ($("#access_4").is(':checked')) {
        access = 40;
    }

    var vip = $("#ch_vip").is(':checked') ? '10' : 0;

    var other = document.getElementById("comment").value;

    var post = document.getElementById("modal_txt_post").value;

    $.post("../site/search-by-name", {num: name}, function(data) {
        if (data.guest == null && post == '') {
            $('.bd-example-modal-sm').modal('show');
            document.getElementById("modal_txt_post").value = 'Без должности';
        }else{
            $.post("../key/add-request",
                {
                    number: number,
                    name: name,
                    post: post,
                    type: type,
                    bracelet: bracelet,
                    access: access,
                    vip: vip,
                    other: other
                },
                function (data) {
                    $("#request_content").html('');
                    $('#request_content').html('<div class="alert alert-success" role="alert"><b>Готово.</b> Заявка #'+ data.request_number +' отправлена</div>')
                }
            );
        }
    });

}

function modal_sendRequest() {
    $('.bd-example-modal-sm').modal('hide');
    btnSendRequest_Click();
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

function add_free_key() {
    var key = +document.getElementById("free_key").value;
    document.location.href = "add-free-key?key=" + key;
}

function getFreeKey() {
    $.ajax({
        url: '../key/get-free-key',
        type: 'post',
        success: function (data) {
            document.getElementById("txt_number_key").value = data.key.number;
            searchByNumberKey();
        }
    });
}

function addGuest(req_id) {
    var name = document.getElementById('txt_request_name').value;
    var post = document.getElementById('txt_request_post').value;

    $.post("../admin/addguest",
        {
            name: name,
            post: post,
            request_id: req_id
        },
        function (data) {

        }
    );
}

/* begin::admin/action-key */

function action_key_getKey() {
    var number = +document.getElementById('txt_action_key_number').value;
    if (!isFinite(number) || number == '' || number == 0) {
        alert('Не верный номер брелка');
        return;
    }

    $.post("../site/search-by-key",
        {
            num: number
        },
        function (data) {
            if (data.key_status == 40){
                $('#result').html('<div class="alert alert-info" role="alert"><b>На складе.</b> ' +
                    'Данный брелок находится у маркетолога</div>' + addLossButton());
            }
            if (data.key_status == 0) {
                $('#result').html('<div class="alert alert-danger" role="alert"><b>Ошибка.</b> ' +
                    'Такого ключа не существует</div>' + addLossButton());
            }
            if (data.key_status == 20 || data.key_status == 60){
                if (data.guest != null){
                    $('#result').html('' +
                        '<div class="panel panel-success">' +
                        '   <div class="panel-heading">' +
                        '       <div class="row">' +
                        '           <div class="col-md-8 col-xs-8">' +
                        '               <h4>'+ data.guest.name +'<span class="label label-primary">'+ data.key_status_name +'</span></h4>' +
                        '           </div>' +
                        '           <div class="col-md-4 col-xs-4 text-right">' +
                        '               <button onclick="action_key_loss_all_key_from_guest()"'+
                        '                   class="btn btn-primary">' +
                        '                   <i class="glyphicon glyphicon-minus"></i>' +
                        '               </button>' +
                        '           </div>   ' +
                        '       </div>' +
                        '   </div>' +
                        '   <div class="panel-body">' +
                        '       <h4>Должность:</h4>' +
                        '       <div class="well">'+ data.guest.post +'</div>' +
                        addReturnButtons() + addLossButton() +
                        '   </div>' +
                        '</div>');
                }else{
                    $('#result').html('<div class="alert alert-info" role="alert"><b>Утрачен.</b> ' +
                        'Данный брелок потеряли, сломали или еще что-то с ним сделали</div>' + addReturnButtons());
                }
            }
            if (data.key_status == 10) {
                $('#result').html('<div class="alert alert-success" role="alert"><b>Свободен.</b> ' +
                    'Данный брелок находится у техника СКД</div>' + addLossButton());
            }
            if (data.key_status == 50) {
                $('#result').html('<div class="alert alert-warning" role="alert"><b>Занят.</b> ' +
                    'Данный брелок находится в заявке на выдачу</div>');
            }
        });

}

function addReturnButtons() {
    var html = '<div class="btn-group">' +
        '           <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown">' +
        '               Вернуть' +
        '               <span class="caret"></span>' +
        '           </button>' +
        '           <ul class="dropdown-menu">' +
        '               <li><button class="btn btn-link" onclick="action_key_return(10)">Технику</button></li>' +
        '               <li><button class="btn btn-link" onclick="action_key_return(40)">Маркетологу</button></li>' +
        '           </ul>' +
        '       </div>';
    return html;
}

function addLossButton() {
    var html = '<button class="btn btn-danger" onclick="action_key_loss()">Утрачен</button>';
    return html;
}

function action_key_loss() {
    var number = +document.getElementById('txt_action_key_number').value;
    if (!isFinite(number) || number == '' || number == 0) {
        alert('Не верный номер брелка');
        return;
    }

    $.post("../admin/action-key",
        {
            action: 'loss',
            number: number
        },
        function (data) {
            action_key_getKey();
        });
}

function action_key_return(status) {
    var number = +document.getElementById('txt_action_key_number').value;
    if (!isFinite(number) || number == '' || number == 0) {
        alert('Не верный номер брелка');
        return;
    }

    $.post("../admin/action-key",
        {
            action: 'return',
            from: status,
            number: number
        },
        function (data) {
            action_key_getKey();
        });

}

function action_key_loss_all_key_from_guest() {
    var number = +document.getElementById('txt_action_key_number').value;
    if (!isFinite(number) || number == '' || number == 0) {
        alert('Не верный номер брелка');
        return;
    }

    $.post("../admin/action-key",
        {
            action: 'loss_all_key_from_guest',
            number: number
        },
        function (data) {
            action_key_getKey();
        });
}

/* end::admin/action-key */