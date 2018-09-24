var Message = function(user_json){
   this.from=user_json.from;
   this.to=user_json.to;
   this.content=user_json.content;
   this.time=user_json.time;
}

Message.prototype.messageList=function(){

	var message_p=$("<p></p>");
	if(Message.from==global_user){
		message_p.addClass('me');
	}else{
		message_p.addClass('other');
	}
    message_p.append(Message.time);
	message_p.html(Message.content);

	return message_p; 
}