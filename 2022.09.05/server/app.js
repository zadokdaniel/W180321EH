const express = require("express");
const http = require("http");
const socketIO = require("socket.io");
const { addMessage, getRoomMessages } = require("./messagesManager");

const app = express();
const server = http.createServer(app);

const io = new socketIO.Server(server, {
  cors: { origin: "*" },
});

app.use(require("morgan")("dev"));

io.on("connection", (socket) => {
  console.log("new connection");

  const { roomId, name } = socket.handshake.query;
  socket.join(roomId);

  socket.emit("old_messages", getRoomMessages(roomId));

  socket.on("new_chat_message", (message) => {
    addMessage(roomId, message);

    io.to(roomId).emit("new_chat_message", message);
  });

  socket.on("disconnect", () => {
    console.log("disconnected");
    socket.leave(roomId);
  });
});

const PORT = 3005;
server.listen(PORT, () => console.log(`listening on port ${PORT}`));
