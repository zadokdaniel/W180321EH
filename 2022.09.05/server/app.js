const express = require("express");
const http = require("http");
const socketIO = require("socket.io");

const app = express();
const server = http.createServer();
server.on("request", app);

const io = new socketIO.Server(server, {
  cors: { origin: "*" },
});

// app.use(require("morgan")("dev"));

io.on("connection", (socket) => {
  console.log("new connection");

  socket.on("disconnect", () => {
    console.log("disconnected");
  });
});

const PORT = 3005;
server.listen(PORT, () => console.log(`listening on port ${PORT}`));
