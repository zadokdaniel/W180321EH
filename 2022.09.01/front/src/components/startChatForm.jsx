const StartChatForm = () => {
  return (
    <div className="rooms">
      <div className="mb-2">
        <label htmlFor="name">Name</label>
        <input
          type="text"
          id="name"
          className="form-control"
          placeholder="John Doe"
        />
      </div>
      <div>
        <label htmlFor="name">Room</label>
        <input
          type="text"
          id="name"
          className="form-control"
          placeholder="The Cat Lovers"
        />
      </div>

      <button className="btn btn-success btn-lg w-100 mt-3">
        Start Chatting
      </button>

      <div className="mt-5">
        <h3 className="display-5">or Choose an Existing Room</h3>
        <ul className="list-group mt-3">
          <li className="list-group-item">An item</li>
          <li className="list-group-item">A second item</li>
          <li className="list-group-item">A third item</li>
          <li className="list-group-item">A fourth item</li>
          <li className="list-group-item">And a fifth one</li>
        </ul>
      </div>
    </div>
  );
};

export default StartChatForm;
