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

  const texts = useSelector(state => state.app.texts);
  const admin = useSelector(state => state.app.admin);
  const pin = useSelector(state => state.app.pin);

  useEffect(() => {
    axios.post('https://toreadit.test/wp-json/TomoveitRestApi/v1/reading-check', {
      pin: pin,
    },
    ).then((response) => {
      if (response.data) {
        history.push('/activities');
      }
    }, (error) => {
      console.log(error);
    });
  }, []);

  useEffect(() => {
    // Check if
  }, [pages]);

  const handleClick = (e) => {
    e.preventDefault();
    console.log(pages);

    axios.post('https://toreadit.test/wp-json/TomoveitRestApi/v1/reading', {
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

  return (
    <div className={style('reading-input')}>
      <Container>
        <div className={style('reading-input__content')}>
          <h2>Registrera antal sidor!</h2>
          <input className={style('reading-input__input')} type='number' onChange={handleOnChange} />
          <Button loading={false} to={'/activities'} text={'Gå vidare'} handleClick={handleClick}/>
        </div>
      </Container>
    </div>
  );
};

export default ReadingInput;
