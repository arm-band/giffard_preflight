import React from 'react';
import { AppBar, Toolbar, Typography } from '@material-ui/core';

function Navbar(props) {
  return (
    <header className="header">
        <AppBar position="static">
            <Toolbar>
                <Typography variant="h6">
                    {props.props.sitename}
                </Typography>
            </Toolbar>
        </AppBar>
    </header>
  );
}

export default Navbar;
