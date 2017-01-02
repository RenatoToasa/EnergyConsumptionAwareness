<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Send Notification</title>
   <!-- Bootstrap core CSS -->
   <link href="bootstrap-3.3.5/css/bootstrap.min.css" rel="stylesheet">
   <link href="css/signin.css" rel="stylesheet">
  </head>
<body id="page-top" class="index">

<script src="js/jquery-1.11.3.min.js"></script>
<script src="https://www.gstatic.com/firebasejs/3.6.2/firebase.js"></script>
<script>
  // Initialize Firebase
  var config = {
    apiKey: "AIzaSyBocdknSXC5zGueLYWKG0-7OM5eIEMYWQY",
    authDomain: "energyconsumptionawarene-b1efa.firebaseapp.com",
    databaseURL: "https://energyconsumptionawarene-b1efa.firebaseio.com",
    storageBucket: "energyconsumptionawarene-b1efa.appspot.com",
    messagingSenderId: "237430741070"
  }

  firebase.initializeApp(config);
</script>

<!--Seccion Iniciar-->
<section  id="section1" > 
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <h2 class="form-signin-heading">Notificaciones</h2>
        <div class="line"></div>
      </div>
    </div>
    <div class='entrada'>
    <p id="demo">Message State</p>
    </div>
      <input id="id_person" class="form-control" placeholder="insert person id here.. " autofocus>
      <input id="title" class="form-control" placeholder="insert Title here " autofocus>
      <input id="message" class="form-control" placeholder="insert Message here " autofocus>
      <input id="id_language" class="form-control" placeholder="insert id Language here " autofocus>
      <input id="id_question" class="form-control" placeholder="insert id Question here " autofocus>
      <input id="id_question_option" class="form-control" placeholder="insert id Question Option here " autofocus>
      <button  onclick="EnviarNot()" class="btn btn-lg btn-primary btn-block">Enviar</button>
    </div> 
</section>

<script>
function EnviarNot(){

  document.getElementById("demo").innerHTML = "searching in data base..";
    $.ajax({
        url: encodeURI('WebService/php/usuario_consultar-NOT.php'),
        type: 'POST',
        data: {
         "id_person":document.getElementById("id_person").value,
         "id_language":document.getElementById("id_language").value,
         "id_question":document.getElementById("id_question").value,
         "id_question_option":document.getElementById("id_question_option").value,
         "advice":document.getElementById("message").value
        },
        success: function (data) {
        var obj = JSON && JSON.parse(data) || $.parseJSON(data);
        console.log(data)
        if (obj["token"]==undefined) {
          //console.log(obj);
            document.getElementById("demo").innerHTML = "Not found records..";
        } else {
                document.getElementById("demo").innerHTML = "user exists!!!";
                var titulo = document.getElementById("title").value;
                var notification = document.getElementById("message").value;
                var token = obj["token"];
                document.getElementById("demo").innerHTML = "sending..";
                    $.ajax({
                            url: encodeURI('https://fcm.googleapis.com/fcm/send'),
                            type: 'POST',
                           //contentType: "application/json",
                            data: {
                              "vibrate" : "1",
                              "sound" : "1",
                              "to" : token,
                              "priority" : "high",
                              "notification": {
                                      "title": titulo,
                                      "body": notification,
                                      "text": notification
                              }, "data": {
                                      "title": titulo,
                                      "body": notification,
                                      "text": notification
                              }
                            },
                            beforeSend: function (xhr) {
                            xhr.setRequestHeader ("Authorization","key=AIzaSyBocdknSXC5zGueLYWKG0-7OM5eIEMYWQY");
                            },
                            success: function (data) {document.getElementById("demo").innerHTML = "notification sended";},
                            error: function (data) {document.getElementById("demo").innerHTML = "error to send notification";
                                                    console.log(data)}
                          });
                }
            },
        error: function (data) {document.getElementById("demo").innerHTML = "Error with the data base consult...";
                                console.log(data);}
     });

  
}

</script>

</body>
</html>
