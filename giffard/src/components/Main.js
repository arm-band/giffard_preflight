import React from 'react';
import { Container, Box, TextField, Button, Switch, FormLabel } from '@material-ui/core';
import { makeStyles, createStyles } from '@material-ui/core/styles';
import axios from 'axios';

const useStyles = makeStyles(createStyles({
    textfield: {
        width: '100%'
    },
    tfWrapper: {
        paddingTop: '3rem'
    },
    buttonWrapper: {
        display: 'flex',
        justifyContent: 'space-evenly',
        alignItems: 'center',
        padding: '3rem 0'
    },
    results: {
        width: '100%',
        height: '20rem',
        resize: 'vertical',
        overflowY: 'scroll'
    }
}));

function escHtml (string) {
    if(typeof string !== 'string') {
        return string;
    }
    return string.replace(/[&'`"<>]/g, function(match) {
        return {
            '&': '&amp;',
            "'": '&#x27;',
            '`': '&#x60;',
            '"': '&quot;',
            '<': '&lt;',
            '>': '&gt;',
        }[match]
    });
}

function Main(props) {
    const classes = useStyles();
    //state, switch
    const [state, setState] = React.useState({
        ACAO: true, //Access-Control-Allow-Origin
        ACAH: true, //Access-Control-Allow-Headers
        ACAM: true, //Access-Control-Allow-Methods
    });
    //switch change
    const handleChange = (event) => {
        setState({ ...state, [event.target.name]: event.target.checked });
    };
    const handleSubmit = (e) => {
        //simpleRequest
        const resultId = '#testFlightResult';
        e.preventDefault();
        axios({
            method: 'GET',
            url: `${props.props.origin.protocol}://${props.props.origin.hostname}:${props.props.origin.port}${props.props.origin.path}`
        }).then((response) => {
            console.log(response);
            if (String(document.querySelector(resultId).value).length === 0) {
                document.querySelector(resultId).value = JSON.stringify(response.data);
            }
            else {
            document.querySelector(resultId).value = `${document.querySelector(resultId).value}

${JSON.stringify(response.data)}`;
            }
        }).catch((error) => {
            console.log(error);
            if (String(document.querySelector(resultId).value).length === 0) {
                document.querySelector(resultId).value = JSON.stringify(error);
            }
            else {
            document.querySelector(resultId).value = `${document.querySelector(resultId).value}

${JSON.stringify(error)}`;
            }
        });
    };
    const handleSubmit2 = (e) => {
        //preflightRequest
        const inputId = '#testFlight';
        const resultId = '#testFlightResult2';
        e.preventDefault();
        console.log(state)
        const postData = {
            testFlight: escHtml(document.querySelector(inputId).value),
            ACAO: state.ACAO,
            ACAH: state.ACAH,
            ACAM: state.ACAM
        };
        console.log(postData);
        axios({
            method: 'POST',
            url: `${props.props.origin.protocol}://${props.props.origin.hostname}:${props.props.origin.port}${props.props.origin.path2}`,
            data: postData
        }).then((response) => {
            console.log(response);
            if (String(document.querySelector(resultId).value).length === 0) {
                document.querySelector(resultId).value = JSON.stringify(response.data);
            }
            else {
            document.querySelector(resultId).value = `${document.querySelector(resultId).value}

${JSON.stringify(response.data)}`;
            }
        }).catch((error) => {
            console.log(error);
            if (String(document.querySelector(resultId).value).length === 0) {
                document.querySelector(resultId).value = JSON.stringify(error);
            }
            else {
            document.querySelector(resultId).value = `${document.querySelector(resultId).value}

${JSON.stringify(error)}`;
            }
        });
    };

  return (
    <main className="main">
        <form onSubmit={handleSubmit}>
            <Container maxWidth="md" className={classes.buttonWrapper}>
                <Box>
                    <Button
                        type="submit"
                        variant="contained"
                        color="secondary"
                    >
                        simple request
                    </Button>
                </Box>
            </Container>
        </form>
        <Container maxWidth="md" className={classes.resultsWrapper}>
            <Box>
                <textarea
                    className={classes.results}
                    id="testFlightResult"
                    placeholder="results..."
                />
            </Box>
        </Container>
        <form onSubmit={handleSubmit2}>
            <Container maxWidth="md" className={classes.tfWrapper}>
                <Box>
                    <TextField
                        id="testFlight"
                        label="Test flight"
                        className={classes.textfield}
                        defaultValue={props.props.testflight}
                    />
                </Box>
            </Container>
            <Container maxWidth="md" className={classes.tfWrapper}>
                <Box>
                    <FormLabel component="legend">Access-Control-Allow-Origin</FormLabel>
                    <Switch
                        checked={state.ACAO}
                        onChange={handleChange}
                        name="ACAO"
                        inputProps={{ 'aria-label': 'Access-Control-Allow-Origin' }}
                    />
                </Box>
                <Box>
                    <FormLabel component="legend">Access-Control-Allow-Headers</FormLabel>
                    <Switch
                        checked={state.ACAH}
                        onChange={handleChange}
                        name="ACAH"
                        inputProps={{ 'aria-label': 'Access-Control-Allow-Headers' }}
                    />
                </Box>
                <Box>
                    <FormLabel component="legend">Access-Control-Allow-Methods</FormLabel>
                    <Switch
                        checked={state.ACAM}
                        onChange={handleChange}
                        name="ACAM"
                        inputProps={{ 'aria-label': 'Access-Control-Allow-Methods' }}
                    />
                </Box>
            </Container>
            <Container maxWidth="md" className={classes.buttonWrapper}>
                <Box>
                    <Button
                        type="submit"
                        variant="contained"
                        color="primary"
                    >
                        with preflight request
                    </Button>
                </Box>
            </Container>
        </form>
        <Container maxWidth="md" className={classes.resultsWrapper}>
            <Box>
                <textarea
                    className={classes.results}
                    id="testFlightResult2"
                    placeholder="results..."
                />
            </Box>
        </Container>
    </main>
  );
}

export default Main;
