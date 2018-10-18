$(document).ready(function(){
    

var name;
var now = new Date(Date.now());
var minutes = now.getMinutes();
if (minutes < 10) {
    minutes = "0" + minutes;
}
var formatted = now.getHours() + ":" + minutes;
var image; 

$.ajax({
    url: 'getChatDetails.php',
    type: 'POST', 
 
    success: function (data)
    {
        name = data;
    },
    error: function ()
    {
        dataType: 'text';
    }
});


$.ajax({
    url: 'getChatDetailsImage.php',
    type: 'POST', 
 
    success: function (data)
    {
        image = data;
    },
    error: function ()
    {
        dataType: 'text';
    }
});



var sock = new WebSocket("ws://localhost:5001");

var log = document.getElementById("log");

sock.onmessage = function (event)
{

    console.log(event);
    var json = JSON.parse(event.data);
    console.log("json.name:");
    
    log.innerHTML += '<div class="chat-message clearfix" ><img src="' + json.image + '" alt="" width="32" height="32"><div class="chat-message-content clearfix"><span class="chat-time">' + formatted + '</span><h5>' + json.name + '</h5><p>' + json.data + '</p></div></div><hr>';

};

$("#chatBoxText").click(function(){
    $("#chatBoxText").val("");
});
document.querySelector("#chatBoxButton").onclick = function ()
{
    var text = document.getElementById("chatBoxText").value;
//              sock.send(text);

    sock.send(JSON.stringify({
        type: "name",
        data: name + "," + image
    }));
    
    sock.send(JSON.stringify({
        type: "message",
        data: text
    })); 
    log.innerHTML += '<div class="chat-message clearfix" ><span class="chat-time">' + formatted + '</span><img src="' + image + '" alt="" width="32" height="32"><div class="chat-message-content clearfix"><h5>You: </h5><p>' + text + '</p></div></div><hr>';
$("#chatBoxText").val("");
};
});