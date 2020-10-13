import React from 'react';
import './App.css';
import { ThemeProvider, createMuiTheme, makeStyles, createStyles, Theme } from '@material-ui/core/styles';
import { amber, orange } from "@material-ui/core/colors";
import Navbar from './components/Navbar';
import Main from './components/Main';
import Footer from './components/Footer';

const theme = createMuiTheme({
    palette: {
        primary: {
            main: orange[500]
        },
        secondary: {
            main: amber[500]
        }
    },
    typography: {
        button: {
            textTransform: "none"
        }
    }
});

const useStyles = makeStyles((Theme) => createStyles({
    root: {
        backgroundColor: '#fff'
    },
}));

function App() {
    const classes = useStyles();
    const commonParams = {
        sitename: 'Giffard',
        author: 'アルム＝バンド',
        year: 2020,
        origin: {
            protocol: 'http',
            hostname: 'localhost',
            port: 8999,
            path: '/icanfly/plain',
            path2: '/icanfly/api'
        },
        testflight: 'Baptiste Jacques Henri Giffard'
    };

    return (
        <div className={classes.root}>
            <ThemeProvider theme={theme}>
                <Navbar props={commonParams} />
                <Main props={commonParams} />
                <Footer props={commonParams} />
            </ThemeProvider>
        </div>
    );
}

export default App;
