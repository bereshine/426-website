var url_base = "http://wwwp.cs.unc.edu/Courses/comp426-f16/users/zengao/final/server-side";

$(document).ready(function(){
	var global_user;

	$('#login_form').on('submit',function(e){
	e.preventDefault();
	$.ajax(url_base+'/login.php',
	{type:"GET",
	data:$("#login_form").serialize(),
	dataType:"json",
	success: function(user_json, status, jqXHR){
		global_user=new User(user_json);
		alert(global_user.name);
        var user_friends=global_user.friends;
                   for (var each_friend in user_friends){

                      $('#friend_list').append(each_friend.makeDiv());
                    }

		}
	})
})
      //build friend list

       // $.ajax(url_base + "/hub.php",
       //   		{type: "GET",
       //   		data: $('#registerform').serialize(),
       //           dataType: "json",
       //       	 success: function(user_json,status, jqXHR ){
       //       	 	global_user=new User(user_json);
       //       	 	var user_friends=user.friends;
       //       	 	for (var each_friend in user_friends){

       //       	 		$('#friend_list').append(each_friend.makeDiv());
       //       	 	}
       //       	 } 
                 
                 


       //                 })

      //add friend
       $('#add_form').on('submit',
       	                  '.friend_block',
       	                 function(e){
       	                 	e.preventDefault();
       	                 	$.ajax(url_base+"/hub.php",
                               {type: "POST",
                                dataType:"json",
                                data: $(this).serialize(),
                                success: function(json,status,jqXHR){
                                	//if json friend not added
                                        if(json.flag==false){
                                            alert('friend not found');
                                        }else{
                                	var new_friend=new Person(json);
                                	$('#friend_list').append(new_friend.makeDiv());
                                    global_user.friend_list.push(Person);}
                                }})
       	                })

     // build dialogue box
      $('.friend_block').on('click',
      	                  function(e){
                         $('.dialogue_box').empty();
      	                 var current_chating=$('.friend_block').data('friend_block');
                        
      	                 $('.dialogue_box').append(current_chating.makeDia());
                         }
      	                 )
      	                     

     // update dialogue box while sending out message

      $('.dialogue_box').on('submit',
      					function(e){
      						e.preventDefault();
      						$ajax(url_base+"/hub.php",
      							{type: "POST",
      							dataType: "json",
      							data: $(this).serialize(),
      							success: function (json,status,jqXHR){
                                    var sent = new Message(jason);
                                    for (var person_sent in global_user.friends){
                                    	if(sent.to==person_sent.name){
                                                //update database
                                               person_sent.messages.push(sent);

                                    	}
                                    }
                                    //update dialogue box
                                   
                                    $('.content').append(sent.messageList());

      							}
      					
      					})
})


})
