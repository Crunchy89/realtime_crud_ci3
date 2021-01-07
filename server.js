var socket = require("socket.io");
var express = require("express");
var app = express();
var server = require("http").createServer(app);
var io = socket.listen(server);
var port = process.env.PORT || 3000;

server.listen(port, function () {
  console.log("Server listening at port %d", port);
});

io.on("connection", function (socket) {
  socket.on("role", (data) => {
    io.sockets.emit("role", {
      status: data.status,
      pesan: data.pesan,
      data: data.data,
    });
  });
});
