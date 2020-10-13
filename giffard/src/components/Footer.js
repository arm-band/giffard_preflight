import React from 'react';

function Footer(props) {

  return (
    <footer className="footer">
        <small className="copyRight">
            © {props.props.year} {props.props.author}
        </small>
    </footer>
  );
}

export default Footer;
