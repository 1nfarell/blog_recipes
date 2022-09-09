
let dataForm = $(this).serialize();
var field = $('#main-center');

$.ajax({
    url: 'vendor/outputHome.php',
    method: 'GET',
    data: dataForm,                   
    success: function(data){                
        SelectData = JSON.parse(data);
        console.log(SelectData); 

        for (let key in SelectData){
            $(field).append('                                                                                          \
                <div class="main-field">                                                                               \
                    <a href="post.php?id='+`${SelectData[key]['id']}`+'">                                        \
                        <img class="card-text-picture"  src="data:image/jpeg;base64,'+`${SelectData[key]['image']}`+'">\
                    </a>                                                                                               \
                    <div class="card-id">                                                                              \
                        <img class="card-icon-id" src="images\\hashtag-sign.png">                                      \
                        <p class="card-id-name">'+`${SelectData[key]['name']}`+'</p>                                   \
                    </div>                                                                                             \
                    <a class="card-title" href="post.php?id='+`${SelectData[key]['id']}`+'">                     \
                        <h2>'+`${SelectData[key]['title']}`+'</h2>                                                     \
                    </a>                                                                                               \
                    <p class="card-text-description">'+`${SelectData[key]['description']}`+'</p>                       \
                    <div class="card-autor">                                                                           \
                        <img class="card-icon-autor" src="images\\icon-user.png">                                      \
                        <a href="autor.php?user='+`${SelectData[key]['full_name']}`+'">                                \
                            <p class="card-text-autor">'+`${SelectData[key]['full_name']}`+'</p>                       \
                        </a>                                                                                           \
                    </div>                                                                                             \
                    <div class="card-views">                                                                           \
                        <img class="card-icon-views" src="images\\eye.png">                                            \
                        <p class="card-text-views">'+`${SelectData[key]['views']}`+'</p>                               \
                    </div>                                                                                             \
                    <div class="card-text-indigrients">                                                                \
                        <img class="card-text-plus" src="images\\plus.png">                                            \
                        <p class="card-text-indigr">Развернуть</p>                                                     \
                    </div>                                                                                             \
                    <div class="card-indigrients" style="display: none;">                                              \
                        '+SelectData[key]['ingr'].reduce((previousValue, currentValue) => previousValue + `<div class="card-indigrients-indigrient">${currentValue['indigrient']}</div>         
                        <div class="card-indigrients-amount">${currentValue['amount']}</div>`,'')+
                        '</div>                                                                                        \
                </div>');
                $(".card-text-indigrients").click(function () {
                    $(this).siblings(".card-indigrients").slideDown("slow");
                  });
                  $(".card-indigrients").click(function () {
                    $(this).siblings(".card-indigrients").slideUp("slow");
                    $(".card-indigrients").hide(50);
                  });
              
            }
            
    },                 
}) 






