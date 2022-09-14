
let dataForm = $(this).serialize();
var field = $('#main-center');

$.ajax({
    url: 'vendor/outputHome.php',
    method: 'GET',
    data: dataForm,                   
    success: function(data){                
        SelectData = JSON.parse(data);
         
        outputData = SelectData;
        
        function output(){
            for (let key in outputData){ 
                
                $(field).append('                                                                                          \
                    <div class="main-field">                                                                               \
                        <a href="post.php?title='+`${outputData[key]['title']}`+'&id='+`${outputData[key]['id']}`+'">      \
                            <img class="card-text-picture"  src="data:image/jpeg;base64,'+`${outputData[key]['image']}`+'">\
                        </a>                                                                                               \
                        <div class="card-id">                                                                              \
                            <img class="card-icon-id" src="images\\hashtag-sign.png">                                      \
                            <p class="card-id-name">'+`${outputData[key]['categName']}`+'</p>                              \
                        </div>                                                                                             \
                        <a class="card-title" href="post.php?title='+`${outputData[key]['title']}`+'&id='+`${outputData[key]['id']}`+'">\
                            <h2>'+`${outputData[key]['title']}`+'</h2>                                                     \
                        </a>                                                                                               \
                        <div class="card-text-descr">                                                                      \
                            <p class="card-text-description">'+`${outputData[key]['description']}`+'</p>                   \
                        </div>                                                                                             \
                        <div class="card-autor">                                                                           \
                            <img class="card-icon-autor" src="images\\icon-user.png">                                      \
                            <a href="autor.php?user='+`${outputData[key]['full_name']}`+'">                                \
                                <p class="card-text-autor">'+`${outputData[key]['full_name']}`+'</p>                       \
                            </a>                                                                                           \
                        </div>                                                                                             \
                        <div class="card-views">                                                                           \
                            <img class="card-icon-views" src="images\\eye.png">                                            \
                            <p class="card-text-views">'+`${outputData[key]['views']}`+'</p>                               \
                        </div>                                                                                             \
                        <div class="card-text-indigrients">                                                                \
                            <img class="card-text-plus" src="images\\plus.png">                                            \
                            <p class="card-text-indigr">Развернуть</p>                                                     \
                        </div>                                                                                             \
                        <div class="card-indigrients" style="display: none;">                                              \
                            '+outputData[key]['ingr'].reduce((previousValue, currentValue) => previousValue + `<div class="card-indigrients-indigrient">${currentValue['indigrient']}</div>         
                            <div class="card-indigrients-amount">${currentValue['amount']}</div>`,'')+
                            '</div>                                                                                        \
                    </div>'
                );          
            } 
            $(".card-text-indigrients").click(function () {
                $(this).siblings(".card-indigrients").slideDown("slow");
            });
            $(".card-indigrients").click(function () {
                $(this).slideUp("slow");
            });
        }
          
        output();
        //фильтрация по категории
        $(filterCateg).on('change', function(){
            //сортировка по категории
            if($(this.selectedOptions).is('[value='+`${filterCateg.value}`+']')){
                
                $(".main-field").remove();
                
                outputData = SelectData;

                if(`${filterCateg.value}`== "sortdefault"){
                    if(`${filtersort.value}`=="sortdate"){
                        // сортировка по дате по убыванию
                        outputData.sort(function (a, b) {
                            if (a.date < b.date) {
                            return 1;
                            }
                            if (a.date > b.date) {
                            return -1;
                            }
                            // a должно быть равным b
                            return 0;                    
                        });
                        output();  
                    } 
                    if(`${filtersort.value}`=="sortviews"){
                        // сортировка по просмотрам по убыванию
                            outputData = SelectData;
                            outputData.sort(function (a, b) {
                                return b.views - a.views;
                            });                                 
                            output();   
                    }  
                    if(`${filtersort.value}`=="sortdefault"){
                        // сортировка по id по убыванию
                        outputData.sort(function (a, b) {
                            return b.id - a.id;
                        }); 
                        output();   
                    }   
                } else{ 
                    outputData = SelectData.filter(function(a) {
                        return a.categID == `${filterCateg.value}`;
                    });
                    output();
                }
            }
        });   
        //упорядочивание(сортировка)
        $(filtersort).on('change', function(){  
            if($(this.selectedOptions).is('[value='+`${filtersort.value}`+']')){
                
                $(".main-field").remove();
                
                if(`${filtersort.value}`== "sortdefault"){
                    // сортировка по id 
                    outputData.sort(function (a, b) {
                        return b.id - a.id;
                    }); 
                    output();                           
                }  
                if(`${filtersort.value}`== "sortdate"){
                    // сортировка по дате по убыванию
                    outputData.sort(function (a, b) {
                        if (a.date < b.date) {
                        return 1;
                        }
                        if (a.date > b.date) {
                        return -1;
                        }
                        // a должно быть равным b
                        return 0;                    
                    });
                    output();
                }
                if(`${filtersort.value}`== "sortviews"){
                    // сортировка по просмотрам по убыванию
                    
                    outputData.sort(function (a, b) {
                        return b.views - a.views;
                    }); 
                    output();                           
                }   
            }
        });
        
       
        //поиск на странице
        $(search).on("input", function(){
            outputData = SelectData;
            outputData = SelectData.filter(function(a) {
                
                let str=a.categName+a.title+a.description+a.full_name;
                str = str.toLowerCase();
                if(str.includes(`${search.value}`)){
                    $(".main-field").remove(); 
                    
                    return str;
                }  if ($(search).value != "")$('#btnDelSearch').show();
            }); 
            output();

            });
           

        document.getElementById('btnDelSearch').onclick = function(e) {
            
            document.getElementById('search').value = "";
            $('#btnDelSearch').hide();
            $(".main-field").remove();
            outputData = SelectData;
            output();
        }

    },              
}) 







