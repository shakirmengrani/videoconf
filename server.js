// Load required modules
var http    = require("http");              // http server core module
var express = require("express");           // web framework external module
var io      = require("socket.io");         // web socket external module
var easyrtc = require("easyrtc");           // EasyRTC external module
var path = require("path");
var index = require("./routes/index");

var app = express();

var config = {
	PORT: 8080,
	view_engine: "ejs",
	path: {
		view: './views',
		staticPath: './public'
	},
	status:{
		__404:404
	}
};

app.set('views', path.join(__dirname, config.path.view));
app.set('view engine', 'ejs');
app.use(express.static(path.join(__dirname, config.path.staticPath)));

app.use('/',index);

app.use(function(req,res,next){
	var err = new Error("Page Not Found !");
	res.sendStatus(config.status.__404).send(err);
	next(err);
});

// Start Express http server on port 8080
var webServer = http.createServer(app).listen(config.PORT);

// Start Socket.io so it attaches itself to Express server
var socketServer = io.listen(webServer,{});

// Start EasyRTC server
var rtc = easyrtc.listen(app, socketServer);
