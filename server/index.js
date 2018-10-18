var server = require("ws").Server;
var s = new server({port: 5001});

s.on("connection", function(ws){
   ws.on("message", function(message){
       
       message = JSON.parse(message);
       
       if(message.type == "name")
       {
           var res = message.data.split(",");
           ws.personName = res[0];
           ws.personImage = res[1];
           return;
       }
       
      console.log("Recieved: " + message);
      
      s.clients.forEach(function e(client) {
          if(client != ws)
          { 
              client.send(JSON.stringify({
                  name: ws.personName,
                  image: ws.personImage,
                  data: message.data
              }));
          } 
      });
      
      //ws.send("From Server: " + message);
   }); 
   ws.on("close", function(){
      console.log("I lost a client"); 
   });
});
