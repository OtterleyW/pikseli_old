import React from 'react';
import { render } from 'react-dom';
import Sukutaulu from './Sukutaulu';

const sukuJson = {
  name: 'Heppa',
  father: {
    name: 'Isä',
    father: {
      name: 'Isän isä',
      father: { name: 'Isän isän isä' },
      mother: { name: 'Isän isän emä' } },
    mother: {
      name: 'Isän emä',
      father: { name: 'Isän emän isä' },
      mother: { name: 'Isän emän emä' }
    }
  },
  mother: {
    name: 'Emä',
    father: {
      name: 'Emän isä',
      father: { name: 'Emän isän isä' },
      mother: { name: 'Emän isän emä' }
    },
    mother: {
      name: 'Emän emä',
      father: { name: 'Emän emän isä' },
      mother: { name: 'Emän emän emä' }
    }
  }
};

render(<Sukutaulu suku={sukuJson} />, document.getElementById('vs-sukutaulu-root'));
