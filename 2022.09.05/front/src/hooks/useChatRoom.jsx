import socketIOClient from "socket.io-client";
import { useEffect, useState, useRef } from "react";

const SOCKET_SERVER = "ws://localhost:3005";

const useChatRoom = ({ roomId, name }) => {
  const [messages, setMessages] = useState([]);
  const socketRef = useRef();

  useEffect(() => {
    socketRef.current = socketIOClient(SOCKET_SERVER, {
      query: { roomId, name },
    });

    socketRef.current.on("old_messages", (oldMessages) => {
      setMessages((messages) => [...oldMessages, ...messages]);
    });

    socketRef.current.on("new_chat_message", (message) => {
      setMessages((messages) => [...messages, message]);
    });

    return () => {
      socketRef.current.disconnect();
    };
  }, [roomId, name]);

  const sendMessage = (message) => {
    socketRef.current.emit("new_chat_message", {
      body: message,
      name,
      sentAt: Date.now(),
      senderId: socketRef.current.id,
    });
  };

  return { messages, sendMessage };
};
export default useChatRoom;
