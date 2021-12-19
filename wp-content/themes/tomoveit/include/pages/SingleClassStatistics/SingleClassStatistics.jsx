import React, { useEffect, useState } from 'react';
import classNames from 'classnames/bind';
import styles from './SingleClassStatistics.scss';
import { useSelector } from 'react-redux';
import { Chart } from 'chart.js';
/* eslint-disable */
import ChartDataLabels from 'chartjs-plugin-datalabels';
/* eslint-enable */
import moment from 'moment';
import axios from 'axios';
import { ConfettiCanvas } from 'react-raining-confetti';
import PropTypes from 'prop-types';

const style = classNames.bind(styles);

const SingleClassStatistics = (props) => {
  const pin = useSelector(state => state.app.pin);
  const [loding, setLoading] = useState(true);
  const [date, setdate] = useState(new Date());
  const [data, setData] = useState([]);

  useEffect(() => {
    setLoading(true);
    let monday = moment(date).startOf('isoWeek');
    let sunday = moment(date).startOf('isoWeek').add(6, 'days');

    axios.post('https://toreadit.hbgtest.se/wp-json/TomoveitRestApi/v1/classes-data', {
      pin: pin,
      start_date: monday,
      end_date: sunday,
    },
    ).then((response) => {
      if (props.class === '6A') {
        setData(response.data[0]);
      } else if (props.class === '6B') {
        setData(response.data[1]);
      } else {
        setData(response.data[2]);
      }
      setLoading(false);
    }, (error) => {
      console.log(error);
    });
  }, [date]);

  useEffect(() => {
    if (!loding) {
      const chart = createChart(data);
      return () => {
        chart.destroy();
      };
    }
  }, [loding]);

  const createChart = (data) => {
    const chartElement = (document.getElementById('StatisticContainer')).getContext('2d');
    return new Chart(chartElement, {
      type: 'bar',
      data: {
        labels: ['MÅNDAG', 'TISDAG', 'ONSDAG', 'TORSDAG', 'FREDAG', 'LÖRDAG', 'SÖNDAG'],
        datasets: [{
          label: '# Lästa sidor',
          data: data.data.pages_array,
          backgroundColor: '#4b4eff',
        }],
      },
      options: {
        layout: {
          padding: {
            left: 0,
            right: 0,
            top: 50,
            bottom: 0,
          },
        },
        scales: {
          xAxes: [{
            gridLines: {
              color: 'rgba(0, 0, 0, 0)',
              drawBorder: false,
              drawOnChartArea: false,
            },
          }],
          yAxes: [{
            display: false,
            gridLines: {
              color: 'rgba(0, 0, 0, 0)',
              drawBorder: false,
              drawOnChartArea: false,
            },
          }],
        },
        responsive: true,
        maintainAspectRatio: false,
        legend: {
          display: false,
          labels: {
            fontFamily: 'Montserrat',
          },
        },
        plugins: {
          // Change options for ALL labels of THIS CHART
          datalabels: {
            anchor: 'end',
            align: 'top',
            color: '#4b4eff',
            font: {
              weight: 'bold',
              size: 27,
              style: 'italic',
            },
          },
        },
      },
    });
  };

  const handleClickLeft = () => {
    setdate(moment(date).subtract(1, 'week').toDate());
  };

  const handleClickRight = () => {
    setdate(moment(date).add(1, 'week').toDate());
  };

  return (
    <div className={ style('statistics')}>
      { (data.data && (data.data.total_pages_sum >= data.goal)) &&
        <div className={style('statistics__confetti')}>
          <ConfettiCanvas active={true} fadingMode="LIGHT" stopAfterMs={10000}/>
        </div>
      }
      <div className={ style('statistics__wrapper')}>
        <svg className={ style('statistics__arrow-left')} onClick={handleClickLeft}>
          <use xlinkHref={ 'wp-content/themes/tomoveit/dist/spritemap.svg#order-icon-arrow-left' } />
        </svg>
        <p>Vecka {moment(date).format('w')} ( {moment(date).startOf('week').format('DD MMMM')} — {moment(date).startOf('week').add(6, 'days').format('DD MMMM')} )</p>
        <svg className={ style('statistics__arrow-right')} onClick={handleClickRight}>
          <use xlinkHref={ 'wp-content/themes/tomoveit/dist/spritemap.svg#order-icon-arrow-left' } />
        </svg>
      </div>
      <div className={ style('statistics__stats')}>
        <h1>Klass {props.class}</h1>
        <h3>Totalt antal lästa sidor hittills</h3>
        <h1>{data.data ? data.data.total_pages_sum : 0}</h1>
        <span>Snyggt jobbat!👏💪</span>
      </div>
      <div className={ style('statistics__chart-container')}>
        <canvas className={ style('statistics__chart')} id="StatisticContainer">
        </canvas>
      </div>
    </div>
  );
};

SingleClassStatistics.propTypes = {
  class: PropTypes.string.isRequired,
};

export default SingleClassStatistics;
