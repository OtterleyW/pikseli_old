import React, { Component } from 'react';
import Sukulainen from './Sukulainen';

import styles from './styles/Sukutaulu.css';

const suvunPituus = (sukuObj, pituus = 0) => {
  const { mother, father } = sukuObj;
  if (mother && father) {
    return Math.max(
      suvunPituus(mother, pituus + 1),
      suvunPituus(father, pituus + 1)
    );
  }
  return pituus;
};

export default class Sukutaulu extends Component {
  render() {
    const { suku } = this.props;
    const pituus = suvunPituus(suku);

    return (
      <div style={{ overflow: 'hidden' }}>
        <div className={styles.container}>
          {this._renderHeppa(suku, pituus)}
        </div>
      </div>
    );
  }

  _renderHeppa(heppa, pituus, polvi = 0) {
    const { name: nimi, father, mother } = heppa;

    if (father && mother) {
      return (
        <Sukulainen nimi={nimi} polvi={polvi} pituus={pituus} key={nimi}>
          {this._renderHeppa(father, pituus, polvi + 1)}
          {this._renderHeppa(mother, pituus, polvi + 1)}
        </Sukulainen>
      );
    }
    else {
      return <Sukulainen nimi={nimi} polvi={polvi} pituus={pituus} key={nimi} />;
    }
  }
}
