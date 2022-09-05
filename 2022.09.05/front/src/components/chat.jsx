import React, { useState } from "react";
import { useParams, useLocation, useMatch } from "react-router-dom";
import useChatRoom from "../hooks/useChatRoom";

const Chat = () => {
  const { roomId } = useParams();
  const { state } = useLocation();

  const { messages, sendMessage } = useChatRoom({
    roomId,
    name: state?.name || "anonymous",
  });

  const [message, setMessage] = useState("");

  const handleSendMessage = () => {
    if (message.length) {
      sendMessage(message);
      setMessage("");
    }
  };

  const messagesByDate = messages.reduce((acc, curr) => {
    const messageDate = new Date(curr.sentAt).toLocaleDateString();

    return {
      ...acc,
      [messageDate]: Array.isArray(acc[messageDate])
        ? [...acc[messageDate], curr]
        : [curr],
    };
  }, {});

  const messagesDates = Object.keys(messagesByDate)
    .map((key) => new Date(key))
    .sort((a, b) => (a > b ? 1 : -1))
    .map((d) => d.toLocaleDateString());

  return (
    <div className="chat">
      <div
        className="messages"
        style={{
          height: "80vh",
          overflowY: "auto",
        }}
      >
        {messagesDates.map((d) => {
          return (
            <div key={d}>
              <div className="day text-center my-3 text-warning fw-bold">
                {new Date(d).toLocaleDateString("en-il", {
                  weekday: "long",
                  day: "2-digit",
                  month: "2-digit",
                  year: "2-digit",
                })}
              </div>

              {messagesByDate[d].map((message) => {
                return (
                  <React.Fragment
                    key={String(message.sentAt) + message.senderId}
                  >
                    <div className="message">
                      <span className="text-warning fw-bold me-2">
                        {new Date(message.sentAt).toLocaleTimeString("en-il", {
                          timeStyle: "short",
                        })}
                      </span>
                      <span className="text-success fw-bold">
                        {message.name}
                      </span>
                      <p>{message.body}</p>
                    </div>
                  </React.Fragment>
                );
              })}
            </div>
          );
        })}
      </div>

      <div className="message-input mt-3">
        <div className="input-group">
          <input
            value={message}
            onChange={(e) => setMessage(e.target.value)}
            onKeyDown={(e) => {
              if (e.key === "Enter") {
                handleSendMessage();
              }
            }}
            type="text"
            className="form-control"
          />
          <button
            onClick={() => {
              handleSendMessage();
            }}
            className="btn btn-primary"
          >
            send
          </button>
        </div>
      </div>
    </div>
  );
};

export default Chat;
