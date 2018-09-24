var Person = function(user_json){
  this.name=user_json.name;
  this.status=user_json.status;
  this.messages=new Array();

  for (var message in user_json.messages){
  	tmp=new Message(user_json);
  	this.messages.push(tmp);

  }
}







//做friendlist ： friendname（clickable）    －－－－对话框
//                status

Person.prototype.makeDiv= function(){
     var cdiv = $("<div></div>");
     cdiv.addClass('friend_block');

     var friend_div=$("<div><div>");
     friend_div.addClass('person_name');
     friend_div.html(Person.name);
     cdiv.append(Person_name);

     var status_div=$("<div></div>");
     status_div.addClass('status');

     if(Person.status){
         status_div.html(Person.status.toString());
     }else{
         status_div.html("LAZY player without status");
     }
     cdiv.append(status_div);


     cdiv.data('friend_block',this);

     return cdiv;

}

Person.prototype.makeDia=function(){
      var box=$("<div></div>");
	  for (var message in Person.messages){
           var each_message=message.messageList();
           box.append(each_message);
	  }
      
	  var dia_form=$("<form></form>");
	  dia_form.addClass("dia_bar");
	  dia_form.append($("<input type='text' name='content'>"));
	  dia_form.append("<br>");
	  dia_form.append("<button type='submit'> Send </button><button type ='button' class='cancel'>Close</button>");
      dia_form.append('<input type="hidden" name="to" value='+this.name+'>');
      dia_form.append('<input type="hidden" name="from" value='+global_user.name+'>');
	  box.append(dia_form);


	 return box;

}



