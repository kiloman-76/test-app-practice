$('document').ready(() => {
    console.log('my js');
    
    $('body').on('click', '.add-admin', function() {
        console.log('del');
        var link = $(this);
        $.ajax({
            url: '/user-manage/add-admin-status',
            type: 'GET',
            data: link.data(),
            success: function(response) {
                if(link.hasClass('btn')){
                    link.replaceWith('<a class="btn btn-danger delete-admin" href="#" data-id="'+ response + '">Удалить права администратора</a>');
                } else {
                    link.replaceWith('<a class="delete-admin" href="#" data-id="'+ response + '"><span class="glyphicon glyphicon-arrow-down text_color_red"></span></a>');
                }
            },
            error: function(error) {
            }
        });
        return false;
    });
    
    $('body').on('click', '.delete-admin', function() {
        console.log('add');
        var link = $(this);
        $.ajax({
            url: '/user-manage/delete-admin-status',
            type: 'GET',
            data: link.data(),
            success: function(response) {
                if(link.hasClass('btn')){
                    link.replaceWith('<a class="btn btn-success add-admin" href="#" data-id="' + response  + '">Дать права администратора</a>');
                } else {
                    link.replaceWith('<a class="add-admin" href="#" data-id="'+ response + '"><span class="glyphicon glyphicon-arrow-up text_color_green"></span></a>');
                }
            },
            error: function(error) {
            }
        });
        return false;
    });
    
    $('.operation-type').on('change', function(){
        $( "select option:selected" ).each(function() {
            $.pjax.reload({container : '#transactions', timeout: '300', url:'/operation/view-transaction?type=' + $(this).val()});

        })
    })
    
    $('#sendmoneyform-email').on('keyup', function(){
        console.log($(this).val());
        $.pjax.reload({container : '#search-users', timeout: '5000', url:'/user-manage/search?email=' + $(this).val()});
    })
});