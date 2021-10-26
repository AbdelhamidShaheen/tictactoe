<html>

<head>
    <title>TICTACTOE</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <style>
    .cell {
        height: 100px;
    }

    h1 {
        text-align: center;
    }
    </style>


    <script>
    function handleFormCall(form, callback) {

        $(form).submit(function(e) {

            e.preventDefault();


            context = $(this);


            data = {};
            fields = $(this).serializeArray();
            $.each(fields, function(i, field) {
                data[field.name] = field.value;
            });


            $.ajax({
                type: context.attr("method"),
                url: context.attr("action"),
                data: data,
                success: function(data, status, jqXhr) {

                    callback(true, data);

                },
                error: function(jqXhr, textStatus, errorMessage) {

                    callback(false, errorMessage);

                },
                beforeSend: function() {
                    $('#wait').show();
                },
                complete: function() {
                    $('#wait').hide();
                }
            });

        });





    }
    </script>

</head>

<body>

    <h1 class="reuslt "></h1>
    <div class="container mt-5">


        <form method="post" action="/tictactoe/evaluate.php">

            <div class="row mt-3">
                <div class="col-sm">

                    <div class="cell border border-primary">
                        <input type="text" hidden name="cell1" />
                        <h1> </h1>
                    </div>
                </div>
                <div class="col-sm">

                    <div class="cell border border-primary">
                        <input type="text" hidden name="cell2" />
                        <h1></h1>
                    </div>
                </div>
                <div class="col-sm">

                    <div class="cell border border-primary">
                        <input type="text" hidden name="cell3" />
                        <h1></h1>
                    </div>
                </div>





            </div>
            <div class="row mt-3">
                <div class="col-sm">

                    <div class="cell border border-primary">
                        <input type="text" hidden name="cell4" />
                        <h1></h1>
                    </div>
                </div>
                <div class="col-sm">

                    <div class="cell border border-primary">
                        <input type="text" hidden name="cell5" />
                        <h1></h1>
                    </div>
                </div>
                <div class="col-sm">

                    <div class="cell border border-primary">
                        <input type="text" hidden name="cell6" />
                        <h1></h1>
                    </div>
                </div>





            </div>
            <div class="row mt-3">
                <div class="col-sm">

                    <div class="cell border border-primary">
                        <input type="text" hidden name="cell7" />
                        <h1></h1>
                    </div>
                </div>
                <div class="col-sm">

                    <div class="cell border border-primary">
                        <input type="text" hidden name="cell8" />
                        <h1></h1>
                    </div>
                </div>
                <div class="col-sm">

                    <div class="cell border border-primary">
                        <input type="text" hidden name="cell9" />
                        <h1></h1>
                    </div>
                </div>





            </div>



        </form>


    </div>


    <script>
    handleFormCall("form", function(success, data) {
         var next="[name="+data.next+"]";
         
        if (success) {
          switch(data.status){
          case 0 :
        
            $(next).parent().find("h1").text("o");
            $(next).val("o");

            break;
          case 1 :
           
            $(".reuslt").text("winner");
            Object.keys(data.winner).forEach(key => {
                var cell="[name="+key+"]";
           $(cell).parent().addClass("bg-success");
})
            
            break;  
          case 2 :
            $(next).parent().find("h1").text("o");
            $(next).val("o");
            $(".reuslt").text("loaser");
            Object.keys(data.winner).forEach(key => {
                var cell="[name="+key+"]";
           $(cell).parent().addClass("bg-success");
})

            

            break;  
          case 3 :
            
            $(".reuslt").text("draw");

            break;   
          }


        }
    });

    $(".cell").click(function() {
        if (!$(this).find("input").val()) {
            $(this).find("h1").text("x");
            $(this).find("input").val("x");
            $('form').trigger('submit');
        }
    });
    </script>




</body>

</html>
