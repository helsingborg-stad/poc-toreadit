import React from 'react';
import styles from './SingleCompanyActivity.scss';
import classNames from 'classnames/bind';
import { useSelector } from 'react-redux';
import moment from 'moment';
import ReactPlayer from 'react-player';
import { replaceLineBreaksWithHTML } from '../../util/util';

const style = classNames.bind(styles);

const SingleCompanyActivities = () => {
  const companyActivities = useSelector(state => state.app.companyActivities);
  const companyActivityId = useSelector(state => state.app.companyActivityId);

  const data = companyActivities.find(item => item.id === companyActivityId);
  const datePublished = moment(data.published).format('DD MMMM YYYY');
  moment.locale('sv');
  const stars = () => {
    let stars = '';
    for (let i = 0; i < parseInt(data.stars); i++) {
      stars += '⭐';
    }
    return stars;
  };
  return (
    <div className={style('company-single')}>
      <div className={style('company-single__container')}>
        <h1>{data.title}</h1>
        <span>Publicerad {datePublished}</span>
        {data.videoUrl &&
          <div className={style('company-single__player-wrapper')}>
            <ReactPlayer
              className='react-player'
              url={data.videoUrl}
              width='100%'
              height='100%'
            />
            { data.videoText && <p>{data.videoText}</p> }
          </div>
        }
        <div className={style('company-single__content')}>
          {
            data.review_check ? <>
              <p className={style('company-single__text-title')}>Bok</p>
              <p>{replaceLineBreaksWithHTML(data.book)}</p>
              <p className={style('company-single__text-title')}>Författare</p>
              <p>{replaceLineBreaksWithHTML(data.name)}</p>
              <p className={style('company-single__text-title')}>Betyg</p>
              <p>{stars()}</p>
              <p className={style('company-single__text-title')}>Vad var bra med boken?</p>
              <p>{replaceLineBreaksWithHTML(data.best)}</p>
            </> : <>
              <p className={style('company-single__text-title')}>Namn</p>
              <p>{replaceLineBreaksWithHTML(data.name)}</p>
              <p className={style('company-single__text-title')}>Varför läsning?</p>
              <p>{data.why_reading && replaceLineBreaksWithHTML(data.why_reading)}</p>
              <p className={style('company-single__text-title')}>Vad läste personen för oss?</p>
              <p>{data.what_did_they_read && replaceLineBreaksWithHTML(data.what_did_they_read)}</p>
              <p className={style('company-single__text-title')}>Vad har läsning betytt för personen?</p>
              <p>{data.meaning && replaceLineBreaksWithHTML(data.meaning)}</p>
              <p className={style('company-single__text-title')}>Vilken är personens favoritbok?</p>
              <p>{data.favorite && replaceLineBreaksWithHTML(data.favorite)}</p>
            </>
          }
          <div className={style('company-single__line')}></div>
          <p className={style('company-single__text-title')}>Denna sida är skapad av:</p>
          <p>{data.author}</p>
        </div>
      </div>
    </div>
  );
};

export default SingleCompanyActivities;
