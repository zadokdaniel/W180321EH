const express = require("express");
const http = require("http");
const socketIO = require("socket.io");

const server = http.createServer();
const io = new socketIO.Server(server, {
  cors: { origin: "*" },
});
const app = express();
app.use(require("morgan")("dev"));

server.on("request", app);

io.on("connection", (socket) => {
  console.log("new connection");

  socket.on("disconnect", () => {
    console.log("disconnected");
  });
});

const PORT = 3005;
server.listen(PORT, () => console.log(`listening on port ${PORT}`));
