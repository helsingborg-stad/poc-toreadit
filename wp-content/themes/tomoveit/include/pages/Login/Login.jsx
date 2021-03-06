import React, { useState, useEffect } from 'react';
import { useDispatch } from 'react-redux';
import Container from '../../components/Container/Container.jsx';
import Input from '../../components/Input/Input.jsx';
import Button from '../../components/Button/Button.jsx';
import BottomContainer from '../../components/Presentational/BottomContainer/BottomContainer.jsx';
import { useHistory } from 'react-router-dom';
import axios from 'axios';
import classNames from 'classnames/bind';
import styles from '../Login/Login.scss';
import {
  addActivities,
  runningActivity,
  setPin,
  setData,
  setTexts,
  setAdmin,
  addCompanyActivities,
} from '../../actions/app';

const style = classNames.bind(styles);

const Login = () => {
  const history = useHistory();
  const dispatch = useDispatch();

  const [pin, setPinCode] = useState('');
  const [logedIn, setLogedIn] = useState(false);
  const [errorText, setErrorText] = useState(false);
  const [errorWrongPin, setErrorWrongPin] = useState(false);

  const [awaitActivities, setAwaitActivities] = useState(false);
  const [awaitRunningActivities, setAwaitRunningActivities] = useState(false);
  const [awaitAuth, setAwaitAuth] = useState(false);
  const [loading, setLoading] = useState(false);

  const handleChange = (e) => {
    setPinCode(e.target.value);
  };

  useEffect(() => {
    dispatch(setData([]));
    axios.get('https://toreadit.hbgtest.se/wp-json/TomoveitRestApi/v1/getTexts')
      .then((response) => {
        dispatch(setTexts(response.data));
      }, (error) => {
        console.log(error);
      });
  }, []);

  useEffect(() => {
    if (awaitActivities && awaitRunningActivities && awaitAuth) {
      setLoading(false);
      history.push('/läsning');
    }
  }, [awaitActivities, awaitRunningActivities, awaitAuth]);

  useEffect(() => {
    if (logedIn) {
      dispatch(setPin(pin));
      axios.get('https://toreadit.hbgtest.se/wp-json/TomoveitRestApi/v1/getTexts')
        .then((response) => {
          dispatch(setTexts(response.data));
        }, (error) => {
          console.log(error);
        });
      axios.post('https://toreadit.hbgtest.se/wp-json/TomoveitRestApi/v1/activities', {
        pin: pin,
      },
      ).then((response) => {
        dispatch(addActivities(response.data));
        setAwaitActivities(true);
      }, (error) => {
        console.log(error);
      });

      axios.get('https://toreadit.hbgtest.se/wp-json/TomoveitRestApi/v1/companyActivities')
        .then((response) => {
          console.log(response);
          dispatch(addCompanyActivities(response.data));
        }, (error) => {
          console.log(error);
        });

      axios.post('https://toreadit.hbgtest.se/wp-json/TomoveitRestApi/v1/getRunningActivity', {
        pin: pin,
      },
      ).then((response) => {
        dispatch(runningActivity(response.data));
        setAwaitRunningActivities(true);
      }, (error) => {
        console.log(error);
      });
    }
  }, [logedIn]);

  const handleClick = (e) => {
    e.preventDefault();
    setLoading(true);
    axios.post('https://toreadit.hbgtest.se/wp-json/TomoveitRestApi/v1/login', {
      pin: pin,
    },
    ).then((response) => {
      if (response.data.admin) {
        dispatch(setAdmin(true));
      } else {
        dispatch(setAdmin(false));
      }

      if (response.data.error) {
        setErrorWrongPin(true);
        setLoading(false);
      } else {
        setLogedIn(true);
      }
      setAwaitAuth(true);
    }, (error) => {
      console.log(error);
    });
  };

  return (
    <div className={style('login')}>
      <Container>
        <h3>Skriv in din PIN-kod:</h3>
        {(errorText || errorWrongPin) && <div className={ style('login__error')}><h3>😩</h3><h3>{ errorWrongPin ? 'Fel pinkod.' : 'Nånting funkar inte just nu. Prova ladda om sidan.'}</h3></div>}
        <BottomContainer>
          <form onSubmit={handleClick} className={ style('login__form')}>
            <Input handleChange={handleChange} />
            <div className={style('login__buttons')}>
              <Button type='submit' loading={loading} to={'/welcome'} text={'LOGGA IN'}/>
              <Button loading={false} to={'/klass-statistik'} text={'GÅ TILL STATISTIK'}/>
            </div>
          </form>
        </BottomContainer>
      </Container>
    </div>
  );
};

export default Login;
