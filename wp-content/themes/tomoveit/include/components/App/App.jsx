import React from 'react';
import { Route, Switch, HashRouter } from 'react-router-dom';
import { Provider } from 'react-redux';
import { PersistGate } from 'redux-persist/integration/react';

import configureStore from '../../store/store';

import Activities from '../../pages/Activities/Activities.jsx';
import Login from '../../pages/Login/Login.jsx';
import Header from '../Header/Header.jsx';
import SingleActivity from '../../pages/SingleActivity/SingleActivity.jsx';
import CurrentActivity from '../../pages/CurrentActivity/CurrentActivity.jsx';
import Statistics from '../../pages/Statistics/Statistics.jsx';
import PrivateRoute from '../PrivateRoute/PrivateRoute.jsx';
import CompanyActivities from '../../pages/CompanyActivities/CompanyActivities.jsx';
import SingleCompanyActivity from '../../pages/SingleCompanyActivity/SingleCompanyActivity.jsx';
import ReadingInput from '../../pages/ReadingInput/ReadingInput.jsx';
import StatisticsOverall from '../../pages/StatisticsOverall/StatisticsOverall.jsx';
import SingleClassStatistics from '../../pages/SingleClassStatistics/SingleClassStatistics.jsx';
const store = configureStore();

const App = () => {
  return (
    <Provider store={store.store}>
      <PersistGate persistor={store.persistor}>
        <HashRouter>
          <Header/>
          <Switch>
            <Route exact path="/" component={Login} />
            <PrivateRoute path="/activities" component={Activities} />
            <PrivateRoute path="/activity" component={SingleActivity} />
            <PrivateRoute path="/runningActivity" component={CurrentActivity} />
            <PrivateRoute path="/statistics" component={Statistics} />
            <PrivateRoute path="/föreningar" component={CompanyActivities} />
            <PrivateRoute path="/aktivitet" component={SingleCompanyActivity} />
            <PrivateRoute path="/läsning" component={ReadingInput} />
            <Route path="/klass-statistik" component={StatisticsOverall} />
            <Route path="/6A" component={() => <SingleClassStatistics class={'6A'}/>} />
            <Route path="/6B" component={() => <SingleClassStatistics class={'6B'}/>} />
            <Route path="/6C" component={() => <SingleClassStatistics class={'6C'}/>} />
          </Switch>
        </HashRouter>
      </PersistGate>
    </Provider>
  );
};

export default App;
