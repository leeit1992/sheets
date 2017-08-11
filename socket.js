var socketIO = require('socket.io'),
http = require('http'),
port = process.env.PORT || 8080;
ip = process.env.IP || '127.0.0.1',
server = http.createServer().listen(port,ip,function(){
	console.log('start socket');
}),
io = socketIO.listen(server);

io.set('origins','*:*');

var run = function(socket)
{
	// user-ha nhan event tu admin roi gui toi client
	socket.on('notice-inbox',function(data){
		socket.broadcast.emit('user-' + data, data);
	});
}
io.on('connection', run);
