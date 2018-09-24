//'#calendar_view' for grid
//'activity_view' for a div that exhibits all the activities that is happening during that time

var Activity = function(user_json){
   this.id=user_json.id;
   this.holder=user_json.holder;
   //need to make time a javascript Date object
   this.time=new Date(user_json.time);
   this.description=user_json.description;
   this.participant_list=new Array();
   for(var part in user_json.participant){
     this.participant_list.push(part);
   }
    
}

//return a string <div></div>
Activity.prototype.make_div = function(){
  var tmp_holder = this.holder;
  var tmp_time = this.time;
  var tmp_description = this.description;
  var tmp_participant_list = this.participant_list;
  var tmp_str = '<div>';
  tmp_str += '<p> Holder:'+tmp_holder+'</p>';
  tmp_str += '<p>'+tmp_time.toLocaleDateString()+'</p>';
  tmp_str += '<p>'+tmp_description+'</p>';
  tmp_str += '<p> Participants:';
  tmp_participant_list.forEach(
    function($tmp_participant){
      tmp_str+='<p>' + tmp_participant + '</p>';
    }
  );
  tmp_str+='</p>';
  return tmp_str;
}

//need today's Date -- curr_time
var mili_sec_day = 24*3600*1000;
var original_calendar_str = "";
var curr_time = new Date();

//create the inital calendar view
for(i=0;i<=4;i++){
  original_calendar_str +='<tr id = "'+i+'">';
  for(j=0;j<=23;j++){
    original_calendar_str += '<td class = "empty" id = "'+i+','+j+'"> </td>';
  }
  original_calendar_str += '</tr>';
}

//$("#calendar_view").append(original_calendar_str)
//given a list of Activity objects, create a string of the calendar

var make_calendar = function(activity_list){
  var calendar_string = "";
  //add each activity into the calendar
  activity_list.forEach(
    function(activity){
      var start_time = activity.start_time;
      var end_time = activity.end_time;
      var days_from_today = (activity.time - curr_time)/mili_sec_day;
      if(activity.holder == global_user.name){
        for(i = start_time; i<=end_time;i++){
          var td_id = '#'+days_from_today+','+i;
          $(td_id).addClass('me');
          $(td_id).data("activities").push(activity);
        }
      }
      else{
        for(i = start_time; i<=end_time;i++){
          var td_id = '#'+days_from_today+','+i;
          $(td_id).addClass('other');
          $(td_id).data("activities").push(activity);
        }
      }
    })
    //combine each td with its related activity
    $('#calendar_view').on('click','td',function(){
      var td_activities = $.data("activities").data();
      var activities_str = "";
      td_activities.forEach(
        function(td_activity){
          activities_str += td_activity.make_div();
        }
      )
      $('#activity_view').html(activities_str);
    })
}

var customize_calendar = function(){
  $('#calendar_view').empty();
  $('#activity_view').empty();
  $('#calendar_view').append('<div id="customize_calendar_view"></div>');
  var customize_calendar_str = "";
  for(i=0;i<=4;i++){
    customize_calendar_str +='<tr id = "'+i+'">';
    for(j=0;j<=23;j++){
      customize_calendar_str += '<td class = "empty" id = "'+i+','+j+'"> </td>';
    }
    customize_calendar_str += '</tr>';
  }
  $('#customize_alendar_view').html(customize_calendar_str);
  $('#customize_activity_form').append('Description:<br>'
  +'<input id="activity_description" type="text"> <br>'+
  '<button type="submit">Game Together!</button>');
  var time_slots = [];
  var customize_activity_date;
  var description;
  $('#calendar_view td').on('click','td',function(){
    var date_diff = ($(this).attr('id').split(','))[0];
    customize_activity_date = Date.setDate(curr_time.getDate()+date_diff);
    time_slots.push(date_diff[1]);
    var start_time = Math.min(time_slots);
    var end_time = Math.max(time_slots);
    $("#customize_activity_form").append('<input type="hidden" name="start_time" value='+start_time+'>');
    $("#customize_activity_form").append('<input type="hidden" name="end_time" value='+end_time+'>');
    $("#customize_activity_form").append('<input type="hidden" name="time" value='+customize_activity_date.toLocaleDateString()+'>');
  })
  $("#customize_activity_form").append('<input type="hidden" name="holder" value='+$global_user.name+'>');
}