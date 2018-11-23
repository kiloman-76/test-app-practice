$('document').ready(function(){

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
                    link.replaceWith('<a class="delete-admin" title="Удалить права администратора" href="#" data-id="'+ response + '"><span class="glyphicon glyphicon-arrow-down text_color_red"></span></a>');
                }
            },
            error: function(error) {
            }
        });
        return false;
    });
    
    $('body').on('click', '.delete-admin', function() {
        var link = $(this);
        $.ajax({
            url: '/user-manage/delete-admin-status',
            type: 'GET',
            data: link.data(),
            success: function(response) {
                if(link.hasClass('btn')){
                    link.replaceWith('<a class="btn btn-success add-admin" href="#" data-id="' + response  + '">Дать права администратора</a>');
                } else {
                    link.replaceWith('<a class="add-admin" title="Дать права администратора" href="#" data-id="'+ response + '"><span class="glyphicon glyphicon-arrow-up text_color_green"></span></a>');
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
    });
    
    $('#sendmoneyform-email').on('keyup', function(){
        $.ajax()
    });

    $('body').on('click', '.request-access', function(event) {
        event.preventDefault();
        var link = $(this);
        hreflink = link.attr("href");
        $.ajax({
            url: hreflink,
            type: 'GET',
            success: function(response) {
                if(response['MESSAGE'] !== ''){
                    link.parent().replaceWith('<span>'+ response['MESSAGE'] + '</span>');
                } else if(response['ERROR']) {
                    link.parent().append('<span>'+ response['ERROR'] + '</span>');
                }
            },
        });
        return false;
    });

    $('.news-notification').click(function(){
        $('.news-list').toggle();
    });

    $('.news-list__close').click(function(){
        $('.news-list').hide();
    });


    $.ajax({
        url: '/news/take-user-news',
        type: 'GET',
        success: function (response) {
            console.log(response);
            news_list = $('.news-list');
            count_news = 0;
            response['NEWS'].forEach(
                function(element){
                    news_list.append('<div class="news-list__item active" data-id="' + element['id'] + '"><span class="news-list_item_text">'+ element['text'] +'</span><div class="news-list__item__new"></div></div>');
                    count_news++;
                }
            );
            if(count_news === 0 ){
                news_list.append('<span>Нет новых новостей</span>')
            } else {
                $('.news-notification').append('<span class="count-news">'+ count_news +'</span>');
            }

            $('.news-list__item.active').on('mouseover', function(){
                var news = $(this);
                $.ajax({
                    url: '/news/mark-as-read',
                    type: 'GET',
                    data: $(this).data(),
                    success: function(response) {
                        news.find('.news-list__item__new').animate({opacity: 0}, 1000);
                        count_news--;
                        if(count_news === 0){
                            $('.count-news').hide();
                        } else {
                            $('.count-news').html(count_news);
                        }
                    },
                })
            });
            $('.news-list__item.active').on('mouseout', function(){
                $(this).off('mouseover');
            });
        }

    });




});