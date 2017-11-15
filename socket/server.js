var app = require('express')();
var https = require('http').createServer(app);
console.log(https);



var io = require('socket.io')(https);
app.get('/', function(req, res){
    res.send('<h1>Hello world</h1>');
});
io.on('connection', function(socket){
    console.log('a user connected');
    socket.on('disconnect', function(){
        console.log('user disconnected');
    });
    socket.on('login', function(login){
        io.emit('login_search_page',{login: login});
    });
    socket.on('order', function(order){
        console.log('i am here');
        if(order.merchant_id)
         io.emit('order-'+order.merchant_id, order);
    });
});

https.listen(8080, function(){
    console.log('listening on *:8080');
});