import { useFormik } from "formik";
import * as Yup from "yup";
import { useNavigate } from "react-router-dom";

const ChatRooms = () => {
  const navigate = useNavigate();

  const form = useFormik({
    validateOnMount: true,
    initialValues: {
      name: "",
      room: "",
    },
    validationSchema: Yup.object({
      name: Yup.string()
        .min(2)
        .max(20)
        .matches(/^[\w ]+$/)
        .required(),
      room: Yup.string()
        .min(5)
        .max(50)
        .matches(/^[\w ]+$/)
        .required(),
    }),
    onSubmit(values) {
      navigate(`/${values.room}`, {
        state: {
          name: values.name,
        },
      });
    },
  });

  return (
    <div className="rooms">
      <form onSubmit={form.handleSubmit}>
        <div className="mb-2">
          <label htmlFor="name">Name</label>
          <input
            type="text"
            id="name"
            className="form-control"
            placeholder="John Doe"
            {...form.getFieldProps("name")}
          />
          <span className="text-danger">
            {form.touched.name && form.errors.name}
          </span>
        </div>
        <div>
          <label htmlFor="room">Room</label>
          <input
            type="text"
            id="room"
            className="form-control"
            placeholder="The Cat Lovers"
            {...form.getFieldProps("room")}
          />
          <span className="text-danger">
            {form.touched.room && form.errors.room}
          </span>
        </div>

        <button
          disabled={!form.isValid}
          type="submit"
          className="btn btn-success btn-lg w-100 mt-3"
        >
          Start Chatting
        </button>
      </form>

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

export default ChatRooms;
