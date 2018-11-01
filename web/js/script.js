function searchByNumberKey(){
    var number = document.getElementById('txt_number_key').value;
    if (!isFinite(number)){
        $.ajax({
            url: 'search-by-name',
            type: 'post',
            data: {num: number},
            success: function (data) {
                if (data.guest == null) {
                    $('#result').html('' +
                        '   <div class="alert alert-info" role="alert">' +
                        '   <b>Не найден.</b> ' +
                        '   Гость еще не зарегестрирован' +
                        '</div>');
                }else {
                    $('#result').html('' +
                        '<div class="panel panel-success">' +
                        '   <div class="panel-heading"><h4>'+ data.guest.name +'</h4></div>' +
                        '   <div class="panel-body">' +
                        '       <h4>Должность:</h4>' +
                        '       <div class="well">'+ data.guest.post +'</div>' +
                        '       <h4>Ключи: <span class="badge">'+ data.keys_count +'</span></h4>' +
                        '   </div>' +
                        '</div>');
                }
            }
        });
        return;
    }
    $.ajax({
        url: 'search-by-key',
        type: 'post',
        data: {num: number},
        success: function (data) {
            if (data.key_status == 40)
            $('#result').html('<div class="alert alert-info" role="alert"><b>На складе.</b> Данный брелок находится у маркетолога</div>')
        }
    });
}

function ready(){
    $('#btn').button();
}