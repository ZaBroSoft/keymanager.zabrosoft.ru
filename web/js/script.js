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
                        '<div class="panel">' +
                        '   <div class="panel-body">' +
                        '       <h3 class="text-center">'+ data.guest.name +'</h3>' +
                        '       <br>' +
                        '       <div class="well">'+ data.guest.post +'</div>' +
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