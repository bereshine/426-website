var url_base = "http://wwwp.cs.unc.edu/Courses/comp426-f16/users/zengao/final/server-side/hub.php";
$(document).ready(function(){
    $('#register').on('click',
    function(e){
        e.preventDefault();
        $.ajax(url_base + "/user",
        {type: "POST",
        dataType:"json",
        data: $('form').serialize(),
        error: function(){
            alert('username already exists')
        }
        }
        )
    }
    );
}

)