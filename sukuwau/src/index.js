import React from 'react';
import { render } from 'react-dom';
import Sukutaulu from './Sukutaulu';
import configureStore from './configureStore';

import { Provider } from 'react-redux';

const store = configureStore(window.VS_SUKU_JSON);

render(
  <Provider store={store}>
    <Sukutaulu />
  </Provider>
  , document.getElementById('vs-sukutaulu-root')
);
