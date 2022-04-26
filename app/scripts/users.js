init();

function init() {
    getData();
}

function getData() {
    $.ajax({
        url: 'http://localhost:8080/api/users',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            console.log(data);
            displayData(data);
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function ObtainUserById(userId) {
  parametros ={
    "userId": userId
  }
  $.ajax({
      data:parametros,
      url:'controllers/UsersController.php?op=ObtainUserById',
      type:'POST',
      beforeSend: function(){},
      success:function(response) {
        console.log(response);
      }
  });
}