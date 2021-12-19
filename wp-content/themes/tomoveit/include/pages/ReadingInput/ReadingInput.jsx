import React, { useEffect, useState } from 'react';
import classNames from 'classnames/bind';
import styles from './ReadingInput.scss';

import Button from '../../components/Button/Button.jsx';

import { useSelector } from 'react-redux';
import Container from '../../components/Container/Container.jsx';
import axios from 'axios';
import { useHistory } from 'react-router-dom';

const style = classNames.bind(styles);

const ReadingInput = () => {
  const history = useHistory();

  const [pages, setPages] = useState('');
  const [goal6A, setGoal6A] = useState(0);
  const [goal6B, setGoal6B] = useState(0);
  const [goal6C, setGoal6C] = useState(0);

  const texts = useSelector(state => state.app.texts);
  const admin = useSelector(state => state.app.admin);
  const pin = useSelector(state => state.app.pin);

  useEffect(() => {
    axios.post('https://toreadit.hbgtest.se/wp-json/TomoveitRestApi/v1/reading-check', {
      pin: pin,
    },
    ).then((response) => {
      if (response.data && !admin) {
        history.push('/activities');
      }
    }, (error) => {
      console.log(error);
    });

    if (admin) {
      axios.get('https://toreadit.hbgtest.se/wp-json/TomoveitRestApi/v1/goals',
      ).then((response) => {
        setGoal6A(response.data[0].goal);
        setGoal6B(response.data[1].goal);
        setGoal6C(response.data[2].goal);
      }, (error) => {
        console.log(error);
      });
    }
  }, []);

  useEffect(() => {
    // Check if
  }, [pages]);

  const handleClick = (e) => {
    e.preventDefault();
    axios.post('https://toreadit.hbgtest.se/wp-json/TomoveitRestApi/v1/reading', {
      pin: pin,
      pages: pages,
    },
    ).then((response) => {
      history.push('/activities');
    }, (error) => {
      console.log(error);
    });
  };

  const handleOnChange = (e) => {
    setPages(e.target.value);
  };

  const saveGoals = (e) => {
    e.preventDefault();
    axios.post('https://toreadit.hbgtest.se/wp-json/TomoveitRestApi/v1/update/goals', { data: [
      { school_class: '6A', pages: goal6A },
      { school_class: '6B', pages: goal6B },
      { school_class: '6C', pages: goal6C },
    ],
    }
    ).then((response) => {
      history.push('/activities');
    }, (error) => {
      console.log(error);
    });
  };

  return (
    <div className={style('reading-input')}>
      <Container>
        { !admin &&
          <div className={style('reading-input__content')}>
            <h2>Registrera antal sidor!</h2>
            <input className={style('reading-input__input')} type='number' onChange={handleOnChange} />
            <Button loading={false} to={'/activities'} text={'Gå vidare'} handleClick={handleClick}/>
          </div>
        }
        { admin &&
          <div>
            <h2>Registrera mål för klass 6A</h2>
            <input className={style('reading-input__input')} type='number' value={goal6A} onChange={(e) => setGoal6A(e.target.value)}/>
            <h2>Registrera mål för klass 6B</h2>
            <input className={style('reading-input__input')} type='number' value={goal6B} onChange={(e) => setGoal6B(e.target.value)}/>
            <h2>Registrera mål för klass 6C</h2>
            <input className={style('reading-input__input')} type='number' value={goal6C} onChange={(e) => setGoal6C(e.target.value)}/>
            <div className={style('reading-input__admin-buttons')}>
              <Button loading={false} to={'/activities'} text={'Gå vidare'}/>
              <Button loading={false} to={'/activities'} text={'Spara'} handleClick={saveGoals}/>
            </div>
          </div>
        }
      </Container>
    </div>
  );
};

export default ReadingInput;
