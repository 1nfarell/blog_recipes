let dataForm = $(this).serialize();
let field = $('#field-center');
 
function tableValue() {
    
    let arr = "";
    for(let key in SelectData){ arr = arr + '<tr><td class="table-field-tr id">'+`${SelectData[key]['id']}`+'</td>\
            <td class="table-field-tr title"><a href="post.php?id_article='+`${SelectData[key]['id']}`+'">'+`${SelectData[key]['title']}`+'</a></td>\
            <td class="table-field-tr name">'+`${SelectData[key]['name']}`+'</td>\
            <td class="table-field-tr views">'+`${SelectData[key]['views']}`+'</td>\
            <td><input class="editButton" type="button" value="Изменить"/>\
                <input id="'+`${SelectData[key]['id']}`+'" class="deleteButton" type="button" value="Удалить"/></td></tr>';
    }
    return arr;    
}

$.ajax({
    url: 'vendor/outputCabinet.php',
    method: 'GET',
    data: dataForm,
    success: function(data){
        SelectData = JSON.parse(data);
        console.log(SelectData);   
            $(field).append('<p style="padding-bottom: 20px; font-size: 18px">Ваши рецепты</p>\
    <div  class="field">\
        <table id="table-field" class="table-field">\
            <tr>\
                <th class="table-field-th id">ID</th>\
                <th class="table-field-th title">Название</th>\
                <th class="table-field-th name">Категория</th>\
                <th class="table-field-th views">Просм.</th>\
                <th></th>\
            </tr>'+`${tableValue()}`+'\
           </table></div>');
           $(".deleteButton").click(function (e) {     
            $.ajax({
                url: 'vendor/deletePost.php', 
                method: 'GET',
                data: {article_id: e.target.id},
            })            
        })      
}});


                      
       