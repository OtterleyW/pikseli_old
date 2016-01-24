import 'babel-polyfill';

import React from 'react';
import { render } from 'react-dom';
import Sukutaulu from './components/Sukutaulu';
import configureStore from './configureStore';

import { Provider } from 'react-redux';

const store = configureStore({ horses: window.VS_SUKU_JSON });

render(
  <Provider store={store}>
    <Sukutaulu />
  </Provider>
  , document.getElementById('vs-sukutaulu-root')
);
