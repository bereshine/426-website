var User = function(user_json){

	this.name=user_json.name;
	this.status=user_json.status;
	
	this.friend_list=new Array();

//    for (var friend in user_json.friends){
//    	tmp=new Person(friend);
//    	this.friend_list.push(tmp);
//    }
     
    this.activity_list=new Array();

    for (var activity in user_json.activities){
     tmp = new Activity(user_json);
     this.activity_list.push(tmp);
    }

}