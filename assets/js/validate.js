// function validateAddPost(){
//     //Считаем значения из полей name и email в переменные x и y
//     var categories=document.forms["formAddPost"]["categories"].value;
//     var title=document.forms["formAddPost"]["title"].value; 
//     var description=document.forms["formAddPost"]["description"].value;
//     var myimage=document.forms["formAddPost"]["myimage"].value;
//     var indigrient=document.forms["formAddPost"]["indigrient"].value;
//     var amount=document.forms["formAddPost"]["amount"].value;
//     var measure=document.forms["formAddPost"]["measure"].value;

// }
function validateAddPost(){
 $(document).ready(function() {
    $('form[id="formAddPost"]').validate({
    rules: {
        categories: 'required',
        title: 'required'

        
        // user_email: {
        // required: true,
        // email: true,
        // },
        // psword: {
        // required: true,
        // minlength: 8,
        // }
    },
    messages: {
        categories: 'This field is required',
        title: 'This field is required',
        // user_email: 'Enter a valid email',
        // psword: {
        // minlength: 'Password must be atleast 8 characterslong'
        // }
    },
    submitHandler: function(form) {
        form.submit();
    }
    });

}
}
function validateRegister(){
   //Считаем значения из полей name и email в переменные x и y
   var x=document.forms["form"]["name"].value;
   var y=document.forms["form"]["email"].value;
   //Если поле name пустое выведем сообщение и предотвратим отправку формы
   if (x.length==0){
      document.getElementById("namef").innerHTML="*данное поле обязательно для заполнения";
      return false;
   }
   //Если поле email пустое выведем сообщение и предотвратим отправку формы
   if (y.length==0){
      document.getElementById("emailf").innerHTML="*данное поле обязательно для заполнения";
      return false;
   }
   //Проверим содержит ли значение введенное в поле email символы @ и .
   at=y.indexOf("@");
   dot=y.indexOf(".");
   //Если поле не содержит эти символы знач email введен не верно
   if (at<1 || dot <1){
      document.getElementById("emailf").innerHTML="*email введен не верно";
      return false;
   }
}
