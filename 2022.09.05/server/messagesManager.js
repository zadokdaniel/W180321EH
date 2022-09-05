const messages = {
  about: [
    {
      body: "dsafsdaf",
      name: "anonymous",
      senderId: "gx1WlvDQb0due6dXAAAG",
      sentAt: 1662474492000,
    },
    {
      body: "dsafsdaf",
      name: "anonymous",
      senderId: "gx1WlvsQb0due6dXAAAG",
      sentAt: 1662474492000,
    },
    {
      body: "dsafsdaf",
      name: "anonymous",
      senderId: "gx1WlvgQb0due6dXAAAG",
      sentAt: 1665066492000,
    },
    {
      body: "dsafsdaf",
      name: "anonymous",
      senderId: "gx1Wlvsdb0due6dXAAAG",
      sentAt: 1665066492000,
    },
    {
      body: "dsafsdaf",
      name: "anonymous",
      senderId: "gx1WlvDQassue6dXAAAG",
      sentAt: 1665066492000,
    },
    {
      body: "dsafsdaf",
      name: "anonymous",
      senderId: "gx1WlvDQddue6dXAAAG",
      sentAt: 1665066492000,
    },
    {
      body: "dsafsdaf",
      name: "anonymous",
      senderId: "gx1WlvDQbdsdue6dXAAAG",
      sentAt: 1633530492000,
    },
    {
      body: "dsafsdaf",
      name: "anonymous",
      senderId: "gx1Wsdue6dXAAAG",
      sentAt: 1633530492000,
    },
    {
      body: "dsafsdaf",
      name: "anonymous",
      senderId: "gx1WlvDd0due6dXAAAG",
      sentAt: 1633530492000,
    },
    {
      body: "dsafsdaf",
      name: "anonymous",
      senderId: "gx1WlvDgue6dXAAAG",
      sentAt: 1662398977000,
    },
    {
      body: "dsafsdaf",
      name: "anonymous",
      senderId: "sdfsb0due6dXAAAG",
      sentAt: 1662398977000,
    },
    {
      body: "dsafsdaf",
      name: "anonymous",
      senderId: "gx1WlvDdsf0due6dXAAAG",
      sentAt: 1662398977000,
    },
    {
      body: "dsafsdaf",
      name: "anonymous",
      senderId: "gx1Wlvdsfasd0due6dXAAAG",
      sentAt: 1662398977000,
    },
  ],
};

const addMessage = (room, message) => {
  if (Array.isArray(messages[room])) {
    messages[room].push(message);
    return;
  }

  messages[room] = [message];
};

const getRoomMessages = (room) => {
  return messages[room] || [];
};

module.exports = {
  addMessage,
  getRoomMessages,
};
