import React, { useEffect, useState } from 'react';
import classNames from 'classnames/bind';
import styles from './Statistics.scss';
import { useSelector } from 'react-redux';
import { Chart } from 'chart.js';
/* eslint-disable */
import ChartDataLabels from 'chartjs-plugin-datalabels';
/* eslint-enable */
import moment from 'moment';
import axios from 'axios';

const style = classNames.bind(styles);

const Statistics = () => {
  const pin = useSelector(state => state.app.pin);
  const [loding, setLoading] = useState(false);
  const [date, setdate] = useState(new Date());
  const [data, setData] = useState([]);

  useEffect(() => {
    let monday = moment(date).startOf('isoWeek');
    let sunday = moment(date).startOf('isoWeek').add(6, 'days');
    console.log(monday.toString());
    console.log(sunday.toString());

    setLoading(true);

    axios.post('https://toreadit.test/wp-json/TomoveitRestApi/v1/data', {
      pin: pin,
      start_date: monday,
      end_date: sunday,
    },
    ).then((response) => {
      setData(response.data);
      setLoading(false);
    }, (error) => {
      console.log(error);
    });
  }, [date]);

  useEffect(() => {
    if (!loding) {
      const chart = createChart(data);
      return () => chart.destroy();
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
          data: data.pages_array,
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
      <div className={ style('statistics__stats')}>
        <h1>{data.total_pages_sum}</h1>
        <h3>Totalt antal lästa sidor hittills</h3>
        <span>Snyggt jobbat! 👏💪</span>
      </div>
      <div className={ style('statistics__wrapper')}>
        <svg className={ style('statistics__arrow-left')} onClick={handleClickLeft}>
          <use xlinkHref={ 'wp-content/themes/tomoveit/dist/spritemap.svg#order-icon-arrow-left' } />
        </svg>
        <p>Vecka {moment(date).format('w')} ( {moment(date).startOf('week').format('DD MMMM')} — {moment(date).startOf('week').add(6, 'days').format('DD MMMM')} )</p>
        <svg className={ style('statistics__arrow-right')} onClick={handleClickRight}>
          <use xlinkHref={ 'wp-content/themes/tomoveit/dist/spritemap.svg#order-icon-arrow-left' } />
        </svg>
      </div>
      <div className={ style('statistics__chart-container')}>
        <canvas className={ style('statistics__chart')} id="StatisticContainer">
        </canvas>
      </div>
    </div>
  );
};

export default Statistics;
