const Navigation = () => {
  return (
    <nav
      className="navbar navbar-expand-sm navbar-light bg-primary shadow-lg"
      aria-label="Third navbar example"
    >
      <div className="container">
        <a className="navbar-brand" href="/">
          Chat WiTh US
        </a>
        <button
          className="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarsExample03"
          aria-controls="navbarsExample03"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span className="navbar-toggler-icon"></span>
        </button>

        <div className="ms-auto">
          <div className="collapse navbar-collapse" id="navbarsExample03">
            <form role="search">
              <input
                className="form-control"
                type="search"
                placeholder="Search"
                aria-label="Search"
              />
            </form>
          </div>
        </div>
      </div>
    </nav>
  );
};

export default Navigation;
