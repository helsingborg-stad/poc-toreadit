import React from 'react';
import classNames from 'classnames/bind';
import styles from './Container.scss';
import PropTypes from 'prop-types';

const style = classNames.bind(styles);

const Container = (props) => {
  return (
    <div className={ style('wrapper', 'container', 'container__inner')}>
      {props.children}
    </div>
  );
};

Container.propTypes = {
  children: PropTypes.any.isRequired,
};
export default Container;
